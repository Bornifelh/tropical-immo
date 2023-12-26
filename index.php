<!-- php verification login -->




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Tropical Immo - Accueil</title>
</head>

<body>
    <!-- Header -->
<?php include 'navbar.php' ?>

<!-- Main -->
    <main>
        <div class="contenair">
            <section class="bloc-1">
                <img src="assets/images/libreville.jpeg" alt="">
                <span class="form-content">
                        
                    <form action="" method="post" class="formulaire-recherche">
                    <h1>RECHERCHER UN BIEN</h1>
                        <span class="input-content">
                            <input class="ville-province" type="text" placeholder="Dans quelle ville ? Quartier ?">
                            <input class="montant-recherche" type="text" placeholder="Votre budget max ?">
                        </span>
                        <span class="chekbox">
                            <span class="item-checkbox">
                                <input type="checkbox" name="maison" id="">
                                <label for="maison">Maison</label>
                            </span>
                            <span class="item-checkbox">
                                <input type="checkbox" name="appartement" id="" value="Appatement2">
                                <label for="maison">Apparement</label>
                            </span>
                            <span class="item-checkbox">
                                <input type="checkbox" name="commerce" id="">
                                <label for="maison">Commerce</label>
                            </span>
                            <span class="item-checkbox">
                                <input type="checkbox" name="Terrain" id="">
                                <label for="terrain">Terrain</label>
                            </span>
                            <span class="item-checkbox">
                                <input type="checkbox" name="Autres" id="">
                                <label for="autres">Autres</label>
                            </span>
                            
                        </span>

                        <a class="src-avance" href="">Recherche avancée</a>

                        <button class="btn-search" type="submit">Rechercher</button>
                    </form>
                </span>
                
            </section>
            <section class="services-agence">
                <div class="content-serveices">
                    <a href="" class="btn-3d">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-badge-3d-fill" viewBox="0 0 16 16">
                            <path d="M10.157 5.968h-.844v4.06h.844c1.116 0 1.621-.667 1.621-2.02 0-1.354-.51-2.04-1.621-2.04z"/>
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.184 4.368c.646 0 1.055.378 1.06.9.008.537-.427.919-1.086.919-.598-.004-1.037-.325-1.068-.756H3c.03.914.791 1.688 2.153 1.688 1.24 0 2.285-.66 2.272-1.798-.013-.953-.747-1.38-1.292-1.432v-.062c.44-.07 1.125-.527 1.108-1.375-.013-.906-.8-1.57-2.053-1.565-1.31.005-2.043.734-2.074 1.67h1.103c.022-.391.383-.751.936-.751.532 0 .928.33.928.813.004.479-.383.835-.928.835h-.632v.914h.663zM8.126 11h2.189C12.125 11 13 9.893 13 7.985c0-1.894-.861-2.984-2.685-2.984H8.126z"/>
                        </svg>
                          Déposer une annonce avec service 3D
                    </a>
                    <a href="" class="btn-3d">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
                        <path d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5"/>
                    </svg>
                          Contacter notre agence
                    </a>

                </div>
            </section>

            <section class="bloc-2-2">

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
                <a class="voirplus" href="">Voir plus</a>
            </section>

            <section class="bloc-3">

            
            <span ></span>

                <?php
                    
                    include('bdd/config.php');

                    $sql = "SELECT id, libelle_bien, image_bien, details_bien, prix_bien, localisation_bien, superficie_bien, nb_chambre_bien, cuisine_bien, nb_terrasse_bien, id_category_bien, proprietaire_bien, numero_proprietaire_bien, id_proprietaire_bien, type_category FROM biens WHERE type_category = 'favoris'";
                    $result = $conn->query($sql);
                    $product_counter = 0;
                    echo "<h1 class='titre-coupcoeur' >Les favoris</h1>";

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
            <a class="voirplus" href="">Voir plus</a>
            </section>
            
        </div>
    </main>

    <?php include 'footer.php' ?>
</body>

</html>