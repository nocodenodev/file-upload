<?php
date_default_timezone_set('America/Sao_Paulo');

// URL da API
$url = 'https://store1.gofile.io/contents/uploadfile';

// Verifica se o arquivo foi enviado
if (isset($_FILES['file'])) {
    // Caminho temporário do arquivo enviado
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];

    // Inicializa a sessão cURL
    $ch = curl_init();

    // Configura as opções cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Define o cabeçalho de autorização (se necessário)
    // Exemplo: $headers = ["Authorization: Bearer your_token"];
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Prepara os dados do arquivo e o ID da pasta para o upload
    $post_fields = [
        'file' => new CURLFile($file_tmp, $_FILES['file']['type'], $file_name),
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    // Executa a requisição cURL
    $response = curl_exec($ch);

    // Verifica se houve algum erro
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        // Exibe a resposta
        $responseData = json_decode($response, true);
        if (isset($responseData['data']['downloadPage'])) {
            $downloadPageUrl = $responseData['data']['downloadPage'];

            $timestamp = date('Y-m-d H:i:s');
            error_log("[$timestamp] Download URL: $downloadPageUrl\n", 3, "arquivos_da_galera.txt");
            // Redireciona para a página de sucesso com a URL de download
            header('Location: upload-success.php?url=' . urlencode($downloadPageUrl));
            exit();
        } else {
            echo 'Não foi possível obter a URL de download.';
        }
    }

    // Fecha a sessão cURL
    curl_close($ch);
} else {
    echo 'Não foi feito upload de arquivo.';
}
?>
