<?php
 ###############################################################################################################
#																																																								#
#                   `---:/.     																																								#			
#               .--.    `+h.   																																									#
#            `--`         om   																																									#
#          `:-   `-:-`    :M.  		___________.__                .__                  _____  __   								#
#         .:#` :ydy++y    +M`  		\_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_ 								#
#        :.  #hm+.   /`   mh   		 |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\								#
#       :`  +Ns`     /   oN-   		 |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  | 								#
#      /`  +N+      ::.-oN+    		/_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|									#
#     :.  .No     `:`# /No     		        \/      \/     |__|        \/     \/  																#
#    `/   +M`   `--`##sN+      		   _____            _             _      _____           _            				#
#    :`   .m/..--`  -dd-       		 / ____|          | |           | |    / ____|         | |           					#
#    +    .:.``   .ymo`        		| |     ___  _ __ | |_ __ _  ___| |_  | |     ___ _ __ | |_ ___ _ __ 					#
#   /:  --     :yms.          		| |    / _ \| '_ \| __/ _` |/ __| __| | |    / _ \ '_ \| __/ _ \ '__|					#
#     s+/.  ./smh+`            		| |___| (_) | | | | || (_| | (__| |_  | |___|  __/ | | | ||  __/ |   					#
#      -oyhhyo:`               		 \_____\___/|_| |_|\__\__,_|\___|\__|  \_____\___|_| |_|\__\___|_|						#
#																																																								#
#	-------------------------																																											#
#																																																								#
 ###############################################################################################################


 
######################################### C O N F I G U R A T I O N   F I L E ###################################

# DATA SOURCE
$link_data_acc 	= "view/sosmed/sosmed_blast_data.php";

# DETAIL PAGE SOURCE
$menu_linkdet	= "sosmed_blast_det";

# TABLE COLUMN
$field_data 	= array(
					  array("","ID"),
					  array("a.channel","Channel"),
					  array("a.blast_name","Blast Name"),
            array("","SPV Name"),
					  array("a.created_by","Created By"),
            array("CONCAT(e.agent_name,' / ',e.agent_id)","Assign To"),
            array("","Remark"),
					  array("a.created_time","Created Time"),
            array("a.status","Status"),
				  );
# SETTING TABLE COLUMN WHICH WOULD TO HIDE
  // default, 1st Column
$hiddencol 		= "1";

# VISIBILITY SEARCH FEATURE
  // 1 = Enable     		0 = Disable
$s_time = 0;


# ACTION VISIBILITY
  // 1= Visible 	0 = Hidden
  $action_visibility  = 1;

# ACTION BUTTON  
  // 1= Enable Add Button 	0 = Disanble
  $add_button  = 1;

  // Format "Href", "Caption"
  // Left Href blank if Disable Goto anywhere
  // The id will be generated As "btn_Action" + array
  $action_arr   = array(
					/*array("","Tombol2"),
					array("http://google.com","Tombol3")
				  	*/
				  );


include 'sysconf/global_list.php';
?>

