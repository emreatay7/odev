<?php
declare(strict_types=1);

function notHesapla(float $vize, float $final): array
{
    $ortalama = ($vize * 0.40) + ($final * 0.60);

    $harfAraliklari = [
        90 => 'AA',
        85 => 'BA',
        80 => 'BB',
        70 => 'CB',
        60 => 'CC',
        50 => 'DC',
        0  => 'FF',
    ];

    $harf = 'FF';
    foreach ($harfAraliklari as $min => $deger) {
        if ($ortalama >= $min) {
            $harf = $deger;
            break;
        }
    }

    $durum = ($ortalama >= 50) ? 'Gecti' : 'Kaldi';

    return [
        'ortalama' => round($ortalama, 2),
        'harf' => $harf,
        'durum' => $durum,
    ];
}

function notuOku(string $alan): ?float
{
    if (!isset($_POST[$alan])) return null;
    $raw = trim((string)$_POST[$alan]);
    if ($raw === '' || !is_numeric($raw)) return null;

    $val = (float)$raw;
    if ($val < 0 || $val > 100) return null;
    return $val;
}

function metinOku(string $alan): string
{
    return trim((string)($_POST[$alan] ?? ''));
}

function swalScript(string $icon, string $title, string $textOrHtml, bool $isHtml = false): string
{
    if ($isHtml) {
        return "<script>
Swal.fire({
  icon: " . json_encode($icon) . ",
  title: " . json_encode($title) . ",
  html: " . json_encode($textOrHtml) . ",
  confirmButtonColor: '#16a34a'
});
</script>";
    }

    return "<script>
Swal.fire({
  icon: " . json_encode($icon) . ",
  title: " . json_encode($title) . ",
  text: " . json_encode($textOrHtml) . ",
  confirmButtonColor: '#16a34a'
});
</script>";
}

$hata = '';
$sonuc = null;

$adSoyad = metinOku('adsoyad');
$ders = metinOku('ders');
$vize = notuOku('vize');
$final = notuOku('final');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($adSoyad === '' || $ders === '') {
        $hata = 'Lutfen Ad Soyad ve Ders Adi alanlarini doldurunuz.';
    } elseif ($vize === null || $final === null) {
        $hata = 'Vize ve Final notlari 0-100 araliginda sayisal olmalidir.';
    } else {
        $sonuc = notHesapla($vize, $final);
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Giris ve Hesaplama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ana: #16a34a;
            --ana-koyu: #15803d;
            --arka: #f0fdf4;
            --kart: #ffffff;
            --yazi: #14532d;
            --ikincil: #166534;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--yazi);
            background:
                radial-gradient(circle at 20% 20%, #dcfce7 0%, transparent 45%),
                radial-gradient(circle at 80% 0%, #bbf7d0 0%, transparent 35%),
                var(--arka);
            display: flex;
            align-items: center;
        }

        .wrap {
            width: 100%;
            padding: 24px 12px;
        }

        .app-card {
            max-width: 720px;
            margin: 0 auto;
            background: var(--kart);
            border-radius: 20px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 18px 40px rgba(20, 83, 45, 0.12);
            overflow: hidden;
        }

        .app-header {
            padding: 20px 24px;
            background: linear-gradient(135deg, var(--ana), #4ade80);
            color: #fff;
        }

        .app-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .app-header p {
            margin: 6px 0 0 0;
            opacity: 0.95;
            font-size: 14px;
        }

        .app-body {
            padding: 26px 24px 22px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #166534;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #86efac;
            padding: 11px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--ana);
            box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.18);
        }

        .btn-hesapla {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--ana), #22c55e);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-hesapla:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(21, 128, 61, 0.28);
            background: linear-gradient(135deg, var(--ana-koyu), var(--ana));
            color: #fff;
        }

        .sonuc-kutu {
            margin-top: 20px;
            border: 1px solid #86efac;
            background: #f0fdf4;
            border-radius: 14px;
            padding: 14px 14px 8px;
        }

        .sonuc-kutu h5 {
            margin-bottom: 10px;
            font-weight: 700;
            color: #166534;
        }

        .sonuc-kutu p {
            margin-bottom: 8px;
            color: #14532d;
        }

        .alt-not {
            margin-top: 14px;
            color: var(--ikincil);
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="app-card">
        <div class="app-header">
            <h1>Ogrenci Not Hesaplama</h1>
            <p>Vize ve final notunu gir, ortalama ve harf notunu gorelim.</p>
        </div>

        <div class="app-body">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                    <input type="text" id="adsoyad" name="adsoyad" class="form-control" required
                           value="<?= htmlspecialchars($adSoyad, ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="mb-3">
                    <label for="ders" class="form-label">Ders Adi</label>
                    <input type="text" id="ders" name="ders" class="form-control" required
                           value="<?= htmlspecialchars($ders, ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="vize" class="form-label">Vize Notu</label>
                        <input type="number" id="vize" name="vize" class="form-control"
                               min="0" max="100" step="0.01" required
                               value="<?= htmlspecialchars((string)($_POST['vize'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="final" class="form-label">Final Notu</label>
                        <input type="number" id="final" name="final" class="form-control"
                               min="0" max="100" step="0.01" required
                               value="<?= htmlspecialchars((string)($_POST['final'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-hesapla">Notu Hesapla</button>
                </div>
            </form>

            <?php if ($sonuc): ?>
                <div class="sonuc-kutu">
                    <h5>Sonuc</h5>
                    <p><strong>Ortalama:</strong> <?= htmlspecialchars((string)$sonuc['ortalama']) ?></p>
                    <p><strong>Harf Notu:</strong> <?= htmlspecialchars($sonuc['harf']) ?></p>
                    <p><strong>Durum:</strong> <?= htmlspecialchars($sonuc['durum']) ?></p>
                </div>
            <?php endif; ?>

            <div class="alt-not">Notlar 0-100 araliginda olmalidir.</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if ($hata !== '') {
    echo swalScript('error', 'Hata', $hata, false);
} elseif ($sonuc) {
    $html = "<b>Ortalama:</b> {$sonuc['ortalama']}<br><b>Harf Notu:</b> {$sonuc['harf']}<br><b>Durum:</b> {$sonuc['durum']}";
    echo swalScript('success', 'Hesaplama Basarili', $html, true);
}
?>
</body>
</html>