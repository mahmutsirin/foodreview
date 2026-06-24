<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Food Comment-Hakkımızda</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    
<body>
 <!--! header baslangıc -->
   <?php 
    // 3. ADIM: Merkezi Header dosyasını çağırıyoruz.
    include 'inc/header.inc.php'; 
    ?>
    <!--! header bitis -->

    <!--! hakkinda baslangıc -->
    <section class="about">
        <h1 class="heading">Hakkımda</h1>
        <div class="row">
            <div class="image">
                <img src="images/sahip.jpg " alt="about">
            </div>
            <div class="content">
                <p class="txt" style="color:black;">Bu proje Mahmut Huda ŞİRİN tarafından WEB TABANLI PROGRAMLAMA dersinin proje ödevi için hazırlanmıştır. 
                Projede veritabanına bağlanmak için PDO dan yararlanışmıştır. Projede kayıt olma,giriş yapma, dosya yükleme
                , yapılan yüklemelere yorum ekleme gibi özellikler bulunmaktadır. Proje hazırlanırken HTML, CSS, PHP
                ve az da olsa Javascript kullanılmıştır. Proje konum ise gidip görüp yediğiniz bir yemekle ilgili fotoğraf, mekan, konum ve fikir
                paylaşımı yaparak sizden sonra gidecek olanlara yol göstermek, sizden önce gidenlerin ya da henüz gitmemiş olanların da sizin fikrinize yorum yapabileceği
                bir platform oluşturmak. Bu fikirler ve yorumlar doğrultusunda da kullanıcıları bir etkileşim halinde tutmak amaçlanmıştır. </p>
                
                <a href="https://www.instagram.com/mhmtsrn07/" class="btn">Daha fazla bilgi için bize ulaşın</a>

            </div>
            
        </div>
      
    </section>
    <!--! hakkinda bitis -->

    
</body>
</html>