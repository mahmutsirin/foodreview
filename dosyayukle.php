<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title>İlk Sayfam</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <?php 
    // 3. ADIM: Merkezi Header dosyasını çağırıyoruz.
    include 'inc/header.inc.php'; 
    ?>
    <div class="signup-form">
    <h1>FoodComment</h1>
    <form action="dosyayuklekontrol.php?formdangelen=1" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Yemeğin adı" name="name" id="name" class="txt">
        <input type="text" placeholder="Nerde yediniz?(Cafe Bahçe vs. gibi)" name="ra" class="txt">
        <input type="text" placeholder="Adresi" name="rk" class="txt">     
        <input type="hidden" name="MAX_FILE_SIZE" value="1500000" class="txt"/>              
        <div>
        <input type="file" id="dosya" name="dosya" class="txt">
        </div>
        <textarea name="fikir"  placeholder="Lütfen fikrinizi buraya giriniz!" class="txt"></textarea>        
        <p><input type="submit" value="Yükle" class="btn"></p>
        

    </form>
</div>
</body>
</html>