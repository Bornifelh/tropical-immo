<!-- Register user -->

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("bdd/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $numtel = $_POST["numtel"];
    $nomprenom = $_POST["nomprenom"];
    $quartier = $_POST["quartier"];
    $proprietaire = $_POST["proprietaire"];
    $password = $_POST["password"];
    $photoprofile= $_POST["photoprofile"];
    $compteactif= $_POST["compteactif"];

    // Générez un identifiant unique pour numero_abonne
    $numero_abonne = uniqid();

    // Vérifiez si user ou numtel existent déjà dans la base de données
    $check_sql = "SELECT * FROM users WHERE user='$user' OR numtel='$numtel'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Nom d'utilisateur ou numéro de téléphone déjà existant.";
    } else {
        // Générez un sel aléatoire
        $salt = uniqid(mt_rand(), true);

        // Utilisez password_hash pour hacher le mot de passe avec le sel
        $hashed_password = password_hash($password . $salt, PASSWORD_BCRYPT);

        $insert_sql = "INSERT INTO users (user, password, numtel, nomprenom, numero_abonne, quartier, proprietaire, salt, photo_profile, compte_actif) VALUES ('$user', '$hashed_password', '$numtel', '$nomprenom', '$numero_abonne', '$quartier','$proprietaire', '$salt','$photoprofile', '$compteactif')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "Utilisateur ajouté avec succès.";
        } else {
            echo "Erreur : " . $insert_sql . "<br>" . $conn->error;
        }
    }
}
?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/login-register.css" />
    <title>Créer un compte</title>
  </head>
  <body>
    <div class="contenair-login">
      <div class="content-form">
        <div class="content-form-plus">
          <section class="content-img">
            <img src="assets/images/maison.png" alt="" />
          </section>
          <section class="content-login-view">
            <div class="content-logo">
              <img src="assets/images/logo.png" alt="" class="logo-login" />
            </div>
            <form action="" method="post" class="form-login">
              <h1 for="">Créer un compte</h1>
              <input
                name="nomprenom"
                class="phone-email"
                type="text"
                placeholder="Nom (s) & Prénom(s)"
              />
              <br />

              <input
                name="user"
                class="phone-email"
                type="text"
                placeholder="Utilisateur"
              />
              <br />

              <input
                name="numtel"
                class="phone-email"
                type="text"
                placeholder="Téléphone"
              />
              <br />


              <input style="display:none;"
                name="quartier"
                class="phone-email"
                type="hidden"
                placeholder="Téléphone"
              />

              <input style="display:none;"
                name="photoprofile"
                class="phone-email"
                type="hidden"
                placeholder="Téléphone"
              />

              <input style="display:none;"
                name="compteactif"
                class="phone-email"
                type="hidden"
                placeholder="Téléphone"
              />


              <input style="display:none;"
                name="proprietaire"
                class="phone-email"
                type="hidden"
                placeholder="Téléphone"
              />



              <input
                type="password"
                name="password"
                id="password"
                class="motdepasse"
                placeholder="Mot de passe"
              />
              <br />
              <button type="submit" name="register" class="submit">
                Créer un compte
              </button>
                <a href="login.php" name="login" class="register">
                  Se connecter
                </a>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
