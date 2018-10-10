<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 03/07/2018 23:14
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


//1)MODEL : requête de selection des achats
$bdd = new Bdd();


$query =" 
SELECT a.id, a.libelle, prix_achat_reel, prix_achat_prevu, 
date_achat_reelle, date_achat_prevue_debut, date_achat_prevue_fin,date_debit,
a.id_etat, e.libelle AS etat, id_categorie, c.libelle AS categorie, id_moyen_payement, mp.libelle AS moyen_payement,
id_lieu, l.libelle as lieu , id_site_internet, s.libelle AS site, s.url AS url_site, a.url_produit
FROM achat a
JOIN etat e ON a.id_etat = e.id
JOIN categorie c ON a.id_categorie = c.id
JOIN moyen_payement mp ON a.id_moyen_payement = mp.id
JOIN lieu l ON a.id_lieu = l.id
LEFT JOIN site_internet s ON a.id_site_internet = s.id
 ";
$achats_non_formates = $bdd->select($query);

$query_categories="SELECT * from categorie";
$categories = $bdd->select($query_categories);

$query_types="SELECT * from type_categorie";
$types_categories = $bdd->select($query_types);

$query_lieux="SELECT * from lieu";
$lieux = $bdd->select($query_lieux);




//2)VIEW: chargement du template
$page_achat_list = new AchatController('./template/achat_list_view.html');



//3)CONTROLLER
$achats =[];
foreach($achats_non_formates as $achat)
{
    foreach($achat as $field=>$value)
    {
        if ($field=='id')
        {
            $achats[$value] = $achat;
        }
    }
}
$_SESSION['achats'] = $achats;
//var_dump($achats);

$test = file_get_contents('./template/achat_recherche.html');
//var_dump($test);//it works

$message = $page_achat_list->getMessage();
$page_achat_list->replaceBalise("#message#", $message);
$page_achat_list->replaceBalise("#titre#", 'Liste des Achats');

$page_achat_list->replaceBalise("#achat_recherche#", $test);
$page_achat_list->setCategories($categories);
$page_achat_list->setTypes($types_categories);
$page_achat_list->setLieux($lieux);
$page_achat_list->replaceBalise("<select","<br/><select");
$page_achat_list->replaceBalise("</select><br/><br/>","</select>");

$lignes_achat = $page_achat_list->remplirLignesAchats();
$page_achat_list->replaceBalise("#lignes_achats#", $lignes_achat);


//4) Affichage :
echo $page_achat_list->getHtml();



var_dump($_POST);