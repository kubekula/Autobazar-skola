<?php 
require 'header.php';


if (!isset($_GET['znacka'])) {         //pokud nejsou nastavene hodnoty, tak je to nastaví
    $_GET['znacka'] = "Vybrat vše"; 
    $_GET['typ_paliva'] = "Vybrat vše";   
    $_GET['prevodovka'] = "Vybrat vše";
}

?>

    
    
    
    
<div class="hledacipanel">
    <form method="GET">
        <div class="skupina">
            <div class="hledacipanel-item">
                <label for="znacka">Značka:</label>
                <select id="znacka" name="znacka">
                    <option value="Vybrat vše" <?php if (isset($_GET['znacka']) && $_GET['znacka'] == 'Vybrat vše') echo 'selected'; ?>>Vybrat vše</option>
                    <?php    
                    $sql = "SELECT nazev FROM webova_stranka_znacky";    //////nacteni znacek 
                    $pripojeni = $conn->prepare($sql);                  
                    $pripojeni->execute();                              
                    $znacky = $pripojeni->fetchAll(PDO::FETCH_ASSOC);   

                    foreach ($znacky as $znacka) {         /////vypis znacek
                        $selected = (isset($_GET['znacka']) && $_GET['znacka'] == $znacka['nazev']) ? 'selected' : '';
                        echo '<option value="' . $znacka['nazev'] . '" ' . $selected . '>' . $znacka['nazev'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="hledacipanel-item">
                <label for="typ_paliva">Typ paliva:</label>
                <select id="typ_paliva" name="typ_paliva">
                    <option value="Vybrat vše" <?php if (isset($_GET['typ_paliva']) && $_GET['typ_paliva'] == 'Vybrat vše') echo 'selected'; ?>>Vybrat vše</option>
                    <option value="Benzín" <?php if (isset($_GET['typ_paliva']) && $_GET['typ_paliva'] == 'Benzín') echo 'selected'; ?>>Benzín</option>
                    <option value="Nafta" <?php if (isset($_GET['typ_paliva']) && $_GET['typ_paliva'] == 'Nafta') echo 'selected'; ?>>Nafta</option>
                    <option value="Elektro" <?php if (isset($_GET['typ_paliva']) && $_GET['typ_paliva'] == 'Elektro') echo 'selected'; ?>>Elektrický</option>
                    <option value="Hybrid" <?php if (isset($_GET['typ_paliva']) && $_GET['typ_paliva'] == 'Hybrid') echo 'selected'; ?>>Hybrid</option>
                </select>
            </div>

            <div class="hledacipanel-item">
                <label for="prevodovka">Převodovka:</label>
                <select id="prevodovka" name="prevodovka">
                    <option value="Vybrat vše" <?php if (isset($_GET['prevodovka']) && $_GET['prevodovka'] == 'Vybrat vše') echo 'selected'; ?>>Vybrat vše</option>
                    <option value="Manuální" <?php if (isset($_GET['prevodovka']) && $_GET['prevodovka'] == 'Manuální') echo 'selected'; ?>>Manuální</option>
                    <option value="Automatická" <?php if (isset($_GET['prevodovka']) && $_GET['prevodovka'] == 'Automatická') echo 'selected'; ?>>Automatická</option>
                    <option value="Poloautomatická" <?php if (isset($_GET['prevodovka']) && $_GET['prevodovka'] == 'Poloautomatická') echo 'selected'; ?>>Poloautomatická</option>
                </select>
            </div>

            <div class="hledacipanel-item">
                <label for="rok_vyroby">Rok výroby:</label>
                <div class="rok-vyroby">
                    <input type="number" name="rok_vyrobyod" placeholder="Od" value="<?php if (isset($_GET['rok_vyrobyod'])) { echo htmlspecialchars($_GET['rok_vyrobyod']); } ?>">
                    <input type="number" name="rok_vyrobydo" placeholder="Do" value="<?php if (isset($_GET['rok_vyrobydo'])) { echo htmlspecialchars($_GET['rok_vyrobydo']); } ?>">
                </div>
            </div>

            <div class="hledacipanel-item">
                <label for="cena">Cena:</label>
                <div class="cena">
                    <input type="number" name="cenaod" placeholder="Od" value="<?php if (isset($_GET['cenaod'])) { echo htmlspecialchars($_GET['cenaod']); } ?>">
                    <input type="number" name="cenado" placeholder="Do" value="<?php if (isset($_GET['cenado'])) { echo htmlspecialchars($_GET['cenado']); } ?>">
                </div>
            </div>

            <div class="hledacipanel-item">
                <label for="najezd">Nájezd:</label>
                <div class="najezd">
                    <input type="number" name="najezdod" placeholder="Od" value="<?php if (isset($_GET['najezdod'])) { echo htmlspecialchars($_GET['najezdod']); } ?>">
                    <input type="number" name="dojezddo" placeholder="Do" value="<?php if (isset($_GET['dojezddo'])) { echo htmlspecialchars($_GET['dojezddo']); } ?>">
                </div>
            </div>

            <div class="hledacipanel-item">
                <input type="submit" value="Filtrovat">
            </div>
        </div>
    </form>
</div>


    <h3>Počet inzerátů : 
        <?php /////////zjistí počet inzerátů
        $sqlCount = "SELECT COUNT(*) AS pocet_vozidel FROM webova_stranka_auta WHERE 1=1"; 

        // prida podminky podle filtru
        if ($_GET['znacka'] !== "Vybrat vše") {
            $sqlCount .= " AND znacka = :znacka";
        }
        if (!empty($_GET['rok_vyrobyod'])) {
            $sqlCount .= " AND rok_vyroby >= :rok_vyrobyod";
        }
        if (!empty($_GET['rok_vyrobydo'])) {
            $sqlCount .= " AND rok_vyroby <= :rok_vyrobydo";
        }
        if (!empty($_GET['cenaod'])) {
            $sqlCount .= " AND cena >= :cenaod";
        }
        if (!empty($_GET['cenado'])) {
            $sqlCount .= " AND cena <= :cenado";
        }
        if (!empty($_GET['najezdod'])) {
            $sqlCount .= " AND najezd >= :najezdod";
        }
        if (!empty($_GET['dojezddo'])) {
            $sqlCount .= " AND najezd <= :dojezddo";
        }
        if ($_GET['typ_paliva'] !== "Vybrat vše") {
            $sqlCount .= " AND typ_paliva = :typ_paliva";
        }
        if ($_GET['prevodovka'] !== "Vybrat vše") {
            $sqlCount .= " AND prevodovka = :prevodovka";
        }
    
        // Příprava a provedení dotazu
        $stmtCount = $conn->prepare($sqlCount);
    
        // prepise parametry do dotazu
        if ($_GET['znacka'] !== "Vybrat vše") {
            $stmtCount->bindParam(':znacka', $_GET['znacka']);
        }
        if (!empty($_GET['rok_vyrobyod'])) {
            $stmtCount->bindParam(':rok_vyrobyod', $_GET['rok_vyrobyod']);
        }
        if (!empty($_GET['rok_vyrobydo'])) {
            $stmtCount->bindParam(':rok_vyrobydo', $_GET['rok_vyrobydo']);
        }
        if (!empty($_GET['cenaod'])) {
            $stmtCount->bindParam(':cenaod', $_GET['cenaod']);
        }
        if (!empty($_GET['cenado'])) {
            $stmtCount->bindParam(':cenado', $_GET['cenado']);
        }
        if (!empty($_GET['najezdod'])) {
            $stmtCount->bindParam(':najezdod', $_GET['najezdod']);
        }
        if (!empty($_GET['dojezddo'])) {
            $stmtCount->bindParam(':dojezddo', $_GET['dojezddo']);
        }
        if ($_GET['typ_paliva'] !== "Vybrat vše") {
            $stmtCount->bindParam(':typ_paliva', $_GET['typ_paliva']);
        }
        if ($_GET['prevodovka'] !== "Vybrat vše") {
            $stmtCount->bindParam(':prevodovka', $_GET['prevodovka']);
        }
    
        $stmtCount->execute();
        
        // Zpracování výsledku
        $pocet = $stmtCount->fetch(PDO::FETCH_ASSOC);
        echo $pocet['pocet_vozidel'];
        ?>
        </h3><br>
    
        
        

                                                            <!--Produkty -->
<div class="dolek">
    <div class="card-container">
        <?php 
        

       



        $inzeratyNaStranku = 20;        ///Pocet inzeratu kolik se jich ma zobrazit na stranku
if (isset($_GET['page'])) {             ///pokud neni nastavena page tak ji nastaví
    $page = $_GET['page'];
} else {
    $page = 1;
}

$stmtCount->execute();
$pocet = $stmtCount->fetch(PDO::FETCH_ASSOC);        
$totalPages = ceil($pocet['pocet_vozidel'] / $inzeratyNaStranku);        //////vypocita finalni pocet stranek


$sql = "SELECT * FROM webova_stranka_auta WHERE 1=1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
$z = 0;
$stranka = 0;

       foreach ($results as $t) {       /////////projede všechny inzeraty
        
        if ($stranka < 20){             ////////vypise jich 20 na stranku (Pokud je vyjeto 20 vozidel tak to zastaví a prestane to zkouset dalsi auta)

 
        $matches = true; 

    ////////////////// kontrola filtru jestli se shoduje s nejakym vozidlem
    if ($_GET['znacka'] !== "Vybrat vše" && $t['znacka'] !== $_GET['znacka']) {
        $matches = false;
    }

   
    if ($_GET['typ_paliva'] !== "Vybrat vše" && $t['typ_paliva'] !== $_GET['typ_paliva']) {
        $matches = false;
    }

   
    if (!empty($_GET['rok_vyrobyod']) && $t['rok_vyroby'] < $_GET['rok_vyrobyod']) {
        $matches = false;
    }
    if (!empty($_GET['rok_vyrobydo']) && $t['rok_vyroby'] > $_GET['rok_vyrobydo']) {
        $matches = false;
    }


    if (!empty($_GET['cenaod']) && $t['cena'] < $_GET['cenaod']) {
        $matches = false;
    }
    if (!empty($_GET['cenado']) && $t['cena'] > $_GET['cenado']) {
        $matches = false;
    }


    if (!empty($_GET['najezdod']) && $t['najezd'] < $_GET['najezdod']) {
        $matches = false;
    }
    if (!empty($_GET['dojezddo']) && $t['najezd'] > $_GET['dojezddo']) {
        $matches = false;
    }

  
    if ($_GET['prevodovka'] !== "Vybrat vše" && $t['prevodovka'] !== $_GET['prevodovka']) {
        $matches = false;
    }

    if($matches){   ////////jestli projde filtr tak pricte $z
    $z++;
    }
    
    $neco = 0;      /////////pocatecni hodnota
    $g = 20;       /////////pocet inzeratu na stranku

if(!isset($_GET['page'])){      ////////pokud neni nastavena page tak ji nastaví na 1
    $_GET['page'] = 1;
}

      for($i = 1; $_GET['page'] > $i;$i++){     ////////////vypocita na jake jsem strance a pomoci toho pricte jaky auta to ma vyhledat
          
          $neco = $neco + 20;
          $g = $g + 20;

      }

 if ($neco < $z){           ////////$neco = kolikate auto ma byt nacteno, $z = pokud projde filtr tak to pricte 1, tím pádem pokud je uzivatel na strance 2, tak $neco = 20 a auta to zacne vypisovat az od 21 
    if ($matches) {
        $stranka++;         ///////pricte $stranka. $stranka slouzi pro ukonceni ciklu, takze az se bude $stranka = 20 tak to prestane vypisovat auta
        echo '<a class="ne" href="auto.php?id=' . $t['id'] . '">';    /////////presmeruje na stranku auto.php kde bude $_GET['id'] = id auta    
        echo '<div class="card">';
        if (!empty($t['image_data'])) {         ////pokud tam je obrazek tak
            echo '<img src="data:image/jpeg;base64,' . base64_encode($t['image_data']) . '" alt="Obrázek ' . $t['id'] . '" class="product-image">'; /////// prevod obrazku z textu na obrazek

        } else {
            echo '<p>Obrázek nenalezen</p>';
        }
        echo '<h3>' . htmlspecialchars($t['nazev']) . '</h3>';
        echo '<h4>Cena : '.$t['cena'].' Kč</h4>';
        echo '</a>';
        echo '</div>'; 
            }
        }
    }
}
echo '</div>';
     '</div>';


     echo '<div class="dalsistranka">';     
    echo '<div class="dalsistranka-grid">';



// Zobrazit odkaz na předchozí stránku (zobrazí pokud page != 1)
if ($page > 1) {
    $params = $_GET;    /////nacte cely $_GET a ulozi do $params
    $params['page'] = $page - 1;    //////// vezme to aktualni page a odecte od ni 1
    $predchoziStranka = '?' . http_build_query($params); // http_build_query prevede $parametry do formatu url
    echo '<a href="' . $predchoziStranka . '">Načíst předchozí stránku</a> '; //////vypise predchozi stranku
}
echo '</div>';

// Zobrazit čísla stránek
echo '<div class="dalsistranka-grid">';
for ($i = 1; $i <= $totalPages; $i++) {     ////vypise pocet stranek
    $params = $_GET;    
    $params['page'] = $i; ///////vezme to stranku 1,2,3,...
    $pageUrl = '?' . http_build_query($params); /////ulozi odkaz na danou page
    if ($i == $page) {      /////pokud je to aktualni stranka tak ji zvyrazni
        echo '<b>' . $i . '</b> '; 
    } else {    //////// pokud to neni aktualni stranka tak vypise cislo s odkazem
        echo '<a href="' . $pageUrl . '">' . $i . '</a> ';
    }
}
echo '</div>';


echo '<div class="dalsistranka-grid">';

// Zobrazit odkaz na další stránku (zobrazí pokud page != posledni stranka)
if ($page < $totalPages) {  
    $params = $_GET; 
    $params['page'] = $page + 1; 
    $dalsiStranka = '?' . http_build_query($params); 
    echo '<a href="' . $dalsiStranka . '">Načíst další inzeráty</a>';
}
echo '</div>';

?>






<?php 


require 'spodek.php';




// Uzavření připojení
$conn = null;
?>

<script>



</script>




</body>
</html>

