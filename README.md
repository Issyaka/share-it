# Slim Starter
Preconfigured Slim app including **PHP-DI**, **Twig** and **Doctrine DBAL**.

# Installation
Clone the repository, move into the created directory and install **Composer** dependencies:
```sh
git clone https://github.com/AymDev/Slim-Starter.git slim-app
cd slim-app
composer install
```

# Usage
The web server implementation is left to the developer. 
For a quick start, use the *PHP built-in server* which can also be started with the custom **Composer** command:
```sh
composer serve
```
You will find the default page on `http://localhost:8000`.

# Configuration
Some services are already configured in the `config/bootstrap.php`.
To configure your **Doctrine DBAL** database connection, add your params in `config/doctrine.php`.

# Controllers
A `AbstractController` class is present with methods for rendering **Twig** templates and to redirect to another route.

# Templating
A `link()` function has been added to **Twig** to create links to routes in templates.



# Projet
Le site **Share It** doit permettre de partager des fichiers (clone de WeTransfer).

Sur la page d'accueil, on doit avoir un formulaire qui permet d'envoyer 1 fichier via un formulaire.
Lorsque le formulaire est envoyé, on vérifie que le fichier ait été correctement chargé,
puis on l'enregistre dans un dossier `files` avec un nom unique.

Aussi, enregistrer les informations du fichier en base de données:

 - `id` la clé primaire
 - `filename` nom unique du fichier sur le serveur
 - `original_filename` nom original du fichier
 
Sur une autre page, on doit pouvoir télécharger un fichier.
L'adresse pourrait être `/download/42` (où `42` est l'identifiant en base de données).

Le lien de téléchargement doit apparaître après avoir envoyé un fichier.

# Link
https://www.php.net/manual/fr/function.date.php
https://www.php.net/manual/fr/datetime.format.php
https://www.php.net/manual/fr/function.random-bytes
https://www.php.net/manual/fr/features.file-upload.post-method.php
https://www.php.net/manual/fr/features.file-upload.errors.php
https://www.php.net/manual/fr/function.move-uploaded-file
https://www.php.net/manual/fr/function.finfo-file

https://developer.mozilla.org/fr/docs/Web/HTML/Element/Input/file
https://unsplash.com/
https://developer.mozilla.org/fr/docs/Web/HTML/Element/Form
https://www.slimframework.com/docs/v4/objects/routing.html
https://github.com/nikic/FastRoute

$ php -S localhost:8000 -t public
