<?php
    require_once('db.php');
    //Tester l'existence de la variable d'url
    if(isset($_GET['id'])){
        //Requete sql de suppression avec marqueur nommé qui sera lié avec une variable
        $sql = 'delete from stagiaire where id= :id';
        //Prépare la requête
        $sth = $dbh->prepare($sql);
        //Lien entre le marqueur nommé et une variable en précisant le type de données
        //de la colone sql
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        //on exécute la requête
        $sth->execute();
        //header() on manipule l'entête http, 
        header('Location: index.php');
    }

?>