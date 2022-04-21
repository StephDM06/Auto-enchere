<?php

// Insertion des  encheres dans notre base de données

// On vérifie que l'utilisateur est bien connecté
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();

    if (!isset($_SESSION["user_id"])) {
        // S'il n'est pas connecté, on le renvoit vers la page de connexion
        header("Location: connexion.php");
        die();
    }
    // Sinon on insère son enchere dans notre base de données

    $id_user_acheteur = $_SESSION["user_id"];
    $id_annonce = filter_var($_POST["id_annonce"], FILTER_SANITIZE_NUMBER_INT);
    $prix_propose = filter_var($_POST["prix_propose"], FILTER_SANITIZE_NUMBER_FLOAT);
    $annonce_id = filter_var($_POST["detailAnnonce"], FILTER_SANITIZE_NUMBER_INT);
    $prixAnnonce = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT);

    $dataBase = new PDO("mysql:dbname=auto_enchere;host=localhost", "root", "");
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_insert_enchere1.css">
    <title> Auto Enchere</title>

</head>

<body>

    <header>

        <a href="index.php"><img src="images/logo.png" alt="" class="logo" /></a>
        <a href="index.php"><img src="images/logo_text.png" alt="" class="logo_text" /></a>

        <nav>
            <?php if (isset($_SESSION["user_id"])) { ?>
                <a href="edit_profil.php"> <button> Modifier votre profil </button> </a>
                <a href="deconnexion.php"><button> Déconnexion </button></a>

            <?php } else { ?>
                <a href="connexion.php"> <button> Connexion </button> </a>
                <a href="inscription.php"> <button> Inscription </button> </a>
            <?php } ?>
        </nav>

    </header>
    <?php
    if ($annonce_id < $prix_propose && $prix_propose > $prixAnnonce) {
        $requete = $dataBase->prepare("INSERT INTO enchere (id_annonce, id_user_acheteur, prix_propose)
    VALUES (?, ?, ?)");
        $result = $requete->execute([$id_annonce, $id_user_acheteur, $prix_propose]); ?>
        <div class="result">
            <p>Votre enchère est bien soumise</p>
        </div>
    <?php } else { ?>
        <div class="result">
            <p>Le prix renseigné ne convient pas !</p>
        </div>

    <?php } ?>
    <div class="container">
        <img src="images/enchere.png" alt="" class="img_enchere">

        <a href="annonce.php"><button> Revenir aux offres </button></a> <br>



    </div>



</body>

</html>