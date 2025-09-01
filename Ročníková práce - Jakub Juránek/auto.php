<?php
require 'header.php';
$validace = 0;

// zjisteni id vozidla
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    $id = 0;
}


// Vyhledá vozidlo v databazi
if (isset($_POST['odstranit'])) {
    $sql = "SELECT * FROM webova_stranka_auta WHERE id = :id";      //hledani pouze id
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);      
    $stmt->execute();
    $vozidlo = $stmt->fetch(PDO::FETCH_ASSOC);

///// Zkontroluje uzivatele a pak odstraní vozidlo
    if($vozidlo['prezdivka'] === $_SESSION['prezdivka'] | $_SESSION['prezdivka'] === "admin" ){ 
        $sql = "DELETE FROM webova_stranka_auta WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: index.php");
            exit();
        }
    }


    ////// Pokud ID existuje tak
if ($id > 0) {
    $sql = "SELECT * FROM webova_stranka_auta WHERE id = :id";      //hledani pouze id
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);      
    $stmt->execute();
    $vozidlo = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($vozidlo) {         //////Vypis informaci o vozidle
       echo '<div class="hledacipanel">';
        
       //if (isset($_POST['upravit'])) {
       // echo '<h1>Úprava vozidla</h1>';
       //}

        
        
        echo '<div class="obrazektext">';
       
            if(!empty($vozidlo['image_data'])){
            echo '<img src="data:image/jpeg;base64,' . base64_encode($vozidlo['image_data']). '" alt="Obrázek ">';  /////// prevod obrazku z textu na obrazek
            
            if($vozidlo['prezdivka'] === $_SESSION['prezdivka'] | $_SESSION['prezdivka'] === "admin"){   /////ukaze tlacitka pouze pokud je prihlasen spravny uzivatel
            echo '<form method="POST">';
            /*echo '<button type="submit" name="upravit" class="upravit"><b>Upravit</b></button>';*/
            echo '<button type="submit" name="odstranit" class="odstranit"><b>Odstranit</b></button>';
            echo '</form>';
                }
        
            }else{
                echo "Obrazek nenalezen";
            }
            echo '</div>';
        

    if (!isset($_POST['upravit'])) {
        echo '<div class="znacka">';
        echo '<h1>' . $vozidlo['znacka'] . ' ' . $vozidlo['model'] . '</h1>';
        echo '</div>';
        
        echo '<div class="popis">';
        echo $vozidlo['popis'];
        echo '</div>';
        
        
        ////// zobrazeni technickych veci
        echo '<div class="grid-auto">';
        echo '<div class="grid-autoItem"><strong>Rok výroby:</strong> ' . $vozidlo['rok_vyroby'] . '</div>';
        echo '<div class="grid-autoItem"><strong>Nájezd:</strong> ' . $vozidlo['najezd'] . '</div>';
        echo '<div class="grid-autoItem"><strong>Typ paliva:</strong> ' . $vozidlo['typ_paliva'] . '</div>';
        echo '<div class="grid-autoItem"><strong>Převodovka:</strong> ' . $vozidlo['prevodovka'] . '</div>';
        echo '<div class="grid-autoItem"><strong>Barva:</strong> ' . $vozidlo['barva'] . '</div>';
        echo '<div class="grid-autoItem"><strong>Cena:</strong> ' . $vozidlo['cena'] . '</div>';
        echo '</div>'; // konec gridu
        echo 'PSČ prodeje : '.$vozidlo['psc'].'<br>';
    }
    } else {
        echo '<p>Vozidlo nebylo nalezeno.</p>';
    }
} else {
    echo '<p>Neplatné ID vozidla.</p>';
}   
    

if($_SESSION['prezdivka'] == "" | !isset($_SESSION['prezdivka'])){         

    echo 'Pro zobrazení údajů o majiteli se musite <a href="login.php">přihlásit!</a>';

}else{
    
$uzivatel = $vozidlo['prezdivka'];

$sql = "SELECT * FROM webova_stranka_uzivatele";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nalezen = 0;

foreach($results as $t){    ////////vypise informace o prodejci


if($t['prezdivka'] == $uzivatel){

    echo '<div class="hledacipanel">';
    echo 'Uživatel: '.$t['prezdivka'].'</p>';
    echo 'Jméno: '.$t['jmeno'].' '.$t['prijmeni'].'</p>';
    echo 'Email: '.$t['email'].'</p>';
    echo 'Telefon: '.$t['telefon'].'</p>';
    echo '</div>';

    $nalezen++;

}

}
if($nalezen = 0){
    echo "Uživatel nenalezen";
}


}

