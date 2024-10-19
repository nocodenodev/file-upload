<?php
$weatherData = null;
$error = null;

if (isset($_GET['location'])) {
    $apiKey = 'SUA_CHAVE_AQUI';
    $location = urlencode($_GET['location']);
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric&lang=pt_br";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        $weatherData = json_decode($response, true);
    } else {
        $error = "Erro: " . $httpCode . " - " . json_decode($response)->message;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>Weather App</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <form method="GET" action="getWeather.php">
            <div class="search-box">
                <i class="bx bxs-map"></i>
                <input type="text" name="location" placeholder="Digite sua localização" required />
                <button type="submit" class="bx bx-search"></button>
            </div>
        </form>

        <?php if ($weatherData): ?>
            <p class="city"><?php echo $weatherData['name']; ?></p>

            <div id="weather-box">
                <img
                    id="weather-img"
                    src="http://openweathermap.org/img/wn/<?php echo $weatherData['weather'][0]['icon']; ?>@2x.png"
                    alt="Clima"
                />
                <div>
                    <p id="weather-value">
                        <?php echo round($weatherData['main']['temp']); ?> <sup>°C</sup>
                    </p>
                    <p id="weather-description"><?php echo htmlspecialchars($weatherData['weather'][0]['description']); ?></p>
                </div>
            </div>
            <div class="weather-details">
            <div class="temperature">
                    <img src="images/temperatura.svg" alt="">
                    <div class="text">
                        <p>Max / Mín</p>
                        <div class="info-temperature">
                            <span>
                              <?php echo round($weatherData['main']['temp_max']); ?>°/
                              <?php echo round($weatherData['main']['temp_min']); ?>°
                            </span>
                        </div>
                    </div>
                </div>
                <div class="feels-like">
                    <img src="images/sensacao_termica.svg" alt="">
                    <div class="text">
                        <p>Sensação Térmica</p>
                        <div class="info-feels-like">
                            <span><?php echo round($weatherData['main']['feels_like']); ?>°C</span>
                        </div>
                    </div>
                </div>
                <div class="humidity">
                    <img src="images/umidade.svg" alt="">
                    <div class="text">
                        <p>Umidade</p>
                        <div class="info-humidity">
                            <span><?php echo $weatherData['main']['humidity']; ?>%</span>
                        </div>
                    </div>
                </div>
                <div class="wind">
                    <img src="images/vento.svg" alt="">
                    <div class="text">
                        <p>Vento</p>
                        <div class="info-wind">
                            <span><?php echo round($weatherData['wind']['speed']); ?> Km/h</span>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($error): ?>
            <div class="not-found">
                <div class="box">
                    <img src="images/404.png" alt="Não Encontrado" />
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
