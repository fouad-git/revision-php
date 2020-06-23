

<?php
    require_once('db.php');//Comme le include mais il est utilisable une seule fois (il inclut le script de connexion à la bdd)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagiaires</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Stagiaires</h1>
    <p><a href="edit.php">Ajouter</a></p>
    <table>
    <tr>ID
        <th> 
            Nom/Prénom
        </th>
        <th>
            CP/ville
        </th>
        <th>
            Date d'entrée
        </th>
        <th>
            Modifier/Supprimer
        </th>
    </tr>
    <?php
        //Prépartion de la requête
        $sql = 'SELECT id, nom, prenom, cp, ville, date_entree FROM stagiaire';
        //avec la variable $dbh qui contient l'objet connexion avec cette variable on prepare la requête et on récupere ts ça ds la variable $sth
        $sth = $dbh->prepare($sql);
        //on execute
        $sth->execute();//on demande l'exécution de la requête
        //on va récupérer l'extraction ou le résultat de la requête
        $result = $sth->fetchAll(PDO::FETCH_ASSOC); //on récupere toutes les lignes sous forme de tableau associatif.
        //Déclaration ou gestion des formats des dates en français
        $intlDateFormater = new IntlDateFormatter('fr FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);

        //on parcourt le résultat et imprimé et à l'écran les données
        //pour les parcourirs toutes les lignes on une boucle foreach
        foreach($result as $row){
            echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
            echo '<td>'.$row['nom'].' '.$row['prenom'].'</td>';
            echo '<td>'.$row['cp'].' '.$row['ville'].'</td>';
            echo '<td>'.$intlDateFormater->format(strtotime($row['date_entree'])).'</td>';
            echo '<td><a href="edit.php?edit=1&id='.$row['id'].'">Modifier</a> <a href="delete.php?id='.$row['id'].'">Supprimer</a></td>';
            echo'</tr>';
                                }
    ?>
    </table>
    <?php
        //Si le nombre d'élément dans le tableau
        //Alors tableau vide - Donc pas d'enregistrement(on met 3 égal pour vérifier l'égalité et le type)
        if(count($result) === 0){
            echo '<p>Aucun stagiaire</p>';
        }
    ?>
</body>
</html>