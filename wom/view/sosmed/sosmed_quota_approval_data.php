<?php
 ###############################################################################################################
#																												#
#                   `---:/.     																				#			
#               .--.    `+h.   																					#
#            `--`         om   																					#
#          `:-   `-:-`    :M.  		___________.__                .__                  _____  __   				#
#         .:#` :ydy++y    +M`  		\_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_ 				#
#        :.  #hm+.   /`   mh   		 |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\				#
#       :`  +Ns`     /   oN-   		 |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  | 				#
#      /`  +N+      ::.-oN+    		/_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|				#
#     :.  .No     `:`# /No     		        \/      \/     |__|        \/     \/  								#
#    `/   +M`   `--`##sN+      		   _____            _             _      _____           _            		#
#    :`   .m/..--`  -dd-       		 / ____|          | |           | |    / ____|         | |           		#
#    +    .:.``   .ymo`        		| |     ___  _ __ | |_ __ _  ___| |_  | |     ___ _ __ | |_ ___ _ __ 		#
#   /:  --     :yms.          		| |    / _ \| '_ \| __/ _` |/ __| __| | |    / _ \ '_ \| __/ _ \ '__|		#
#     s+/.  ./smh+`            		| |___| (_) | | | | || (_| | (__| |_  | |___|  __/ | | | ||  __/ |   		#
#      -oyhhyo:`               		 \_____\___/|_| |_|\__\__,_|\___|\__|  \_____\___|_| |_|\__\___|_|			#
#																												#
#	-------------------------																					#
#																												#
 ###############################################################################################################


 
######################################### C O N F I G U R A T I O N   F I L E ###################################
 
	# DATA FIELD
	$aColumns = array(  'a.id',
						'b.agent_name',
						'a.request_time',
						'a.request_from',
						'a.request_to',
						'a.reason',
						'IF(a.status = 0,\'Waiting Approval\',IF(a.status = 1,\'Aproved\',\'Rejected\'))',
						'c.agent_name',
						'a.approved_time',
						'IF(a.status=0,"Active",IF(a.status = 2,"Script","Expired"))'
					);
/*
'IF(a.message_dir = "i", "-", 
							IF(a.status_read = "0000-00-00 00:00:00", 
								IF(a.status_delivered = "0000-00-00 00:00:00", 
									IF(a.status_server = "0000-00-00 00:00:00", "Mengirim", "Terkirim")
								, "Diterima")
							, "Dibaca")
						)',
						*/
							
	# INDEX ID				
	$sIndexColumn = "a.id";
	
	# START TIME & END TIME 
	$start_date_field = "a.request_time";
	$end_date_field	  = "a.request_time";

	# FROM QUERY
	$sFromTable = "FROM cc_sosmed_blast_quota_det a 
				   LEFT JOIN cc_agent_profile b ON a.agent_id = b.id
				   LEFT JOIN cc_agent_profile c ON a.approved_by = c.id 
				   WHERE 1=1 ";

	# VIEW TRACE
	  // 0 = Disable     1 = Enable
	  // If you enable this Trace, so your data may be broke, but you can trace it in network data :D :P 
	  $viewTrace = 0;


####################################  E N D   O F  C O N F I G U R A T I O N   F I L E #  #########################
include '../../sysconf/global_data.php';

?>
