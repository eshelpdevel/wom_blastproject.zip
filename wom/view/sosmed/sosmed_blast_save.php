<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "global_func_cust.php";
$condb = connectDB();

$v_agentid      		= get_session("v_agentid");
$iddet					= get_param("iddet");
$account				= get_param("account");
$tipe					= get_param("tipe");
$blast_name		    	= get_param("blast_name");
$channel		    	= get_param("channel");
$ffm_body		    	= get_param("messagebody");
$send_method		    = get_param("send_method");
$template		    	= get_param("template");
$spv_id		    		= get_param("spv_id");
$ass_id		    		= get_param("ass_id");

//$autoreply_while_busy	= mysqli_real_escape_string($condb,get_param("autoreply_while_busy"));

if ($channel == "") {
	echo "Channel must be filled";
}elseif ($account == '') {
	echo "Account must be filled";
}else{

	if ($iddet == '') {
		$sqlu 	= "INSERT INTO cc_sosmed_blast SET 
						       channel 		= '$channel',
						       account 		= '$account',
						       blast_name 	= '".addslashes($blast_name)."',
						       hsm_template	= '".addslashes($template)."',
						       created_by 	= '$v_agentid',
						       spv_id 		= '$spv_id',
						       assign_id 	= '$ass_id',
						       created_time = NOW()";
	}else{
		$sqlu = "UPDATE cc_sosmed_blast SET 
						  blast_name 	= '".addslashes($blast_name)."',
						  send_method 	= '$send_method',
						  ffm_body 		= '".addslashes($ffm_body)."' 
				  WHERE id = '$iddet'";
	}
	if($rec_u = mysqli_query($condb,$sqlu)) {
				//user trail log
				// $traildesc2 = "Insert cc_customer_contact id $iddet, Success";
				// cc_insert_trail_log($v_agentid,$traildesc2,$condb);
			
			
			echo "Success";
		}
		else {
			echo "Failed ";
		}

}

disconnectDB($condb);
?>