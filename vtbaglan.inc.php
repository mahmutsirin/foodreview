<?php
// Profesyonel Yaklaşım: Değişken tabanlı yapı. 
// Yarın bir gün projeyi internete yüklediğinizde sadece bu 4 satırı değiştirmeniz yeterli olur.
$host     = "localhost";
$db_name  = "foodcomment";
$db_user  = "root";
$db_pass  = ""; 
$charset  = "utf8";

try {
    // DSN (Data Source Name): Bağlantı bilgilerini standart bir formatta birleştiriyoruz.
    $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
    
    // PDO nesnesini oluşturuyoruz.
    $vt = new PDO($dsn, $db_user, $db_pass);
    
    /* ÖNEMLİ: Hata Modu Ayarı
       ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
       Bu satır, SQL kodunuzda bir hata olursa PHP'nin bunu bir "istisna" olarak fırlatmasını sağlar.
       Böylece hataları 'catch' bloğunda yakalayıp profesyonelce yönetebiliriz.
    */
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verileri çekerken varsayılan olarak "ilişkisel dizi" (Associative Array) gelmesini sağlıyoruz.
    $vt->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    /* GÜVENLİK NOTU: 
       Hata mesajını ($e->getMessage()) sadece geliştirme yaparken ekrana basın. 
       Canlı sitede kullanıcıya "Veritabanı şifresi hatalı" gibi bilgiler göstermek güvenlik açığıdır.
    */
    die("Veritabanı bağlantısı şu anda sağlanamıyor."); 
}
?>