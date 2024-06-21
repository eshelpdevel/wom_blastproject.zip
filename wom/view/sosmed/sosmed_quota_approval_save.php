<?php
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";
include "global_func_cust.php";
$condb = connectDB();

$v_agentid      		= get_session("v_agentid");
$iddet					= get_param("iddet");
$status					= get_param("status");

if ($status == 0) {
	echo "Failed\nYou must choose Aprove or Reject";
}else{
	$query = "UPDATE cc_sosmed_blast_quota_det SET status = '$status', approved_by = '$v_agentid', approved_time = NOW() WHERE id = '$iddet'";
	if(mysqli_query($condb, $query)){
		echo "Success!";
		$sqlv = "SELECT request_to,agent_id from cc_sosmed_blast_quota_det where id =  '$iddet' "; 
		$resv = mysqli_query($condb, $sqlv);
		if($recv = mysqli_fetch_array($resv)){
			$request_to 							= $recv["request_to"];
			$agent_id 							= $recv["agent_id"];
		}

		if ($status == 1) {
			 $sqlv = "SELECT count(*) as jml from cc_sosmed_blast_quota where agent_id =  '$agent_id' "; 
			$resv = mysqli_query($condb, $sqlv);
			if($recv = mysqli_fetch_array($resv)){
				$jml 							= $recv["jml"];
				if ($jml == 0) {
					 $queyr = "INSERT INTO cc_sosmed_blast_quota SET 
										  agent_id = '$agent_id',
										  quota    = '$request_to',
										  insert_time = NOW()";
				}else{
					 $queyr = "UPDATE  cc_sosmed_blast_quota SET 
										  quota    = '$request_to',
										  update_time = NOW()
							  WHERE agent_id = '$agent_id'";
				}
				mysqli_query($condb, $queyr);
			}
		}
	}else{
		echo "Failed!";

	}
	

	


}

disconnectDB($condb);
?>