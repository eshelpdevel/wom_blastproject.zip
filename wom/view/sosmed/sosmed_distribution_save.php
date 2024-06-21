<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "global_func_cust.php";
$condb = connectDB();

$v_agentid      		= get_session("v_agentid");
$iddet					= get_param("iddet");
$limit_distribution		= get_param("limit_distribution");
$delay_autoreply		= get_param("delay_autoreply");
$autoreply_while_busy	= mysqli_real_escape_string($condb,get_param("autoreply_while_busy"));
$autoreply_while_off	= mysqli_real_escape_string($condb,get_param("autoreply_while_off"));
$autogreeting			= mysqli_real_escape_string($condb,get_param("autogreeting"));
$autogreeting_fromblast			= mysqli_real_escape_string($condb,get_param("autogreeting_fromblast"));
$queueinfo				= mysqli_real_escape_string($condb,get_param("queueinfo"));
$session_close		    = get_param("session_close");
$show_bot_answer		= get_param("show_bot_answer");
$aux_can_reply		    = get_param("aux_can_reply");
$draftpick		    	= get_param("draftpick");
$resent		    		= get_param("resent");

$auto_close		    	= get_param("auto_close");
$offclose		    	= get_param("offclose");
$entertoSend		    = get_param("entertoSend");
$show_monitoring_botscript		    = get_param("show_monitoring_botscript");




$autoclosing		    = get_param("autoclosing");
$autoclosing_bot		= get_param("autoclosing_bot");
$autotransfering		= get_param("autotransfering");
$show_transfersession	= get_param("show_transfersession");

		 $sqlu = "UPDATE cc_channel_desc SET
					limit_distribution      = '$limit_distribution',
		            delay_autoreply     	= '$delay_autoreply',
		            autoreply_while_busy    = '$autoreply_while_busy',
		            autoreply_while_off     = '$autoreply_while_off',
		            autogreeting     		= '$autogreeting',
		            autogreeting_fromblast     		= '$autogreeting_fromblast',
		            session_close     		= '$session_close',
		            show_autoreply     		= '$show_bot_answer',
		            aux_can_reply     		= '$aux_can_reply',
		            entertoSend 			= '$entertoSend',
		            show_monitoring_botscript = '$show_monitoring_botscript',
		            resent     				= '$resent',
		            show_draft     			= '$draftpick',
		            auto_close 				= '$auto_close',
		            offclose 				= '$offclose',
		            autoclosing     		= '$autoclosing',
		            autoclosing_bot     	= '$autoclosing_bot',
		            autotransfering     	= '$autotransfering',
		            show_transfersession    = '$show_transfersession',
		            queueinfo 				= '$queueinfo',
		            modif_by     			= '$v_agentid',
		            modif_time     			= now()
				  WHERE id            		= '$iddet'";//echo "$sqlu";
		if($rec_u = mysqli_query($condb,$sqlu)) {
				//user trail log
				// $traildesc2 = "Insert cc_customer_contact id $iddet, Success";
				// cc_insert_trail_log($v_agentid,$traildesc2,$condb);
			
			
			echo "Success";
		}
		else {
			echo "Failed";
	}
disconnectDB($condb);
?>