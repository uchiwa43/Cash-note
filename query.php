<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 04/07/2018 00:08
 * Description:
 */

session_start();
require('autoload.php');

$bdd = new Bdd();

$query="
UPDATE 
SET libelle = ''
where id=";
$result = $bdd->executeQuery($query);
var_dump($result);


$bdd = new Bdd();
$query="
SELECT * from moyen_payement";

$result = $bdd->select($query);
var_dump($result);
