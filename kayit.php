<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<title>FoodComment</title>
    <link rel="stylesheet" href="styles/style2.css">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
      <?php 
    // 3. ADIM: Merkezi Header dosyasını çağırıyoruz.
    include 'inc/header.inc.php'; 
    ?>
<div class="signup-form">
    <form  method="post" action="kayitkontrol.php">
        <h3>KAYIT OL</h3>
        <input type="text" placeholder="Adınız" name="name" class="txt"> 
        <input type="text" placeholder="Soyadınız" name="surname" class="txt">
        <input type="text" placeholder="Kullanıcı Adınız" name="user" class="txt"> 
        <input type="email" placeholder="Email" name="email" class="txt">
        <input type="password" placeholder="Şifreniz" name="password" class="txt">
        <input type="password" placeholder="Şifreniz(Tekrar)" name="password1" class="txt">
        
            
        <input type="submit" name="formudoldurdum" value="Hesap Oluştur" class="btn">
        <a href="giris.php">Zaten Hesabınız var mı?</a>
    </form>

</body>
</html>