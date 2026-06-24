<?php
session_start();

// 1. Formdan gelip gelmediğini kontrol et
if (!isset($_POST["formudoldurdum"])) {
    echo "<script>
            alert('Lütfen önce formu doldurunuz!');
            window.location.href='kayit.php';
          </script>";
    exit;
}

// 2. Şifrelerin eşleşme kontrolü
if ($_POST["password"] != $_POST["password1"]) {
    echo "<script>
            alert('Şifreler birbiriyle uyuşmuyor!');
            window.location.href='kayit.php';
          </script>";
    exit;
}

// 3. Veri temizleme ve temel boşluk kontrolleri
$name = trim($_POST["name"]);
$surname = trim($_POST["surname"]);
$user = trim($_POST["user"]);
$email = $_POST["email"];
$dob = $_POST["date"];

if (empty($name) || empty($surname) || empty($user) || empty($email)) {
    echo "<script>
            alert('Lütfen tüm alanları doldurunuz!');
            window.location.href='kayit.php';
          </script>";
    exit;
}

// 4. Ad ve Soyad uzunluk kontrolü (En az 5 karakter)
if (strlen($name) + strlen($surname) < 5) {
    echo "<script>
            alert('Adınız ve soyadınız toplamda en az 5 karakter olmalıdır!');
            window.location.href='kayit.php';
          </script>";
    exit;
}

// 5. E-posta format kontrolü
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>
            alert('Lütfen geçerli bir e-posta adresi giriniz!');
            window.location.href='kayit.php';
          </script>";
    exit;
}

// 6. Şifreyi güvenli hale getir (Hashing)
$sifre_hashli = password_hash($_POST["password"], PASSWORD_DEFAULT);

// 7. Veritabanı işlemleri
try {
    $vt = new PDO("mysql:dbname=foodcomment;host=localhost;charset=utf8", "root", "");
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO kullanicikayit (isim, soyisim, user, eposta, sifre, dogumtarihi) 
            VALUES (:isim, :soyisim, :user, :eposta, :sifre, :dogumtarihi)";
    
    $ifade = $vt->prepare($sql);
    $sonuc = $ifade->execute([
        ":isim"        => $name,
        ":soyisim"     => $surname,
        ":user"        => $user,
        ":eposta"      => $email,
        ":sifre"       => $sifre_hashli,
        ":dogumtarihi" => $dob
    ]);

    if ($sonuc) {
        echo "<script>
                alert('Hesabınız başarıyla oluşturuldu! Giriş yapabilirsiniz.');
                window.location.href='giris.php';
              </script>";
    }

} catch (PDOException $e) {
    // Hata durumunda kullanıcıya teknik detay yerine genel bir mesaj gösterelim
    echo "<script>
            alert('Kayıt sırasında bir hata oluştu. Lütfen kullanıcı adını veya e-postayı kontrol edin.');
            window.location.href='kayit.php';
          </script>";
}

// Bağlantıyı kapat
$vt = null;
?>