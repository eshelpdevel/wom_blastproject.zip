<?php
 /******************************************************************************/
 #       ___________.__                .__                  _____  __           #
 #       \_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_         #
 #        |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\        #
 #        |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  |          #
 #       /_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|          #
 #               \/      \/     |__|        \/     \/                           #
 #                                                                              #
 #            All RIght Reserved, 2021 | Elyphsoft Teknologi Asia               #
 #                                                                              #
 /******************************************************************************/
$maksimalAgent = 3;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include "../../../sysconf/con_reff.php";
    include "../../../sysconf/global_func.php";
include '../sosmed_configuration.php';


function lempar_sesi($conDB,$agent_id,$channel,$session,$agent_from,$agent_to){

    //$myfile = fopen("transfer_".date('Y-m-d-H-i').".txt", "a") or die("Unable to open file!");
    //$txt = date('H:i:s')."\n";
    //fwrite($myfile, $txt);
    

        global $database_name;

        $temp                   = extractor($channel);
        $tempr                  = explode("|", $temp);
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
        $session_close          = $tempr[11];

        $autotransfer          = $tempr[22];
        ################################################

        $session_new            =  date('YmdHis').rand(0,9999);

        //ambil waktu sekarang, biar sama
        $waktuSkrg              = date('Y-m-d H:i:s');
        $sql_str11              = "SELECT NOW() as waktuSkrg";
        $sql_res1               = execSQL($conDB, $sql_str11);    
        while ($sql_rec1        = mysqli_fetch_array($sql_res1)) {
            $waktuSkrg          = $sql_rec1['waktuSkrg'];  
        }

        //fwrite($myfile, "- ".$sql_str11."\n");

        //update session lama
        $query = "UPDATE $cc_table_history SET 
                         end_session_by = '$agent_from',
                         status         = 1,
                         transfer_to    = '$session_new',
                         last_active    = '$waktuSkrg',
                         end_time       = '$waktuSkrg'
                  WHERE session_id      = '$session'";
        execSQL($conDB, $query);
        //fwrite($myfile, "- ".$query."\n");

        //update session omni lama 
        $query = "UPDATE cc_omni_session_history SET 
                        omni_status       = '2',
                        last_message      = 'Transfer to ".$session_new."'
                  WHERE channel_id        = '$channel'
                  AND session_id          = '$session'";
        execSQL($conDB, $query);
        //fwrite($myfile, "- ".$query."\n");

        //ambil informasi session lama
        $curSkill = $channel;
         if ($curSkill == 25) {
            # WHATSAPP
            $additionHistory  = "contact_phone";
        }elseif ($curSkill == 27) {
            # LINE
            $additionHistory  = "contact_userid";
        }elseif ($curSkill == 21) {
            # FACEBOOK
            $additionHistory  = "fb_user_id";
        }elseif ($curSkill == 22) {
            # MESSENGER
            $additionHistory  = "contact_uid";
        }elseif ($curSkill == 24) {
            # INSTAGRAM
            $additionHistory  = "ig_user_id";
        }elseif ($curSkill == 23) {
            # TWITTER
            $additionHistory  = "tw_user_id";
        }elseif ($curSkill == 26) {
            # WHATSAPP
            $additionHistory  = "tg_username";
        }elseif ($curSkill == 30) {
            # OTHER
            $additionHistory  = "oth_username";
        }else{
            $additionHistory  = "";
            $additionMessages = "";
        }
        $sql_str11 = "SELECT 
                            a.source,
                            a.call_type,
                            b.contact_name as username,
                            a.contact_id,
                            a.".$additionHistory." as usernameID,
                            '' AS source_omni
                        FROM ".$cc_table_history." a 
                        INNER JOIN cc_customer_contact b ON a.contact_id = b.id
                        WHERE a.session_id = '".$session."'";
                        //echo " ---\n ".$sql_str11."\n----\n";
        $sql_res1  = execSQL($conDB, $sql_str11);    
        while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
            $vd_source          = $sql_rec1['source'];
            $vd_call_type       = $sql_rec1['call_type'];
            $vd_username        = $sql_rec1['username'];
            $vd_contact_id      = $sql_rec1['contact_id'];
            $vd_usernameID      = $sql_rec1['usernameID'];
            $vd_source_omni     = $sql_rec1['source_omni'];
        }
        //fwrite($myfile, "- ".$sql_str11."\n");


        //insert session baru
        $sql_str11 = "SELECT GROUP_CONCAT(COLUMN_NAME) as tarik FROM information_schema.columns WHERE table_schema='".$database_name."' AND table_name='".$cc_table_history."' AND COLUMN_NAME != 'id'";
        $sql_res1  = execSQL($conDB, $sql_str11);    
        while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
            $parKolom         = $sql_rec1['tarik'];  
        }
        $namaKolom = explode(",", $parKolom);
        
        //fwrite($myfile, "- ".$sql_str11."\n");

        $arrnew = 0;
        $sql_str11 = "SELECT $parKolom FROM ".$cc_table_history." WHERE session_id='".$session."'";
        //$namaValue = "";
        $sql_res1  = execSQL($conDB, $sql_str11);    
        while ($sql_rec1 = mysqli_fetch_array($sql_res1)) {
            //$namaKolom         = $sql_rec1['tarik'];
            for ($i=0; $i <count($namaKolom) ; $i++) {
                if ($namaKolom[$i] == 'session_id') {
                     $namaValue[$i] = $session_new; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'agent_id') {
                     $namaValue[$i] = $agent_to; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'start_time') {
                     $namaValue[$i] = "$waktuSkrg"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'end_time') {
                     $namaValue[$i] = ""; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'last_active') {
                     $namaValue[$i] = "$waktuSkrg"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'last_message') {
                     $namaValue[$i] = "Session Transfered"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'last_sender') {
                     $namaValue[$i] = "0"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'read_status') {
                     $namaValue[$i] = "0"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'distribution_time') {
                     $namaValue[$i] = "$waktuSkrg"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'first_response') {
                     $namaValue[$i] = "1"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'first_response_time') {
                     $namaValue[$i] = "$waktuSkrg"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'status') {
                     $namaValue[$i] = "0"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'transfer_from') {
                     $namaValue[$i] = $session; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'transfer_to') {
                     $namaValue[$i] = ""; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'direction') {
                     $namaValue[$i] = "2"; 
                     $arrnew++;
                }elseif ($namaKolom[$i] == 'end_session_by') {
                     $namaValue[$i] = ""; 
                     $arrnew++;
                }else{
                    $namaValue[$i] = $sql_rec1[$namaKolom[$i]]; 
                    $arrnew++;
                }
                
            }
        }
        //fwrite($myfile, "- ".$sql_str11."\n");

        $query   = "INSERT INTO ".$cc_table_history." SET ";
        for ($i=0; $i <count($namaKolom) ; $i++) {
            $namaField = $namaValue[$i];
            if ($namaField != 'NOW()') {
                 $namaField = "'".$namaField."'";
            }else{
                $namaField = "NOW()";
            }
            
            if ($i != 0) {
                 $query .= ",";
            } 
            $query  .= "`".$namaKolom[$i]."` = ".$namaField;
        }
        execSQL($conDB, $query);
        //fwrite($myfile, "- ".$query."\n");

        //insert session omni baru
        $query = "INSERT INTO cc_omni_session_history SET 
                            channel_id          = '$channel',
                            session_id          = '$session_new',
                            source              = '$vd_source_omni',
                            call_type           = '$vd_call_type',
                            username            = '".addslashes($vd_username)."',
                            agent_id            = '$agent_to',
                            omni_status         = 0,
                            insert_time         = NOW(),
                            omni_read_status    = '0',
                            last_message        = 'Session Transfered',
                            last_active         = NOW()";
        execSQL($conDB, $query);
        //fwrite($myfile, "- ".$query."\n");

        $autotransfer = "";
        if ($autotransfer == "") {
            # code...
            //tulis sebgai robot
            $sql_str2 = "INSERT INTO `".$cc_table_messages."`(`session_id`,`agent_id`,`contact_id`,`message_content`,`insert_time`,`message_type`,`direction`)
                         VALUES('$session_new','$agent_to','$vd_contact_id','".addslashes("Session Transfered")."','".$waktuSkrg."','text','3') ";
            if(execSQL($conDB, $sql_str2)){

            }
            //fwrite($myfile, "- ".$sql_str2."\n");
        }else{
            //cust
            //agent_from
            //agent_to
            $autotransfer = str_replace("[cust]", custname_fromID($conn,$vd_contact_id), $autotransfer);
            $autotransfer = str_replace("[agent_from]", agentname_fromID($conDB,$agent_from), $autotransfer);
            $autotransfer = str_replace("[agent_to]", agentname_fromID($conDB,$agent_to), $autotransfer);

            $sql_str2 = "INSERT INTO `".$cc_table_messages."`(`session_id`,`agent_id`,`contact_id`,`message_content`,`insert_time`,`message_type`,`direction`)
                         VALUES('$session_new','$agent_to','$vd_contact_id','".addslashes($autotransfer)."','".$waktuSkrg."','text','3') ";
            //fwrite($myfile, "- ".$sql_str2."\n");
            if(execSQL($conDB, $sql_str2)){
                $greetingID = mysqli_insert_id($conDB);
               // fwrite($myfile, "- Greeting ID ".$greetingID."\n");
                if ($curSkill == 25) {
                    //wa
                    $whatsApp_token = get_wa_token_from_phone($conDB,$vd_source);
                    $laporanKirim =  kirimWhatsApp($conDB,$vd_usernameID,$vd_source,$whatsApp_token,$greetingID,addslashes($autotransfer),'text',0,0,'','','greeting');

                    if ($laporanKirim != 0) {
                        pesanKeluarwa($conDB,$laporanKirim);
                    }
                }elseif ($curSkill == 24) {
                    //igdm
                    $laporanKirim = kirimInstagram($conDB,$agent_id,$vd_source,$vd_usernameID,1,$greetingID,addslashes($autotransfer),'text',0,0,'','');
                    if ($laporanKirim != 0) {
                        pesanKeluarInstagram($conDB,$laporanKirim);
                    }
                }elseif ($curSkill == 26) {
                    //telegram
                    $tg_token = get_tg_token_from_tgid($conDB,$vd_source);
                    $laporanKirim = kirimTelegram($conDB,$vd_usernameID,$vd_source,$tg_token,$greetingID,addslashes($autotransfer),'text',$agent_id,0,'','','greeting','');
                    if ($laporanKirim != 0) {
                        pesanKeluarTelegram($conDB,$laporanKirim);
                    }
                }elseif ($curSkill == 27) {
                    //line
                    $line_token = get_line_token_fromsource($conDB,$vd_source);
                    $laporanKirim = kirimLINE($conDB,$vd_usernameID,$vd_source,$line_token,$greetingID,addslashes($autotransfer),'text',$agent_id,0,'','','greeting','');
                    if ($laporanKirim != 0) {
                        pesanKeluarLine($conDB,$laporanKirim);
                    }
                }elseif ($curSkill == 22) {
                    //messenger
                    $msg_token = get_msg_token_from_pages($conn,$vd_source);
                    $laporanKirim = kirimMessenger($conDB,$vd_usernameID,$vd_source,$msg_token,$greetingID,addslashes($autotransfer),'text',$agent_id,0,'','');
                    if ($laporanKirim != 0) {
                        pesanKeluarMessenger($conDB,$laporanKirim);
                    }
                }else{
                    echo "------- Belum didefinisi untuk skill ".$curSkill." --------\n";
                }
               // fwrite($myfile, "- laporanKirim ".$laporanKirim."\n\n--------\n");
            }
            //tulis ssebagai robot
            //kirim ke customer
        }
