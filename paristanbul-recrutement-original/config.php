<?php
const MAGASIN = 'Melun';

// Chemin du fichier CSV pour sauvegarder les candidatures
// Le fichier sera créé dans le dossier htdocs/ si inexistant
const CSV_PATH = __DIR__ . '/candidatures.csv';

// =======================
// CONFIGURATION E-MAIL
// =======================

// E-mail de l'expéditeur (tu peux mettre ton e-mail principal)
const MAIL_FROM = 'r.quashieo@lprs.fr';        //
const MAIL_FROM_NAME = 'Paristanbul Recrutement';

// E-mail de réception (où tu reçois les candidatures)
const MAIL_TO = 'j.bao@lprs.fr';          //
const MAIL_TO_NAME = 'RH Paristanbul';

// =======================
// SMTP (optionnel si tu utilises PHPMailer)
// =======================
// Sur InfinityFree, la fonction mail() de PHP fonctionne sans SMTP
// Si tu veux utiliser PHPMailer avec SMTP, remplis ces infos
const SMTP_HOST = '';       // ex: smtp.gmail.com
const SMTP_USER = '';       // ton login SMTP
const SMTP_PASS = '';       // mot de passe SMTP
const SMTP_SECURE = 'tls';  // 'ssl' ou 'tls'
const SMTP_PORT = 587;      // port SMTP

?>
