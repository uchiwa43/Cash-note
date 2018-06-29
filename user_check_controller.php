<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 26/06/2018 08:45
 * Description: Vérifie les input text entrés dans user_view.html
 * et redirige soit vers l'écriture en base en cas de succès,
 * soit vers le formulaire à nouveau en cas d'erreur
 */

session_start();
require('autoload.php');

//1)MODEL : aucun

//2)VIEW: aucune

//3)CONTROLLER
$user_check = new UserController();


//on vérifie tous les champs
//champs text
$is_pseudo_verified = $user_check->checkPseudo();
$is_mail_verified = $user_check->checkMail();
$is_password_verified = $user_check->checkPassword();

//champs select
$is_statut_verified = $user_check->checkStatut(2);
$is_etat_verified = $user_check->checkEtat(4);


//Si tous les champs sont à 1 : bool_field sera à 1, sinon il sera à 0
$bool_fields = $is_pseudo_verified & $is_statut_verified & $is_mail_verified & $is_password_verified & $is_etat_verified;


$user_check->traitementFormulaire($bool_fields);
