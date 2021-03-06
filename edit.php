<?php
    require_once('db.php');
    //on vérifie si on reçoit le formulaire, on initialise des variables vide
    $nom = '';
    $prenom = '';
    $adresse = '';
    $complement = '';
    $cp = '';
    $ville = '';
    $dateEntry = '';
    $error = false;
    //si on a soumis le formulaire
    if(count($_POST) > 0){
      
        if(strlen(trim($_POST['nom'])) !== 0){
            $nom = trim($_POST['nom']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['prenom'])) !== 0){
            $prenom = trim($_POST['prenom']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['adresse'])) !== 0){
            $adresse = trim($_POST['adresse']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['cp'])) !== 0){
            $cp = trim($_POST['cp']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['ville'])) !== 0){
            $ville = trim($_POST['ville']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['date'])) !== 0){
            $dateEntry = trim($_POST['date']);
        }else{
            $error = true;
        }
        $complement = trim($_POST['complement']);
        //Si pas d'erreur alors on inserre dans la base de données
        if($error === false){
            
            $sql = "INSERT INTO stagiaire(nom, prenom, adresse, complement_adresse,cp, ville,date_entree) VALUES(:nom, :prenom,:adresse, :complement, :cp,:ville,:date)";
            $sth = $dbh->prepare($sql);
            //bindParam important pour se protéger contre l'injection sql.
            $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
            $sth->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $sth->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $sth->bindParam(':complement', $complement, PDO::PARAM_STR);
            $sth->bindParam(':cp', $cp, PDO::PARAM_STR);
            $sth->bindParam(':ville', $ville, PDO::PARAM_STR);
            $sth->bindValue(':date', strftime("%Y-%m-%d",strtotime($dateEntry)), PDO::PARAM_STR);
            $sth->execute(); 
        }
    } 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un(e) stagiaire</title>
</head>
<body>
    <h1>Ajouter un(e) stagiaire</h1>
    <div>
        <form action="" method="post">
            <div>
                <input type="text" name="nom" id="nom" placeholder="Nom" value="<?=$nom; ?>">
            </div>
            <div>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?=$prenom; ?>">
            </div>
            <div>
                <input type="text" name="adresse" id="adresse" placeholder="Adresse" value="<?=$adresse; ?>">
            </div>
            <div>
                <input type="text" name="complement" id="complement" placeholder="Complément adresse" value="<?=$complement; ?>">
            </div>
            <div>
                <input type="text" name="cp" id="cp" placeholder="Code postal" value="<?=$cp; ?>">
                <input type="text" name="ville" id="ville" placeholder="Ville" value="<?=$ville; ?>">
            </div>
            <div>
                <input type="date" name="date" id="date" placeholder="Date d'entrée" value="<?=$dateEntry; ?>">
            </div>
            <div>
               <button type="submit">Ajouter</button>
            </div>


        </form>

    </div>
</body>
</html>