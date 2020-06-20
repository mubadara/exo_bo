<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);
// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());
// chargement de données des articles
$articles = require __DIR__.'/articles-data.php';
$article = [
    'id' => '',
    'name' =>'',
    'description' => '',
    'price' => '',
    'quantity' => '',
];
$errors = [];
$messages = [];

if ($_POST) {
    if (isset($_POST['name'])) {
        $article['name'] = $_POST['name'];
    }

    if (!isset($_POST['name'])|| empty($_POST['name'])) {
        $errors['name'] = true;
        $messages['name'] = 'Merci de renseigner le nom de l\'article';
    }
    elseif (strlen($_POST['name'] < 2) || strlen($_POST['name']) > 100) {
        $errors['name'] = true;
        $messages['name'] = 'Le nombre de caractères doit être inclu en 2 et 100 pour le champ nom';
    }
}


// affichage du rendu d'un template
echo $twig->render('article-new.html.twig',[
    'article' => $article,
    'errors' => $errors,
    'messages' => $messages,
]);