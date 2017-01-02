<?php
function ping($host, $port=25565, $timeout=30) {
    $handle = fsockopen($host, $port, $errno, $errstr, $timeout);
    try {
        fwrite($handle, "\xFE");
        $d = fread($handle, 256);
        if ($d[0] != "\xFF") return false;
        $d = substr($d, 3);
        $d = mb_convert_encoding($d, 'auto', 'UCS-2');
        $d = explode("\xA7", $d);
        fclose($handle);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    return array('motd' => $d[0], 'players' => (int)$d[1], 'max_players' => (int)$d[2]);
}
var_dump(ping('mc.hypixel.net'));
