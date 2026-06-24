<?php
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8","root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["begeni_yap"]) && isset($_POST["kod"])) {
        $yemek_id = $_POST["kod"];
        $cookie_name = "begendi_" . $yemek_id;

        if (isset($_COOKIE[$cookie_name])) {
            // DAHA ÖNCE BEĞENMİŞ: Beğeniyi geri çek
            $sql = "UPDATE foodreview SET begueni_sayisi = begueni_sayisi - 1 WHERE id = :id";
            // Çerezi sil (süresini geçmişe alarak)
            setcookie($cookie_name, "", time() - 3600, "/");
        } else {
            // İLK KEZ BEĞENİYOR: Sayıyı artır
            $sql = "UPDATE foodreview SET begueni_sayisi = begueni_sayisi + 1 WHERE id = :id";
            // Çerezi kaydet (30 gün geçerli)
            setcookie($cookie_name, "1", time() + (86400 * 30), "/");
        }

        $sorgu = $vt->prepare($sql);
        $sorgu->execute([':id' => $yemek_id]);

        header("Location: detay.php?kod=" . $yemek_id);
        exit;
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>