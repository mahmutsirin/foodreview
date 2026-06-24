<?php session_start(); 

// GET["kod"] tanımlanmış mı?
if (!isset($_GET["kod"])) {
    header("Location: index.php");
    exit;
}
  
  // GET["kod"] sayı mı?
  if (!is_numeric($_GET["kod"])) {
    header("Location: index.php");
    exit;
  }
  ?>
  <?php
require_once 'inc/vtbaglan.inc.php'; 
?>



<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Food Comment</title>
        <link rel="stylesheet" href="styles/style.detay.css">
    </head>
    
<body>

  <!--! header baslangıc -->
 
    <!--! header bitis -->

    <?php
        
        // Veri tabanına bağlanalım...
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8","root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
        
        $sql ="select foodreview.*, kullanicikayit.isim ,kullanicikayit.soyisim from foodreview, kullanicikayit WHERE foodreview.yukleyen = kullanicikayit.id and foodreview.id = :id" ;
        $ifade = $vt->prepare($sql);
        $ifade->execute(Array(":id"=>$_GET["kod"]));
        $kayit = $ifade->fetch(PDO::FETCH_ASSOC);  
        
            if ($kayit == false) { // Kod bulunamadıysa 
                echo "Bu yemeğe ait veriler okunamadı!";
                header("Location: index.php");
            } else  { // Kod veri tabanında bulunduysa
                /*
                echo "<pre>";
                print_r($kayit);
                echo "</pre>";
                */
                include 'inc/header.inc.php'; 
        ?>


        <!--! yorumlar baslangıc -->
 
    
    <section class="review">
                <div class="box-container">
            <div class="box">
                
                    <div class="title-container">
                        <a href="review.php" class="back-link">
                            <i class="fas fa-chevron-left"></i>
                            <span>Geri Dön</span>
                        </a>
                        <h2 class="food-title"><?php echo htmlentities($kayit["yemek_adi"]); ?></h2>
                    </div>
            
            
            <img src="<?php echo htmlentities($kayit["dosyayolu"]); ?>" alt="resim" />
                   
                    <p class="comment-text">
                        <?php echo htmlentities($kayit["fikir"]); ?>
                    </p>
<?php
                    if (isset($_SESSION["id"])) { // Giriş yapıldıysa yorum yapabilsin
                        ?>
                    <?php 
            $begendi_mi = isset($_COOKIE["begendi_" . $kayit['id']]);
            $buton_stili = $begendi_mi ? "background-color: #ff4757; color: white; border-color: #ff4757;" : "";
            $ikon_stili = $begendi_mi ? "color: white;" : "color: #ff4757;";
        ?>
        <form action="begenikontrol.php" method="post">
            <input type="hidden" name="kod" value="<?php echo $kayit['id']; ?>">
            <button type="submit" name="begeni_yap" class="like-button" style="<?php echo $buton_stili; ?>">
                <i class="fas fa-heart" style="<?php echo $ikon_stili; ?>"></i>
                <span><?php echo $begendi_mi ? "Beğendin" : "Beğen"; ?> (<?php echo $kayit['begueni_sayisi'] ?? 0; ?>)</span>
            </button>
        </form>
         <?php
                    }
                    ?>
                    
                
                <?php        
            $sql ="select yorum.*, kullanicikayit.isim,kullanicikayit.soyisim from yorum, kullanicikayit WHERE yapilan= :yapilan and kullanicikayit.id=yorum.yapan  order by yorum.zaman desc";
            $ifade = $vt->prepare($sql);
            $ifade->execute(Array(":yapilan"=>$_GET["kod"]));
            ?>
            
            <div class="review">
                
                
                <?php
                    if (isset($_SESSION["id"])) { // Giriş yapıldıysa yorum yapabilsin
                        ?>
                            <<form action="yorumkontrol.php" method="post">
        <div>
            <textarea name="yorum" class="yorum" placeholder="Yemeği siz nasıl buldunuz? Yorumunuzu buraya yazınız..."></textarea>
        </div>
        <input type="hidden" name="kod" value="<?php echo $_GET["kod"]; ?>">
        <div>
            <input type="submit" class="btnn" name="formdangelen" value="Yorum Yap">  
        </div>                                    
    </form>
                        
                        <?php
                    }
                    ?>
                    
                </div>
                <div>
                        <div class="comments-display">
    <?php while ($kayit_yorum = $ifade->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="comment-box">
        <div class="comment-header">
            <strong><?php echo htmlentities($kayit_yorum["isim"]." ".$kayit_yorum["soyisim"]); ?></strong>
            <span class="comment-date"><?php echo $kayit_yorum["zaman"]; ?></span>

            <?php if (isset($_SESSION["id"]) && $_SESSION["id"] == $kayit_yorum["yapan"]): ?>
                <a href="yorumsil.php?zaman=<?php echo urlencode($kayit_yorum['zaman']); ?>&kod=<?php echo $_GET['kod']; ?>" 
                   onclick="return confirm('Bu yorumu silmek istediğine emin misin?')" 
                   style="color: #ff4757; margin-left: 10px; text-decoration:none;">
                   <i class="fas fa-trash"></i> 
                </a>
            <?php endif; ?>
        </div>
        <p ><?php echo htmlentities($kayit_yorum["metin"]); ?></p>
    </div>
<?php endwhile; ?>
    <?php if (isset($_SESSION["id"])): ?>
    <div class="like-section">
        
    </div>
<?php else: ?>
    <div style="text-align: center; margin: 3rem 0;">
        <a href="giris.php" style="text-decoration: none;">
            <div style="font-size: 1.6rem; color: #666; display: inline-block; padding: 1rem 2rem; border: 1px dashed #ccc; border-radius: 1rem;">
                <i class="fas fa-comments" style="color: var(--main2-color); margin-right: 1rem;"></i>
                Yorum yapmak için lütfen <span style="color: var(--main2-color); font-weight: bold; text-decoration: underline;">giriş yapın</span>.
            </div>
        </a>
    </div>
<?php endif; ?>
</div>     
                        </div>
                                                       
                    </div>
                    
                </div>
            </div>
            
            </div>
            
        </div>
        
       </section>
    <!--! yorumlar bitis -->
 <?php 
 } 
 ?>


<script>
window.addEventListener('load', function() {
    const images = document.querySelectorAll('.review .box-container .box img');
    
    images.forEach(img => {
        // Eğer resim dikeyse (Yükseklik > Genişlik)
        if (img.naturalHeight > img.naturalWidth) {
            
            // 1. BOYUT TAKASI (KİLİT NOKTA)
            // Resim 270 derece döneceği için;
            // Yeni Genişlik = Senin istediğin Yükseklik (35rem)
            // Yeni Yükseklik = Senin istediğin Genişlik (Box'ın %70'i)
            
            const parentWidth = img.parentElement.offsetWidth;
            const targetWidth = parentWidth * 0.70; // %70 genişlik
            const targetHeight = 350; // 35rem (yaklaşık 350px)

            // Dikkat: Resim yan döneceği için boyutları ters veriyoruz
            img.style.width = targetHeight + "px"; 
            img.style.height = targetWidth + "px";

            // 2. DÖNDÜRME VE KONUMLANDIRMA
            // Resmi döndürürken oluşan o hayalet boşlukları yok etmek için scale ekliyoruz
            // %70 genişlik ve 35rem yüksekliğe tam oturması için:
            img.style.transform = "rotate(270deg) scale(1.85)";
            
            // 3. BOŞLUKLARI SIFIRLA
            // Resim yan döndüğünde dikeyde çok yer kaplamasın diye:
            img.style.marginTop = "2rem";
            img.style.marginBottom = "5rem";
            
            // Resmin kutuya yayılmasını sağla
            img.style.objectFit = "cover";
            img.style.width = "20rem";
            img.style.height = "30rem";
            // Kart içindeki diğer elemanların (yazıların) yukarı kayması için 
            // resmin dış kutu etkisini manuel daraltıyoruz
            img.parentElement.style.height = "auto";
        } else {
            // Eğer resim zaten yataysa sadece senin istediğin ölçüleri uygula
            
        }
    });
});
</script>
</body>
</html>
</body>
            </html>