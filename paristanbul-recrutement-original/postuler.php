\
    <?php
    require_once __DIR__ . '/config.php';
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Postuler — Supermarché Paristanbul (Melun)</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            :root{
                /* Paristanbul */
                --brand-blue:#1f4aa9;
                --brand-blue-2:#2a64d4;
                --brand-red:#e53935;

                /* Déjà présents chez toi */
                --green:#2d9b47;
                --dark:#222;
                --light:#f6f7f9;
                --error:#c1121f;
            }

            *{box-sizing:border-box}

            /* Fond de page Paristanbul */
            body{
                font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
                color:#222; margin:0; min-height:100vh;

                /* dégradé bleu -> rouge + halos doux */
                background:
                        radial-gradient(1200px 600px at -10% -10%, rgba(255,255,255,.10) 0%, rgba(255,255,255,0) 60%),
                        radial-gradient(900px 450px at 110% 0%, rgba(255,255,255,.10) 0%, rgba(255,255,255,0) 60%),
                        linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-blue-2) 45%, var(--brand-red) 100%);
                background-attachment: fixed;
            }

            /* Conteneur lisible au-dessus du fond */
            .container{
                max-width:960px; margin:24px auto; padding:24px;
                background:rgba(255,255,255,.92);
                border:1px solid #e5e7eb; border-radius:20px;
                box-shadow:0 10px 30px rgba(31,74,169,.15);
            }

            header{display:flex;gap:16px;align-items:center;padding:24px 0}
            header img{height:56px}
            h1{margin:0;font-size:28px}

            .card{
                background:#fff;border:1px solid #e5e7eb;border-radius:16px;
                padding:24px;box-shadow:0 4px 18px rgba(0,0,0,.06)
            }

            .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
            .grid-1{display:grid;grid-template-columns:1fr;gap:16px}

            label{font-weight:600;margin-bottom:6px;display:block}
            input[type=text],input[type=date],input[type=email],input[type=tel],textarea,select{
                width:100%;padding:12px 14px;border:1px solid #d1d5db;border-radius:12px;background:#fff;font-size:15px
            }
            textarea{min-height:120px;resize:vertical}
            .hint{font-size:12px;color:#666;margin-top:4px}
            .inline{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
            .inline label{font-weight:500}
            .hidden{display:none}
            .required::after{content:" *";color:var(--error);font-weight:700}
            .actions{display:flex;justify-content:space-between;align-items:center;margin-top:16px;gap:16px}

            /* Tu peux passer le bouton en bleu si tu veux */
            .btn{
                background:var(--brand-blue); border:none; color:#fff; font-weight:700;
                padding:12px 18px;border-radius:12px;cursor:pointer
            }
            .btn:hover{filter:brightness(.95)}

            .footer-note{font-size:12px;color:#6b7280;margin-top:12px}

            /* Badge avec teinte bleue douce */
            .badge{display:inline-block;padding:4px 10px;border-radius:999px;background:#eaf0fb;color:#0b3a8a;font-weight:600;font-size:12px}

            .error{color:var(--error);font-size:14px;margin-top:8px}
        </style>

    </head>
    <body>
        <div class="container">
            <header>
                <img src="https://play-lh.googleusercontent.com/4-hTf32960CWp7N_cBSNN7UnH3UNHMzgye3wGzXqSp69-iAc7-88jwc1jPlkeqDktLE=w240-h480" alt="Logo" />
                <div>
                    <h1>Recrutement — Supermarché Paristanbul <span class="badge">Melun</span></h1>
                    <div>Merci de remplir ce formulaire pour postuler.</div>
                </div>
            </header>

            <form class="card" action="traitement_candidature.php" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="magasin" value="<?php echo htmlspecialchars(MAGASIN); ?>">
                <div class="grid">
                    <div>
                        <label class="required" for="nom">Nom</label>
                        <input id="nom" name="nom" type="text" required />
                    </div>
                    <div>
                        <label class="required" for="prenom">Prénom</label>
                        <input id="prenom" name="prenom" type="text" required />
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label class="required" for="telephone">Numéro de téléphone</label>
                        <input id="telephone" name="telephone" type="tel" placeholder="+33 6 12 34 56 78" required />
                        <div class="hint">Nous vous appellerons sur ce numéro.</div>
                    </div>
                    <div>
                        <label class="required" for="email">Adresse e-mail</label>
                        <input id="email" name="email" type="email" placeholder="vous@exemple.com" required />
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label class="required" for="date_naissance">Date de naissance</label>
                        <input id="date_naissance" name="date_naissance" type="date" required />
                    </div>
                    <div>
                        <label class="required" for="langues">Langues parlées</label>
                        <input id="langues" name="langues" type="text" placeholder="Français, Turc, Anglais…" required />
                    </div>
                </div>

                <div class="grid-1">
                    <div>
                        <label class="required" for="adresse">Adresse</label>
                        <input id="adresse" name="adresse" type="text" placeholder="N°, Rue, Ville, Code postal" required />
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label class="required">Permis de conduire</label>
                        <div class="inline">
                            <label><input type="radio" name="permis" value="oui" required> Oui</label>
                            <label><input type="radio" name="permis" value="non"> Non</label>
                        </div>
                    </div>
                    <div id="vehicule-group" class="hidden">
                        <label class="required">Véhicule</label>
                        <div class="inline">
                            <label><input type="radio" name="vehicule" value="oui"> Oui</label>
                            <label><input type="radio" name="vehicule" value="non"> Non</label>
                        </div>
                    </div>
                </div>

                <div class="grid-1">
                    <div>
                        <label class="required" for="experiences">Expériences (poste, durée, missions)</label>
                        <textarea id="experiences" name="experiences" required placeholder="Décrivez rapidement vos expériences pertinentes."></textarea>
                    </div>
                </div>

                <div class="grid-1">
                    <div>
                        <label class="required" for="lettre_motivation">Lettre de motivation</label>
                        <textarea id="lettre_motivation" name="lettre_motivation" required placeholder="Expliquez votre motivation, vos disponibilités, etc."></textarea>
                    </div>
                </div>

                <div class="grid">
                    <div>
                        <label for="cv">CV (PDF, DOCX) — optionnel</label>
                        <input id="cv" name="cv" type="file" accept=".pdf,.doc,.docx" />
                    </div>
                    <div>
                        <label for="autre">Autre pièce jointe — optionnel</label>
                        <input id="autre" name="autre" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                    </div>
                </div>

                <!-- Anti-spam (honeypot) -->
                <div class="hidden">
                    <label>Votre site web</label>
                    <input type="text" name="website" autocomplete="off" />
                </div>

                <div class="inline" style="margin-top:8px">
                    <label><input type="checkbox" name="consent" required> J'accepte que mes données soient utilisées pour traiter ma candidature.</label>
                </div>

                <div class="actions">
                    <div class="footer-note">Les champs marqués * sont obligatoires.</div>
                    <button class="btn" type="submit">Envoyer ma candidature</button>
                </div>
                <?php if(isset($_GET['err'])): ?>
                    <div class="error">Erreur : <?php echo htmlspecialchars($_GET['err']); ?></div>
                <?php endif; ?>
            </form>
        </div>
        <script>
            // Affiche/masque la question "Véhicule" si permis = oui
            const permisRadios = document.querySelectorAll('input[name="permis"]');
            const vehiculeGroup = document.getElementById('vehicule-group');
            permisRadios.forEach(r => {
                r.addEventListener('change', () => {
                    if (r.value === 'oui' && r.checked) {
                        vehiculeGroup.classList.remove('hidden');
                        // Rendre requis si permis = oui
                        document.querySelectorAll('input[name="vehicule"]').forEach(v => v.required = true);
                    } else if (r.value === 'non' && r.checked) {
                        vehiculeGroup.classList.add('hidden');
                        document.querySelectorAll('input[name="vehicule"]').forEach(v => v.required = false);
                    }
                });
            });
        </script>
    </body>
    </html>
