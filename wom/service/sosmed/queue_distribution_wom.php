<?php
   
 include "sosmed_configuration.php";
 ob_start();
 $numputer = 1;
 if (isset($_GET['trace']) == 'ok') {
     $numputer = 1;
 }
    for ($zxz = 0; $zxz<$numputer; $zxz++){
        echo "$database_host | ";
        $qyert      = "SELECT a.id as curSkill FROM cc_ticket_channel a WHERE a.STATUS = 1 AND id >=14";

        $resultl0   = mysqli_query($conn,$qyert);
        if ($resultl0) {
            while ($rows0 = mysqli_fetch_array($resultl0)){
                $curSkill      = $rows0['curSkill']; 
                
                ##################################################  
                $temp  = extractor($curSkill);
                $tempr = explode("|", $temp);

                /*$cc_table_history           = $tempr[0];
                $cc_join_customer_scheme    = $tempr[1];
                $channel_logo               = $tempr[2];
                $cc_table_messages          = $tempr[3];
                $cc_channel_descr           = $tempr[4];
                $cc_last_activity           = $tempr[6];
                $limit_distribution         = $tempr[7];
                */
                $cc_table_history       = $tempr[0];
                $cc_table_messages      = $tempr[1];
                $cc_join_customer_scheme= $tempr[2];
                $channel_logo           = $tempr[3];
                $cc_channel_descr       = $tempr[4];
                $cc_last_activity       = $tempr[5];
                $limit_distribution     = $tempr[6];
                $cc_table_outbox        = $tempr[7];        
                $delay_autoreply        = $tempr[8];        
                $autoreply_while_busy   = $tempr[9];        
                $autoreply_while_off    = $tempr[10];   
                $source_config_table    = $tempr[12];
                $source_config_column   = $tempr[13];
                $cc_table_template      = $tempr[14];
                $autogreeting           = $tempr[15];
                $offclose               = $tempr[28];
                $queueinfo              = $tempr[29];
               
                $source_config_table    = $tempr[12];
                $source_config_column   = $tempr[13];
                if ($curSkill == 25) {
                    $vdestination = 'a.contact_phone';
                }elseif ($curSkill == 24) {
                    $vdestination = 'a.ig_user_id';
                }elseif ($curSkill == 14) {
                    $vdestination = 'a.sesid';
                }elseif($curSkill == 22){
                    $vdestination = 'a.contact_uid';
                }elseif($curSkill == 23){
                    $vdestination = 'a.tw_user_id';
                }elseif($curSkill == 27){
                    $vdestination = 'a.contact_userid';
                }elseif($curSkill == 28){
                    $vdestination = 'a.youtube_userid';
                }elseif($curSkill == 21){
                    $vdestination = 'a.fb_user_id';
                }elseif($curSkill == 26){
                    $vdestination = 'a.tg_username';
                }elseif($curSkill == 29){
                    $vdestination = 'a.review_id';
                }else{
                     $vdestination = 'a.contact_phone';
                }
                ################################################## 
                $sql_str1      = "SELECT 
                                        a.session_id,
                                        a.last_message,
                                        b.id AS refid,
                                        a.last_script_content,
                                        a.status,
                                        c.route,
                                        a.source,
                                        a.contact_id,
                                        a.call_type,
                                        ".$vdestination." as contact_phone,
                                        a.info_agent
                                   FROM $cc_table_history a 
                                   INNER JOIN ".$source_config_table." b ON a.source = b.".$source_config_column."
                                   LEFT JOIN cc_omni_bot_question c ON a.last_script_content = c.id
                                   WHERE a.agent_id = '0'
                                   AND ((a.status = '0')OR(a.status = 2 AND a.last_script_type = 3)) 
                                   ORDER BY a.start_queuetime ASC LIMIT 2";
                                   //GROUP BY a.source
                echo $sql_str1."<hr />";
                $antrianke = '1';
                $resultl01   = mysqli_query($conn,$sql_str1);
                if ($resultl01) {
                    while ($rows01      = mysqli_fetch_array($resultl01)){
                        $session_id     = $rows01['session_id'];
                        $last_message   = $rows01['last_message'];
                        $referenceID    = $rows01['refid'];
                        $skillinfo      = $rows01['route'];
                        $status         = $rows01['status'];
                        $source         = $rows01['source'];
                        $idCust         = $rows01['contact_id'];
                        $contact_phone  = $rows01['contact_phone'];
                        $call_type      = $rows01['call_type'];
                        $info_agent      = $rows01['info_agent'];

                        if ($info_agent != '0') {
                            $paramACD = "channel=".$curSkill."&acdflow=agent&reference=".$info_agent;
                            echo "Nomor Sesi : $session_id -> agent -> $info_agent";
                        }else{
                             if ($status == 0) {
                                $paramACD = "channel=".$curSkill."&acdflow=account&reference=".$referenceID;
                                echo "Nomor Sesi : $session_id -> account -> $referenceID";
                            }else{
                                $paramACD = "channel=".$curSkill."&acdflow=skill&reference=".$skillinfo; 
                                echo "Nomor Sesi : $session_id -> skill -> $skillinfo";
                        }
                           
                        }
                        
                        //////////////////////////  ACD  ////////////////////////////
                        $curlPath = "http://".$server_host."/".$applicationFolder."/service/sosmed/acd.php";
                        echo $curlPath.'<hr />';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $curlPath);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramACD);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
                        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
                           curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                        }
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25);

                        if ($modeEs) {
                            echo "melakukan Curl ke ".$curlPath."\n";   
                        }
                        $isbot_officehour = 0;

                        $response = curl_exec($ch);
                        $info = curl_getinfo($ch);
                        curl_close ($ch);

                        //$response = get_agent_support_cc_feature_noactivity($conn, $curSkill);
                        $obj = json_decode($response, true);
echo ">".$response."<";
                        //$response = get_agent_support_cc_feature_noactivity($conn, $curSkill);
                        //$obj = json_decode($response, true);
echo "<hr />";
                        //print_r($obj);
echo "<hr />";
                        //suppid
                       /* $tholday  =  $obj['data'][0]['isholiday'];
                        if ($tholday == 0) {
                            $toffhour =  $obj['data'][0]['status'];
                            if ($toffhour != "ready") {
                                $nilai     = 0;
                            }else{
                                 $nilai     = $obj['data'][0]['agendid']; 
                            }
                        }else{
                            $nilai     = 0;
                            
                        }*/
                        $tholday = $obj['isholiday'];
                        if ($tholday == 0) {
                            $tstatus = $obj['status'];
                            if ($tstatus == 'no channel') {
                                $nilai     = 0;
                                $isbot_officehour = 1;
                            }elseif ($tstatus == 'limit distribution') {
                                $nilai     = 0;
                            }elseif ($tstatus == 'not ready') {
                                $nilai     = 0;
                            }elseif ($tstatus == 'ready') {
                                $nilai = $obj['agendid'];
                               // echo "s";
                            }
                        }else{
                            $nilai     = 0;
                            $isbot_officehour = 1;
                        }
                        if ($nilai == 0) {
                            echo "<br />[".$curSkill."] Response : Menunggu Agent ...";
                            $isclose = 0;
                            if ($isbot_officehour == 1) {
                                echo "\nKondisi karna diluar jam kerja";
                                if ($offclose == 1) {
                                    echo "\nKondisi karna diluar jam kerja dan ketika non office hour langsung close session";
                                    $timestamp = date('Y-m-d H:i:s');
                                    $query_isbot_officehour = "UPDATE ".$cc_table_history." SET 
                                                                      end_session_by = 0,
                                                                      status         = 1,
                                                                      end_time       = '$timestamp'
                                                               WHERE session_id      = '$session_id'";
                                    mysqli_query($conn,$query_isbot_officehour);
                                    $query_isbot_officehour_x = "UPDATE cc_omni_session_history SET 
                                                                        omni_status     = 2
                                                               WHERE session_id     = '$session_id'
                                                               AND channel_id       = '$curSkill'";
                                    mysqli_query($conn,$query_isbot_officehour_x);
                                    if ($modeEs) {
                                        echo "------- Query Bot Non Office Hour --------\n";
                                        echo str_replace("                              ","",$query_isbot_officehour)."\n";
                                        echo str_replace("                              ","",$query_isbot_officehour_x)."\n";
                                        echo "--------------------------------------\n";
                                    }

                                    //kirimpesan
                                    //$autoreply_while_off;;
                                    if (($call_type == '1') && ($autoreply_while_off != '')) {
                                        $query_bot = "INSERT INTO ".$cc_table_messages." SET
                                               session_id       = '$session_id',
                                               contact_id       = '$idCust',
                                               agent_id         = '0',
                                               message_content  = '".addslashes($autoreply_while_off)."',
                                               insert_time      = NOW(),
                                               message_type     = 'text',
                                               direction        = '3',
                                               webhook_id       = '0'";
                                        mysqli_query($conn,$query_bot);
                                        $greetingID = mysqli_insert_id($conn);

                                        kirimOmni($conn,$curSkill,$source,$contact_phone,$greetingID,$autoreply_while_off,'text','0','0','','','greeting','0',$call_type,'','');
                                    }
                                      
                                }else{
                                    if ($call_type == '1') {
                                        $isclose++;
                                    } 
                                }
                            }else{
                                if ($call_type == '1') {
                                    $isclose++;
                                }  
                            }
                            echo $call_type."<>".$isclose." <<<<";
                            if (($call_type == '1') && ($isclose != 0)) {
                                $current_antrian = 0;
                                $queryl0    = "SELECT
                                                queue_info
                                               FROM ".$cc_table_history." 
                                               WHERE session_id = '$session_id'";
                                $resultl0   = mysqli_query($conn,$queryl0);
                                if ($resultl0) {
                                    while ($rows0 = mysqli_fetch_row($resultl0)){
                                        $current_antrian         = $rows0[0];
                                    }
                                    mysqli_free_result($resultl0);
                                }
                                if ($current_antrian != $antrianke) {
                                    //update notif 
                                    $query_isbot_officehour = "UPDATE ".$cc_table_history." SET 
                                                                      queue_info = '$antrianke',
                                                                      last_active = NOW()
                                                               WHERE session_id      = '$session_id'";
                                    mysqli_query($conn,$query_isbot_officehour);
                                    $query_isbot_officehour_x = "UPDATE cc_omni_session_history SET 
                                                                        queue_info = '$antrianke',
                                                                        last_active = NOW()
                                                               WHERE session_id     = '$session_id'
                                                               AND channel_id       = '$curSkill'";
                                    mysqli_query($conn,$query_isbot_officehour_x);
                                    
                                    if ($queueinfo != '') {
                                        
                                        $customername = custname_fromID($conn,$idCust);
                                        $queueinfo = str_replace("[cust]", $customername, $queueinfo);
                                        $queueinfo = str_replace("[queue_info]", $antrianke, $queueinfo);

                                        $query_bot = "INSERT INTO ".$cc_table_messages." SET
                                               session_id       = '$session_id',
                                               contact_id       = '$idCust',
                                               agent_id         = '0',
                                               message_content  = '".addslashes($queueinfo)."',
                                               insert_time      = NOW(),
                                               message_type     = 'text',
                                               direction        = '3',
                                               webhook_id       = '0'";
                                        mysqli_query($conn,$query_bot);
                                        $greetingID = mysqli_insert_id($conn);

                                        kirimOmni($conn,$curSkill,$source,$contact_phone,$greetingID,$queueinfo,'text','0','0','','','greeting','0',$call_type,'','');
                                    }
                                    
                                }
                            }
                        }else{
                             echo "<br /[".$curSkill."] >Response : Diterima oleh $nilai";
                             //query pindah 
                             $sql_str1      = "UPDATE $cc_table_history SET  
                                                   agent_id            = '$nilai', 
                                                   status              = 0,
                                                   distribution_time   = NOW(),
                                                   end_queuetime       = NOW(),
                                                   last_active         = NOW() 
                                               WHERE session_id    = '$session_id'";
                             if(mysqli_query($conn,$sql_str1)){
                                echo "Berhasil updat ke $sql_str1<br />";
                             }else{
                                echo "Gagal update ke $sql_str1 <br />";
                             }

                             $sql_str1      = "UPDATE cc_omni_session_history SET  
                                                   agent_id            = '$nilai', 
                                                   omni_status         = 0,
                                                   last_active         = now() 
                                               WHERE session_id    = '$session_id'
                                               AND channel_id      = '$curSkill'";
                             if(mysqli_query($conn,$sql_str1)){
                                echo "Berhasil updat ke $sql_str1<br />";
                             }else{
                                echo "Gagal update ke $sql_str1 <br />";
                             }

                             $sql_str1      = "UPDATE $cc_table_messages SET  
                                               agent_id             = '$nilai',
                                               insert_time          = NOW() 
                                               WHERE session_id     = '$session_id'";
                             if(mysqli_query($conn,$sql_str1)){
                                echo "Berhasil updat ke $sql_str1<br />";
                             }else{
                                echo "Gagal update ke $sql_str1 <br />";
                             }

                             if (($autogreeting != "")&&($call_type == 1)) {
                                $pesanGreeting = $autogreeting;
                                $customername = custname_fromID($conn,$idCust);
                                $agentname = agentname_fromID($conn,$nilai);
                                $pesanGreeting = str_replace("[agent]", $agentname, $pesanGreeting);
                                $pesanGreeting = str_replace("[cust]", $customername, $pesanGreeting);
                                $query_bot = "INSERT INTO ".$cc_table_messages." SET
                                       session_id       = '$session_id',
                                       contact_id       = '$idCust',
                                       agent_id         = '$nilai',
                                       message_content  = '".addslashes($pesanGreeting)."',
                                       insert_time      = NOW(),
                                       message_type     = 'text',
                                       direction        = '3',
                                       webhook_id       = '0'";
                                mysqli_query($conn,$query_bot);
                                $greetingID = mysqli_insert_id($conn);

                               if ($curSkill == 25) {
                                    $whatsApp_token = get_wa_token_from_phone($conn,$source);
                                    $laporanKirim =  kirimWhatsApp($conn,$contact_phone,$source,$whatsApp_token,$greetingID,$pesanGreeting,'text',0,0,'','','greeting');

                                    if ($laporanKirim != 0) {
                                        pesanKeluarwa($conn,$laporanKirim);
                                    }
                               }elseif ($curSkill == 24) {
                                    if ($call_type == 1) {
                                        $laporanKirim = kirimInstagram($conn,$agent_id,$source,$contact_phone,1,$greetingID,$pesanGreeting,'text',0,0,'','greeting');

                                        if ($laporanKirim != 0) {
                                            pesanKeluarInstagram($conn,$laporanKirim);
                                        }
                                    }
                               }elseif ($curSkill == 26) {
                                    //telegram
                                    $mytelegram_token       = get_tg_token_from_tgid($conn,$source);
                                    $laporanKirim = kirimTelegram($conn,$contact_phone,$source,$mytelegram_token,$greetingID,$pesanGreeting,'text',$agent_id,0,'','','greeting','');
                                    if ($laporanKirim != 0) {
                                        pesanKeluarTelegram($conn,$laporanKirim);
                                    }
                                }elseif ($curSkill == 22) {
                                    //messenger
                                    $msg_token = get_msg_token_from_pages($conn,$source);
                                    $laporanKirim = kirimMessenger($conn,$contact_phone,$source,$msg_token,$greetingID,$pesanGreeting,'text',$agent_id,0,'','');
                                    if ($laporanKirim != 0) {
                                        pesanKeluarMessenger($conn,$laporanKirim);
                                    }
                                }elseif ($curSkill == 23) {
                                    if ($call_type == 1) {
                                        $laporanKirim = kirimTwitter($conn,$contact_phone,$source,$greetingID,$pesanGreeting,'text',$agent_id,'','','0');
                                        if ($laporanKirim != 0) {
                                            pesanKeluarTwitter($conn,$laporanKirim);
                                        }
                                    }
                                }elseif ($curSkill == 27) {
                                    //line
                                    $line_token = get_line_token_fromsource($conn,$source);
                                    $laporanKirim = kirimLINE($conn,$contact_phone,$source,$line_token,$greetingID,$pesanGreeting,'text',$agent_id,0,'','');
                                    if ($laporanKirim != 0) {
                                        pesanKeluarLine($conn,$laporanKirim);
                                    }
                                }
                            }
                             update_sosmed_last_received_dan_history($conn, $cc_table_history, $cc_last_activity,$nilai,$session_id,$last_message);
                        }
                       

                        echo "<hr />";
                                                   
                                            
                    }
                    mysqli_free_result($resultl01);
                }   
                                 
            }
            mysqli_free_result($resultl0);
        }


      ob_flush();
        flush();
        sleep(3);
    }

    ob_end_flush();            
         mysqli_close($conn);   
            
           

    ?>