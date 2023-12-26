<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



include("bdd/config.php");


$stmt = $conn->prepare("SELECT compte_actif FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();

    // Vérifier si l'utilisateur est actif
    if ($user_data['compte_actif'] !== "oui") {
        header("Location: abonnement.php");
        exit();
    }
} else {
    // Utilisateur non trouvé dans la base de données
    header("Location: login.php");
    exit();
}


// Utiliser une requête préparée pour éviter les injections SQL
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();


$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();


    // echo "Nom d'utilisateur : " . $user_data['nomprenom'];
    // echo "Email : " . $user_data['numtel'];


    $proprietaire_bien = $user_data['nomprenom'];
    $numtel = $user_data['numtel'];
    $iduser = $user_data['id'];
} else {
    echo "Aucun utilisateur trouvé avec cet ID.";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST["libelle"];
    $superficie = $_POST["superficie"];
    $chambre = $_POST["chambre"];
    $terrasse = $_POST["terrasse"];
    $cuisine = $_POST["cuisine"];
    $prixbien = $_POST["prixbien"];
    $typebien = $_POST["typebien"];
    $categorie = $_POST["categorie"];
    $ville = $_POST["ville"];
    $image = file_get_contents($_FILES["image"]["tmp_name"]);

    // Traitement des images multiples
    $numImages = count($_FILES["imagesbien"]["name"]);
    $encodedImages = [];

    for ($i = 0; $i < $numImages; $i++) {
        $imageContent = file_get_contents($_FILES["imagesbien"]["tmp_name"][$i]);
        $encodedImages[] = base64_encode($imageContent);
    }

    $jsonImages = json_encode($encodedImages);

    $details = $_POST["details"];
    $typecategory = $_POST["typecategory"];

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO biens (libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, type_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category, images_bien) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Liaison des paramètres
    $stmt->bind_param("ssssssssssssssss", $libelle, $image, $details, $prixbien, $ville, $superficie, $chambre, $cuisine, $terrasse, $categorie, $typebien, $proprietaire_bien, $numtel, $iduser, $typecategory, $jsonImages);

    if ($stmt->execute()) {
        echo "<p class='toast-success'>Votre bien a été ajouté avec succès.</p>";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/ajout-bien.css">
    <title>Déposer une annonce</title>
</head>
<body>
    <!-- Header -->
    <?php include "navbar.php" ?>
    <div class="contenair-annonce">
        <section class="bloc-1-form">
            <form method="post" action="" class="add-annonce" enctype="multipart/form-data">
        <h1>SAISISSEZ VOTRE BIEN</h1>
        <div class="content-add-annonce">
            <input type="text" name="libelle" placeholder="Titre du bien"/>
            <input type="text" name="superficie" placeholder="Superficie en m2"/>
            <input type="text" name="chambre" placeholder="Nombre de chambre"/>
            <input type="text" name="terrasse" placeholder="Nombre de terrasse"/>
            <input type="text" name="cuisine" placeholder="Nombre de cuisine"/>
            <input type="text" name="prixbien" placeholder="Prix du bien"/>
            <input type="text" name="douche" placeholder="Nombre de douche"/>
            <input type="text" name="salon" placeholder="Nombre de salon"/>
            <input type="text" name="wc" placeholder="Nombre de W/C"/>
            <input type="text" name="salleamanger" placeholder="Nombre de salle à manger"/>
            <input type="hidden" name="typecategory"/>
            <select name="typebien" id="typebien" class="type-bien">
                <option value="">Selectionner le type de bien</option>
                <option value="Terrain">Terrain</option>
                <option value="Appartement">Appartement</option>
                <option value="Villa">Villa</option>
                <option value="Commerce">Commerce</option>
                <option value="Autres">Autres</option>
            </select>
            <select name="categorie" id="categorie" class="selection-category">
                <option value="">Selectionner votre catégorie</option>
                <option value="Vente">Vente</option>
                <option value="Location">Location</option>
            </select>
        </div>
        <input type="text" name="ville" placeholder="Ville ou quartier"/>
        <label for="image">Selectionner l'image principale</label>
        <input type="file" name="image" id="image">

        <label class="imagesbien" for="imagesbien">Selectionner d'autres images du bien</label>
        <input type="file" name="imagesbien[]" id="imagesbien" multiple accept="image/*">
        <textarea type="text" name="details" placeholder="Plus de details sur le bien"></textarea>
        <input type="submit" value="Ajouter l'annonce">
    </form>
    </section>
   
    </div>
    <?php include 'footer.php' ?>
</body>
</html>
