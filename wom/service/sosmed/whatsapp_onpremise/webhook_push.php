<?php 
 /******************************************************************************/
 #       ___________.__                .__                  _____  __           #
 #       \_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_         #
 #        |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\        #
 #        |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  |          #
 #       /_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|          #
 #               \/      \/     |__|        \/     \/                           #
 #                                                                              #
 #            All RIght Reserved, 2018 | Elyphsoft Teknologi Asia               #
 #                                                                              #
 /******************************************************************************/
$maksimalAgent = 3;
include '../sosmed_configuration.php';

$PUSHED_DATA = json_decode(file_get_contents('php://input'),true);
$me_phone = $_GET['me_phone'];


if (isset($PUSHED_DATA['contacts'])) {

		$contact_name			= $PUSHED_DATA['contacts'][0]['profile']['name'];
		$contact_uid			= $PUSHED_DATA['contacts'][0]['wa_id'];
		$message_dtm			= $PUSHED_DATA['messages'][0]['from'];
		$message_uid 			= $PUSHED_DATA['messages'][0]['id'];
		$msgtype 				= $PUSHED_DATA['messages'][0]['type'];	

		$msgtimestamp			= $PUSHED_DATA['messages'][0]['timestamp'];
		
		//image
		$imageid				= $PUSHED_DATA['messages'][0]['image']['id'];
		$image_mimetype			= $PUSHED_DATA['messages'][0]['image']['mime_type'];
		$image_sha256			= $PUSHED_DATA['messages'][0]['image']['sha256'];
		$image_caption			= $PUSHED_DATA['messages'][0]['image']['caption'];
		//video
		$videoid				= $PUSHED_DATA['messages'][0]['video']['id'];
		$video_mimetype			= $PUSHED_DATA['messages'][0]['video']['mime_type'];
		$video_sha256			= $PUSHED_DATA['messages'][0]['video']['sha256'];
		$video_caption			= $PUSHED_DATA['messages'][0]['video']['caption'];
		//voice
		$voiceid				= $PUSHED_DATA['messages'][0]['voice']['id'];
		$voice_mimetype			= $PUSHED_DATA['messages'][0]['voice']['mime_type'];
		$voice_sha256			= $PUSHED_DATA['messages'][0]['voice']['sha256'];
		//document
		$documentid				= $PUSHED_DATA['messages'][0]['document']['id'];
		$document_mimetype		= $PUSHED_DATA['messages'][0]['document']['mime_type'];
		$document_sha256		= $PUSHED_DATA['messages'][0]['document']['sha256'];
		$document_filename		= $PUSHED_DATA['messages'][0]['document']['filename'];
		$document_caption		= $PUSHED_DATA['messages'][0]['document']['caption'];
		//location
		$location_lat			= $PUSHED_DATA['messages'][0]['location']['latitude'];
		$location_long			= $PUSHED_DATA['messages'][0]['location']['longitude'];
		
		
		//contents
		$contact_firstname		= $PUSHED_DATA['messages'][0]['contacts'][0]['name']['first_name'];
		$contact_formatname		= $PUSHED_DATA['messages'][0]['contacts'][0]['name']['formatted_name'];
		$contact_phone			= $PUSHED_DATA['messages'][0]['contacts'][0]['phones'][0]['phone'];
		$contact_typ			= $PUSHED_DATA['messages'][0]['contacts'][0]['phones'][0]['type'];
		$contact_waid			= $PUSHED_DATA['messages'][0]['contacts'][0]['phones'][0]['wa_id'];

		$sticker_id				= $PUSHED_DATA['messages'][0]['sticker']['id'];
		$sticker_mime_type		= $PUSHED_DATA['messages'][0]['sticker']['mime_type'];
		$sticker_sha256		= $PUSHED_DATA['messages'][0]['sticker']['sha256'];
		if ($msgtype == 'text') {
			//text
			$textbody				= $PUSHED_DATA['messages'][0]['text']['body'];
		}else{
			//unknown
			$textbody				= $PUSHED_DATA['messages'][0]['errors']['title'];
		}
		

		if ($msgtype == 'video') {
			$textcaption 	= $video_caption;
			$textmimetype 	= $video_mimetype;
			$textsha256 	= $video_sha256;
			$vdataid		= $videoid;
		}elseif ($msgtype == 'image') {
			$textcaption 	= $image_caption;
			$textmimetype 	= $image_mimetype;
			$textsha256 	= $image_sha256;
			$vdataid		= $imageid;
		}elseif ($msgtype == 'document') {
			$textcaption 	= $document_caption;
			$textmimetype 	= $document_mimetype;
			$textsha256 	= $document_sha256;
			$vdataid		= $documentid;
		}elseif ($msgtype == 'voice') {
			$textcaption 	= "";
			$textmimetype 	= $voice_mimetype;
			$textsha256 	= $voice_sha256;
			$vdataid		= $voiceid;
		}elseif ($msgtype == 'sticker') {
			$textcaption 	= "";
			$textmimetype 	= $sticker_mime_type;
			$textsha256 	= $sticker_sha256;
			$vdataid		= $sticker_id;
			$msgtype 		= "image";
		}elseif ($msgtype == 'contacts') {
			$msgtype = 'vcard';
		}elseif ($msgtype == 'button') {
			$msgtype = 'text';
			$textbody				= $PUSHED_DATA['messages'][0]['button']['text'];
		}

		if (isset($PUSHED_DATA['messages'][0]['context']['id'])) {
			$replyFrom 	= $PUSHED_DATA['messages'][0]['context']['from'];
			$replyID 	= $PUSHED_DATA['messages'][0]['context']['id'];

			//cari di webhook
			$msgidd = 0;
			$vwid = 0;
			$queryl0 	= "SELECT id FROM cc_wa_webhook WHERE message_uid = '$replyID'";
			$resultl0 	= mysqli_query($conn,$queryl0);
			if ($resultl0) {
				while ($rows0 = mysqli_fetch_row($resultl0)){
					$vwid = $rows0[0];	

					$queryl01 	= "SELECT id FROM cc_wa_messages WHERE webhook_id = '$vwid'";
					$resultl01 	= mysqli_query($conn,$queryl01);
					if ($resultl01) {
						while ($rows01 = mysqli_fetch_row($resultl01)){
							$msgidd = $rows01[0];			 			 
						}
						mysqli_free_result($resultl01);
					}		 			 
				}
				mysqli_free_result($resultl0);
			}
			if ($msgidd == 0) {
				$queryl0 	= "SELECT id_outbox FROM cc_wa_outbox_log WHERE message_respon = '$replyID'";
				$resultl0 	= mysqli_query($conn,$queryl0);
				if ($resultl0) {
					while ($rows0 = mysqli_fetch_row($resultl0)){
						$vwid = $rows0[0];	

						$queryl01 	= "SELECT message_id FROM cc_wa_outbox WHERE id = '$vwid'";
						$resultl01 	= mysqli_query($conn,$queryl01);
						if ($resultl01) {
							while ($rows01 = mysqli_fetch_row($resultl01)){
								$msgidd = $rows01[0];			 			 
							}
							mysqli_free_result($resultl01);
						}		 			 
					}
					mysqli_free_result($resultl0);
				}
			}

			$inreply_id = $msgidd;
		}

			$query= "INSERT INTO cc_wa_webhook(
						channel_type,
						event,
						token,
						channel_mysource,
						contact_uid,
						contact_name,
						contact_type,
						message_dtm,
						message_uid,
						message_cuid,
						message_dir,
						message_type,
						message_body_text,
						message_body_caption,
						message_body_mimetype,
						message_body_size,
						message_body_thumb,
						message_body_url,
						message_body_contact,
						message_body_vcard,
						message_body_name,
						message_body_lng,
						message_body_lat,
						message_body_duration,
						message_ack,
						message_body_saved_path,
						curtime,
						sync,
						`timestamp`,
						raw
					) VALUES(
						'intikom',
						'messages',
						'',
						'$me_phone',
						'$contact_uid',
						'$contact_name',
						'user',
						'$message_dtm',
						'$message_uid',
						'',
						'i',
						'$msgtype',
						'$textbody',
						'$textcaption',
						'$textmimetype',
						'0',
						'0',
						'$vdataid',
						'$contact_firstname',
						'$contact_phone',
						'',
						'$location_long',
						'$location_lat',
						'',
						'',
						'',
						NOW(),
						'0',
						'$msgtimestamp',
						'".addslashes(json_encode($PUSHED_DATA))."'
					)";
			if (mysqli_query($conn,$query)) {
				$lastID = mysqli_insert_id($conn);
				
				$curSkill		= "25";							// Skill feature
				$stringPesan	= $textbody;
				$webhookID		= $lastID;						
				$msg_type 		= $msgtype;
				$usernameID 	= $contact_uid;				// user ID
				$calltype 		= "1";							// 1 = Messages, 2 Retweet, 3 Mentions 4 Posts, 5 Comments (cc_chat_call_type)
				$inboundID 		= "";							// id_str (ID post inbound)
				$groupID 		= "";							// Chat = variabel kosong, Facebook = Parent ID / Post ID, Twitter = Parent ID / Post ID,
				$source 		= $me_phone;

				$socialName 	= $contact_name;
				$socialUname 	= $contact_uid;
				$inreplyID 		= $inreply_id;
				if ($msg_type == 'sticker') {
					$msg_type = 'image';
					//$stringPesan = "Sticker message can't be retrieved yet";
				}
				
				if ($contact_uid != "") {
					if ($msg_type != 'system') {
						include '../rule.php';
						
					}
				}
			
			}else{
				echo "";
			}
		
}elseif (isset($PUSHED_DATA['statuses'])) {
	if ($PUSHED_DATA['statuses'][0]['status'] != 'failed') {
		$rstatus = $PUSHED_DATA['statuses'][0]['status'];
		if ($rstatus == 'sent') {
			$sql = "UPDATE cc_wa_outbox SET pushed_remark = '".$rstatus."',success_time = NOW() WHERE sent_code = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

			$sql = "UPDATE cc_wa_outbox_log SET pushed_remark = '".$rstatus."',success_time = NOW() WHERE message_report = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

		}elseif ($rstatus == 'delivered') {
			$sql = "UPDATE cc_wa_outbox SET pushed_remark = '".$rstatus."',delivered_time = NOW() WHERE sent_code = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

			$sql = "UPDATE cc_wa_outbox_log SET pushed_remark = '".$rstatus."',delivered_time = NOW() WHERE message_report = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

		}elseif ($rstatus == 'read') {
			$sql = "UPDATE cc_wa_outbox SET pushed_remark = '".$rstatus."',read_time = NOW() WHERE sent_code = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

			$sql = "UPDATE cc_wa_outbox_log SET pushed_remark = '".$rstatus."',read_time = NOW() WHERE message_report = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

		}
	}else{
		$rstatus = $PUSHED_DATA['statuses'][0]['status']."\n".$PUSHED_DATA['statuses'][0]['errors'][0]['title'];
		$sql = "UPDATE cc_wa_outbox SET pushed_remark = '".$rstatus."' WHERE sent_code = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);

		$sql = "UPDATE cc_wa_outbox_log SET pushed_remark = '".$rstatus."' WHERE message_report = '" . $PUSHED_DATA['statuses'][0]['id'] . "'";
			mysqli_query($conn,$sql);
	}
	$query = "INSERT INTO cc_wa_ack SET 
						  report_id 	= '" . $PUSHED_DATA['statuses'][0]['id'] . "',
						  `code` 		= '" . $PUSHED_DATA['statuses'][0]['errors'][0]['code'] . "',
						  title 		= '" . $PUSHED_DATA['statuses'][0]['errors'][0]['title'] . "',
						  recipient_id 	= '" . $PUSHED_DATA['statuses'][0]['recipient_id'] . "',
						  `status` 		= '" . $rstatus . "',
						  `timestamp` 	= '" . $PUSHED_DATA['statuses'][0]['timestamp'] . "',
						  `raw` 		= '".addslashes(json_encode($PUSHED_DATA))."',
						  message_time 	= NOW()";
	mysqli_query($conn,$query);
}

?>

