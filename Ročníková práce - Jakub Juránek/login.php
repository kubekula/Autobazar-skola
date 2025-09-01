<?php

require 'header.php';


?>

<body>

<div class="register">
    <h1>Login</h1>
    <form action="" method="POST">
    <?php
$p = 0; ///////////////////Zadá do proměné prázdnou hodnotu



if ($_POST)          ///////// Pokud stisknu jakykoli tlacitko tak
{        

$prezdivka = $_POST['prezdivka'];                ////ulozi hodnoty do promennych
  $heslo = $_POST["heslo"];



  $sql = "SELECT * FROM webova_stranka_uzivatele"; ///pripravy dotaz na vypsani vsech ulozenych uzivatelu
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($results as $t){                  /////prochazi kazdeho uzivatele
  
if ($t['prezdivka'] == $prezdivka){       //// pokud se shoduje prezdivka z databaze
  }
    if (password_verify($heslo, $t['heslo'])){           ////zadane heslo se zaheshuje a porovna se z heslem v databaze
        echo "Správné heslo";
        $_SESSION['prezdivka'] = $prezdivka;      
        header("Location: index.php");
      }
  }
echo "<h4>Máte špatnou přezdívku nebo heslo!</h4>";        ////pokud se nezhoduje prezdivka a heslo tak to vypise
} 

?>    
    <p>Přezdívka :<input type="text" name="prezdivka" size="20"></p>
        <p>Heslo :<input type="password" name="heslo" size="20"></p>
        <input type="submit" name="button" value="Odeslat">
    </form>







<div class="link">
        <p>Nejste zaregistrovaný? Klikněte <a href="registrace.php">sem</a></p>
    </div>
</div>






</body>
</html>