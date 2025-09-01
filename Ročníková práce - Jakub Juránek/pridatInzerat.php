<?php require 'header.php';
ob_start();

$validace = 0;

////////////// toto slouzi pro prvni nacteni stranky, aby to nehazelo hnedka chybnou validaci
if (!isset($nazev)) {
    $nazev = "aaaaaa";
}

if (!isset($popis)) {
    $popis = "aaaaaa";
}

if (!isset($znacka)) {
    $znacka = "aaaaaa";
}
if (!isset($model)) {
    $model = "aaaaaa";
}
if (!isset($rok_vyroby)) {
    $rok_vyroby = "0000";
}if (!isset($cena)) {
    $cena = "0000";
}if (!isset($barva)) {
    $barva = "aaaaaa";
}if (!isset($najezd)) {
    $najezd = "0000";
}if (!isset($typ_paliva)) {
    $typ_paliva = "prvni";
}if (!isset($prevodovka)) {
    $prevodovka = "prvni";
}if (!isset($motorizace)) {
    $motorizace = "aaaaaa";
}
if (!isset($psc)) {
    $psc = "11111";
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {     //////ulozi zadane informace do hodnot
    $nazev = $_POST['nazev'];
    $popis = $_POST['popis'];
    $znacka = $_POST['znacka'];
    $model = $_POST['model'];
    $rok_vyroby = $_POST['rok_vyroby'];
    $cena = $_POST['cena'];
    $barva = $_POST['barva'];
    $najezd = $_POST['najezd'];
    $typ_paliva = $_POST['typ_paliva'];
    $prevodovka = $_POST['prevodovka'];
    $motorizace = $_POST['motorizace'];
    $psc = $_POST['psc'];
    
    }


?>


<!-- Formulář s vyhledáváním -->
<div class="dolekPridatInzerat">
    <div class="pridatInzerat">
        <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nazev" placeholder="Název inzerátu" value="<?php if ($nazev != "aaaaaa"){echo $nazev;} ?>">
                <div class="nazeverror">
                    <?php 
                              
                        if(!isset($_SESSION['prezdivka'])){     ///pokud neni uzivatel prihlaseni  tak to neprojde

                            echo "<h4>Musíte se přihlásit !</h4>";
                            
                        }else{
                            $validace++;
                        }


/////validace
                        if(empty($nazev)){
                            echo "<h4>Zadejte název !</h4>";
                        }elseif(!preg_match("/^(.{3,})$/",$nazev)){
                            echo "<h4>Minimálně 3 znaky !</h4>";
                        }elseif (!preg_match("/^(.{1,30})$/",$nazev)){
                            echo "<h4>Maximálně 30 znaků !</h4>";
                        }elseif (!preg_match("/^[a-žA-Ž0-9 -]{3,30}$/",$nazev)) { 
                            echo "<h4>Zadejte název !</h4>";
                        }else{
                            $validace++; 
                        }
                    ?>
                </div>
                <input type="text" name="popis" placeholder="Popis" value="<?php if ($popis != "aaaaaa"){echo $popis;} ?>">
                <div class="popiserror">
                    <?php 
                              
                        if(empty($popis)){
                            echo "<h4>Zadejte popis !</h4>";
                        }elseif(!preg_match("/^(.{5,})$/",$popis)){
                            echo "<h4>Minimálně 5 znaků !</h4>";
                        }elseif (!preg_match("/^(.{1,150})$/",$popis)){
                            echo "<h4>Maximálně 150 znaků !</h4>";
                        }elseif (!preg_match("/^[a-žA-Ž0-9 -.?]{5,150}$/",$popis)) { 
                            echo "<h4>Popis nemůže obsahovat specilní znaky !</h4>";
                        }else{
                            $validace++; 
                        }
                    ?>
                </div>
            <div class="grid_pridatinzerat">
                <div class="item">
                <select id="znacka" name="znacka">
                    <option value="" <?php if ($znacka == 'Vyberteznačku') echo 'selected'; ?>>Vyberte značku</option>
                    <?php
                    // Načtení značek z databáze
                    $sql = "SELECT nazev FROM webova_stranka_znacky";    
                    $pripojeni = $conn->prepare($sql);                  
                    $pripojeni->execute();                              
                    $znacky = $pripojeni->fetchAll(PDO::FETCH_ASSOC);   
                    foreach ($znacky as $znacka1) {         ////////nacte znacky z databaze 
                        $selected = ($znacka == $znacka1['nazev']) ? 'selected' : '';
                        echo '<option value="' . $znacka1['nazev'] . '" ' . $selected . '>' . $znacka1['nazev'] . '</option>';
                    }
                    ?>
                    </select>
                <div class="znackaerror">
                        <?php 
                              
                              if(empty($znacka)){
                                echo "<h4>Zadejte značku !</h4>";
                              }elseif(!preg_match("/^(.{3,})$/",$znacka)){
                                echo "<h4>Minimálně 3 znaky !</h4>";
                              }elseif (!preg_match("/^(.{1,15})$/",$znacka)){
                                echo "<h4>Maximálně 15 znaků !</h4>";
                              }elseif (!preg_match("/^[a-žA-Ž0-9 -]{3,15}$/",$znacka)) { 
                                echo "<h4>Zadejte značku !</h4>";
                            }else{
                                $validace++; 
                            }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <input type="text" name="model" placeholder="Model" value="<?php if ($model != "aaaaaa"){echo $model;} ?>">
                    <div class="modelerror">
                        <?php 
                              if(empty($model)){
                                echo "<h4>Zadejte model !</h4>";
                              }elseif(!preg_match("/^(.{1,})$/",$model)){
                                echo "<h4>Minimálně 1 znak !</h4>";
                              }elseif (!preg_match("/^(.{1,30})$/",$model)){
                                echo "<h4>Maximálně 30 znaků !</h4>";
                              }elseif (!preg_match("/^[a-žA-Ž0-9 -_]{1,30}$/", $model)) { 
                                echo "<h4>Zadejte model !</h4>";
                                }else{
                                    $validace++; 
                                }
                        ?>
                        </div>
                </div>
                <div class="item">
                <input type="text" name="motorizace" placeholder="Motorizace" value="<?php if ($motorizace != "aaaaaa"){echo $motorizace;} ?>">
                    <div class="motorizaceerror">
                        <?php 
                              if(empty($motorizace)){
                                echo "<h4>Zadejte motorizaci !</h4>";
                              }elseif(!preg_match("/^(.{1,})$/",$motorizace)){
                                echo "<h4>Minimálně 1 znak !</h4>";
                              }elseif (!preg_match("/^(.{1,30})$/",$motorizace)){
                                echo "<h4>Maximálně 30 znaků !</h4>";
                              }elseif (!preg_match("/^[a-žA-Ž0-9 -_+()*&]{1,30}$/",$motorizace)) { 
                                echo "<h4>Zadejte motorizaci !</h4>";
                                }else{
                                    $validace++; 
                                }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <input type="number" name="rok_vyroby" placeholder="Rok výroby"value="<?php if ($rok_vyroby != "0000"){echo $rok_vyroby;} ?>">
                    <div class="rok_vyrobyerror">
                        <?php 
                            if (empty($rok_vyroby)) {
                                echo "<h4>Zadejte rok výroby!</h4>";
                            } elseif (!preg_match("/^[0-9]{4}$/", $rok_vyroby)) {
                                echo "<h4>Rok výroby musí mít přesně 4 číslice !</h4>";
                            } else {
                                $validace++; 
                            }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <input type="number" name="najezd" placeholder="Najezd (v km)"value="<?php if ($najezd != "0000"){echo $najezd;} ?>">
                    <div class="najezderror">
                    <?php 
                              if(empty($najezd)){
                                echo "<h4>Zadejte najezd !</h4>";
                              }elseif(!preg_match("/^(.{3,})$/",$najezd)){
                                echo "<h4>Minimálně 3 čísla !</h4>";
                              }elseif (!preg_match("/^(.{1,10})$/",$najezd)){
                                echo "<h4>Maximálně 10 čísel !</h4>";
                              }elseif (!preg_match("/^[0-9 ]{1,10}$/",$najezd)) { 
                                echo "<h4>Zadejte nájezd !</h4>";
                                }else{
                                    $validace++; 
                                }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <select name="typ_paliva">
                        <option value="">Vyberte typ paliva</option>
                        <option value="Benzín" <?php if($typ_paliva == "Benzín") echo 'selected'; ?>>Benzín</option>
                        <option value="Nafta" <?php if($typ_paliva == "Nafta") echo 'selected'; ?>>Nafta</option>
                        <option value="Elektro" <?php if($typ_paliva == "Elektro") echo 'selected'; ?>>Elektro</option>
                        <option value="Hybrid" <?php if($typ_paliva == "Hybrid") echo 'selected'; ?>>Hybrid</option>
                    </select>
                    <div class="typ_palivaerror">
                    <?php 
                        if(empty($typ_paliva)){
                        echo "<h4>Zadejte typ paliva !</h4>";
                        }elseif($typ_paliva == "Benzín"){
                            $validace++;
                          }elseif($typ_paliva == "Elektro"){
                            $validace++;
                          }elseif($typ_paliva == "Nafta"){
                            $validace++;
                          }elseif($typ_paliva == "Hybrid"){
                            $validace++;
                          }elseif($typ_paliva == "prvni"){
                            $prevodovka == "";
                          }else{
                            echo "<h4>Zadejte typ paliva !</h4>";
                          }
        
                    ?>
                    </div>
                </div>
                <div class="item">
                    <select name="prevodovka">
                        <option value="">Vyberte typ převodovky</option>
                        <option value="Manuální"<?php if($prevodovka == "Manuální") echo 'selected'; ?>>Manuální</option>
                        <option value="Automatická"<?php if($prevodovka == "Automatická") echo 'selected'; ?>>Automatická</option>
                        <option value="Poloautomatická"<?php if($prevodovka == "Poloautomatická") echo 'selected'; ?>>Poloautomatická</option>
                    </select>
                    <div class="prevodovkaerror">
                        <?php 
                            if(empty($prevodovka)){
                                echo "<h4>Zadejte typ převodovky !</h4>";
                            } elseif($prevodovka == "Manuální"){
                                $validace++;
                              }elseif($prevodovka == "Automatická"){
                                $validace++;
                              }elseif($prevodovka == "Poloautomatická"){
                                $validace++;
                              }elseif($prevodovka == "prvni"){
                                $prevodovka == "";
                              }else{
                                echo "<h4>Zadejte typ převodovky !</h4>";
                              }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <input type="text" name="barva" placeholder="Barva" value="<?php if ($barva != "aaaaaa"){echo $barva;} ?>">
                    <div class="barvaerror">
                    <?php 
                              if(empty($barva)){
                                echo "<h4>Zadejte barvu !</h4>";
                              }elseif(!preg_match("/^(.{3,})$/",$barva)){
                                echo "<h4>Minimálně 3 znaky !</h4>";
                              }elseif (!preg_match("/^(.{1,20})$/",$barva)){
                                echo "<h4>Maximálně 20 znaku !</h4>";
                              }elseif (!preg_match("/^[a-žA-Ž ]{3,20}$/",$barva)) { 
                                echo "<h4>Zadejte barvu !</h4>";
                                }else{
                                    $validace++; 
                                }
                        ?>
                    </div>
                </div>
                <div class="item">
                    <input type="number" name="cena" placeholder="Cena" value="<?php if ($cena != "0000"){echo $cena;} ?>">
                    <div class="cenaerror">
                        <?php 
                              if(empty($cena)){
                                echo "<h4>Zadejte cenu !</h4>";
                              }elseif(!preg_match("/^(.{3,})$/",$cena)){
                                echo "<h4>Minimálně 3 čísla !</h4>";
                              }elseif (!preg_match("/^(.{1,10})$/",$cena)){
                                echo "<h4>Maximálně 10 čísel !</h4>";
                              }elseif (!preg_match("/^[0-9 ]{1,10}$/",$cena)) { 
                                echo "<h4>Zadejte cenu !</h4>";
                                }else{
                                    $validace++; 
                                }
                        ?>
                    </div>
                </div>        
                <div class="item">
                    <input type="number" name="psc" placeholder="PSČ" value="<?php if ($psc != "11111"){echo $psc;} ?>">
                    <div class="psc">
                    <?php 
                              if(empty($psc)){
                                echo "<h4>Musíte zadat PSČ !</h4>";
                              }elseif (!preg_match("/^[0-9 ]{5,6}$/",$psc)) { 
                                echo "<h4>Musíte zadat platný PSČ !</h4>";
                              }else{
                                $validace++; 
                              }
                        ?>
                    </div>
                </div>    




                    <div class="item">
                    <input type="file" name="image" accept="image/*" multiple>
                    <div class="imageerror">
                            <?php 
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    // Kontrola fotky
                                    if (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {   ///////kontroluje zda došlo při nahrávání k chybě
                                        $povolene_konce = ['image/jpeg', 'image/png', 'image/jpg'];     //////povolene formaty
                                        $typ = $_FILES['image']['type'];    //////ulozi typ obrazku 
                                        $velikost = $_FILES['image']['size'];  //////ulozi velikost obrazku
                                
                                        // Kontrola typu souboru
                                        if (!in_array($typ, $povolene_konce)) { ////projede zda je to platny format
                                            echo "<h4>Neplatný typ souboru! (pouze JPEG, JPG, PNG)</h4>";
                                        } 
                                        // Kontrola velikosti souboru
                                        elseif ($velikost > 4000000) { // 4MB limit
                                            echo "<h4>Soubor je příliš velký! (max 4MB)</h4>";
                                        } 
                                        // Kontrola rozměru obrazku
                                        else {
                                            list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
                                            if ($width < 100 || $height < 100) {
                                                echo "<h4>Obrázek musí mít minimálně 100x100 pixelů!</h4>";
                                            } else {
                                                $validace++; 
                                            }
                                        }
                                    } else {
                                        echo "<h4>Musíte nahrát obrázek !</h4>";
                                    }
                                }
                
            ?>    
                    </div>
                </div>
            </div>
            <button type="submit">Odeslat</button>
        </form>
    </div>
</div>
</div>
</div>


<?php 
if($_SESSION['prezdivka'] == "" | !isset($_SESSION['prezdivka'])){

    echo "Pro přidání inzerátu se musíte přihlásit !";
}else{
    $validace++;
}


if ($validace == 15) {



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imageData = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {///zkontroluje zda se obrazek dobre nahral
            $imageData = file_get_contents($_FILES['image']['tmp_name']);       /////nacte obsah obrazku
        }


        ///////priprava pro vlozeni dat
        $sql = "INSERT INTO webova_stranka_auta (nazev, znacka, model, rok_vyroby, cena, barva, najezd, typ_paliva, prevodovka, motorizace, image_data, prezdivka, popis, psc) VALUES (:nazev, :znacka, :model, :rok_vyroby, :cena, :barva, :najezd, :typ_paliva, :prevodovka, :motorizace, :image_data, :prezdivka, :popis, :psc)";
        $stmt = $conn->prepare($sql);   ///priprava dotazu

        // Přiřazení hodnot k parametrům
        $stmt->bindParam(':nazev', $nazev);
        $stmt->bindParam(':znacka', $znacka);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':rok_vyroby', $rok_vyroby);
        $stmt->bindParam(':cena', $cena);
        $stmt->bindParam(':barva', $barva);
        $stmt->bindParam(':najezd', $najezd);
        $stmt->bindParam(':typ_paliva', $typ_paliva);
        $stmt->bindParam(':prevodovka', $prevodovka);
        $stmt->bindParam(':motorizace', $motorizace);
        $stmt->bindParam(':image_data', $imageData, PDO::PARAM_LOB); // Ulozeni obrazku jako BLOB
        $stmt->bindParam(':prezdivka', $_SESSION['prezdivka']);
        $stmt->bindParam(':popis', $popis);
        $stmt->bindParam(':psc', $psc);
        if ($stmt->execute()) {
            echo "Úspěšně uloženo";
            header("Location: pridatInzeratUspesne.php");
            exit();
        } else {
            echo "Nastala chyba";
        }
    }
}

?>


<?php 
require 'spodek.php';
?>

</body>
</html>


<?php 
ob_end_flush();
?>