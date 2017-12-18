<?php

function sendXML($ip, $command, $xml) {

	// cURL Press Key Button
	$curl = curl_init();
	curl_setopt_array($curl,
		array(CURLOPT_URL => 'http://' . $ip . ':8090/' . $command,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $xml,
			CURLOPT_HTTPHEADER => array('Content-type: text/xml'),
		));
	$resp = curl_exec($curl);
	curl_close($curl);
}

/*
PLAY
PAUSE
STOP
PREV_TRACK
NEXT_TRACK
THUMBS_UP
THUMBS_DOWN
BOOKMARK
POWER
MUTE
VOLUME_UP
VOLUME_DOWN
PRESET_1
PRESET_2
PRESET_3
PRESET_4
PRESET_5
PRESET_6
AUX_INPUT
SHUFFLE_OFF
SHUFFLE_ON
REPEAT_OFF
REPEAT_ONE
REPEAT_ALL
PLAY_PAUSE
ADD_FAVORITE
REMOVE_FAVORITE
INVALID_KEY
 */

function sendCommand($ip, $command) {
    $url = 'http://' . $ip . ':8090/' . $command;
	// cURL : Query info
	$curl = curl_init();
	curl_setopt_array($curl,
		array(CURLOPT_URL => 'http://' . $ip . ':8090/' . $command,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array('Content-type: text/xml'),
		));
	$resp = curl_exec($curl);
	curl_close($curl);
    return $resp;
}

function sendKeyCommand($ip, $keyname) {

	// Status
	$state01 = "press";
	$state02 = "release";

	// Senders
	$sender = "Gabbo";

	// XML Data
	$xml_data01 = '<key state="' . $state01 . '" sender="' . $sender . '">' . $keyname . '</key>';
	$xml_data02 = '<key state="' . $state02 . '" sender="' . $sender . '">' . $keyname . '</key>';

// cURL Press Key Button
	sendXML($ip, "key", $xml_data01);

// cURL Release Key Button
	sendXML($ip, "key", $xml_data02);
}

function sendVolumeCommand($ip, $volume) {

	// XML Data
	$xml_data01 = '<volume>' . $volume . '</volume>';

	// cURL Press Key Button`
	sendXML($ip, "volume", $xml_data01);
}

function sendSayCommand($ip, $volume) {

// Verifier preset dans http://192.168.1.54:8090/presets

// Save state

// wget -q -U Mozilla "https://translate.google.com/translate_tts?ie=UTF-8&q=content%20de%20moi&tl=fr&total=1&idx=0&textlen=9&tk=43799.429987&client=t" -O /usr/share/nginx/www/jeedom/tmp/in.mp3

//	http://192.168.1.45/tmp/in.mp3

// ws getpresets
	// ws addpreset STORED_MUSIC http://192.168.1.45/tmp/in.mp3 "Jeedom" test 6

	sendKeyCommand($ip, "PRESET_6");

// Restore state

}

?>
