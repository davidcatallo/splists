<?php 
require_once('helper.php');

$bdd = dbConnect('splists', 'root', '', 3308);

$res = $bdd->query('SELECT * from lists');

$lists = [];

while ($donnees = $res ->fetch()) {

    $lists[] = $donnees;
   
}

