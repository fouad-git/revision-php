# revision php et sql, livecoding avec manu
## connexion à la base de donnée
Pour se connecter en utilisant PDO, nous allons devoir instancier la classe ```PDO``` en passant au constructeur la source de la base de données (serveur + nom de la base de données) ainsi qu’un nom d’utilisateur et un mot de passe.
```
<!DOCTYPE html>
<html>
    <head>
        <title>Cours PHP / MySQL</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="cours.css">
    </head>
    <body>
        <h1>Bases de données MySQL</h1>  
        <?php
            $servername = 'localhost';
            $username = 'root';
            $password = 'root';
            
            //On essaie de se connecter

            try{
                $conn = new PDO("mysql:host=$servername;dbname=bddtest", $username, $password);
                //On définit le mode d'erreur de PDO sur Exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Connexion réussie';
            }
            
            /*On capture les exceptions si une exception est lancée et on affiche
             *les informations relatives à celle-ci*/

            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }
        ?>
    </body>
</html>
```
Vous pouvez déjà remarquer ici que pour se connecter à une base de données avec PDO, vous devez passer son nom dans le constructeur de la classe ```PDO```. Cela implique donc qu’il faut que la base ait déjà été créée au préalable (avec phpMyAdmin par exemple) ou qu’on la crée dans le même script.

Notez également qu’avec PDO il est véritablement indispensable que votre script gère et capture les exceptions (erreurs) qui peuvent survenir durant la connexion à la base de données.
En effet, si votre script ne capture pas ces exceptions, l’action par défaut du moteur Zend va être de terminer le script et d’afficher une trace. Cette trace contient tous les détails de connexion à la base de données (nom d’utilisateur, mot de passe, etc.). Nous devons donc la capturer pour éviter que des utilisateurs malveillants tentent de la lire.

Pour faire cela, nous allons utiliser des blocs ```try``` et ```catch```.
Ici, nous utilisons également la méthode ```setAttribute()``` en lui passant deux arguments ```PDO::ATTR_ERRMODE``` et ```PDO::ERRMODE_EXCEPTION```.
La méthode ```setAttribute()``` sert à configurer un attribut PDO. Dans ce cas précis, nous lui demandons de configurer l’attribut ```PDO::ATTR_ERRMODE``` qui sert à créer un rapport d’erreur et nous précisons que l’on souhaite qu’il émette une exception avec ```PDO::ERRMODE_EXCEPTION```.

Plus précisément, en utilisant ```PDO::ERRMODE_EXCEPTION``` on demande au PHP de lancer une exception issue de la classe PDOException (classes étendue de Exception) et d’en définir les propriétés afin de représenter le code d’erreur et les informations complémentaires.

Ensuite, nous n’avons plus qu’à capturer cette exception PDOException et à afficher le message d’erreur correspondant. C’est le rôle de notre bloc ```catch```.


## Préparation et exécution d'une requête préparée
La base de données MySQL supporte les requêtes préparées. Une requête préparée ou requête paramétrable est utilisée pour exécuter la même requête plusieurs fois, avec une grande efficacité.

L'exécution d'une requête préparée se déroule en deux étapes : la préparation et l'exécution. Lors de la préparation, un template de requête est envoyé au serveur de base de données. Le serveur effectue une vérification de la syntaxe, et initialise les ressources internes du serveur pour une utilisation ultérieure.
La préparation : 
```
$sql = 'SELECT id, nom, prenom, cp, ville, date_entree FROM stagiaire';
        $sth = $dbh->prepare($sql);
```
L'exécution : 
```
$sth->execute();
        //on va récupérer l'extraction ou le résultat de la requête
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
```

La préparation est suivie de l'exécution. Pendant l'exécution, le client lie les valeurs des paramètres et les envoie au serveur. Le serveur crée une requête depuis le template et y lie les valeurs pour l'exécution, en utilisant les ressources internes créées précédemment.