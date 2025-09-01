<?php 

require 'header.php';

if (isset($_POST['button'])) {               ////////////Když se zmačkne na tlačitko tak ....
    
    ////////////////Uloží údaje do proměný  
    $jmeno=$_POST["jmeno"]; 
    $prijmeni=$_POST["prijmeni"];
    $prezdivka=$_POST["prezdivka"];
    $email=$_POST["email"];
    $predcisli=$_POST["predcisli"];
    $telefon=$_POST["telefon"];
    $heslo=$_POST["heslo"];
    $kheslo=trim(htmlspecialchars($_POST["kheslo"])); ////////////uloží tak, aby speciální znaky nemohli fungovat    
}
    
///////////////////Zadá do proměných prázdnou hodnotu

 if(!isset($jmeno)){
    $jmeno = "aaaaa";
 }  
 if(!isset($prijmeni)){
    $prijmeni = "aaaaa";
 }  
 if(!isset($prezdivka)){
    $prezdivka = "aaaaa";
 }  
 if(!isset($email)){
    $email = "aaaaa@aaa.aa";
 }  
 if (!isset($telefon)) {
  $telefon = "999999999"; 
}
 if(!isset($predcisli)){
    $predcisli = "+420";
 }
 if(!isset($heslo)){
    $heslo = "aaaaaaa";
 }  
 if(!isset($kheslo)){
    $kheslo = "aaaaaaa";
 }  
    $validace = 0;
    $g = 0;

?>
<body>


<div class="register">
<h1>Registrace</h1>
<form action="" method="POST">
     <p>Jméno :<input type="text" name="jmeno" size="20"></p>
        <?php 
         if(empty($jmeno)){
           echo "<h4>Musíte zadat jméno !</h4>";
         }elseif(!preg_match("/^(.{2,})$/",$jmeno)){
           echo "<h4>Minimálně 2 znaky !</h4>";
         }elseif (!preg_match("/^(.{1,15})$/",$jmeno)){
           echo "<h4>Maximálně 15 znaků !</h4>";
         }elseif (!preg_match("/^[a-žA-Ž]*$/",$jmeno)) { 
           echo "<h4>Musíte zadat jméno !</h4>";
         }else{
           $validace++; 
         }
      ?>
     <p>Přijmení :<input type="text" name="prijmeni" size="20"></p>
     <?php 
        if(empty($prijmeni)){
          echo "<h4>Musíte zadat přijmení !</h4>";
        }elseif(!preg_match("/^(.{2,})$/",$prijmeni)){
          echo "<h4>Minimálně 2 znaky !</h4>";
        }elseif (!preg_match("/^(.{1,25})$/",$prijmeni)){
          echo "<h4>Maximálně 25 znaků !</h4>";
        }elseif (!preg_match("/^[a-žA-Ž]*$/",$prijmeni)) { 
          echo "<h4>Musíte zadat přijmení !</h4>";
        }else{
          $validace++; 
        }
      ?>
     <p>Přezdívka :<input type="text" name="prezdivka" size="20"></p>
     <?php 
        if(empty($prezdivka)){
          echo "<h4>Musíte zadat přezdívku !</h4>";
        }elseif(!preg_match("/^(.{3,})$/",$prezdivka)){
          echo "<h4>Minimálně 3 znaky !</h4>";
        }elseif (!preg_match("/^(.{1,25})$/",$prezdivka)){
          echo "<h4>Maximálně 25 znaků !</h4>";
        }elseif (!preg_match("/^[a-žA-Ž0-9]*$/",$prezdivka)) { 
          echo "<h4>Musíte zadat přezdívku !</h4>";
        }else{
          $validace++; 
        }
     ?>
     <p>E-mail :<input type="text" name="email" size="20"></p>
     <?php 
        if(empty($email)){
          echo "<h4>Musíte zadat email !</h4>";
        }elseif(!preg_match("/^(.{2,})$/",$email)){
          echo "<h4>Minimálně 2 znaky !</h4>";
        }elseif (!preg_match("/^(.{1,80})$/",$email)){
          echo "<h4>Maximálně 80 znaků !</h4>";
        }elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$email)) { 
          echo "<h4>Musíte zadat email !</h4>";
        }else{
          $validace++; 
        }
     ?>
     <p>Telefon :
     <select name="predcisli">
            <option value="+420">+420</option>
            <option value="+421">+421</option>
        </select>   
     <input type="number" name="telefon" size="20"></p>
     <?php 
        
        if($predcisli == "420"){
            $validace++;
        }elseif($predcisli == "421"){
            $validace++;
        } else {
            echo "<h4>Musíte zadat platný předčíslí!</h4>";
        }
        
        if(empty($telefon)){
          echo "<h4>Musíte zadat telefon !</h4>";
        }elseif(preg_match("/^[ ]*$/",$predcisli)){
            "Telefon nesmí obsahovat mezery";
        }elseif (!preg_match("/^[0-9]{9,9}$/",$telefon)) { 
          echo "<h4>Musíte zadat platný formát!</h4>";
        }else{
          $validace++; 
        }
     ?>
     <p>Heslo :<input type="password" name="heslo" size="20"></p>
     <?php 
        if(empty($heslo)){
          echo "<h4>Musíte zadat heslo !</h4>";
        }elseif(!preg_match("/^(.{6,})$/",$heslo)){
          echo "<h4>Minimálně 6 znaků !</h4>";
        }elseif (!preg_match("/^(.{1,30})$/",$heslo)){
          echo "<h4>Maximálně 30 znaků !</h4>";
        }elseif (!preg_match("/^[A-Ža-ž0-9!?]{5,}$/",$heslo)) { 
          echo "<h4>Povolené specialní znaky jsou ? a !</h4>";
        }else{
          $validace++; 
        }
     ?>
    <p>Kontrolní heslo :<input type="password" name="kheslo" size="20"></p>
    <?php 
        if ($heslo != $kheslo){   ///////////kontrola jestli se hesla shoduji
                echo "<h4>Hesla se musí shodovat !</h4>";
            }else{
                $validace++;
        }
    ?>    
     <input type="submit" name="button" value="Odeslat">
    </form>


