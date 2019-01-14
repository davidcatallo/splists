<?php
require_once('helper.php');

/**
 * Instanciation de base de données
 */
$bdd = dbConnect('splists', 'root', '', 3308);

/**
 * READ (tous les éléments): Lecture de toutes les listes dès que j'accède à board.php
 */
// Response de la BDD non traitée
$res = $bdd->query('SELECT * FROM lists');

// Si je veux voir la dernière erreur en BDD : $bdd->errorinfo()

// J'instancie mon tableau qui contiendra mes listes
$lists = [];

// Tant que j'ai des réponses qui vont dans $donnees (variable temporaire pour le while)
while($donnees = $res->fetch()) {
    // Je met le contenu de $donnees (variable temporaire) dans le tableau $lists
    $lists[] = $donnees;
}

$res->closeCursor();


/**
 * CREATE : Cas où je reçois une variable POST de _form_list.php : je créée une liste
 */
if( !empty($_POST['list-title']) ) {

    // Création d'une nouvelle liste :

    $res = $bdd->prepare("INSERT INTO lists(title) VALUES (:title)");

    $res->execute([
        "title" => $_POST['list-title']
    ]);

    Header('Location: /splists/views/board.php?list=' . $bdd->lastInsertId());
}

/**
 * READ (1 élément) : Lecture d'une liste
 */

function getList($idList) {
    $bdd = dbConnect('splists', 'root', '', 3308);

    $request = 'SELECT *
                FROM lists
                WHERE id = ' . $idList;

    $response = $bdd->query($request);

    // Je m'attends à recevoir 1 seul élément, je ne fais pas de while (tant que...)
    // car while (tant que...) me sert à dire : "tant qu'il y a des éléments qui vont dans $liste"
    // or, je n'en ai qu'1 seul qui va dans liste !
    // (voir "select * from lists" ci-dessus pour un cas avec while)
    $liste = $response->fetch();

    return $liste;
}

function getTasks($idList) {
    $bdd = dbConnect('splists', 'root', '', 3308);

    $request = 'SELECT *
                FROM tasks
                WHERE id_list = ' . $idList;

    $response = $bdd->query($request);


    // J'initialise un tableau de tâches vide
    $tasks = [];

    // Tant que j'ai des données reçues...
    while ($donnees = $response->fetch()) {

        // ... j'ajoute (en mettant des crochets au nom de l'array) dans le tableau $task
        // ce que j'ai reçu dans $donnees
        $tasks[] = $donnees;
    }

    return $tasks;
}