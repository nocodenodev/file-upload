<?php
// URL de download obtida após o upload
$downloadPageUrl = $_GET['url']; // Supondo que você passará a URL como parâmetro na query string

// Verifica se a URL está presente
if (empty($downloadPageUrl)) {
    die('URL não fornecida.');
}

// Gera a URL para o QR Code usando a API
$qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($downloadPageUrl);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bem-Sucedido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="success-container">
        <h1>Upload Bem-Sucedido!</h1>
        <div class="qr-code">
            <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
        </div>
        <a href=<?php echo "" . $downloadPageUrl . "" ?>><?php echo $downloadPageUrl ?></a>
        <button class="back-button" onclick="window.location.href='index.html'">Voltar</button>
    </div>
</body>
</html>
