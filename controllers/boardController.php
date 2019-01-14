<?php 
require_once('helper.php');

$bdd = dbConnect('splists', 'root', '', 3308);

$res = $bdd->query('SELECT * from lists');

$lists = [];

while ($donnees = $res ->fetch()) {

    $lists[] = $donnees;
   
}
$res->closeCursor();


if(!empty($_POST['list-title'])) {

    // Création d'une nouvelle liste :
    $res = $bdd->prepare("INSERT into lists(title) values (:title)");

    $res->execute([
        "title" => $_POST['list-title']
    ]);

    header('location: /splists/views/board.php?list=' . $bdd->lastInsertId());
}

//lecture d'une liste

function getList($idList) {
    $bdd= dbConnect('splists', 'root', '', 3308);
    $request= 'SELECT * from lists where id = ' . $idList;
    $response = $bdd->query($request);
    $liste = $response->fetch();
    return $liste;
}

