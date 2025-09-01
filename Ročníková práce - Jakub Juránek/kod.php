
<?php
// Tento kód slouží jen pro procházení a výpis adresářú a souborů
// **********************************************************************************

session_start();
if (!isset($_SESSION['adresar'])) {
    $_SESSION['adresar'] = '.';
}
echo '<style>a.kod{text-decoration: none; color: black;} a.kod:hover{text-decoration: underline;} #slozka{color: blue;}</style>';

// Když z horní nabídky zvolíme výpis souborů, tak se vypíše obsah kořenového adresáře
if (isset($_GET['vypsat'])) {
    $_GET['vybrat'] = '.';
    vypis();
    die();
}

// Když klikneme na odkaz adresáře, tak se vypíše jeho obsah
if (isset($_GET['vybrat'])) {
    vypis();
}

// Když klikneme na soubor, tak se zobrazí jeho kód
if (isset($_GET['zdroj'])) {
    echo '<a class="kod" href="kod.php?vybrat=' . $_SESSION['adresar'] . '">Zpět</a><br><br>';
    $soubor = $_GET['zdroj'];
    echo '<b>' . $soubor . '</b><br><br>';
    // Zobrazíme obrázky
    $pripona = strtolower(pathinfo($soubor, PATHINFO_EXTENSION));
    if ($pripona == "jpg" or $pripona == "png" or $pripona == "gif" or $pripona == "jpeg") {
        echo '<img src="' . $soubor . '" alt="">';
        exit;
    }
    // Ostatní soubory zobrazíme se zvýrazněnou syntaxí
    highlight_file($soubor);
}

// Funkce pro výpis obsahu adresáře
function vypis()
{
    echo '<b>Aktuální adresář:</b><br>';
    $adresar = $_GET['vybrat'];
    // Zamezí přístupu do nadřazeného adresáře
    if ($adresar[0] !== '.' || obsahuje('..', $adresar)) {
        die();
    }

    $_SESSION['adresar'] = $adresar; // zapamatujeme vybraný adresář (využijeme pro funkci zpět)
    // echo '<span style="color: blue;">' . $adresar . '</span><br><br>';
    echo '<a id="slozka" class="kod" href="kod.php?vybrat=.">' . $adresar . '</a><br><br>';
    $rodic = dirname($adresar); // vrátí odkaz na nadřezený adresář

    // Výpis adresářů
    $slozky = glob($adresar . '/*', GLOB_ONLYDIR);
    echo '<div class="slozka">';
    echo '<a class="kod" href="kod.php?vybrat=' . $rodic . '">⇧..</a><br>';
    foreach ($slozky as $slozka) {
        echo '<a id="slozka" class="kod" href="kod.php?vybrat=' . $slozka . '"> &frasl; ' . basename($slozka) . '</a><br>';
    }
    echo '</div>';

    // Výpis souborů
    $soubory = glob($adresar . '/{,.}*', GLOB_BRACE);
    foreach ($soubory as $soubor) {
        if (is_file($soubor)) {
            if (mb_substr(basename($soubor), 0, 9) == 'kod.php' || obsahuje('nastaveni_htaccess.php', basename($soubor))) { // Nevypisuje soubry s uvedeným názven
                //echo basename($soubor) . '<br>';
            } else {
                echo '<a class="kod" href="./kod.php?zdroj=' . $adresar . '/' . basename($soubor) . '"> ' . basename($soubor) . '</a><br>';
            }
        }
    }
}

// Vrátí true, když je $co v $kde
function obsahuje($co, $kde)
{
    return strpos($kde, $co) !== false;
}
