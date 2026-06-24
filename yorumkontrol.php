<?php
session_start();

// Oturum açık mı
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

// Formdan mı geldi, kötü niyetli direkt adresi yazan kişi
if (!isset($_POST["formdangelen"])) {
    header("Location: index.php");
    exit;
}

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
$kod = $_POST["kod"];

// Yorumu kontrol ettir
$yorum = trim($_POST["yorum"]);

if (empty($yorum)) { // Yorum boşsa geri gönderelim...
    header("Location:detay.php?kod=$kod");
    exit;
}

// Veri tabanına bağlanalım...
// Veri tabanına bağlanalım...
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8","root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

$sql = "insert into yorum (yapan, yapilan, metin) values (:yapan, :yapilan, :metin)";
$ifade = $vt->prepare($sql);
$ifade->execute(Array(":yapan"=>$_SESSION["id"], ":yapilan"=>$kod, ":metin"=>$yorum));    
 
//Bağlantıyı yok edelim...
$vt = null;
$_SESSION["mesaj"] = "Yorum başarı ile eklendi!";
header("Location:detay.php?kod=$kod");
?>