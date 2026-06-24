<?php
session_start();

// 1. Formdan gelip gelmediğini kontrol et
if (!isset($_POST["formdangelen"])) {
    header('Location: giris.php');
    exit;
}

// 2. Veritabanı Bağlantısı (Bağlantı hatasını kullanıcıya göstermemek güvenli farksızdır)
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8", "root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Sistem şu an meşgul, lütfen daha sonra tekrar deneyiniz."); 
}

// 3. Kullanıcıyı sorgula
$user = $_POST["user"];
$password = $_POST["password"];

$sql = "SELECT * FROM kullanicikayit WHERE user = :user";
$ifade = $vt->prepare($sql);
$ifade->execute([":user" => $user]);
$kayit = $ifade->fetch(PDO::FETCH_ASSOC);

// 4. Doğrulama (Kullanıcı var mı VE şifre doğru mu?)
if ($kayit && password_verify($password, $kayit["sifre"])) {
    
    // Oturum bilgilerini ata
    $_SESSION["id"]      = $kayit["id"];
    $_SESSION["email"]   = $kayit["eposta"];
    $_SESSION["name"]    = $kayit["isim"];
    $_SESSION["surname"] = $kayit["soyisim"];
    $_SESSION["user"]    = $kayit["user"];
    
    // Giriş başarılı, ana sayfaya yönlendir
    header('Location: index.php');
    exit;

} else {
    // Kullanıcı yoksa veya şifre yanlışsa
    echo "<script language='javascript'>
            alert('Kullanıcı adı veya şifre hatalı!');
            window.location.href='giris.php';
          </script>";
    exit;
}
?>