<?php 
require 'header.php';
?>

<div class="user-container">
    <?php 
        $sql = "SELECT * FROM webova_stranka_uzivatele";   //vybere tabulku 
        $stmt = $conn->prepare($sql);                      //pripoji se do databaze
        $stmt->execute();                                  //provede dotaz
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);      // načte výsledky do pole


        echo '<div class="mujUcet">';
        echo '<h1>Můj účet</h1><br><br>' ;
        
        // Zobrazi informace o uzivateli
        foreach ($results as $t) {
            if ($_SESSION['prezdivka'] == $t['prezdivka']) {
               
               
               echo 'Jméno : '.$t['jmeno'].' '.$t['prijmeni'].'<br>';
               echo 'Přezdívka : '.$t['prezdivka'].'<br>';
               echo 'Email : '.$t['email'].'<br>';
               echo 'Telefon : '.$t['telefon'].'<br>';

                

            }
        }
        echo '</div>';

    ?>
</div>


<?php 
require 'spodek.php';
?>