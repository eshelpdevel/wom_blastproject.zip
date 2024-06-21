<?php


    $url        = $_POST['url'];
    $filename   = "Ivosightdata".date('YmdHis').".".$_POST['extensions'];
    $media_id   = $_POST['media_id'];
    $mytoken    = $_POST['auth_data'];
    $base_url   = $_POST['base_url'];

    if (!file_exists('download')) {
        mkdir('download', 0777, true);
    } 
    
    
    

    $url              = $base_url."/v1/media/".$media_id;
    $ch               = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, '10');
    curl_setopt($ch, CURLOPT_TIMEOUT, '0');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Authorization: Bearer '.$mytoken,  
          'Content-Type: application/json',
          'Content-Length: 0')                                                                       
    );      
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');    
        
    $result             = curl_exec($ch);
    curl_close($ch);

    if($myfile = fopen("download/".$filename, "w") or die("Unable to open file!")){
      $txt = $result;
      fwrite($myfile, $txt);
      fclose($myfile);
      
      $vdata['filename'] = $filename;
    }else{
      $vdata['filename'] = "0";
    }
    $vdata['form']['url'] = $url;

    $vdata['filename'] = $filename;
    $vdata['downloaded'] = true;
    $kirimdata = json_encode($_POST);
    $response = json_encode($vdata);


?>