//echo $sql_str2."\n-----\n";
       // echo "success";


        fclose($myfile);

    }

		$queryl0    = "SELECT 
						a.id,
						a.channel,
						a.session,
						a.agent_from,
						a.agent_to,
						a.agent_requester 
					  FROM cc_omnichannel_transferqueue a 
					  WHERE a.status = 0
					  LIMIT 1";
        $resultl0   = mysqli_query($conn,$queryl0);
        if ($resultl0) {
            while ($rows0 				= mysqli_fetch_row($resultl0)){
                $id  					= $rows0[0];
                $channel  				= $rows0[1];
                $session  				= $rows0[2];
                $agent_from  			= $rows0[3];
                $agent_to  				= $rows0[4];
                $agent_requester  		= $rows0[5];


                $temp                   = extractor($channel);
		        $tempr                  = explode("|", $temp);
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
		        $session_close          = $tempr[11];

		        $autotransfer          = $tempr[22];
		        ################################################
                echo $session."\n";
		        $queryl01    = "SELECT count(*) FROM $cc_table_history WHERE session_id = '$session' and status != 1";
	            $resultl01   = mysqli_query($conn,$queryl01);
	            if ($resultl01) {
	                while ($rows01 = mysqli_fetch_row($resultl01)){
	                    $isada  = $rows01[0];
	                    if ($isada == 0) {
	                    	//abaikan
                            echo "Session already Exist";
	                    	$sql = "UPDATE cc_omnichannel_transferqueue SET status = 2, status_remark = 'Session already not exist',status_time = NOW() WHERE id = '$id'";
	                    	mysqli_query($conn,$sql);
	                    }else{
	                    	$start_date = date('Y-m-d H:i:s');
	                    	$sql = "UPDATE cc_omnichannel_transferqueue SET status = 1, status_remark = 'Processing',status_time = '$start_date' WHERE id = '$id'";
	                    	mysqli_query($conn,$sql);

	                    	lempar_sesi($conn,$agent_requester,$channel,$session,$agent_from,$agent_to);
	                    	$end_date = date('Y-m-d H:i:s');

	                    	$sql = "UPDATE cc_omnichannel_transferqueue SET status = 3, status_remark = '".$start_date." - ".$end_date."',status_time = '$end_date' WHERE id = '$id'";
	                    	mysqli_query($conn,$sql);

                            echo "OK";
	                    }
	                }
	                mysqli_free_result($resultl01);
	            }
            }
            mysqli_free_result($resultl0);
        } 

?>