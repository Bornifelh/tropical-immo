<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("bdd/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Locations</title>
</head>
<body>
       <!-- Header -->
        <?php include 'navbar.php' ?>

        <section class="bloc-2">

            
<span ></span>

    <?php
        
        include('bdd/config.php');

        $sql = "SELECT id, libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category FROM biens WHERE id_category_bien = 'location'";
        $result = $conn->query($sql);
        $product_counter = 0;
        echo "<h1 class='titre-coupcoeur' >Les biens en location</h1>";

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
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-star-fill' viewBox='0 0 16 16'>";
            echo "<path d='M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z'/>";
            echo "<svg>";
            echo "</a>";
            echo "</div>";
            echo "<a href='details_bien.php?id=" . $row['id'] . "' class='voir-bien'> Voir le bien </a>";

            echo "</div>";
            echo "</div>";
            

            

        }

        "</div>";
        $product_counter++;
    ?>
</section>


        <?php include 'footer.php' ?>
    
</body>
</html>