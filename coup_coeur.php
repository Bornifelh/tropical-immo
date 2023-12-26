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
    <title>Coups de coeur de l'agence</title>
</head>
<body>
       <!-- Header -->
        <?php include 'navbar.php' ?>
        <section class="bloc-2">

<h1 class="titre-coupcoeur" >Nos coups de cœur</h1>
<span ></span>

    <?php

        include('bdd/config.php');

        $sql = "SELECT id, libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category FROM biens WHERE type_category = 'coupdecoeur'";
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
    ?>
</section>

       
    
</body>
<?php include 'footer.php' ?>
</html>