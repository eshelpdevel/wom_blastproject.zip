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
	$whenewhen = "";
	include "../../service/sosmed/sosmed_configuration.php";
	$vs = view_whatsapp_provider();
	for ($i=0; $i <count($vs) ; $i++) { 
		$whenewhen .= ' WHEN a.whatsapp_model = "'.$vs[$i][1].'" THEN "<img src=assets/img/'.$vs[$i][3].' width=120px />"'."\n";
		
	}
	//echo $whenewhen;
	/*WHEN a.whatsapp_model = "waboxapp" THEN "<img src=\"assets/img/logo_waboxapp.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "capiwha" THEN "<img src=\"assets/img/logo_capiwha.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "rapiwha" THEN "<img src=\"assets/img/logo_rapiwha.svg\" width=\"120px\" />"
							WHEN a.whatsapp_model = "official" THEN "<img src=\"assets/img/logo_infobip.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "official_sprint" THEN "<img src=\"assets/img/logo_sprint.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "official_wa" THEN "<img src=\"assets/img/logo_whatsapp.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "official_jatis" THEN "<img src=\"assets/img/logo_jatis.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "official_damcorp" THEN "<img src=\"assets/img/logo_damcorp.png\" width=\"120px\" />"
							WHEN a.whatsapp_model = "sociomile" THEN "<img src=\"assets/img/logo_sociomile.png\" width=\"120px\" />"*/
	# DATA FIELD
	$aColumns = array(  'a.id',
						'a.data_id',
						'a.data_template_name',
						'a.data_category',
						'a.data_created_at2',
						'a.data_status',
						'IF(b.id IS NULL,\' - \',\'✓\')');
					
	# INDEX ID				
	$sIndexColumn = "a.id";
	
	# START TIME & END TIME 
	$start_date_field = "a.data_created_at2";
	$end_date_field	  = "a.data_created_at2";

	# FROM QUERY
	$sFromTable = "FROM cc_wa_template_ivosight a 
				   LEFT JOIN cc_wa_template b ON a.data_id = b.template_id
				   WHERE 1=1 ";

	# VIEW TRACE
	  // 0 = Disable     1 = Enable
	  // If you enable this Trace, so your data may be broke, but you can trace it in network data :D :P 
	  $viewTrace = 0;


####################################  E N D   O F  C O N F I G U R A T I O N   F I L E #  #########################
include '../../sysconf/global_data.php';

?>