/*
if (isset($_POST['upravit'])) {
  
  if ($id > 0) {
    $sql = "SELECT * FROM webova_stranka_auta WHERE id = :id";      //hledani pouze id
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);      
    $stmt->execute();
    $vozidlo = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($vozidlo) {
        // Zobrazení informací o vozidle
       echo '<div class="hledacipanel">';
          
  $znacka = $vozidlo['znacka'];
  $model = $vozidlo['model'];
  $popis = $vozidlo['popis'];
  $rok_vyroby = $vozidlo['rok_vyroby'];
  $najezd = $vozidlo['najezd'];
  $typ_paliva = $vozidlo['typ_paliva'];
  $prevodovka = $vozidlo['prevodovka'];
  $barva = $vozidlo['barva'];
  $cena = $vozidlo['cena'];
    }
  }
  


  echo '<h1>Úprava vozidla</h1>';
    echo '<form method="POST">';
    echo '<label>Značka:</label><input type="text" name="znacka" value="' . htmlspecialchars($vozidlo['znacka']) . '"><br>';
    echo '<label>Model:</label><input type="text" name="model" value="' . htmlspecialchars($vozidlo['model']) . '"><br>';

    echo '<textarea name="popis" rows="10" cols="50">' . htmlspecialchars($vozidlo['popis']) . '</textarea><br>';

    echo '<label>Rok výroby:</label><input type="number" name="rok_vyroby" value="' . htmlspecialchars($vozidlo['rok_vyroby']) . '"><br>';

    echo '<label>Nájezd:</label><input type="number" name="najezd" value="' . htmlspecialchars($vozidlo['najezd']) . '"><br>';

    echo '<label>Typ paliva:</label><input type="text" name="typ_paliva" value="' . htmlspecialchars($vozidlo['typ_paliva']) . '"><br>';

    echo '<label>Převodovka:</label><input type="text" name="prevodovka" value="' . htmlspecialchars($vozidlo['prevodovka']) . '"><br>';

    echo '<label>Barva:</label><input type="text" name="barva" value="' . htmlspecialchars($vozidlo['barva']) . '"><br>';

    echo '<label>Cena:</label><input type="number" name="cena" value="' . htmlspecialchars($vozidlo['cena']) . '"><br>';

    echo '<button type="submit" name="ulozit">Uložit změny</button>';
    echo '</form>';
}
if (isset($_POST['ulozit'])) {
  

  $znacka = htmlspecialchars($_POST['znacka']);
  $model = htmlspecialchars($_POST['model']);
  $popis = htmlspecialchars($_POST['popis']);
  $rok_vyroby = intval($_POST['rok_vyroby']);
  $najezd = intval($_POST['najezd']);
  $typ_paliva = htmlspecialchars($_POST['typ_paliva']);
  $prevodovka = htmlspecialchars($_POST['prevodovka']);
  $barva = htmlspecialchars($_POST['barva']);
  $cena = intval($_POST['cena']);

  $sql = "UPDATE webova_stranka_auta 
          SET znacka = :znacka, model = :model, popis = :popis, 
              rok_vyroby = :rok_vyroby, najezd = :najezd, typ_paliva = :typ_paliva, 
              prevodovka = :prevodovka, barva = :barva, cena = :cena
          WHERE id = :id";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':znacka', $znacka, PDO::PARAM_STR);
  $stmt->bindParam(':model', $model, PDO::PARAM_STR);
  $stmt->bindParam(':popis', $popis, PDO::PARAM_STR);
  $stmt->bindParam(':rok_vyroby', $rok_vyroby, PDO::PARAM_INT);
  $stmt->bindParam(':najezd', $najezd, PDO::PARAM_INT);
  $stmt->bindParam(':typ_paliva', $typ_paliva, PDO::PARAM_STR);
  $stmt->bindParam(':prevodovka', $prevodovka, PDO::PARAM_STR);
  $stmt->bindParam(':barva', $barva, PDO::PARAM_STR);
  $stmt->bindParam(':cena', $cena, PDO::PARAM_INT);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    header("Location: index.php");;
  } else {
      echo "<p>Chyba při ukládání změn!</p>";
  }
}



echo '</div>'; // konec auto divu
// Uzavření připojení
$conn = null;

*/

?>

</body>
</html>