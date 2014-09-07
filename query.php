<?php
 
$ip = '';
$queryport = '28015';
 
$socket = @fsockopen("udp://".$ip, $queryport , $errno, $errstr, 1);
 
stream_set_timeout($socket, 1);
stream_set_blocking($socket, TRUE);
fwrite($socket, "\xFF\xFF\xFF\xFF\x54Source Engine Query\x00");
$response = fread($socket, 4096);
@fclose($socket);
 
$packet = explode("\x00", substr($response, 6), 5);
$server = array();
 
$server['name'] = $packet[0];
$server['map'] = $packet[1];
$server['game'] = $packet[2];
$server['description'] = $packet[3];
$inner = $packet[4];
$server['players'] = ord(substr($inner, 2, 1));
$server['playersmax'] = ord(substr($inner, 3, 1));
$server['password'] = ord(substr($inner, 7, 1));
$server['vac'] = ord(substr($inner, 8, 1));
 
var_dump( $server );
 
?>