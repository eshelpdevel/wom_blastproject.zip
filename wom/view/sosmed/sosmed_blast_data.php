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
						'c.channel_descr',
						'a.blast_name',
						'IF(a.spv_id = 0,\'No SPV\',CONCAT(d.agent_name,\' / \',d.agent_id))',
						'CONCAT(e.agent_name,\' / \',e.agent_id)',
						'CONCAT(b.agent_name,\' / \',b.agent_id)',
						'IF(a.close_remark IS NULL ,\' - \',IF(a.close_remark = \'direct\',\'Direct\',CONCAT(\'Scheduled at \',a.schedule_time)))',
						'a.created_time',
						
						'CASE
						    WHEN (a.status=0 AND schedule_time IS NULL) THEN \'Waiting\'
						    WHEN (a.status=0 AND schedule_time IS NOT NULL) THEN \'Scheduling\'
						    WHEN a.status=1 THEN \'Processed\'
						    WHEN a.status=3 THEN \'Processing\'
						    ELSE \'Status description not defined\'
						END'
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
	$start_date_field = "a.created_by";
	$end_date_field	  = "a.created_by";

	# FROM QUERY
	$sFromTable = "FROM cc_sosmed_blast a 
				   LEFT JOIN cc_agent_profile b ON a.created_by = b.id
				   LEFT JOIN cc_channel_desc c ON a.channel = c.channel_id
				   LEFT JOIN cc_agent_profile d ON a.spv_id = d.id
				   LEFT JOIN cc_agent_profile e ON a.assign_id = e.id
				   WHERE 1=1 ";

	# VIEW TRACE
	  // 0 = Disable     1 = Enable
	  // If you enable this Trace, so your data may be broke, but you can trace it in network data :D :P 
	  $viewTrace = 0;


####################################  E N D   O F  C O N F I G U R A T I O N   F I L E #  #########################
include '../../sysconf/global_data.php';

?>
