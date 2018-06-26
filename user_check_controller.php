<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 08:45
 * Description: Vérifie les input text depuis user_controller
 */

session_start();
include_once ('./class/UserCheck.php');
$user_check = new UserCheck();

echo "POST:";
var_dump($_POST);

//on vérifie tous les champs
$is_pseudo_verified = $user_check->checkPseudo();

$is_statut_verified = $user_check->checkStatut(4);

$is_mail_verified = $user_check->checkMail();

$is_password_verified = $user_check->checkPassword();

$is_etat_verified = $user_check->checkEtat(4);

//Si tous les champs sont à 1 : bool_field sera à 1, sinon il sera à 0
$bool_fields = $is_pseudo_verified & $is_statut_verified & $is_mail_verified & $is_password_verified & $is_etat_verified;


$user_check->traitement($bool_fields);
