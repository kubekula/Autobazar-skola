

<div class="spodek">
    <div id="time"></div>







    <div class="pocitadlo">
    <?php 
        $sql = "SELECT pocitadlo FROM webova_stranka_pocitadlo";    
        $pripojeni = $conn->prepare($sql);                  
        $pripojeni->execute();                              
        $result = $pripojeni->fetch(PDO::FETCH_ASSOC);
        $pocitadlo = $result['pocitadlo'];
        echo 'Počet návštěv: ' . $pocitadlo;
    ?>
</div>
</div>

<script>
    function cas() {
        const datum = new Date();
        const formattedDate = datum.toLocaleDateString('cs-CZ'); // Formátování data
        const formattedTime = datum.toLocaleTimeString('cs-CZ'); // Formátování času
        document.getElementById('time').innerText = formattedDate + ' ' + formattedTime; // Zobrazení data a času
    }
    cas();
   
    // Aktualizace každou sekundu
    setInterval(cas, 1000);
</script>
<div class="prava">© 2024 SUPERBAZAR Všechna práva vyhrazena</div>