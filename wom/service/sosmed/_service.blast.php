<?php 

include "sosmed_configuration.php";
	$queryl0 	= "SELECT id from cc_sosmed_blast where schedule_time is not null and schedule_time <= NOW() and status = 0";
	$resultl0 	= mysqli_query($conn,$queryl0);
	if ($resultl0) {
		while ($rows0 	= mysqli_fetch_row($resultl0)){
			$blastid 	= $rows0[0];	
			
			$sql = "UPDATE cc_sosmed_blast SET status = 3,start_exectime = NOW() where id = '$blastid'";
			mysqli_query($conn,$sql);

			start_sendblast($conn,$blastid);
			
			$sql = "UPDATE cc_sosmed_blast SET status = 1, end_exectime = NOW() where id = '$blastid'";
			mysqli_query($conn,$sql);
		}
		mysqli_free_result($resultl0);
	}


	
?>