<?php


if (isset($_POST['button'])) {              
    

    $sql = "SELECT * FROM webova_stranka_uzivatele";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($results as $t){            ///////zkontroluje jestli neni prezdivka nebo email obsazeny
    
 if ($t['prezdivka'] == $prezdivka){              
        echo "Tato přezdívka je obsazená !"   ;     
    $validace++;    
    }else{
        
        }
        
        if ($t['email'] == $email){              
            echo "Tento E-mail je zaregistrovaný !"   ;     
        $validace++;    
        }else{
            
            } 
    }

if ($validace == 8){

        $tel = $predcisli . $telefon;

        // zaheshuje heslo
        $hashed_heslo = password_hash($heslo, PASSWORD_DEFAULT);
    
       
        $sql = "INSERT INTO webova_stranka_uzivatele (jmeno, prijmeni, prezdivka, email, telefon, heslo) VALUES (:jmeno, :prijmeni, :prezdivka, :email, :telefon, :heslo)";
        $stmt = $conn->prepare($sql);
    
      
        $stmt->bindParam(':jmeno', $jmeno);
        $stmt->bindParam(':prijmeni', $prijmeni);
        $stmt->bindParam(':prezdivka', $prezdivka);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefon', $tel);
        $stmt->bindParam(':heslo', $hashed_heslo);
    
        if ($stmt->execute()) {
            echo "Registrace byla úspěšná!";
        } else {
            echo "Nastala chyba při registraci.";
        }
    }


}






?>



<div class="link">
<p>Jste zaregistrovaný ? Klikněte <a href="login.php">sem<a>
</div>
</div>




</div>


</body>
</html>