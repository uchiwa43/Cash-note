<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 22:49
 * Description:
 */
include_once('class/Bdd.php');
$bdd = new Bdd();

$array_sql = $bdd->querySelect('SELECT * FROM lieu WHERE id_ville=5');
echo "tableau sql :";
var_dump($array_sql);