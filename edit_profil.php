<?php
session_start();

$data_base = new PDO("mysql:dbname=auto_enchere;host=localhost", "root", "");

if (isset($_SESSION['user_id'])) {

    $requete = $data_base->prepare("SELECT * FROM user WHERE id = ?");
    $requete->execute([$_SESSION['user_id']]);
    $user = $requete->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $newnom = htmlspecialchars($_POST['newnom']);
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $newemail = htmlspecialchars($_POST['newemail']);
        $mdp1 = $_POST['newmdp1'];
        $mdp2 = $_POST['newmdp2'];

        $editResult = true;


        if (isset($_POST['newnom'])) {

            $insert_nom = $data_base->prepare("UPDATE user SET nom = ? WHERE id = ?");
            $result = $insert_nom->execute([$newnom, $_SESSION['user_id']]);
            $editResult = $result == false ? false : $editResult;
        }

        if (isset($_POST['newprenom'])) {

            $insert_prenom = $data_base->prepare("UPDATE user SET prenom = ? WHERE id = ?");
            $result = $insert_prenom->execute([$newprenom, $_SESSION['user_id']]);
            $_SESSION['user_firstname'] = $newprenom;
            $editResult = $result == false ? false : $editResult;
        }

        if (isset($_POST['newemail'])) {

            if (filter_var($_POST['newemail'], FILTER_VALIDATE_EMAIL)) {
                $insertemail = $data_base->prepare("UPDATE user SET email = ? WHERE id = ?");
                $result = $insertemail->execute([$newemail, $_SESSION['user_id']]);
                $editResult = $result == false ? false : $editResult;
            }
        }

        if (isset($mdp1) && $mdp1 == $mdp2) {
            $insertmdp = $data_base->prepare("UPDATE user SET password = ? WHERE id = ?");
            $result = $insertmdp->execute($mdp1, $_SESSION['user_id']);
            $editResult = $result == false ? false : $editResult;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <!-- <link rel="stylesheet" href="style_edit_profil2.css"> -->
        <title>Document</title>
    </head>

    <body>

        <header>

            <a href="index.php"><img src="images/logo.png" alt="" class="logo" /></a>
            <a href="index.php"><img src="images/logo_text.png" alt="" class="logo_text" /></a>

            <nav>
                <?php if (isset($_SESSION["user_id"])) { ?>
                    <a href="edit_profil.php"> <button> Modifier votre profil </button> </a>
                    <a href="deconnexion.php"><button> D??connexion </button></a>

                <?php } else { ?>
                    <a href="connexion.php"> <button> Connexion </button> </a>
                    <a href="inscription.php"> <button> Inscription </button> </a>
                <?php } ?>
            </nav>

        </header>

        <div class="div_form ">
            <form method="POST" action="edit_profil.php">
                <u>
                    <h2>Nom :</h2>
                </u>
                <br />
                <br />


                <label> Entrez votre nouveau nom : </label>
                <input type="text" name="newnom" placeholder="<?= $user["nom"]; ?>">

                <br />
                <br />
                <hr />


                <u>
                    <h2>Prenom :</h2>
                </u>
                <br />
                <br />


                <label>Entrez votre nouveau prenom :</label>
                <input type="text" name="newprenom" placeholder="<?= $user["prenom"]; ?>">

                <br />
                <br />
                <hr />



                <u>
                    <h2>Email :</h2>
                </u>


                <br />
                <br />

                <label for="email">Entrez votre nouvel email :</label>
                <input type="text" name="newemail" placeholder="<?= $user["email"]; ?>">

                <br />
                <br />
                <hr />



                <u>
                    <h2>Mot de passe :</h2>
                </u>
                <label>Entrez votre nouveau mot de passe :</label>
                <input type="password" name="newmdp1" placeholder="...">

                <br />
                <br />

                <label>Confirmation du nouveau mot de passe :</label>
                <input type="password" name="newmdp2" placeholder="..." />

                <br />
                <br />


                <input type="submit" name="submit" value="Mettre ?? jour mon profil !" />
                <?php
                if (isset($editResult) && $result == true) {
                    echo "Vos donn??es ont ??t?? mises ?? jour !"; ?>

                <?php } ?>

            </form>
        </div>
        <div id="retour">
            <a href="index.php"><button>Retour ?? l'accueil</button></a>

        </div>

    <?php } else {
    echo  "Vos deux mot de passe ne correspondent pas !";
}
    ?>
    </body>

    </html>