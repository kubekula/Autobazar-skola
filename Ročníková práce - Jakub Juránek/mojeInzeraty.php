<?php 
require 'header.php';
$e = 0;
?>

<div class="dolek">
    <div class="card-container">
        <?php 
        
        $sql = "SELECT * FROM webova_stranka_auta";      //vybere tabulku   
        $stmt = $conn->prepare($sql);                   //pripoji se do databaze
        $stmt->execute();                               //provede dotaz
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);   //nacte vysledky do pole
        
        foreach ($results as $t) {                     //pocita pocet inzeratu
            if ($_SESSION['prezdivka'] == $t['prezdivka']){
                $e++; // Zvyšujeme počet vozidel
            }
        }

        echo "<h3>Počet inzerátů : ".$e."</h3>";

       // Zobrazi inzeraty
       foreach ($results as $t) {
        if ($_SESSION['prezdivka'] == $t['prezdivka']){
            echo '<a href="auto.php?id=' . $t['id'] . '">';
        echo '<div class="card">';
        if (!empty($t['image_data'])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($t['image_data']) . '" alt="Obrázek ' . $t['id'] . '" class="product-image">';
        } else {
            echo '<p>Obrázek nenalezen</p>';
        }
        echo '<h3>' . $t['nazev'] . '</h3>';
        echo '<h4>Cena : '.$t['cena'].' Kč</h4>';
        echo '</a>';
        echo '</div>'; 
        }
    }

        if($e == 0){
            echo 'Nemáte žádné inzeráty';
        }


    ?>
</div>
</div>