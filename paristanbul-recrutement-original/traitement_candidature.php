\
    <?php
    // Traitement + notification e-mail
    require_once __DIR__ . '/config.php';

    // Composer autoload pour PHPMailer
    require_once __DIR__ . '/lib/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/lib/phpmailer/src/SMTP.php';
    require_once __DIR__ . '/lib/phpmailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Petite fonction utilitaire
    function field($name) { return trim($_POST[$name] ?? ''); }
    function file_ok($key) { return isset($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name']); }

    // Vérif anti-spam (honeypot)
    if (!empty($_POST['website'] ?? '')) {
        http_response_code(400);
        exit('Spam détecté.');
    }

    // Sanitize + validations minimales
    $required = ['nom','prenom','telephone','email','date_naissance','langues','adresse','permis','experiences','lettre_motivation','magasin','consent'];
    foreach ($required as $r) {
        if ($r === 'consent') {
            if (!isset($_POST['consent'])) {
                header('Location: postuler.php?err=Veuillez cocher la case de consentement.');
                exit;
            }
            continue;
        }
        if (empty($_POST[$r] ?? '')) {
            header('Location: postuler.php?err=Veuillez remplir tous les champs obligatoires.');
            exit;
        }
    }
    if (!filter_var(field('email'), FILTER_VALIDATE_EMAIL)) {
        header('Location: postuler.php?err=E-mail invalide.');
        exit;
    }
    if (field('permis') === 'oui' && empty($_POST['vehicule'] ?? '')) {
        header('Location: postuler.php?err=Veuillez préciser si vous avez un véhicule.');
        exit;
    }

    $nom     = htmlspecialchars(field('nom'));
    $prenom  = htmlspecialchars(field('prenom'));
    $tel     = htmlspecialchars(field('telephone'));
    $email   = htmlspecialchars(field('email'));
    $naiss   = htmlspecialchars(field('date_naissance'));
    $langues = htmlspecialchars(field('langues'));
    $adresse = htmlspecialchars(field('adresse'));
    $permis  = htmlspecialchars(field('permis'));
    $vehic   = htmlspecialchars($_POST['vehicule'] ?? 'N/A');
    $exp     = htmlspecialchars(field('experiences'));
    $lettre  = htmlspecialchars(field('lettre_motivation'));
    $magasin = htmlspecialchars(field('magasin'));
    $ts      = date('Y-m-d H:i:s');
    $ip      = $_SERVER['REMOTE_ADDR'] ?? 'N/A';

    // Enregistrement CSV (en plus du mail)
    $is_new_csv = !file_exists(CSV_PATH);
    $f = fopen(CSV_PATH, 'a');
    if ($f) {
        if ($is_new_csv) {
            fputcsv($f, ['date','ip','magasin','nom','prenom','telephone','email','date_naissance','langues','adresse','permis','vehicule','experiences','lettre_motivation']);
        }
        fputcsv($f, [$ts,$ip,$magasin,$nom,$prenom,$tel,$email,$naiss,$langues,$adresse,$permis,$vehic,$exp,$lettre]);
        fclose($f);
    }

    // Envoi e-mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        if (SMTP_SECURE === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress(MAIL_TO, MAIL_TO_NAME);
        // On met le candidat en reply-to pour répondre facilement
        $mail->addReplyTo($email, $prenom . ' ' . $nom);

        $mail->isHTML(true);
        $mail->Subject = "[Paristanbul {$magasin}] Nouvelle candidature — {$prenom} {$nom}";

        $body = "
        <h2>Nouvelle candidature — Supermarché Paristanbul ({$magasin})</h2>
        <p><strong>Nom Prénom :</strong> {$nom} {$prenom}<br>
        <strong>Téléphone :</strong> {$tel}<br>
        <strong>E-mail :</strong> {$email}<br>
        <strong>Date de naissance :</strong> {$naiss}<br>
        <strong>Langues parlées :</strong> {$langues}<br>
        <strong>Adresse :</strong> {$adresse}<br>
        <strong>Permis de conduire :</strong> {$permis}<br>
        <strong>Véhicule :</strong> {$vehic}<br>
        <strong>Expériences :</strong><br>" . nl2br($exp) . "<br>
        <strong>Lettre de motivation :</strong><br>" . nl2br($lettre) . "<br>
        <hr>
        <small>Envoyé le {$ts} depuis {$ip}.</small>
        ";
        $mail->Body = $body;
        $mail->AltBody = strip_tags(str_replace(["<br>","<br/>","<br />"], "\n", $body));

        // Pièces jointes (optionnelles)
        $allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg','image/png'
        ];
        foreach (['cv','autre'] as $k) {
            if (file_ok($k) && in_array(mime_content_type($_FILES[$k]['tmp_name']), $allowed)) {
                $mail->addAttachment($_FILES[$k]['tmp_name'], $_FILES[$k]['name']);
            }
        }

        $mail->send();
        header('Location: merci.html');
        exit;
    } catch (Exception $e) {
        // En cas d'échec e-mail, on redirige avec message d'erreur (la candidature est quand même au CSV)
        $err = urlencode("Notification e-mail non envoyée : " . $mail->ErrorInfo);
        header("Location: postuler.php?err={$err}");
        exit;
    }
