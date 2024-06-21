<?php
          //$phoneNo            = $_POST['phoneNo'];
          $auth_data            = $_POST['token'];
          $base_url             = $_POST['base_url'];
         
          $url                  = $base_url."/v1/health";
            $ch                 = curl_init();
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
                    'Authorization: Bearer '.$auth_data
                 )                                                                       
              );      


           $vdata            = json_decode(curl_exec($ch),true);
           curl_close($ch);

          if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
           // echo '[1]. Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "<hr />";
          }else{
            $error_msg = curl_error($ch);
           // echo "[1]. ".print_r($error_msg,true);
          }
          $response = json_encode($vdata);
          $kirimdata = json_encode($_POST);
          

            
        
?>
