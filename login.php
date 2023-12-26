
<!-- Php login -->
<?php
session_start();

include("bdd/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sélectionnez le mot de passe haché et le sel associé à l'utilisateur
    $sql = "SELECT id, user, password, salt, compte_actif FROM users WHERE user='$username' OR numtel='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];
        $compteactif = $user['compte_actif'];
        $salt = $user['salt'];

        // Utilisez password_verify pour vérifier le mot de passe
        if (password_verify($password . $salt, $hashed_password)) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['actif'] = $user['compte_actif'];
            header("Location: index.php");
        } else {
            echo "Identifiants incorrects.";
        }
    } else {
        echo "Identifiants incorrects.";
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/login-register.css" />
    <title>Se connecter</title>
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
            <form method="post" action="" class="form-login">
              <h1 for="">Connexion</h1>
              <input
                name="username"
                class="phone-email"
                type="text"
                placeholder="E-mail ou Téléphone"
              />
              <br />
              <input
                type="password"
                name="password"
                id="password"
                class="motdepasse"
                placeholder="Mot de passe"
              />
              <br />
              <div class="content-forget-remember">
                <span>
                  <input type="checkbox" name="remember" id="remember" /><label
                    for=""
                    >Se souvenir</label
                  >
                </span>

                <a class="btn-recoverypass" href=""
                  >Mot de passe oublié ?</a
                >
              </div>

              <button type="submit" class="submit">Se connecter</button>
              <a href="register.php" class="register">Créer un compte</a>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
