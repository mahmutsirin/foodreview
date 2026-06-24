<?php 
session_start(); 
$aktif_sayfa = basename($_SERVER['PHP_SELF']);

require_once 'inc/vtbaglan.inc.php'; 



// ANA SORGU: Beğeni ve Yorum sayısını alt sorgularla çekiyoruz
// ANA SORGU: Beğeni sayısı zaten tabloda olduğu için doğrudan çekiyoruz
// 1. Arama terimi kontrolü
$arama_terimi = isset($_GET['q']) ? $_GET['q'] : '';

// 2. Sorgu Mantığı
if (!empty($arama_terimi)) {
    // ARAMA YAPILDIĞINDA: Hem yorum sayısını çeker hem de filtreleme yapar
    $sql = "SELECT fr.*, k.isim, k.soyisim,
            (SELECT COUNT(*) FROM yorum WHERE yorum.yapilan = fr.id) as toplam_yorum
            FROM foodreview fr 
            JOIN kullanicikayit k ON fr.yukleyen = k.id 
            WHERE fr.yemek_adi LIKE :arama
            ORDER BY fr.id DESC";
            
    $ana_sorgu = $vt->prepare($sql);
    $ana_sorgu->execute([':arama' => "%$arama_terimi%"]);
} else {
    // NORMAL DURUM: Senin gönderdiğin orijinal sorgu (tüm listeyi getirir)
    $sql = "SELECT fr.*, k.isim, k.soyisim,
            (SELECT COUNT(*) FROM yorum WHERE yorum.yapilan = fr.id) as toplam_yorum
            FROM foodreview fr 
            JOIN kullanicikayit k ON fr.yukleyen = k.id 
            ORDER BY fr.id DESC";
            
    $ana_sorgu = $vt->prepare($sql);
    $ana_sorgu->execute();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Paylaşımlar | Food Comment</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>
<body>

    <?php include 'inc/header.inc.php'; ?>

    <section class="review">
        
        <div class="box-container">
            <?php while ($kayit = $ana_sorgu->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="box"> 
                    <div class="content-card"> 
                        
                        
                        <a href="detay.php?kod=<?php echo $kayit['id']; ?>">
                        <h2><?php echo htmlentities($kayit["yemek_adi"]); ?></h2>
                        
                        <img src="<?php echo htmlentities($kayit["dosyayolu"]); ?>" alt="yemek">

                        <div class="details">
                            <p><b><i class="fas fa-utensils"></i> Mekan:</b> <?php echo htmlentities($kayit["mekan_adi"]); ?></p>
                            <p><b><i class="fas fa-map-marker-alt"></i> Adres:</b> <?php echo htmlentities($kayit["konum"]); ?></p>
                            
                          
                        </div>

                   <div class="footer-area">
    <h3><span>Paylaşan:</span> <?php echo htmlentities($kayit["isim"] . " " . $kayit["soyisim"]); ?></h3>
    
    <div class="details">  
        <div style="margin-bottom: 0.5rem;">
            <b><i class="fas fa-heart"></i> Beğeniler:</b> 
            <span><?php echo $kayit["begueni_sayisi"]; ?> beğeni</span>
        </div>

        <div>
            <b><i class="fas fa-comments"></i> Yorumlar:</b> 
            <span><?php echo $kayit["toplam_yorum"]; ?> yorum</span>
        </div>
        
    </div>
    </a>
    
</div>
    <?php if (isset($_SESSION["id"]) && $_SESSION["id"] == $kayit["yukleyen"]): ?>
        <div style="text-align: right; margin-top: 10px;">
            <a href="yuklemesil.php?id=<?php echo $kayit['id']; ?>" 
            onclick="return confirm('Bu paylaşımı ve içindeki tüm verileri silmek istediğine emin misin?')" 
            style="color: #EB6406; font-size: 1.4rem; font-weight: bold; text-decoration: none;">
            <i class="fas fa-trash-alt"></i> Paylaşımı Kaldır
            </a>
        </div>
<?php endif; ?>
                    </div>
                    
                </div>
                
            <?php endwhile; ?>
        </div>
        
    </section>
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
            img.style.marginTop = "4rem";
            img.style.marginBottom = "5rem";
            
            // Resmin kutuya yayılmasını sağla
            img.style.objectFit = "cover";
            img.style.width = "15rem";
            img.style.height = "20rem";
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