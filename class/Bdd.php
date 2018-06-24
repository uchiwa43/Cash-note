<?php
/**
 * Created by: Thomas DUPORT
 * Project: Cash-note
 * Date: 24/06/2018 22:42
 * Description:
 */

class Bdd
{
    /**
     * lien de connexion à la base de données mysql
     * @var object PDO
     */
    protected $lien;

    /**
     * Constructeur de la connexion à la base
     */
    function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=cash_note';
        $username = 'root';
        $password = '';
        $this->lien = new PDO($dsn,$username,$password);
        echo "<div class='BDD'>La connection à la base a bien été faite</div>";
    }

    /**
     * Exécute une requête SELECT sur la base
     * @param string $query
     * @return array|string
     */
    function querySelect($query)
    {
        $array_sql=[];
        $reponse = $this->lien->query($query);

        while($ligne = $reponse->fetch(PDO::FETCH_ASSOC))
        {
            $array_sql[]= $ligne ;
            //echo "Ligne :";
            //var_dump($ligne);
        }
        if(!empty($array_sql))
        {
            return $array_sql;
        }else{
            return "La requête n'a renvoyé aucun résultat";
        }

    }
}