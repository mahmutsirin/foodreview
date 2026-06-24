<?php 
// 1. ADIM: Oturumu başlatıyoruz ki giriş yapıp yapmadığını anlayalım.
session_start(); 

// 2. ADIM: Merkezi veritabanı bağlantısı (Senin inc klasöründeki dosyan).
require_once 'inc/vtbaglan.inc.php'; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Food Comment</title>
    <link rel="stylesheet" href="styles /style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    
    <?php 
    // 3. ADIM: Merkezi Header dosyasını çağırıyoruz.
    include 'inc/header.inc.php'; 
    ?>

    <section class="home">
        <div class="content">
            
            <?php 
            // 4. ADIM: GÖRÜNTÜ DEĞİŞME AYARI
            // Eğer kullanıcı giriş YAPMAMIŞSA (id yoksa) senin orijinal karşılama ekranın gelir:
            if (!isset($_SESSION["id"])): 
            ?> 
                <h3>HEM YEMEĞİ<br>HEM FİKRİNİ <br>PAYLAŞ</h3>
                <p>Sen de yediğin yemekle ilgili fikrini <br>bizimle paylaşmak ister misin?</p>
                
                
                <a href="kayit.php" class="btn">KAYIT OL</a>

            <?php 
            // Eğer kullanıcı GİRİŞ YAPMIŞSA ekran bu şekilde değişir:
            else: 
            ?>
                <h3>Hoş Geldin, <br> <?php echo htmlentities($_SESSION["name"] ); ?>!</h3><br>
                <p>Yeni lezzetler keşfetmek veya kendi <br>deneyimini paylaşmak için hazır mısın?</p>
                
                <a href="review.php" class="btn">PAYLAŞIMLARI GÖR</a>
                <a href="dosyayukle.php" class="btn">YENİ PAYLAŞIM YAP</a>
            <?php endif; ?>

        </div>
    </section>
    </body>
</html>