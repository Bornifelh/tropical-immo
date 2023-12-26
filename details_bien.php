<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("bdd/config.php");

// Utiliser une requête préparée pour éviter les injections SQL
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $proprietaire_bien = $user_data['nomprenom'];
    $numtel = $user_data['numtel'];
    $iduser = $user_data['id'];
} else {
    echo "Aucun utilisateur trouvé avec cet ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/details_bien.css">
    <title>Details - produit</title>
</head>
<body>
<?php include('navbar.php') ?>

<div class="contenair-details-bien">



<?php
echo "<div class='contenair-bien'>"; 
include('bdd/config.php');

// Récupérer l'ID du bien depuis les paramètres de requête
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Utiliser une requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT id, libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, type_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category, images_bien FROM biens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    // Afficher les biens
    while ($row = $result->fetch_assoc()) {
       
        echo "<div class='content-details-produit'>";
            echo "<div class='content-details'>";
                echo "<img class='image-main' src='data:image/jpeg;base64," . base64_encode($row['image_bien']) . "' alt='". $row['libelle_bien'] ."'/>";

                echo "<div class='content-images-bien'>";

                    $encodedImages = $row['images_bien'];

                    // Vérifier si des images existent avant de tenter de les décoder et les afficher
                    if ($encodedImages !== null) {
                        $decodedImages = json_decode($encodedImages);

                        // Vérifier si le décodage a réussi
                        if ($decodedImages !== null) {
                            foreach ($decodedImages as $encodedImage) {
                                $imageContent = base64_decode($encodedImage);
                                echo '<img class="images-bien" src="data:image/png;base64,' . base64_encode($imageContent) . '" alt="Image">';
                            }
                        } else {
                            echo 'Erreur lors du décodage des images.';
                        }
                    } else {
                        echo 'Aucune image disponible.';
                    }
                echo "</div>";
                
            
                echo "<div class='content-infos'>";
                    echo "<h1>" . $row['libelle_bien'] . "</h1>";
                    echo "<div class='content-infos-plus'>";

                        // Prix du bien
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Prix du Bien</label>";
                            echo "<p class='prix-product'>" . $row['prix_bien'] ." F CFA</p>";
                        echo "</div>";

                        // Chambres
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Chambre(s)</label>";
                            echo "<p class='prix-product'>" . $row['nb_chambre_bien'] ."</p>";
                        echo "</div>";

                        // Terrasse
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Terrasse(s)</label>";
                            echo "<p class='prix-product'>" . $row['nb_terrasse_bien'] ."</p>";
                        echo "</div>";

                        // Cuisine
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Cuisine(s)</label>";
                            echo "<p class='prix-product'>" . $row['cuisine_bien'] ."</p>";
                        echo "</div>";

                        // superficie
                        echo "<div class='superficie-bien-div'>";
                            echo "<label class='label-bien-div'>Superficie</label>";
                            echo "<p>" . $row['superficie_bien'] . "</p>";
                        echo "</div>";


                        // Type bien
                        echo "<div class='superficie-bien-div'>";
                            echo "<label class='label-bien-div'>Etat du bien</label>";
                            echo "<p>" . $row['id_category_bien'] . "</p>";
                        echo "</div>";



                    echo "</div>";

                    echo "<div class='content-infos-plus'>";

                        // Localisation du bien
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Localisation</label>";
                            echo "<p class='prix-product'>" . $row['localisation_bien'] ."</p>";
                        echo "</div>";

                        // Localisation du bien
                        echo "<div class='prix-bien-div'>";
                            echo "<label class='label-bien-div'>Type de bien</label>";
                            echo "<p class='prix-product'>" . $row['type_bien'] ."</p>";
                        echo "</div>";

                        

                    echo "</div>";

                    echo "<p class='details-product-details'>" . $row['details_bien'] . "</p>";
                    echo "<p>" . $row['proprietaire_bien'] . "</p>";
                    
                    echo "<a class='btn-callcenter' href='tel:062260717' >Nous contacter</a>";
                    // echo "<a href='to:" . $row['numero_proprietaire_bien'] . "' >Proprietaire</a>";
                echo "</div>";

            echo "</div>";

        echo "</div>";
    
    }
} else {
    echo "ID du bien non spécifié.";
}

// Fermer la connexion à la base de données
$conn->close();
echo"</div>";
?>

<div class="agence-immo">
    <h3 class="nom-agence">
    SCI AGENCE TROPICALE
    </h3>
    <h5>Agence immobilière</h5>

    <div class="btn-agence">
        <a class="profil" href="">Profil de l'agence</a>
        <a href="">Site de l'agence</a>
        <a class="tarif" href="">Nos tarifs</a>
    </div>
    <p class="infos-p p">Informations légales de l'agence</p>
    <p class="infos-p">SCI agence tropicale, au capital de 10 000 000F CFA</p>
    <p class="infos-p">Siège : face hôtel du stade, Likuala, Libreville Gabon</p>
</div>
</div>
</body>
</html>
