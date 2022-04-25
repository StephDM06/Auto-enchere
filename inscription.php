<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title> Auto Enchere</title>

    <link rel="stylesheet" href="style_inscript1.css">
</head>

<body>

    <header>

        <img src="images/logo.png" alt="" class="logo" />
        <a href="index.php"><img src="images/logo_text.png" alt="" class="logo_text" /></a>

        <nav>
            <?php if (isset($_SESSION["user_id"])) { ?>
                <a href="edit_profil.php"> <button> Modifier votre profil </button> </a>
                <a href="deconnexion.php"><button> Déconnexion </button></a>

            <?php } else { ?>
                <a href="connexion.php"> <button> Connexion </button> </a>
                <a href="inscription.php"> <button> Inscription </button> </a>
            <?php } 
            
            if (isset($_SESSION["user_firstname"])) {
            ?> <p> Bienvenue <?php echo $_SESSION["user_firstname"]; ?>, vous êtes connecté(e) </p>
            <?php } //else {
            //header('Location: inscription.php');
            //} 
            ?>
        </nav>

    </header>

    <div class="div_form">

        <form action="verifpassword.php" method="POST">

            <label for="nom">Votre nom:</label>
            <input type="text" name="nom" id="nom">

            <label for="prenom">Votre prénom:</label>
            <input type="text" name="prenom" id="prenom">

            <label for="email"> Votre email :</label>
            <input type="email" name="email" id="email" value="">

            <label for="password"> Votre mot de passe : </label>
            <input type="password" name="password" id="password" value="">

            <label for="password2"> Confirmez votre mot de passe : </label>
            <input type="password" name="password2" id="password2">

            <button> Valider </button>
        </form>
    </div>

</body>

</html>