<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 22:34
 * Description:
 */

include_once('class/Page.php');

$page = new Page("./template/user_list.html");

$message ="l'utilisateur a bien été ajouté";
$page->replaceBalise('#message#', $message);

$lien="<a href=''>Lien</a>";
$page->replaceBalise('#lien#',$lien);

echo $page->getHtml();