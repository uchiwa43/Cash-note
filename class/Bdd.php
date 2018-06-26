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
    }

    /**
     * Exécute une requête SELECT pour plusieurs lignes sur la base
     * @param string $query Requête SQL
     * @return array|string Tableau de résultats ou message d'erreur
     */
    function select($query)
    {
        $array_sql=[];
        $reponse = $this->lien->query($query);

        while($ligne = $reponse->fetch(PDO::FETCH_ASSOC))
        {
            $array_sql[]= $ligne ;
        }
        if(!empty($array_sql))
        {
            return $array_sql;
        }else{
            return "La requête n'a renvoyé aucun résultat";
        }

    }

    /**
     * Exécute une requête SELECT pour une seule lignes sur la base
     * @param string $query Requête SQL
     * @return mixed|string Tableau de résultats ou message d'erreur
     */
    function selectOneLine($query)
    {
        $array_sql=[];
        $reponse = $this->lien->query($query);

        while($ligne = $reponse->fetch(PDO::FETCH_ASSOC))
        {
            $array_sql[]= $ligne ;
        }

        $array_one = $array_sql[0];

        if(!empty($array_one))
        {
            return $array_one;
        }else{
            return "La requête n'a renvoyé aucun résultat";
        }

    }

    /**
     * Renvoie le plus grand id de la table demandée
     * (attention il faudra ajouter +1 pour obtenir l'id pour l'insertion)
     * @param string $table Nom de la table
     * @return int Le plus grand id de cette table
     */
    public function selectMaxId($table)
    {
        $sql_one_data = "SELECT MAX(id) as max_id FROM $table";

        $reponse = $this->lien->query($sql_one_data);
        $array = $reponse->fetch(PDO::FETCH_ASSOC);

        return intval($array['max_id']);
    }

    /**Execute une requête INSERT, UPDATE ou DELETE sur la base de données
     * @param string $sql_insert Requête SQL
     * @return int nombre de lignes impactées
     */
    public function executeQuery($sql_insert)
    {
        $debug = $this->lien->exec($sql_insert);
        return $debug;
    }


}