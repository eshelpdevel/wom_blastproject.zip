<?php


  $mytoken    = $_POST['auth_data'];
  $destphone  = $_POST['phoneNo'];
  $messages   = $_POST['text'];
  $urlPublic  = $_POST['urlPublic'];
  $type       = $_POST['type'];
  $reply_id   = $_POST['reply_id']; 
  $base_url   = $_POST['base_url']; 


  /*$mytoken    = 'eyJhbGciOiAiSFMyNTYiLCAidHlwIjogIkpXVCJ9.eyJ1c2VyIjoiYWRtaW4iLCJpYXQiOjE3MTA4NDYxNTEsImV4cCI6MTcxMTQ1MDk1MSwid2E6cmFuZCI6ImJlYTk5YTkwNGM5N2Y1MTlmMjg3MTA3MTUyZjhhOWJmIn0.5DgYGEUUZylEyWUsutpXT9E0XQLkZkQB9R8jASoMZe0';
  $destphone  = '6289694463666';
  $messages   = '20240325091237_logotest.png';
  $urlPublic  = '';
  $type       = 'image';
  $reply_id   = ''; 
  $base_url   = 'https://10.1.49.219:9091'; */
  

  $sukses = '1';
  
  if (($reply_id != '0') && ($reply_id != '')) {
    $kirimdata['reply_message_id'] = $reply_id;
  }
 
  
 

    $file_local_full = "/var/www/html/wom/public/images/sosmed_upload/".$messages;
    $imem = mime_content_type($file_local_full);
    $thefile = file_get_contents($file_local_full);
    $url              = $base_url."/v1/media";
    $curl               = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_MAXREDIRS, '10');
    curl_setopt($curl, CURLOPT_TIMEOUT, '0');
    curl_setopt($curl, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
        'Authorization: Bearer '.$mytoken,  
        'Content-Type: '.$imem,
        'Content-Length: '.strlen($thefile))                                                                       
      );      
    curl_setopt($curl, CURLOPT_POSTFIELDS, $thefile);    
            
    $response             = curl_exec($curl);
    curl_close($curl);
    if ($response == '') {
      $err = curl_error($curl);
      $vdata['success']     = false;
      $vdata['description'] = 'Failed to save media, Reason : '.$err;
    }else{
      $response = json_decode($response,true);
      if (!curl_errno($curl)) {
            $media_id = $response['media'][0]['id'];

            $kirimdata['preview_url']     = false;
            $kirimdata['recipient_type']  = 'individual';
            $kirimdata['to']              = $destphone;
            $kirimdata['type']            = $type;
            $kirimdata[$type]['id']       = $media_id;
            $kirimdata                    = json_encode($kirimdata);

            $url              = $base_url."/v1/messages";
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
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Authorization: Bearer '.$mytoken,  
                'Content-Type: application/json',
                'Content-Length: '.strlen($kirimdata))                                                                       
              );      
            curl_setopt($ch, CURLOPT_POSTFIELDS, $kirimdata);  

             $vdata = json_decode(curl_exec($ch),true); 
            $err = curl_error($ch);

            if ($err) {
              $vdata['success'] = false;
              $vdata['description'] =  "Error #:".$err; 
            } else {
              if (isset($vdata['error'])) {
                $vdata['success'] = false;
                $vdata['description']    =  $vdata['error']; 
              }else{
                $vdata['success'] = true;
                $vdata['description'] = "Success"; 
              }
            }
            
            curl_close($ch);
      }else{
            $error_msg = curl_error($curl);
            $vdata['success']     = false;
            $vdata['description'] = $error_msg;
      }
    }
            
 
  //$vdata['form'] = $formulir;
  $response = json_encode($vdata);
  $kirimdata = json_encode($_POST); 

?>
