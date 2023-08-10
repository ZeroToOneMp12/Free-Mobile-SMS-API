<?php

// Informations d'authentification FreeboxSMS
define('USER', '');
define('PASS', '');

// Liste des appareils à surveiller
$devices = array(
    array('name' => 'Appareil1', 'ip' => '', 'port' => 80),
    // Ajoutez plus d'appareils si nécessaire
);

// Chemin vers le fichier de cache
$cacheFile = 'status_cache.json';

// Vérification de l'existence du cache
$cachedStatus = array();
if (file_exists($cacheFile)) {
    $cacheData = file_get_contents($cacheFile);
    $cachedStatus = json_decode($cacheData, true);
}

// Boucle de vérification des appareils
foreach ($devices as $device) {
    $ip = $device['ip'];
    $port = $device['port'];
    
    // Vérifier si l'appareil est nouveau
    if (!array_key_exists($ip, $cachedStatus)) {
        $currentStatus = isPortOpen($ip, $port);
        
        $statusMessage = $currentStatus ? "en ligne" : "hors ligne";
        $newDeviceMessage = "La surveillance de l'appareil {$device['name']} ($ip) a commencé. État actuel : $statusMessage";
        file_get_contents("https://smsapi.free-mobile.fr/sendmsg?user=" . USER . "&pass=" . PASS . "&msg=" . urlencode($newDeviceMessage));
    }
    
    $currentStatus = isPortOpen($ip, $port);

    if (array_key_exists($ip, $cachedStatus)) {
        $previousStatus = $cachedStatus[$ip];
        if ($currentStatus !== $previousStatus) {
            // Statut changé (passé de en ligne à hors ligne ou vice versa)
            $statusMessage = $currentStatus ? "en ligne" : "hors ligne";
            $message = "L'appareil {$device['name']} ($ip) est maintenant $statusMessage.";
            file_get_contents("https://smsapi.free-mobile.fr/sendmsg?user=" . USER . "&pass=" . PASS . "&msg=" . urlencode($message));
        }
    }

    // Mise à jour du cache
    $cachedStatus[$ip] = $currentStatus;
}

// Sauvegarde du cache
file_put_contents($cacheFile, json_encode($cachedStatus));

// Fonction pour vérifier si le port est ouvert
function isPortOpen($ip, $port) {
    $timeout = 2;
    $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if ($socket) {
        fclose($socket);
        return true;
    } else {
        return false;
    }
}
?>
