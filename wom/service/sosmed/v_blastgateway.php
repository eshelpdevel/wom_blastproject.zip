<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	function blast($source,$destination,$token,$ref,$body){
		$params = array(
		    'ref' => $ref,
		    'source' => $source,
		    'destination' => $destination,
		    'token' => $token,
		    'body' => $body
		);

		$body = json_encode($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://devcrm.wom.co.id:8766/blashwa");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'token: '.$token
		));
		$exec = curl_exec($ch);
		curl_close($ch);
		return $exec;
	}

	for ($i=1; $i <=2 ; $i++) { 
		echo "tes\n";
		$pesan = "Assalamu'alaikum Wr Wb\n\nBerikut pesan yang dikirim melalui mekanisme blast dengan pengiriman ke $i pada ".date('H:i.s')."\n\nTerimakasih";
		blast('instance57973','6289694463666','902pzfdepnme2wu4','vblast'.$i,$pesan)."<hr />";
	}
?>