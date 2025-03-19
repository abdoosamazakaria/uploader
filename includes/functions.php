<?php
function generateDownloadCode() {
    return uniqid();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function getCountryFromIP($ip) {
    $access_key = '47a3e1261bd14a'; // استبدل بمفتاح API الخاص بك
    $location = json_decode(file_get_contents("http://ipinfo.io/{$ip}?token={$access_key}"), true);
    return $location['country'] ?? 'غير معروف';
}

function getDeviceType() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'Mobile') !== false) {
        return 'هاتف محمول';
    } elseif (strpos($user_agent, 'Tablet') !== false) {
        return 'جهاز لوحي';
    } else {
        return 'كمبيوتر';
    }
}
?>