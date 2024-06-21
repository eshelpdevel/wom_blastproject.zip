<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "global_func_cust.php";
$condb = connectDB();

$v_agentid      		= get_session("v_agentid");
$current_quota					= get_param("current_quota");
$propose_quota				= get_param("propose_quota");
$reason					= get_param("reason");

if ($reason == "") {
	echo "Please fill Reason";
}else{
	$query12 = "SELECT 
					count(*)
				from cc_sosmed_blast_quota_det a 
				where a.agent_id = '$v_agentid'
				and a.status = 0";
	$result12 = mysqli_query($condb,$query12);
	if ($result12) {
		while ($row12 			= mysqli_fetch_row($result12)){
			$isjml 		= $row12[0];
			
		}
		mysqli_free_result($result12);
	} 
	if ($isjml == 0) {
		$sqlu 	= "INSERT INTO cc_sosmed_blast_quota_det SET 
					       channel 			= '25',
					       agent_id 		= '$v_agentid',
					       request_from 	= '$current_quota',
					       request_to 		= '$propose_quota',
					       reason 			= '".addslashes($reason)."',
					       request_by 		= '$v_agentid',
					       request_time 	= NOW()";
		if($rec_u = mysqli_query($condb,$sqlu)) {
				echo "Success";
		}else {
				echo "Failed ";
		}
	}else{
		echo "Please wait your existing proposal";
	}
}

disconnectDB($condb);
?>