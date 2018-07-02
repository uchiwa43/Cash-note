<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 02/07/2018 23:12
 * Description:
 */

session_start();
require('autoload.php');
include('./template/header_jquery.html');

//Supprimer toutes les variables de $_SESSION sauf le message
foreach($_SESSION as $var_session=>$value)
{
    if ($var_session != 'message')
    {
        unset($_SESSION[$var_session]); //"effacer" la variable
    }
}


//1)MODEL : requête de selection des villes
$bdd = new Bdd();
$query =" SELECT c.id, c.libelle, tc.libelle AS type
FROM categorie c
LEFT JOIN type_categorie tc ON c.id_type_categorie = tc.id
 ";

$categories_non_formates = $bdd->select($query);


//2)VIEW: chargement du template
$page_categorie_list = new CategorieController('./template/categorie_list_view.html');



//3)CONTROLLER
foreach($categories_non_formates as $categorie)
{
    foreach($categorie as $field=>$value)
    {
        if ($field=='id')
        {
            $categories[$value] = $categorie;
        }
    }
}
$_SESSION['categories'] = $categories;

$lignes_categories = $page_categorie_list->remplirLignesCategories();
$page_categorie_list->replaceBalise("#lignes_categories#", $lignes_categories);


$page_categorie_list->replaceBalise("#titre#", 'Liste des catégories');
$message = $page_categorie_list->getMessage();
$page_categorie_list->replaceBalise("#message#", $message);


//4) Affichage :
echo $page_categorie_list->getHtml();



