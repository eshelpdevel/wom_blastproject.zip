<?php
    function isJSON($string){
       return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
    $phone_no    			= $par[1];
    $data                   = json_decode(file_get_contents("php://input"),true);
    $kirimdata  			= json_encode($data);
    if ($phone_no 				== "") {
        $vdata['success']     	= false;
        $url 					= $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/Apichat/Wadocker/[UID]";
        $vdata['description']   = "Endpoint `Wadocker` not pointed correctly, please provide full address eg. ".$url;
    }else{
	    $url        			= $domain.'/'.$dir.'/service/sosmed/whatsapp_onpremise/webhook_push.php?me_phone='.$phone_no."&mode=es";
	    $ch         			= curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Content-Length: ' . strlen($kirimdata))                                                                       
        );      
        curl_setopt($ch, CURLOPT_POSTFIELDS, $kirimdata);    
        $response     				= curl_exec($ch);
        curl_close($ch);

        if($response 				== "") {
        	$vdata['success'] 		= false;
        	$vdata['description']   = "Server not send any response yet";
        } else {
	        $vdata['success'] 		= true;
            if(isJSON($response)){
                $vdata['description']   = json_decode($response,true);
            }else{
                $vdata['description']   = $response;
            }
        }
    }
?>

