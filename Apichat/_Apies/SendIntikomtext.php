<?php
          //$phoneNo            = $_POST['phoneNo'];
          $msgtype            = $_POST['msgtype'];
          $text               = $_POST['text'];
          $urlPublic          = $_POST['urlPublic'];
         // $groupid            = $_POST['groupid'];
          //$groupid            = 1652;
          $auth_data          = $_POST['auth_data'];
          $myphone            = $_POST['uid'];
          $destphone          = $_POST['phoneNo'];
          $custom_uid         = $_POST['custom_uid']; 
          $reply_id           = $_POST['reply_id']; 
          $base_url           = $_POST['base_url']; 

          $sukses = '1';
          
          if (($reply_id != '0') && ($reply_id != '')) {
            $kirimdata['reply_message_id'] = $reply_id;
          }

          
          if($sukses == '1'){
            
            $kirimdata['preview_url']     = false;
            $kirimdata['recipient_type']  = 'individual';
            $kirimdata['to']              = $destphone;
            $kirimdata['type']            = 'text';
            $kirimdata['text']['body']    = $text;
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
                'Authorization: Bearer '.$auth_data,  
                'Content-Type: application/json',
                'Content-Length: '.strlen($kirimdata))                                                                       
              );      
            curl_setopt($ch, CURLOPT_POSTFIELDS, $kirimdata);    
$formulir['url'] = $url;
$formulir['kirimdata'] = $kirimdata;

            $vdata = json_decode(curl_exec($ch),true); 
            $err = curl_error($ch);
            if ($err) {
              $vdata['success'] = false;
              $vdata['desc'] =  "Error #:".$err; 
            } else {
              if (isset($vdata['error'])) {
                $vdata['success'] = false;
                $vdata['desc']    =  $vdata['error']; 
              }else{
                $vdata['success'] = true;
                $vdata['desc'] = "Success"; 
              }
            }
            

            curl_close($ch);
          }else{
            $vdata['success'] = false;
            $vdata['desc'] =  "Apichat failed to processing information"; 
          }
          $vdata['query'] = $sentitem;
          $vdata['description'] = $vdata['desc'];

          $vdata['form'] = $formulir;
          $response = json_encode($vdata);
          $kirimdata = json_encode($_POST);
          


            
        
?>
