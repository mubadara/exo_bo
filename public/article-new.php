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
$article = [
    'id' => '',
    'name' => '',
    'description' => '',
    'price' => '',
    'quantity' => '',
];
    $errors = [];
    $messages = [];
if($_POST) {
    
    if (isset($_POST['name'])) {
        $article['name'] = $_POST['name'];
    }
    if (isset($_POST['description'])) {
        $article['description'] = $_POST['description'];
    }
    if (isset($_POST['price'])) {
        $article['price'] = $_POST['price'];
    }
    if (isset($_POST['quantity'])) {
        $article['quantity'] = $_POST['quantity'];
    }
    if (!isset($_POST['name'])|| empty($_POST['name'])) {
        $errors['name'] = true;
        $messages['name'] = 'Merci de renseigner le nom de l\'article';
    }
    elseif (strlen($_POST['name'] < 2) || strlen($_POST['name']) > 100) {
        $errors['name'] = true;
        $messages['name'] = 'Le nombre de caractères doit être inclu en 2 et 100 pour le champ nom';
    }
    if (isset($_POST['description']) && strpos($_POST['description'], '<')
    || strpos($_POST['description'], '>')) {
        $errors = true;
        $messages = 'la description contient un caractère interdit < ou >';
    }
    if (!isset($_POST['price'])|| empty($_POST['price'])) {
        $errors['price'] = true;
        $messages['price'] = 'Merci de renseigner le prix de l\'article';
    }
    elseif(!is_numeric($_POST['price'])){
        $errors['price'] = true;
        $messages['price'] = "Le prix doit être une valeur numérique";
    }
    if (!isset($_POST['quantity'])|| empty($_POST['quantity'])) {
        $errors['quantity'] = true;
        $messages['quantity'] = 'Merci de renseigner la quantité';
    }
    elseif(!is_numeric($_POST['price']) || is_float($_POST['quantity']) || ($_POST['price']) < 0){
        $errors['price'] = true;
        $messages['price'] = "La quantité doit être un nombre entier";
    }
    if (!$errors){
        //Le code suivant permet de rediriger vers la page qui liste les articles existants :
    $url = 'articles.php';
    header("Location: {$url}", true, 302);
    exit();
    }
        
}


// affichage du rendu d'un template
echo $twig->render('article-new.html.twig',[
    'article' => $article,
    'errors' => $errors,
    'messages' => $messages,
]);