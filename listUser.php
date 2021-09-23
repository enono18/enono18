<?php 
require_once "./config/connectDb.php";
$bdd = connectDBS();
include("./connexionbdd.php"); 
    session_start();
    $tab = $_SESSION["listUser"]; // Récupération du tableau utilisateur

    $user = [];

    // Gestion de la déconnexion
    if (isset($_GET["deco"])) {
        $_SESSION["auth"] = false;
    }

    // Si la variable de session auth est à false, on redirige vers la connexion
    if ($_SESSION["auth"] == false) {
        header("Location: ./signin.php");
    }

    // Traitement du formulaire de création directement dans cette page
    if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["ville"]) && isset($_POST["age"])) { // On vérifie que tous les champs du formulaire soit remplis
        // Si le nom a changer, on supprime les anciennes info de l'utilisateur
        if (isset($_POST["oldNom"])) {
            if ($_POST["nom"] != $_POST["oldNom"]) {
            unset($tab[$_POST["oldNom"]]);
            }
        }
        
        // Ajout du nouvel utilisateur à la fin du tableau
        $tab[$_POST["nom"]] = [$_POST["prenom"], $_POST["ville"], $_POST["age"]];
    
        // Sauvegarde du tableau mis à jour dans la session
        $_SESSION["listUser"] = $tab;
        }
    
        // Traitement du formulaire de suppression directement dans cette page
        if (isset($_POST["supp"])) {
        // suppression dans le tableau
        unset($tab[$_POST["supp"]]);
    
        // Sauvegarde du tableau mis à jour dans la session
        $_SESSION["listUser"] = $tab;
        }

    include("./includes/header.php");
?>
    <body>
        <?php 
        include("./includes/nav.php");
        ?>
        <div class="d-flex justify-content-md-center">
            <h1>Liste des utilisateurs</h1>
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Mail</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tab = [];
                // Boucle sur le tableau
                foreach ($tab as $key => $value) {
                ?>
                    <tr>
                        <td><?=$value[0];?></td>
                        <td><?=$value[2];?></td>
                        <td class="d-flex">
                        <form action="#" method="post">
                            <input type="hidden" name="supp" value="<?=$key;?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php 
        include("./includes/footer.php");
        ?>
    </body>
</html>