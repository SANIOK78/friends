<?php
    require_once 'connec.php';
    $pdo = new PDO(DSN, USER, PASS);

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Test "prénom"
        if(!isset($_POST['firstname']) || trim($_POST['firstname']) === '') {
            $errors[] = "Le prénom est obligatoire";
        } else {
            $firstname = htmlentities($_POST['firstname']);
        }

        // Test "nom"
        if(!isset($_POST['lastname']) || trim($_POST['lastname']) === '') {
            $errors[] = "Le nom est obligatoire";
        } else {
            $lastname = htmlentities($_POST['lastname']);
        }

        if(empty($errors)) {

            $req = "INSERT INTO pdo_quest.friend(firstname, lastname) VALUES(:prenom, :nom)";
            $statement = $pdo->prepare($req);

            $statement->bindValue(':prenom', $firstname, PDO::PARAM_STR );
            $statement->bindValue(':nom', $lastname, PDO::PARAM_STR );
            $statement->execute();

            header('Location: index.php');
        }
    }

    $query = "SELECT * FROM friend";
    $statement = $pdo->query($query);
    $friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Friends</title>
        <style>
            label, input{
                display:block;
                padding: 6px 0;
            }
            form{
                padding:20px;
                box-shadow: 1px 1px 10px rgba(0,0,0,0.4);
                max-width: 400px;
                border-radius: 8px;
            }
            button{margin-top: 10px; padding:4px 8px;}
        </style>
    </head>

    <body>
        <ul>
            <?php
                foreach($friendsArray as $friend): ?>
                    <li><?= $friend['firstname'] . ' ' . $friend['lastname'] ;?></li>
                
                <?php endforeach    

            ?>
        </ul>
        <form action="" method="post">
            <h1>Ajouter un acteur</h1>
            <div>
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div>
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <button type="submit">Enregistrer</button>
        </form>
        
    </body>
</html>