<?php
// Telegram Webhook: Verarbeitet eingehende Updates
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    // Benutzerdaten extrahieren
    $telegram_id = $update["message"]["from"]["id"];
    $first_name = $update["message"]["from"]["first_name"] ?? '';
    $last_name = $update["message"]["from"]["last_name"] ?? '';
    $username = $update["message"]["from"]["username"] ?? '';

    // Daten speichern
    $userData = [
        'telegram_id' => $telegram_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'username' => $username,
    ];

    file_put_contents('user_data.json', json_encode($userData));

    // Antwort an den Benutzer
    if ($message == "/start") {
        sendMessage($chat_id, "Hello $first_name! Your data has been saved.");
    }
}

function sendMessage($chat_id, $message) {
    $apiToken = "7940326265:AAGTwMX7dfofnkTBECwCLibNHshgfY_MXAw";
    $url = "https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
    file_get_contents($url);
}
?>
