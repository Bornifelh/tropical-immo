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


    // echo "Nom d'utilisateur : " . $user_data['nomprenom'];
    // echo "Email : " . $user_data['numtel'];


    $proprietaire_bien = $user_data['nomprenom'];
    $numtel = $user_data['numtel'];
    $iduser = $user_data['id'];
    $imageprofile = $user_data['photo_profile'];
    $numabonne = $user_data['numero_abonne'];
} else {
    echo "Aucun utilisateur trouvé avec cet ID.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/profile.css">
    <title>Mon compte</title>
</head>
<body>
<?php include 'navbar.php' ?>

<?php
echo "<div class='contenair-profile'>";
    echo "<div class='section-content'>";
        echo "<div class='content-data-profile'>";
            echo "<div class='data-profile'>";
            echo "<img class='image-proprio' src='data:image/jpeg;base64," . base64_encode($imageprofile) . "' alt='PHOTO PROFILE'/>";
            echo "<h1>$proprietaire_bien</h1>";
            echo "<p>Numéro d'abonné</p>";
            echo "<h3>$numabonne</h3>";
                // ligne des boutons ---------
                echo "<div class='content-btn-profile'>";

                    // btn update
                    echo "<div class='btn-reabonnement'>";
                        echo "<label>Modifier profile</label>";
                        echo "<a href='to:$numtel'>";
                            echo "<svg xmlns='http://www.w3.org/2000/svg' width='80' height='40' fill='currentColor' class='bi bi-credit-card-fill' viewBox='0 0 16 16'>";
                                echo "<path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>";
                                echo "<path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>";
                            echo "</svg>";
                        echo "</a>";
                    echo "</div>";
                    // ------------btn update

                    // btn reabonnement
                    echo "<div class='btn-reabonnement'>";
                        echo "<label>Abonnement</label>";
                        echo "<a href='to:$numtel'>";
                            echo "<svg xmlns='http://www.w3.org/2000/svg' width='80' height='40' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>";
                                echo "<path d='M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1'/>";
                            echo "</svg>";
                        echo "</a>";
                    echo "</div>";
                    // ------------btn reabonnement

                    // btn contact agence
                    echo "<div class='btn-reabonnement'>";
                        echo "<label>Agence</label>";
                        echo "<a href='mailto:agencetropical@tropicalimmo.com'>";
                            echo "<svg xmlns='http://www.w3.org/2000/svg' width='80' height='40' fill='currentColor' class='bi bi-headset' viewBox='0 0 16 16'>";
                                echo "<path d='M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5'/>";
                            echo "</svg>";
                        echo "</a>";
                    echo "</div>";
                    // ------------contact agence



                echo "</div>";
                // ---------------------- liste des boutons
            echo "</div>";

            
        echo "</div>";
        echo "<div class='content-bien-personnel'>";

            include('bdd/config.php');

            $sql = "SELECT id, libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category FROM biens WHERE id_proprietaire_bien = '$iduser'";
            $result = $conn->query($sql);
            $product_counter = 0;
            echo "<div class='content-produits'>";
            while ($row = $result->fetch_assoc()) {
                if ($product_counter >= 8) {
                break;
                };

                echo "<div class='content-bien-view'>";
                echo "<img class='image-bien' src='data:image/jpeg;base64," . base64_encode($row['image_bien']) . "' alt='". $row['libelle_bien'] ."'/>";
                echo "<div class='content-text-bien'>";
                echo "<h1 class='libele-bien'>" . $row['libelle_bien'] . "</h1>";
                // détails bien: superficie | Nb chambre | Nb cuisine | Nb terrasse | 
                echo "<div class='tout-detaisl'>";
                echo "<div class='item-content'>";
                echo "<h4> Superficie </h4>";
                echo "<h4 class='item-content-h4-bas'>" . $row['superficie_bien']."</h4>";
                echo "</div>";
                // Nb chambre
                echo "<div class='item-content'>";
                echo "<h4> Chambres </h4>";
                echo "<h4 class='item-content-h4-bas'>" . $row['nb_chambre_bien']."</h4>";
                echo "</div>";
                // Nb cuisine
                echo "<div class='item-content'>";
                echo "<h4> Cuisine </h4>";
                echo "<h4 class='item-content-h4-bas'>" . $row['cuisine_bien']."</h4>";
                echo "</div>";

                // Nb Terrasse
                echo "<div class='item-content'>";
                echo "<h4> Terrasse </h4>";
                echo "<h4 class='item-content-h4-bas'>" . $row['nb_terrasse_bien']."</h4>";
                echo "</div>";

                echo "<h1 class='prix-bien' style='text-align:center;'>" . $row['prix_bien'] . "F CFA</h1>";
                echo "<a class='coupdecoeur-item'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>";
                echo "<path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>";
                echo "<svg>";
                echo "</a>";
                echo "</div>";
                echo "<a href='details_bien.php?id=" . $row['id'] . "' class='voir-bien'> Voir le bien </a>";

                echo "</div>";
                echo "</div>";
                

                

            }

            "</div>";
            $product_counter++;
        echo "</div>";
    echo "</div>";
echo "</div>";
?>
    <?php include 'footer.php' ?>
</body>
</html>

