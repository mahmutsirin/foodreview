<?php
session_start();


// Oturum açık mı
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

// Formdan mı geldi, kötü niyetli direkt adresi yazan kişi
if (!isset($_GET["formdangelen"])) {
    header("Location: index.php");
    exit;
}

// Dosya geldimi
if ($_FILES["dosya"]["error"] <> 0) { // Hata oluştu mu, dosya geldi mi?
    echo "<script>
    alert('Dosya 1.5MB\'den küçük olmalıdır!');
    window.location.href='dosyayukleform.php';
    </script>";
    exit;
}


// Dosya boyutu kontrol et
if ($_FILES["dosya"]["size"] > 1500000) { // Dosya 1.5 MB'den büyükse
    echo "<script language='javascript'>
    alert('Dosya 1.5MB\'tan küçük olmalıdır!');
    window.location.href='dosyayukleform.php';
    </script>";
    exit;
}

// Resim dosyası mı onu kontrol et
$izinli = ['image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png'];
if (in_array($_FILES['dosya']['type'], $izinli)) {
    echo "Geçerli dosya";
}
else {
    echo "Geçersiz dosya!<br>";
    echo "Yüklemeye çalıştığınız dosya türü: ";
    echo $_FILES['dosya']['type'];
    echo "<script language='javascript'>
    alert('Yüklediğiniz dosya türüne izin verilmiyor!');
    window.location.href='dosyayukleform.php';
    </script>"; 
    exit;   
}

/*
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
*/
// İsmini kontrol ettir
if (!isset($_POST["name"]) or empty($_POST["name"])) {
    //Hata mesajı ver gönder
}

// Dosyayı kaydedeceğiz
// Aynı isimde farklı dosyalar aynı isimle kaydedilmesin
$hedef =  "images/".time().$_SESSION["id"].basename($_FILES["dosya"]["name"]);
move_uploaded_file($_FILES["dosya"]["tmp_name"], $hedef);

// Veri tabanına bağlanalım...
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8","root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

// Sorgular ve diğer işlemler burada...
if (!isset($_POST["name"]) or empty($_POST["name"])) {
    $yemekismi = false;
} else {
    $yemekismi = true;
    // trim yemekismi
    //uzunluk kontrolü vs.     
}

if ($yemekismi == true) { // yemek adı girildiyse
    $sql = "insert into foodreview (yemek_adi,mekan_adi, konum, fikir, dosyayolu, yukleyen) values (:yemek_adi, :mekan_adi, :konum, :fikir, :dosyayolu, :yukleyen)";
    $ifade = $vt->prepare($sql);
    $ifade->execute(Array(":yemek_adi"=>$_POST["name"], ":mekan_adi"=>$_POST["ra"] , ":konum"=>$_POST["rk"], ":dosyayolu"=>$hedef, ":fikir"=>$_POST["fikir"], ":yukleyen"=>$_SESSION["id"]));    
} else { // yemek adi girilmemişse
    $sql = "insert into foodreview (mekan_adi,konum,fikir, dosyayolu, yukleyen) values (:mekan_adi, :konum, :fikir, :dosyayolu, :yukleyen)";
    $ifade = $vt->prepare($sql);
    $ifade->execute(Array(":dosyayolu"=>$hedef, ":fikir"=>$_POST["fikir"], ":yukleyen"=>$_SESSION["id"]));    

} 
//Bağlantıyı yok edelim...
$vt = null;
echo "<script language='javascript'>
alert('Yemek fikriniz başarı ile kaydedildi!');
window.location.href='review.php';
</script>";
?>