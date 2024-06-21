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
	#																												#
	 ###############################################################################################################	
    #                                                                                                               #
    #                                                                                                               #
    #                     ███╗░░░███╗██████╗░░░██╗░░██╗░█████╗░██████╗░░█████╗░██████╗░░█████╗░                     #
    #                     ████╗░████║██╔══██╗░░██║░░██║██╔══██╗██╔══██╗██╔══██╗██╔══██╗██╔══██╗                     #
    #                     ██╔████╔██║██████╔╝░░███████║███████║██████╔╝███████║██║░░██║██║░░██║                     #
    #                     ██║╚██╔╝██║██╔══██╗░░██╔══██║██╔══██║██╔══██╗██╔══██║██║░░██║██║░░██║                     #
    #                     ██║░╚═╝░██║██║░░██║░░██║░░██║██║░░██║██║░░██║██║░░██║██████╔╝╚█████╔╝                     #
    #                     ╚═╝░░░░░╚═╝╚═╝░░╚═╝░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░╚═╝╚═════╝░░╚════╝░                     #
    # G  R  A  N  D     S  U  P  E  R  V  I  S  O  R   &   D  E  V  E  L  O  P  M  E  N  T     M  A  N  A  G  E  R  #
    #                                                                                                               #
	 ###############################################################################################################
	$domain  			= "https://devcrm.wom.co.id"; 		//http://elyphdevel.com application url
    $dir     			= "wom";     			//elyphsoftdemo application directory
    $self 	 			= "http://localhost"; 			//call Apichat itself
    $writelog			= 1; 							//0 = no, 1= write to log directory
    $global 			= 1;							//global json
	
	# PROXY SCHEME FOR SELF / INTRANET CALL
	$local_useproxy      = 0;	 						//0 = disable, 1 = disable
	$local_ipproxy 		= ""; 							//10.11.25.218
	$local_portproxy 	= ""; 							//3128, let it blank if no use
	$local_proxytype 	= ""; 							//tcp, let it blank if no use

	# PROXY SCHEME FOR INTERNET CALL
	$inet_useproxy      = 0;	 						//0 = disable, 1 = disable
	$inet_ipproxy 		= "10.11.25.218"; 				//10.11.25.218
	$inet_portproxy 	= "3128"; 						//3128, let it blank if no use
	$inet_proxytype 	= "tcp"; 						//tcp, let it blank if no use

	#FILECOPY PROXY
	$local_proxycopy  	= ""; 							//tcp://10.11.25.218:3128, let it blank if no use
	$inet_proxycopy  	= ""; 	//tcp://10.11.25.218:3128, let it blank if no use


	/*
	
	if($local_useproxy == "1"){
		curl_setopt($ch, CURLOPT_PROXY, $local_ipproxy);
	}
	if($local_portproxy != ""){
		curl_setopt($ch, CURLOPT_PROXYPORT, $local_portproxy);
	}
	if($local_proxytype != ""){
		curl_setopt($ch, CURLOPT_PROXYTYPE, $local_proxytype);
	}

	if($inet_useproxy == "1"){
		curl_setopt($ch, CURLOPT_PROXY, $inet_ipproxy);
	}
	if($inet_portproxy != ""){
		curl_setopt($ch, CURLOPT_PROXYPORT, $inet_portproxy);
	}
	if($inet_proxytype != ""){
		curl_setopt($ch, CURLOPT_PROXYTYPE, $inet_proxytype);
	}
	
	*/


    #                                                                                                               #
	# ****************************************** ===  MANAGER CONFIG ===  ***************************************** #
	date_default_timezone_set('Asia/Krasnoyarsk');
	/*function media_binary($url){
	    $path = $url;
	    $type = pathinfo($path, PATHINFO_EXTENSION);
	    $data = file_get_contents($path);
	    //$file_lampiran_tunggakan = 'data:image/' . $type . ';base64,' . base64_encode($data);
	    $file_lampiran_tunggakan = $data;
	    return $file_lampiran_tunggakan;
	}*/

	$link = str_replace("/Apichat/", "", $_SERVER['REQUEST_URI']);
    $par = explode("/", $link);
    if ($par[0] == 'Media') {
    	$tw_attachment_url_https = substr($par[1],3,strlen($par[1])-3);
    	$tw_attachment_url_https = base64_decode($tw_attachment_url_https,true);
    	$tw_attachment_url_https = base64_decode($tw_attachment_url_https,true);
		$tw_attachment_url_https = "Mediaupload/".$tw_attachment_url_https;
		header('Content-type:'.$tw_attachment_contentype);
		echo media_binary($tw_attachment_url_https);
		
    }else{
    	$vdata['success'] 		= false;
		$vdata['description'] 	= "Endpoint not available";
		$pathh = '_Apies/'.$par[0].'.php';
		if (!file_exists($pathh)) {
			$pathh = '_Apies/Notfound.php';	
		}
		include $pathh;
		if ($writelog == 1) {
			$dirname = "../log";
			if (!is_dir($dirname)) {
			    mkdir($dirname);
			}

			$nmfile = "Apichat_".$par[0]."_".$par[1]."_".date('Ymd').".txt";
			$myfile = fopen($dirname."/".$nmfile, "a") or die("Unable to open file!");
	        fwrite($myfile, date('H:i:s')." \n-----\n");
	        fwrite($myfile, "Request:\n".$kirimdata." \n\n");
	        fwrite($myfile, "Response:\n".$response);
	        fwrite($myfile, "\n\n ========== \n\n");
	        fclose($myfile);
		}
		if ($global == 1) {
			echo json_encode($vdata);
		}
    }
?>