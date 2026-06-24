<?php 
session_start(); 
// Eğer kullanıcı zaten giriş yapmışsa, tekrar giriş sayfasına girmesin, ana sayfaya gitsin
if (isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap | FoodComment</title>
    <link rel="stylesheet" href="styles/style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>
<body>

    <?php include 'inc/header.inc.php'; ?>

<div class="signup-form">
    <form  method="post" action="giriskontrol.php">
        <h1>Giriş Yap</h1>
            <input type="text" placeholder="Kullanıcı Adınız" name="user" class="txt">
            <input type="password" placeholder="Şifreniz" name="password" class="txt">
            <input type="submit" name="formdangelen" value="Giriş Yap" class="btn">
        <a href="kayit.php">Hesabınız yok mu? - Hesap Oluştur</a>
    </form>

 
</body>
</html>