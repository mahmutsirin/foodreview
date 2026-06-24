<?php
session_start();
require_once 'inc/vtbaglan.inc.php';

if (!isset($_SESSION["id"]) || !isset($_GET["zaman"]) || !isset($_GET["kod"])) {
    header("Location: index.php");
    exit;
}

$zaman = $_GET["zaman"];
$yemek_id = $_GET["kod"];
$kullanici_id = $_SESSION["id"];

try {
    // Üçlü kontrol: Yapan kişi + Yapılan yemek + Tam zamanı
    $sql = "DELETE FROM yorum WHERE yapan = :yapan AND yapilan = :yapilan AND zaman = :zaman";
    $sorgu = $vt->prepare($sql);
    $sorgu->execute([
        ':yapan' => $kullanici_id,
        ':yapilan' => $yemek_id,
        ':zaman' => $zaman
    ]);

    header("Location: detay.php?kod=" . $yemek_id);
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>