<?php
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	echo date('Y-m-d H:i:s');
    echo "\n-----\n";
	include '../sosmed_configuration.php';
	function token_ivowa($port){
		$url        			= "https://10.1.49.219:".$port."/v1/users/login";
	    $ch         			= curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_ENCODING, '');
	    curl_setopt($ch, CURLOPT_MAXREDIRS, '10');
	    curl_setopt($ch, CURLOPT_TIMEOUT, '0');
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(    
	    //YWRtaW46UDRzc3dvcmQh                                                                      
	      'Authorization: Basic d29tY3JtOldvbWNybSoxMjM=',  
	      'Content-Type: application/json',
	      'Content-Length: 0')                                                                       
	    );      
	    curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');    
	    
	    $response     				= curl_exec($ch);
	    $response = json_decode($response,true);
	    curl_close($ch);
	    return $response['users'][0]['token'];
	}


    $wa9090 = token_ivowa('9090');
    
    echo date('Y-m-d H:i:s');
    echo "\n\n";
   
    $query = "UPDATE cc_wa_config SET token_no = '".addslashes($wa9090)."',token_time = NOW() WHERE id = 1";
    mysqli_query($conn,$query);
    echo date('Y-m-d H:i:s');
    $wa9091 = token_ivowa('9091');
    $query = "UPDATE cc_wa_config SET token_no = '".addslashes($wa9091)."',token_time = NOW() WHERE id = 2";
    mysqli_query($conn,$query);
     echo "\n-----\n\n9090 : $wa9090 \n\n9091 : $wa9091\n\n";
    echo "\n\n";
?>