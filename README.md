
# Pack Recrutement — Supermarché Paristanbul (Melun)

**Contenu :**
- `postuler.php` : Formulaire de candidature complet (nom, prénom, adresse, téléphone, e‑mail, date de naissance, langues, permis, véhicule, expériences, lettre de motivation, PJ).
- `traitement_candidature.php` : Traitement + envoi d'une **notification e‑mail** au service RH et sauvegarde CSV.
- `merci.html` : Page de confirmation.
- `config.php` : **A compléter** (SMTP, adresses e‑mail, URL publique).
- `qr-rejoignez-nous.html` : Affiche **A4** prête à imprimer avec **QR code "Rejoignez‑nous"**.
- `data/candidatures.csv` : (créé automatiquement) enregistrement des candidatures.

## 1) Prérequis
- PHP 8.0+
- Accès shell pour exécuter Composer
- Un compte SMTP (ex: votre messagerie pro, ou un provider transactionnel)

## 2) Installation
```bash
cd /var/www/html/recrutement
composer require phpmailer/phpmailer
```

Copiez tous les fichiers de ce dossier dans votre hébergement (par exemple `https://votre-domaine.tld/recrutement/`).  
Assurez-vous que le dossier `data/` soit **inscriptible** par PHP (chmod 755 ou 775 selon l'hébergeur).

## 3) Configuration
Ouvrez `config.php` et renseignez :
- `FORM_URL` = URL publique de `postuler.php` (ex: `https://paristanbul.fr/recrutement/postuler.php`)
- SMTP : `SMTP_HOST`, `SMTP_PORT`, `SMTP_SECURE`, `SMTP_USER`, `SMTP_PASS`
- Emails : `MAIL_TO` (destinataire RH), `MAIL_FROM` (expéditeur)
- `MAGASIN` = `Melun`

Puis dans `qr-rejoignez-nous.html`, remplacez `targetURL` par **la même URL** que `FORM_URL`.

## 4) Test
- Ouvrez `postuler.php` dans le navigateur, faites un envoi test.
- Vérifiez : *vous recevez l'e‑mail* et `data/candidatures.csv` contient la ligne.
- Imprimez `qr-rejoignez-nous.html` et affichez-la en magasin.

## 5) Notes
- Un champ **anti-spam** (honeypot) est présent.
- Les pièces jointes sont **optionnelles** (formats : PDF, DOC/DOCX, JPEG/PNG).
- En cas d'erreur SMTP, la candidature est **quand même enregistrée** dans le CSV et l'utilisateur voit un message.

## 6) (Optionnel) Stocker aussi en base MySQL
Exemple de table :
```sql
CREATE TABLE candidatures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME NOT NULL,
  ip VARCHAR(45) NULL,
  magasin VARCHAR(100) NOT NULL,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  telephone VARCHAR(30) NOT NULL,
  email VARCHAR(180) NOT NULL,
  date_naissance DATE NOT NULL,
  langues VARCHAR(255) NOT NULL,
  adresse VARCHAR(255) NOT NULL,
  permis ENUM('oui','non') NOT NULL,
  vehicule ENUM('oui','non') NULL,
  experiences TEXT NOT NULL,
  lettre_motivation MEDIUMTEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
Vous pourrez ensuite insérer les données dans `traitement_candidature.php` après la section CSV.

---
**Prêt à l'emploi.** Remplissez `config.php`, installez PHPMailer avec Composer, mettez en ligne, et diffusez l'affiche QR.
