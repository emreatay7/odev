<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Formu</title>
</head>
<body>
   <center><h1>İş Başvuru Formu </h1></center>
   <form method="get" action="sonuc.php">
      <input type="text" name="ad" placeholder="Adınızı giriniz">
      <input type="text" name="soyad" placeholder="Soyadınızı giriniz"><br>
      <input type="text" name="il" placeholder="İl giriniz">
      <input type="text" name="ilçe" placeholder="İlçe giriniz"><br>
      <input type="text" name="adres" placeholder="Adres giriniz">
      <input type="text" name="cep_telefonu" placeholder="Cep telefonu giriniz"><br>
      <textarea name="özgeçmiş" placeholder="Özgeçmişinizi giriniz" rows="8" cols="40"></textarea>
      <input type="submit" value="GET ile Gönder">
   </form>
</body>
</html>