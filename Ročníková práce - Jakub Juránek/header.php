<?php
session_start();

// Pripojeni do databaze
$servername = "localhost"; // server
$username = ""; // jmeno
$password = ""; // heslo
$dbname = ""; // nazev databaze

// pripojeni do databaze
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
$pocitadlo = 0;

    if(!isset($_COOKIE['pocitadlo'])){    //// Pocitadlo pristupu
    setcookie('pocitadlo', time() + 86400, '/'); //ulozi aktualni cas + 1 den 
    
    $sql = "UPDATE webova_stranka_pocitadlo SET pocitadlo = pocitadlo + 1";     ////pricte 1
    $conn->exec($sql);
    }
    
    
    if (!isset($_COOKIE["rezim"])) {
        setcookie("rezim", "tmavy", time() + (86400 * 365), "/");
        $css = '"cssTmavy.css"';
        $logo = '"images/logotmavy.svg"';
        $favicon = '"images/favicontmavy.svg"';
    } else {
        if ($_COOKIE["rezim"] == "svetly") {
            $css = '"css.css"';
            $logo = '"images/logosvetly.svg"';
            $favicon = '"images/favicon.svg"';
        } elseif ($_COOKIE["rezim"] == "tmavy") {
            $css = '"cssTmavy.css"';
            $logo = '"images/logotmavy.svg"';
            $favicon = '"images/favicontmavy.svg"';
        }
    }



    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= <?php echo $css ?>>
    <link rel="icon" href=<?php echo $favicon ?> type="image/svg+xml">
    <title>Projekt</title>
    
    <!-- Tiny editor funkcni pouze pro popis (O Nas) !-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
    selector: '#popis', 
    height: 300
    });
    </script>


</head>

<body>


<div class="hlnapis">
    <div class="leva">
       
       
       
       
       
       
       <?php                                    ////////////////////Pokud jsem přihlášen tak mi to ukaze pridat inzerat 
       
       if(!isset($_SESSION['prezdivka'])){           //////////pokud není vytvořený session, tak vypíše
       $_SESSION['prezdivka'] = "";                /////////vytvoří session jmeno
       }elseif($_SESSION["prezdivka"] == ""){      //////// jestli se session rovná "" tak udělej
        
       }else{
       echo '<a class="ne" href="pridatInzerat.php"> 
        <button name="pridatInzerat">Přidat inzerát</button>
    </a>';
       }

       
       
       ?>
       
       
       
    </div>
    <ul>
    <li><a href=oNas.php>O nás</a></li>
      </ul>
    <div class="sted">
    <a href="index.php" class="ne"><img src= <?php echo $logo?> height="50px"></a>
    </div>

<?php    echo '<form method="POST">';

if (isset($_COOKIE["rezim"]) && $_COOKIE["rezim"] == "svetly") {        ////////////jestli se coockies rovna "svetly" , tak vypíše tlačítko světlý režim

echo' <a href="index.php?action=button1" >Tmavý režim</a>';
}else{

 echo '<a href="index.php?action=button2" >Světlý režim</a>';
}

echo '</form>';
?>


<?php
if(!isset($_SESSION['prezdivka'])){           //////////pokud neni vytvorena session, tak nabehne tabulka na login a registr
 echo"<a href=login.php>Přihlásit se</a>";
echo"<a href=registrace.php>Registrovat se</a>";
$_SESSION['prezdivka'] = "";               ///////ulozi session jako ""
}elseif($_SESSION["prezdivka"] == ""){        //////jestli se session = "" tak udela to stejny
  echo"<a href=login.php>Přihlásit se</a>";
 echo"<a href=registrace.php>Registrovat se</a>";
  
}else{

  echo "<ul>";                                  ////////////Pokud je uzivatel prihlasen tak ukaze obrazek loginu a dropdown menu ktery je funkcni pouze po najeti mysi
  echo '<div class="prava">
    <div class="profil-container">
        <a href="login.php" class="profil-link"> 
            <img src="images/profil.svg" alt="Profil">
        </a>
        <div class="dropdown">              
            <ul>
                <li><a href="mujUcet.php">Můj účet</a></li>
                <li><a href="mojeInzeraty.php">Moje inzeráty</a></li>
                <li><a href="odhlasit.php">Odhlásit se</a></li>
            </ul>
        </div>
    </div>
</div>'; 
echo $_SESSION["prezdivka"];    /////vypise prezdivku
  
}



if(isset($_POST["pridatInzerat"])){            /////jestli se zmáčkne na tlačítko, tak vymaže session a přejde na úvodní stránku

    header('location: index.php');  
unset($_SESSION["jmeno"]);
}



if(isset($_GET["action"]) && $_GET["action"] == "button1") {                //////////////přepínání světlého a tmavého režimu
  unset($_COOKIE["rezim1"]);
setcookie("rezim", "tmavy", time() + (86400 * 30 * 365), "/");
header('Location: index.php');
exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "button2") {
  setcookie("rezim", "svetly", time() + (86400 * 30 * 365), "/");
unset($_COOKIE["rezim"]);
header('Location: index.php');
exit();
}


?>
    
</div>