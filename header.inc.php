<link rel="stylesheet" href="styles/style.css">

<?php
// Mevcut dosyanın ismini alır (Örn: index.php)
$aktif_sayfa = basename($_SERVER['PHP_SELF']);
?>

<header>
    <a href="index.php" class="logo">
        <img src="images/logo.png" alt="logo">
    </a>
    <nav class="navbar">
        <div class="search-form">
            <form action="review.php" method="GET">
                <input type="text" name="q" placeholder="Yemek ara..." value="<?php echo isset($_GET['q']) ? htmlentities($_GET['q']) : ''; ?>">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    <a href="index.php" class="<?php echo ($aktif_sayfa == 'index.php') ? 'active' : ''; ?>">Ana Sayfa</a>
    <a href="review.php" class="<?php echo ($aktif_sayfa == 'review.php') ? 'active' : ''; ?>">Paylaşımlar</a>
    <a href="about.php" class="<?php echo ($aktif_sayfa == 'about.php') ? 'active' : ''; ?>">Hakkımızda</a>
    
    <?php if (isset($_SESSION["id"])): ?>         
        <a href="dosyayukle.php" class="<?php echo ($aktif_sayfa == 'dosyayukle.php') ? 'active' : ''; ?>">Dosya Yükle</a>
    <?php endif; ?>
</nav>

    <div class="buttons">
        <button>
            <?php if (isset($_SESSION["id"])): 
                echo htmlentities($_SESSION["name"] . " " . $_SESSION["surname"]); 
            ?>     
                     <a href="cikis.php">Çıkış
                     <i class="fas fa-sign-out-alt">
                        </i>
                     </a>
                        
                    
            <?php endif; ?>
        </button>

        
            <?php if (!isset($_SESSION["id"])): ?> 
                      <button>
                    <a href="giris.php" class="btn-login">
                    <i class="fas fa-user"></i> Giriş Yap
                    </a>
                    </button>
            <?php endif; ?>
        
    </div>
</header>