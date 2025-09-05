\
    <?php
    // ========= Paristanbul Recrutement — Configuration =========
    // Renseignez ces valeurs avant de mettre en ligne.

    // URL publique du formulaire (utilisée pour votre QR code / affiches)
    // Exemple : https://paristanbul.fr/recrutement/postuler.php
    const FORM_URL = 'https://exemple.com/recrutement/postuler.php';

    // Paramètres SMTP (recommandé pour une bonne délivrabilité)
    const SMTP_HOST = 'smtp.exemple.com';
    const SMTP_PORT = 587;               // 465 pour SSL
    const SMTP_SECURE = 'tls';           // 'ssl' ou 'tls'
    const SMTP_USER = 'no-reply@exemple.com';
    const SMTP_PASS = 'MOTDEPASSESMTP';

    // Adresses e-mail
    // Adresse qui reçoit les notifications de candidature
    const MAIL_TO = 'recrutement@paristanbul.fr';
    const MAIL_TO_NAME = 'RH Paristanbul Melun';

    // Adresse d'envoi (expéditeur)
    const MAIL_FROM = 'no-reply@paristanbul.fr';
    const MAIL_FROM_NAME = 'Paristanbul Recrutement';

    // Emplacement du fichier CSV où stocker les candidatures (en plus du mail)
    // Assurez-vous que le dossier "data" est accessible en écriture.
    const CSV_PATH = __DIR__ . '/data/candidatures.csv';

    // Localisation du magasin (apparaît dans l'objet de l'e-mail)
    const MAGASIN = 'Melun';
