<?php
session_start();
require_once 'inc/vtbaglan.inc.php';

// Güvenlik: Giriş ve ID kontrolü
if (!isset($_SESSION["id"]) || !isset($_GET["id"])) {
    header("Location: review.php");
    exit;
}

$silinecek_id = $_GET["id"];
$kullanici_id = $_SESSION["id"];

try {
    // 1. Önce silinecek paylaşımın dosya yolunu (resmi) öğrenmemiz lazım
    $sorgu_dosya = $vt->prepare("SELECT dosyayolu FROM foodreview WHERE id = :id AND yukleyen = :user");
    $sorgu_dosya->execute([':id' => $silinecek_id, ':user' => $kullanici_id]);
    $dosya = $sorgu_dosya->fetch(PDO::FETCH_ASSOC);

    if ($dosya) {
        // 2. Fiziksel dosyayı klasörden sil (Örn: images/yemek.jpg)
        if (file_exists($dosya['dosyayolu'])) {
            unlink($dosya['dosyayolu']);
        }

        // 3. Veritabanından kaydı sil (Yorumlar 'yapilan' sütunu ile bağlıysa onlar da silinmeli)
        // Eğer veritabanında "ON DELETE CASCADE" yoksa önce yorumları silmelisin:
        $vt->prepare("DELETE FROM yorum WHERE yapilan = :id")->execute([':id' => $silinecek_id]);
        
        // Şimdi asıl paylaşımı sil
        $sql = "DELETE FROM foodreview WHERE id = :id AND yukleyen = :user";
        $sil_sorgu = $vt->prepare($sql);
        $sil_sorgu->execute([':id' => $silinecek_id, ':user' => $kullanici_id]);
    }

    header("Location: review.php?mesaj=silindi");
} catch (PDOException $e) {
    die("Hata: " . $e->getMessage());
}
?>