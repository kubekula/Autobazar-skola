<?php 
require 'header.php';

/////nacte text do $results
$sql = 'SELECT `popis` FROM webova_stranka_onas';
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SESSION['prezdivka'] === "admin") {   ///pokud se prihlasi admin tak se zobrazi tlacitko upravit
    echo '<form method="POST" id="editForm">';
    echo '<button type="submit" name="upravit" class="upravit"><b>Upravit</b></button>';
    echo '</form>';
    
    
    if (isset($_POST['upravit'])) {         ///////pokud se stiskne tlacitko upravit
        
        $popis = $results[0]['popis'];      //////nacteme prvni radek v databazi

        echo '<form method="POST" id="editForm">';          ///////zobrazime tiny editor ve kterem muzeme dany text upravit
        echo '<textarea id="popis" name="popis">' . $popis . '</textarea><br>';
        echo '<button type="submit" name="ulozit" class="ulozit"><b>Uložit změny</b></button>';
        echo '</form>';
    }
    
    
    if (isset($_POST['ulozit'])) {          ///// pokud se klikne na ulozit
     
        $novyPopis = $_POST['popis'];  ///// ulozime upraveny text

        
        $sqlUpdate = 'UPDATE webova_stranka_onas SET popis = :popis'; ////// vyhledame radek v databazi
        $stmtUpdate = $conn->prepare($sqlUpdate);       /////pripravime dotaz
        $stmtUpdate->execute([':popis' => $novyPopis]);         //////priradime $novyPopis do popisu a provedeme dotaz

        header('Location: oNas.php');               //// vrati nas zpatky na stranku
    }
}


echo '<div class="hledacipanel">';
echo '<h1>O nás</h1>';
if ($results) {     //////pokud je neco v $results tak,
    foreach ($results as $t) {    ////////vyhleda radek a vypise ho 
        echo $t['popis'] . "<br>";
    }
} else {
    echo "Žádné výsledky nenalezeny.";
}
echo '</div>';
?>

<div class="hledacipanel">

<h1>Fotogalerie naší firmy</h1>


<div class="gallery">
        
        <a class="ne" href="Fotky/1.jpg" data-fslightbox="gallery">     <!-- data-fslightbox="gallery" slouzi ke komunikaci s knihovnou-->
            <img src="Fotky/1.jpg" alt="Fotka 1">
        </a>
        <a class="ne" href="Fotky/2.jpg" data-fslightbox="gallery">
            <img src="Fotky/1.jpg" alt="Fotka 2">
        </a>
        <a class="ne" href="Fotky/3.jpg" data-fslightbox="gallery">
            <img src="Fotky/3.jpg" alt="Fotka 3">
        </a>
        <a class="ne" href="Fotky/4.jpg" data-fslightbox="gallery">
            <img src="Fotky/4.jpg" alt="Fotka 3">
        </a>
        <a class="ne" href="Fotky/5.jpg" data-fslightbox="gallery">
            <img src="Fotky/5.jpg" alt="Fotka 3">
        </a>
        <a class="ne" href="Fotky/6.jpg" data-fslightbox="gallery">
            <img src="Fotky/6.jpg" alt="Fotka 3">
        </a>
        </div>
</div>
<script src="./fslightbox.js"></script>     <!-- nacte script pro Fotogalerii-->





<div class="hledacipanel">
    <h1>Kde nás najdete ?</h1>
    <div style="display: flex; justify-content: center;">   <!-- zobrazení mapy-->
        <iframe width="500px" height="200px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20544.915246383174!2d16.79265335!3d49.93419455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47120f406e04df91%3A0x400af0f66152680!2zNzg5IDAxIEplZGzDrS1aw6FixZllaCwgxIxlc2tv!5e0!3m2!1scs!2sde!4v1733416352415!5m2!1scs!2sde" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<?php require 'spodek.php'; ?>