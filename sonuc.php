<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Başvuru Sonucu</title>
</head>
<body>
    <h1>Personel Bilgi Sorgulama Ekranı</h1>

    <?php
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h3>Yöntem: <span style='color:red;'>POST</span></h3>";
        $veriler = $_POST; 
    } 
   
    elseif ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
        echo "<h3>Yöntem: <span style='color:blue;'>GET</span></h3>";
        $veriler = $_GET; 
        }

    echo "<strong>Ad: </strong>" . $veriler["ad"] . "<br>";
    echo "<strong>Soyad: </strong>" . $veriler["soyad"] . "<br>";
    echo "<strong>İl: </strong>" . $veriler["il"] . "<br>";
    echo "<strong>İlçe: </strong>" . $veriler["ilçe"] . "<br>";
    echo "<strong>Adres: </strong>" . $veriler["adres"] . "<br>";
    echo "<strong>Cep Telefonu: </strong>" . $veriler["cep_telefonu"] . "<br>";
    echo "<strong>Özgeçmiş: </strong><br>" . nl2br($veriler["özgeçmiş"]) . "<br>";
    ?>

    <br>
    <a href="form_post.php">Geri Dön</a>
</body>
</html>