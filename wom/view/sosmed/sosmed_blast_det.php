<?php
include "../../sysconf/con_reff.php";
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

$condb = connectDB();
$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");
$tbl_name 		= "cc_sosmed_webhook";
$iddet 			= $library['iddet'];

$query12 = "SELECT count(*) from cc_omni_license where channel_id = 25 and agent_id = '$v_agentid' and license = 1 and interaction = 1";
$result12 = mysqli_query($condb,$query12);
if ($result12) {
	while ($row12 			= mysqli_fetch_row($result12)){
		if ($row12[0] == 0) {
			if ($_GET['mode'] == 'es') {
				?>
					<script type="text/javascript">
						alert("You are not have license for this feature, but no problem");
					</script>
				<?php
			}else{
				?>
					<script type="text/javascript">
						alert("You are not have license for this feature");
						document.location = "index.php?v=c29zbWVkfHNvc21lZF9ibGFzdF9saXN0fEJsYXN0fDMxOHw%3D";
					</script>
				<?php	
			}
		}
	}
	mysqli_free_result($result12);
}   

$ffolder		= $library['folder'];
$fmenu_link		= $library['menu_link'];
$fdescription	= $library['description'];
$fmenu_id		= $library['menu_id'];
$ficon			= $library['icon'];
$fiddet			= $library['iddet'];
$fblist			= $library['blist'];

$fmenu_link_back = "sosmed_blast_list";
    	
$blist 			= $library['blist'];
$strblist       = explode(";", $blist); 
$blist_date		= $strblist[0];
$blist_fcount	= $strblist[1];
$blist_csearch0	= $strblist[2];
$blist_tsearch0	= $strblist[3];
$blist_csearch1	= $strblist[4];
$blist_tsearch1	= $strblist[5];
$blist_csearch2	= $strblist[6];
$blist_tsearch2	= $strblist[7];
$blist_csearch3	= $strblist[8];
$blist_tsearch3	= $strblist[9];
$blist_csearch4	= $strblist[10];
$blist_tsearch4	= $strblist[11];

	$sqlv = "SELECT blast_name,channel,account,tipe,ffm_body,status,send_method,hsm_template,created_by,spv_id,schedule_time
			 FROM   cc_sosmed_blast a
			 WHERE a.id = '$iddet' "; 
	$resv = mysqli_query($condb, $sqlv);
	if($recv = mysqli_fetch_array($resv)){
		$blast_name 			= $recv["blast_name"];
		$channel 				= $recv["channel"];
		$account 				= $recv["account"];
		$tipe 					= $recv["tipe"];
		$messagebody 			= $recv["ffm_body"];
		$setstatus 				= $recv["status"];
		$send_method 			= $recv["send_method"];
		$hsm_template 			= $recv["hsm_template"];
		$created_by 			= $recv["created_by"];
		$spv_id 				= $recv["spv_id"];
		$schedule_time 			= $recv["schedule_time"];
		if ($created_by != $v_agentid) {
			if ($_GET['mode'] == 'es') {
				?>
					<script type="text/javascript">
						alert("You are not the owner for this blast. but no problem");
					</script>
				<?php
			}else{
				?>
					<script type="text/javascript">
						alert("You are not the owner for this blast");
						document.location = "index.php?v=c29zbWVkfHNvc21lZF9ibGFzdF9saXN0fEJsYXN0fDMxOHw%3D";
					</script>
				<?php
				}
		}
	} else {
		$blast_name        		= "";
		$channel        		= "";
		$account 				= "";
		$tipe 					= "";
		$messagebody  			= "";
		$setstatus 				= "";
		$send_method 			= "";
		$hsm_template 				= "";
	}

//file save data
$save_form = "view/sosmed/sosmed_blast_save.php";

if($iddet  == "") {
	$desc_iddet = "Create New";
}else{
	$desc_iddet = "View";
}
//$desc_iddet = "Configuration";


?>


<form name="frmDataDet" id="frmDataDet" method="POST">
<input type="hidden" name="iddet" id="iddet" value="<?php echo $iddet;?>">

<input type="hidden" name="blist_date" id="blist_date" value="<?php echo $blist_date;?>">
<input type="hidden" name="blist_fcount" id="blist_fcount" value="<?php echo $blist_fcount;?>">
<input type="hidden" name="blist_csearch0" id="blist_csearch0" value="<?php echo $blist_csearch0;?>">
<input type="hidden" name="blist_tsearch0" id="blist_tsearch0" value="<?php echo $blist_tsearch0;?>">
<input type="hidden" name="blist_csearch1" id="blist_csearch1" value="<?php echo $blist_csearch1;?>">
<input type="hidden" name="blist_tsearch1" id="blist_tsearch1" value="<?php echo $blist_tsearch1;?>">
<input type="hidden" name="blist_csearch2" id="blist_csearch2" value="<?php echo $blist_csearch2;?>">
<input type="hidden" name="blist_tsearch2" id="blist_tsearch2" value="<?php echo $blist_tsearch2;?>">
<input type="hidden" name="blist_csearch3" id="blist_csearch3" value="<?php echo $blist_csearch3;?>">
<input type="hidden" name="blist_tsearch3" id="blist_tsearch3" value="<?php echo $blist_tsearch3;?>">
<input type="hidden" name="blist_csearch4" id="blist_csearch4" value="<?php echo $blist_csearch4;?>">
<input type="hidden" name="blist_tsearch4" id="blist_tsearch4" value="<?php echo $blist_tsearch4;?>">


<div class="page-inner">
	<div class="page-header"  style="margin-bottom:0px;margin-top:-15px;padding-left:0px;padding:0px;margin-left:-20px;">
		<ul class="breadcrumbs" style="border-left:0px;margin:0px;">
			<li class="nav-home">
				<a href="index.php">
					<i class="fas fa-home"></i>
				</a>
			</li>
			<li class="separator">
				<i class="fas fa-chevron-right"></i>
			</li>
			<?php
				$menu_tree = explode("|", $library['page']);
				for ($i=0; $i <count($menu_tree) ; $i++) { 
					if ($i != 0) {
						echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
					}
					echo "<li class=\"nav-item\">".$menu_tree[$i]."</li>";;
				}
				echo "<li class=\"separator\"><i class=\"fas fa-chevron-right\"></i></li>";
				echo "<li class=\"nav-item\">".$desc_iddet."</li>";;				
			?>
		</ul>
	</div>
	<div class="content" style="margin-top: 10px;">
		<div class="row">
		<script type="text/javascript">
			function uplheader(placeid){
				var data = new FormData();
                                             
                 
                 var fileInput = document.getElementById('vupl' + placeid);
                 var file_data = $('input[name="vupl' + placeid + '"]')[0].files;
                 var total     = fileInput.files.length;
                 data.append('media', 'image');
                 for (var i = 0; i < fileInput.files.length; i++) {
                    data.append("fileName"+i+"[]", file_data[i]);
                 }
                 data.append("total", total);

                 data.append('key', 'value');   
                 $.ajax({
                    url: "service/sosmed/media_upload.php",
                    type: "post",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(d) {
                        document.getElementById('header_' + placeid).value = 'https://devcrm.wom.co.id/wom/public/images/sosmed_upload/' + d;
                    }
                  });
			}
			function channel_breakdown(t){
				document.getElementById('account').innerHTML = "<option value=\"\">Processing ...</option>";
				$.ajax({
                    type:'GET',
                    url:'service/sosmed/chat.php',
                    data:'action=get_account_config&agent_id=<?php echo $v_agentid ?>&channel=' + encodeURI(t),
                    success:function(html){
                     
                     if (html == "") {
                     	document.getElementById('account').innerHTML = "<option value=\"\">Failed to retrieve</option>";
                     }else{
                     	html = JSON.parse(html);
                     	if (typeof html.data !== 'undefined') {
                     		var vtt = "";
                     		vtt = vtt + "<option value=\"\">Choose Account</option>";
	                     	for (var i = 0;i<html.data.length;i++) {
	                     		
	                     		vtt = vtt + "<option value=\"" + html.data[i].reference + "\">" + html.data[i].alias + "</option>";
	                     	}
                     	}else{
                     		document.getElementById('account').innerHTML = "<option value=\"\">No Account Available</option>";
                     	}
                     }
                     document.getElementById('account').innerHTML = vtt;   
                    }
                });
			}
		</script>
		<!-- table 1 start -->
		<div class="col-md-4">
			<div class="card">
				<script type="text/javascript">
					function acc_breakdown(t){
						document.getElementById('template').innerHTML = "<option value=\"\">Loading...</option>";
						$.ajax({
		                    type:'GET',
		                    url:'service/sosmed/chat.php',
		                    data:'action=get_templates&channel=25&account=' + encodeURI(t),
		                    success:function(html){
		                     
		                     if (html == "") {
		                     	document.getElementById('template').innerHTML = "<option value=\"\">Failed to retrieve</option>";
		                     }else{
		                     	html = JSON.parse(html);
		                     	if (typeof html.data !== 'undefined') {
		                     		var vtt = "";
			                     	for (var i = 0;i<html.data.length;i++) {
			                     		
			                     		vtt = vtt + "<option value=\"" + html.data[i].reference + "\">" + html.data[i].alias + "</option>";
			                     	}
		                     	}else{
		                     		var vtt = "<option value=\"\">No Template Available</option>";
		                     	}
		                     }
		                     document.getElementById('template').innerHTML = vtt;   
		                    }
		                });
					}
				</script>
				<div style="margin:10px 10px 10px 10px;">
					<div>
							<div class="form-body">		
								<?php
								
									$txttitle	= $library['title'];
		                    		$icofrm	  = "fas fa-list-ul";
		                    		echo title_form_det($txttitle,$icofrm);
									
									$x						 		 = 0;
		        	
                                        

		                    		$chpicker = "<SELECT id=\"channel\" name=\"channel\" class=\"select2 form-control\" onchange=\"channel_breakdown(this.value)\">  ";
		                    		if ($channel == '') {
		                    			$chpicker .= "<option value=\"\" selected>Choose Channel</option>";
		                    		}
										$query12 = "SELECT a.skill_feature as idchannel,c.channel_descr as channelname
                                                    FROM cc_skill_feature a 
                                                    INNER JOIN cc_skill_agent b ON a.skill_id = b.skill_id AND b.agent_id = ".$v_agentid."
                                                    INNER JOIN cc_channel_desc c ON c.channel_id = CEIL(a.skill_feature)
                                                    group by a.skill_feature";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												if ($channel == "") {
													$chpicker .= "<option value=\"".$row12[0]."\" $sel0>".$row12[1]."</option>";		
												}else{
													if ($channel == $row12[0]) {
														$chpicker .= "<option value=\"".$row12[0]."\" $sel0>".$row12[1]."</option>";	
													}
												}
											}
											mysqli_free_result($result12);
										}   
					                  $chpicker .= "</SELECT>";
		                    		
		                    		$txtlabel[$x]      = "Channel Name";
			                    	$bodycontent[$x]   = $chpicker;
			                    	$x++;
		                    		
		                    		$txtlabel[$x]      = "Blast Name";
		                    		$bodycontent[$x]   = input_text_temp("blast_name","blast_name",$blast_name,"","required","form-control border-primary");
		                    		$x++;

		                    		 $accpicker = "<SELECT id=\"account\" name=\"account\" class=\"select2 form-control\" onchange=\"acc_breakdown(this.value)\">  ";
		                    		 if ($account != '') {
		                    		 	$query12 = "SELECT id,alias FROM cc_wa_config WHERE id = '$account'";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												if ($account == "") {
													$accpicker .= "<option value=\"".$row12[0]."\" $sel0>".$row12[1]."</option>";		
												}else{
													if ($account == $row12[0]) {
														$accpicker .= "<option value=\"".$row12[0]."\" $sel0>".$row12[1]."</option>";	
													}
												}
											}
											mysqli_free_result($result12);
										}  
		                    		 }
		                    		  
					                  $accpicker .= "</SELECT>";
		                    		
		                    		$txtlabel[$x]      = "Account";
			                    	$bodycontent[$x]   = $accpicker;
			                    	$x++;

			                    	$vtempl = "<SELECT id=\"template\" name=\"template\" class=\"select2 form-control\">";
			                    	if ($hsm_template != '') {
			                    		$query12 = "select template_id,template_name from cc_wa_template where template_id = '$hsm_template'";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												$vtempl .= "<option value=\"".$row12[0]."\" $sel0>".$row12[1]."</option>";
											}
											mysqli_free_result($result12);
										}   
			                    	}
			                    	$vtempl .= "</SELECT>";
		                    		
		                    		$txtlabel[$x]      = "Template";
			                    	$bodycontent[$x]   = $vtempl;
			                    	$x++;


			                    	$accpicker = "<SELECT id=\"tipe\" name=\"tipe\" class=\"select2 form-control\">  ";
		                    		if ($tipe == 'ffm') {
		                    		 	$accpicker .= "<option value=\"ffm\" selected>FFM - Freeform Message</option>";	
		                    		}else{
		                    			if ($tipe == '') {
		                    				$accpicker .= "<option value=\"ffm\">FFM - Freeform Message</option>";
		                    			}
		                    		} 

		                    		/*if ($tipe == 'hsm') {
		                    		 	$accpicker .= "<option value=\"hsm\" selected>HSM - High Structure Message</option>";	
		                    		}else{
		                    			if ($tipe == '') {
		                    				$accpicker .= "<option value=\"hsm\">HSM - High Structure Message</option>";
		                    			}
		                    		} 
					                $accpicker .= "</SELECT><br /><font color=blue><table><tr><td style=\"text-align:left\">👉🏻 FFM</td><td style=\"text-align:left\">Freeform (Textarea) in Messagebody</td></tr><tr><td style=\"text-align:left\">👉🏻 HSM</td><td style=\"text-align:left\">High Structure Message (Whatsapp Official Only for Initiate interaction)</td></tr></table></font>";

					                
			                    	$txtlabel[$x]      = "Blast Type";
			                    	$bodycontent[$x]   = $accpicker;
			                    	$x++;


			                    	$setipe_picker = "<SELECT id=\"send_method\" name=\"send_method\" class=\"select2 form-control\">  ";
		                    		if ($send_method == 'direct') {
		                    		 	$setipe_picker .= "<option value=\"direct\" selected>Bulk</option>";	
		                    		}else{
		                    			if ($send_method == '') {
		                    				$setipe_picker .= "<option value=\"direct\">Bulk</option>";
		                    			}
		                    		} 

		                    		if ($send_method == 'regular') {
		                    		 	$setipe_picker .= "<option value=\"regular\" selected>Normal</option>";	
		                    		}else{
		                    			if ($send_method == '') {
		                    				$setipe_picker .= "<option value=\"regular\">Normal</option>";
		                    			}
		                    		} 
					                $setipe_picker .= "</SELECT><br /><font color=blue><table><tr><td style=\"text-align:left\">👉🏻 Bulk</td><td style=\"text-align:left\">Request all out message in sametime</td></tr><tr><td style=\"text-align:left\">👉🏻 Normal</td><td style=\"text-align:left\">Queue, system will request each message after 3 second</td></tr></table></font>";

					                
			                    	$txtlabel[$x]      = "Send method";
			                    	$bodycontent[$x]   = $setipe_picker;
			                    	$x++;
			                    	*/

			                    	$ownpicker = "<SELECT id=\"ass_id\" name=\"ass_id\" class=\"select2 form-control\">  ";
		                    		if (($v_agentlevel == 1) || ($v_agentlevel == 2)) {
			                    		$query12 = "SELECT id,CONCAT(agent_name,' / ',agent_id) FROM cc_agent_profile WHERE id = '$v_agentid'";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												$ownpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";	
											}
											mysqli_free_result($result12);
										}
		                    			 
		                    		}elseif ($v_agentlevel == 3) {
		                    			$query12 = "SELECT id,CONCAT(agent_name,' / ',agent_id) FROM cc_agent_profile WHERE agent_level = 2 AND STATUS = 1";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												if ($spv_id == "") {
													$ownpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";		
												}else{
													if ($spv_id == $row12[0]) {
														$ownpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";	
													}
												}
											}
											mysqli_free_result($result12);
										} 
		                    		}
		                    		 	 
		                    		// 
		                    		  
					                  $ownpicker .= "</SELECT>";
		                    		
		                    		$txtlabel[$x]      = "Feedback Assign";
			                    	$bodycontent[$x]   = $ownpicker;
			                    	$x++;


			                    	$spvpicker = "<SELECT id=\"spv_id\" name=\"spv_id\" class=\"select2 form-control\">  ";
		                    		if ($v_agentlevel == 1) {
			                    		if ($spv_id == '') {
				                    		$spvpicker .= "<option value=\"0\">No SPV</option>";	
			                    		}
		                    			$query12 = "SELECT id,CONCAT(agent_name,' / ',agent_id) FROM cc_agent_profile WHERE agent_level = 2 AND STATUS = 1";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												if ($spv_id == "") {
													$spvpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";		
												}else{
													if ($spv_id == $row12[0]) {
														$spvpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";	
													}
												}
											}
											mysqli_free_result($result12);
										} 

		                    		}elseif ($v_agentlevel == 2) {
		                    			$query12 = "SELECT id,CONCAT(agent_name,' / ',agent_id) FROM cc_agent_profile WHERE id = '$v_agentid'";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												$spvpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";	
											}
											mysqli_free_result($result12);
										} 
		                    		}elseif ($v_agentlevel == 3) {
		                    			$query12 = "SELECT id,CONCAT(agent_name,' / ',agent_id) FROM cc_agent_profile WHERE agent_level = 2 AND STATUS = 1";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												if ($spv_id == "") {
													$spvpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";		
												}else{
													if ($spv_id == $row12[0]) {
														$spvpicker .= "<option value=\"".$row12[0]."\" >".$row12[1]."</option>";	
													}
												}
											}
											mysqli_free_result($result12);
										} 
		                    		}
		                    		 	 
		                    		// 
		                    		  
					                  $spvpicker .= "</SELECT>";
		                    		
		                    		$txtlabel[$x]      = "SPV Reference";
			                    	$bodycontent[$x]   = $spvpicker;
			                    	$x++;


		                    		echo label_form_det($txtlabel,$bodycontent,$x);
		                    	?>
		                    	
							</div>


					</div>
				</div>
			</div>

			<div class="card-action">
			<?php
			if ($iddet == '') {
				echo button_priv('1','1','0');
			}else{
				
				?>
					<button class="btn btn-warning" id="btnCancelForm" value="cancel"><i class="fas fa-backspace"></i>&nbsp;Cancel</button>
					<?php
						if ($setstatus == '0') {
							if ($schedule_time == "") {
								?>
									<a data-toggle="modal" onclick="document.getElementById('wisub').click();return false;" data-backdrop="false" data-target="#backdrop_last"><button class="btn btn-primary" value="cancel"><i class="fas fa-send"></i>&nbsp;Send Blast</button></a>

									<a onclick="confirmdelete();return false;"><button class="btn btn-danger" value="cancel"><i class="fas fa-trash"></i>&nbsp;Delete</button></a>
								<?php
							}
								
							//echo "<div class=\"btn btn-primary\" value=\"proces\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-send\"></i>&nbsp;&nbsp;&nbsp;Send Blast</div></a><br /><br />";
						}
					?>

					
				<?php
				//echo button_priv('0','1','0');
			}
			?>
		</div>
	</div>
	<div class="col-md-8">
			<div class="card">
				<div style="margin:10px 10px 10px 10px;">
					<div>
							<div class="form-body">	
							<div class="card-head-row">
								<div class="card-title">
									<?php
										$txttitle	= "Body Message & Participants";
			                    		$icofrm	  = "fas fa-list-ul";
			                    		echo title_form_det($txttitle,$icofrm);	
			                    	?>
		                    	</div>
		                    	<script type="text/javascript">
		                    		function inspectMe(nophone,id,name){
		                    			var blastid = '<?php echo $iddet ?>';
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_participant&username=' + encodeURI(nophone) + '&userid=' + encodeURI(id) + "&usercontactname=" + encodeURI(name)  + "&idblast=" + blastid  + "&agent_id=<?php echo $v_agentid ?>",
                                            success:function(html){
                                                viewlist();
                                            }
                                        });
		                    		}
		                    		function delete_ok(id){
		                    			var blastid = '<?php echo $iddet ?>';
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_participant_del&id=' + id,
                                            success:function(html){
                                                viewlist();
                                            }
                                        });
		                    		}
		                    		function run_process(){
		                    			var blastid = '<?php echo $iddet ?>';
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_process&id=' + blastid,
                                            success:function(html){
                                                //viewlist();
                                                swal({ icon: "success",title: "Success", type: 'success',  text: "Data Processed",   timer: 1000,   showConfirmButton: false });
                                                viewlist(); 
                                                location.reload();
                                                 
                                            }
                                        });
		                    		}

		                    		function run_endblast(t){
		                    			$('#backdrop_last').modal('hide');
		                    			swal({ icon: "success",title: "Success", type: 'success',  text: t,   timer: 1000,   showConfirmButton: false });

		                    			var blastid = '<?php echo $iddet ?>';
		                    			var close_date = $('#close_date').val();
		                    			var close_time = $('#close_time').val();
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_endprocess&id=' + blastid + '&t=' + t + '&close_date=' + close_date + '&close_time=' + close_time,
                                            success:function(html){
                                                //viewlist();
                                                swal({ icon: "success",title: "Success", type: 'success',  text: html,   timer: 1000,   showConfirmButton: false });
                                                location.reload();
                                                 
                                            }
                                        });
		                    		}
		                    		function run_confirmdelete(){
		                    			var blastid = '<?php echo $iddet ?>';
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_deletet&id=' + blastid,
                                            success:function(html){
                                                //viewlist();
                                                swal({ icon: "success",title: "Success", type: 'success',  text: html,   timer: 1000,   showConfirmButton: false });
                                                document.location = "index.php?v=c29zbWVkfHNvc21lZF9ibGFzdF9saXN0fEJsYXN0fDMxOHx8Nzd8MjAyNC0wNC0yMyAtIDIwMjQtMDQtMjM7MDs7Ozs7Ozs7Ozs7MA==";
                                                 
                                            }
                                        });
		                    		}
		                    		function confirmdelete(){
		                    			swal({
		                                    title: 'Are you sure want to Delete this?',
		                                    text: "It will remove all participant information which consumes your daily quotas",
		                                    type: 'warning',
		                                    buttons:{
		                                        confirm: {
		                                            text : 'Yes',
		                                            className : 'btn btn-success'
		                                        },
		                                        cancel: {
		                                            visible: true,
		                                            className: 'btn btn-danger'
		                                        }
		                                    }
		                                }).then((Save) => {
		                                    if (Save) {
		                                         run_confirmdelete();
		                                    }
		                                });
		                    		}
		                    		
		                    		function conf_endblast(t){
		                    			swal({
		                                    title: 'Are you sure want to Execute this Blast for that Participants?',
		                                    text: "",
		                                    type: 'warning',
		                                    buttons:{
		                                        confirm: {
		                                            text : 'Yes',
		                                            className : 'btn btn-success'
		                                        },
		                                        cancel: {
		                                            visible: true,
		                                            className: 'btn btn-danger'
		                                        }
		                                    }
		                                }).then((Save) => {
		                                    if (Save) {
		                                         run_endblast(t);
		                                    } else {
		                                        swal.close();
		                                        $('#backdrop_last').modal('hide');
		                                    }
		                                });
		                    		}

		                    		function conf_process(){
		                    			swal({
		                                    title: 'Are you sure want to Execute this Blast for that Participants?',
		                                    text: "",
		                                    type: 'warning',
		                                    buttons:{
		                                        confirm: {
		                                            text : 'Yes',
		                                            className : 'btn btn-success'
		                                        },
		                                        cancel: {
		                                            visible: true,
		                                            className: 'btn btn-danger'
		                                        }
		                                    }
		                                }).then((Save) => {
		                                    if (Save) {
		                                         run_process();
		                                    } else {
		                                        swal.close();
		                                    }
		                                });
		                    		}
		                    		function conf_delete(id){
		                    			swal({
		                                    title: 'Are you sure want to Delete this participant info in Blastlist?',
		                                    text: "",
		                                    type: 'warning',
		                                    buttons:{
		                                        confirm: {
		                                            text : 'Yes',
		                                            className : 'btn btn-success'
		                                        },
		                                        cancel: {
		                                            visible: true,
		                                            className: 'btn btn-danger'
		                                        }
		                                    }
		                                }).then((Save) => {
		                                    if (Save) {
		                                         delete_ok(id);
		                                    } else {
		                                        swal.close();
		                                    }
		                                });
		                    		}
		                    		function breakdown_pariticipant(id){
		                    			var participants = document.getElementsByClassName('participants');
		                    			for (var i = participants.length - 1; i >= 0; i--) {
		                    				participants[i].innerHTML = "";
		                    			}

		                    			document.getElementById('participant_' + id).innerHTML = "<img src=\"assets/img/fbloading.gif\" width=\"30px\" />";
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=sosmed_outboxinfo&channel=<?php echo $channel ?>&id=' + id,
                                            success:function(html){
                                            	if (html == '') {
                                            		document.getElementById('participant_' + id).innerHTML = "<center>No response</center>";	
                                            	}else{
                                            		html = JSON.parse(html);
                                            		if (typeof html.data !== 'undefined') {
                                            			var vtemp = "";
                                            			vtemp = vtemp + "<table width=\"100%\">";
                                            			/*vtemp = vtemp + "<tr>";
                                            			vtemp = vtemp + "<td style=\"padding:10px;color:white\" width=\"30px\" rowspan=\"100\"></td>";
                                            			vtemp = vtemp + "<td class=\"headerClass\" style=\"padding:10px;color:white\">Status</td>";
                                            			vtemp = vtemp + "<td class=\"headerClass\" style=\"padding:10px;color:white\">Description</td>";
                                            			vtemp = vtemp + "<td class=\"headerClass\" style=\"padding:10px;color:white\">Log Time</td>";
                                            			vtemp = vtemp + "</tr>";*/
                                            			for (var i =0;i< html.data.length;i++) {
                                            				if (html.data[i].message_status == 0) {
                                            					setstatus = "Waiting";
                                            				}else if (html.data[i].message_status == 1) {
                                            					setstatus = "Success";
                                            				}else if (html.data[i].message_status == 2) {
                                            					setstatus = "Failed";
                                            				}else{
                                            					setstatus = "Unknown";
                                            				}

                                            				vtemp = vtemp + "<tr>";
                                            				vtemp = vtemp + "<td style=\"width:75px\"></td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left\">Status</td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left\">" + setstatus + "</td>";
                                            				vtemp = vtemp + "</tr>";
                                            				vtemp = vtemp + "<tr>";
                                            				vtemp = vtemp + "<td style=\"width:75px\"></td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left\">Description</td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left\">" + html.data[i].message_respon + "</td>";
                                            				vtemp = vtemp + "</tr>";
                                            				vtemp = vtemp + "<tr>";
                                            				vtemp = vtemp + "<td style=\"width:75px\"></td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left;vertical-align:top\">Log</td>";
                                            				vtemp = vtemp + "<td style=\"text-align:left\">";

                                            				var vtb = "<table>";
                                            				vtb = vtb + "<tr><td style=\"text-align:left\">Request Sent </td><td style=\"text-align:right\"> " + html.data[i].message_time + "</td></tr>";
                                            				

                                            				if (typeof html.data[i].ack !== 'undefined') {
                                            					for (var j =0;j< html.data[i].ack.length;j++) {
	                                            					vtb = vtb + "<tr><td style=\"text-align:left\">" + html.data[i].ack[j].status + "</td><td style=\"text-align:right\">" + html.data[i].ack[j].message_time + "</td></tr>";
                                            					}
                                            					
	                                            				//vtb = vtemp + "</tr>";
                                            				}
                                            				vtb = vtb + "</table>";
                                            				vtemp = vtemp + vtb;

                                            				vtemp = vtemp + "</td>";
                                            				vtemp = vtemp + "</tr>";
                                            				/*vtemp = vtemp + "<tr>";
                                            				if (html.data[i].message_status == 0) {
                                            					setstatus = "Waiting";
                                            				}else if (html.data[i].message_status == 1) {
                                            					setstatus = "Success";
                                            				}else if (html.data[i].message_status == 2) {
                                            					setstatus = "Failed";
                                            				}else{
                                            					setstatus = "Unknown";
                                            				}
	                                            			vtemp = vtemp + "<td>" + setstatus + "</td>";
	                                            			vtemp = vtemp + "<td>" + html.data[i].message_respon + "</td>";
	                                            			vtemp = vtemp + "<td>" + html.data[i].message_time + "</td>";
	                                            			vtemp = vtemp + "</tr>";*/
                                            			}
                                            			vtemp = vtemp + "</table><br /><br />";
                                            			document.getElementById('participant_' + id).innerHTML = vtemp;
                                            		}else{
                                            			document.getElementById('participant_' + id).innerHTML = "<center>No Sent Log available</center>";
                                            		}
                                            	}
												
                                            }
                                        });

		                    		}
		                    		function viewlist(){
		                    			document.getElementById('participant_info').innerHTML = "<br /><br /><br /><center><img src=\"assets/img/fbloading.gif\" width=\"30px\" /></center>";
		                    			var blastid = '<?php echo $iddet ?>';
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_participants&blastid=' + blastid,
                                            success:function(html){
                                            	var vtemp = "";
												vtemp = vtemp + '<table width="100%">';
												vtemp = vtemp + '<tr class="headerClass">';
												vtemp = vtemp + '<td style="color:white;padding:10px">No</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Source</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Customer Name</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Tahun</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Unit</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Contact</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Cabang</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Cusid</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Order no</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Label</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Produk</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Nominal Denda</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">DPD</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">No Polisi</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Jatuh Tempo</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Angsuran Ke-</td>';


												vtemp = vtemp + '<td style="padding:10px;cursor:pointer" width="100px" onclick=\"viewlist()\"><img src=\"assets/img/retrieve.png\" width=\"25px\" /></td>';
												vtemp = vtemp + '</tr>';
												

												if (html == "") {
													vtemp = vtemp + '<tr class="headerClass">';
													vtemp = vtemp + '<td colspan="4" style="padding:10px;text-align:center">Failed to retrieve Information</td>';
													vtemp = vtemp + '</tr>';
												}else{
													html = JSON.parse(html);
													if (typeof html.data !== 'undefined') {
													    for (var i =0;i< html.data.length;i++) {
													    	if (i%2==0) {
													    		clNm = "nave_even1";
													    	}else{
													    		clNm = "nave_odd1";
													    	}
													    	vtemp = vtemp + '<tr class=\"'+ clNm + '\">';
															vtemp = vtemp + '<td style="padding:10px;text-align:center">' + (i+1) + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].user_cometipe + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].usercontactname + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].tahun + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].unit + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].username + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].cabang + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].cusid + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].orderno + '</td>';

															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].label + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].produk + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].nominaldenda + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].dpd + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].nopolisi + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].jatuhtempo + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].angsuranke + '</td>';


															


															if (html.data[i].sent_status == null) {
																vtemp = vtemp + '<td style="padding:10px;text-align:center;cursor:pointer" onclick="conf_delete(\'' + html.data[i].id + '\')"><i class=\"fas fa-trash\"></i></td>';
															}else{
																if (html.data[i].sent_status == '0') {
																	vtemp = vtemp + '<td style="padding:10px;text-align:center;cursor:pointer"><i class=\"fas fa-clock\"></i></td>';
																}else if (html.data[i].sent_status == '1') {
																	vtemp = vtemp + '<td onclick="breakdown_pariticipant(\'' + html.data[i].id + '\')" style="padding:10px;text-align:center;cursor:pointer"><i class=\"fab fa-get-pocket\"></i></td>';
																}else if (html.data[i].sent_status == '2') {
																	vtemp = vtemp + '<td style="padding:10px;text-align:center;cursor:pointer"><i class=\"fas fa-window-close\"></td>';
																}
															}
															vtemp = vtemp + '</tr>';
															vtemp = vtemp + '<tr class=\"'+ clNm + '\">';
															vtemp = vtemp + '<td colspan="7" id="participant_' + html.data[i].id + '" class="participants"></td>';
															vtemp = vtemp + '</tr>';
													    }
													}else{
														vtemp = vtemp + '<tr>';
														vtemp = vtemp + '<td colspan="19" style="padding:10px;text-align:center">No participant data available</td>';
														vtemp = vtemp + '</tr>';
													}
												}
												vtemp = vtemp + '</table>';

												document.getElementById('participant_info').innerHTML = vtemp;
                                            }
                                        });
		                    		}
		                    		function pick_customerpush_wom_manual(){
		                    			var channel 			= document.getElementById('channel').value;
                                        var source 				= $("#direction").val();
                                        var man_name 			= $("#man_name").val();
                                        var man_wa 				= $("#man_wa").val();
                                        var man_tahun 			= $("#man_tahun").val();
                                        var man_unit 			= $("#man_unit").val();
                                        var man_cabang 			= $("#man_cabang").val();
                                        var man_cusid 			= $("#man_cusid").val();
                                        var man_orderno 		= $("#man_orderno").val();
                                        var man_label 			= $("#man_label").val();
                                        var man_produk 			= $("#man_produk").val();
                                        var man_nominaldenda 	= $("#man_nominaldenda").val();
                                        var man_dpd 			= $("#man_dpd").val();
                                        var man_nopolisi 		= $("#man_nopolisi").val();
                                        var man_jatuhtempo 		= $("#man_jatuhtempo").val();
                                        var man_angsuranke 		= $("#man_angsuranke").val();
                                        if (man_name == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Name / Initial are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_wa == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Phone No are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_tahun == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Tahun Unit are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_unit == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Unit are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_cabang == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Cabang are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_cusid == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "CusID are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_orderno == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Order No are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_label == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Label are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_produk == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Produk are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_nominaldenda == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Nominal Denda are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_dpd == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "DPD are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_nopolisi == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "No Polisi are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_jatuhtempo == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Jatuh tempo are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_angsuranke == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Angsuran ke are required",   timer: 1000,   showConfirmButton: false });
                                        }else{
                                        	if (man_wa.substr(0, 2) != '62') {
                                        		swal({ title: "Ops!", type: "error",  text: "WhatsApp No Must be started from 62 instead 0",   timer: 1000,   showConfirmButton: false });
                                        	}else{
                                        		$.ajax({
		                                            type:'GET',
		                                            url:'service/sosmed/chat.php',
		                                            data:'action=blast_addcust_wom_manual&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>&man_name=' + encodeURI(man_name) + '&man_wa='+ encodeURI(man_wa) + '&man_tahun='+ encodeURI(man_tahun) + '&man_unit=' + encodeURI(man_unit) + '&man_cabang=' + encodeURI(man_cabang) + '&man_cusid=' + encodeURI(man_cusid)  + '&man_orderno=' + encodeURI(man_orderno)  + '&man_label=' + encodeURI(man_label)  + '&man_produk=' + encodeURI(man_produk)  + '&man_nominaldenda=' + encodeURI(man_nominaldenda)  + '&man_dpd=' + encodeURI(man_dpd)  + '&man_nopolisi=' + encodeURI(man_nopolisi)  + '&man_jatuhtempo=' + encodeURI(man_jatuhtempo)  + '&man_angsuranke=' + encodeURI(man_angsuranke) ,
		                                            success:function(html){
		                                            	if (html == 'Success!') {
			                                                document.getElementById('custdatta').click();
			                                                document.getElementById('man_name').value = "";
			                                                document.getElementById('man_wa').value = "";
			                                                document.getElementById('man_tahun').value = "";
			                                                document.getElementById('man_unit').value = "";
		                                            	}else{
		                                            		swal({ title: "Ops!", type: "error",  text: html,   timer: 1000,   showConfirmButton: false });
		                                            	}
		                                            }
		                                        });
                                        	}
                                        }
		                    		}
		                    		function pick_customerpush(keyword){
		                    			var channel = document.getElementById('channel').value;
                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpCustCkk','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist&keyword=' + keyword + '&channel=' + channel + "&source=" + source,
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);
                                            }
                                        });

                                        return false;
		                    		}

		                    		function blast_summariesinfo(){
		                    			document.getElementById('blast_summaries').innerHTML = "Loading...";
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=blast_summariesinfo&blastid=<?php echo $iddet ?>',
                                            success:function(html){
                                                document.getElementById('blast_summaries').innerHTML = html
                                            }
                                        });
		                    		}
		                    		function finsert(app,t){
		                    			if (t == '') {
		                    				swal({ title: "Ops!", type: "error",  text: "No data available",   timer: 1000,   showConfirmButton: false });
		                    			}else{
		                    				$.ajax({
	                                            type:'POST',
	                                            url:'service/sosmed/chat.php?action=blast_addcust_wom&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>&app=' + app,
	                                            data: { data: t }
										    }).done(function( msg ) {
										        //var msg = JSON.parse(msg);
										        swal('Request proceed', "", "success");
										        document.getElementById('custdatta').click();
										    }).fail(function( jqXHR, textStatus ) {
										        swal('Error!', "Check your network or connectifity", "error");
										        document.getElementById('custdatta').click();
										    });

		                    			}
			                    			

		                    			
		                    		}

		                    		function push_blastparam(){
		                    			var data_header = [];
		                    			var param_header = document.getElementsByClassName('param_header');
		                    			for (var i = 0; i < param_header.length; i++) {
		                    				data_header[i] = param_header[i].value;
		                    			}

		                    			data_body = [];
		                    			var param_body = document.getElementsByClassName('param_body');
		                    			for (var i = 0; i < param_body.length; i++) {
		                    				data_body[i] = param_body[i].value;
		                    			}
		                    			var Jsonheader = btoa(JSON.stringify(data_header));
		                    			var Jsonbody = btoa(JSON.stringify(data_body));
		                    			$.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:"action=push_blastparam&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>&Jsonheader=" + encodeURI(Jsonheader) + "&Jsonbody=" + encodeURI(Jsonbody) ,
                                            success:function(html){
                                            	 location.reload();
                                            }
                                        });
		                    		}
		                    		function pick_customerpush_wom(page,keyword){
		                    			var channel 			= 25;
		                    			var cmb_callstatus 		= $('#cmb_callstatus').val();
		                    			var cmb_region 			= $('#cmb_region').val();
		                    			var cmb_cabang 			= $('#cmb_cabang').val();
		                    			var cmb_labelpriority 	= $('#cmb_labelpriority').val();
		                    			var input_lastcall 		= $('#input_lastcall').val();
		                    			var input_lastwa 		= $('#input_lastwa').val();
		                    			var account 			= $('#account').val();
		                    			var input_totalrow      = $('#input_totalrow').val();

                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpcustWOM','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist_wom&page=' + page + '&totalrow=' + encodeURI(input_totalrow) + '&keyword=' + encodeURI(keyword) + '&channel=' + channel + "&source=" + account  + "&cmb_callstatus=" + encodeURI(cmb_callstatus) + "&cmb_cabang=" + encodeURI(cmb_cabang) + "&input_lastwa=" + encodeURI(input_lastwa) + "&cmb_region=" + encodeURI(cmb_region) + "&cmb_labelpriority=" + encodeURI(cmb_labelpriority) + "&input_lastcall=" + encodeURI(input_lastcall) + "&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>" ,
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);

                                               /*$('#cabang').select2({
										        theme: "bootstrap",
										        placeholder: "--- select type asset ---",
										        multiple: true
										      });*/
                                            }
                                        });

                                        return false;
		                    		}

		                    		function pick_customerpush_wom_telecollection(page,keyword){
		                    			var channel 				= 25;
		                    			var cmb_callstatus 			= $('#cmb_callstatus2').val();
		                    			var cmb_region 				= $('#cmb_region2').val();
		                    			var cmb_cabang 				= $('#cmb_cabang2').val();
		                    			var cmb_labelpriority 		= $('#cmb_labelpriority2').val();
		                    			var input_lastcall 			= $('#input_lastcall2').val();
		                    			var input_lastwa 			= $('#input_lastwa2').val();
		                    			var account 				= $('#account2').val();
		                    			var input_totalrow      	= $('#input_totalrow2').val();

		                    			var cmb_dpd_from 			= $('#cmb_dpd_from2').val();
		                    			var cmb_dpd_to 			= $('#cmb_dpd_to2').val();

		                    			var cmb_nominaldenda_from 	= $('#cmb_nominaldenda_from2').val();
		                    			var cmb_nominaldenda_to 	= $('#cmb_nominaldenda_to2').val();
		                    			var input_jatuhtempo 		= $('#input_jatuhtempo2').val();

                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpcustWOM','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist_wom_telecollection&page=' + page + '&totalrow=' + encodeURI(input_totalrow) + '&keyword=' + encodeURI(keyword) + '&channel=' + channel + "&source=" + account  + "&cmb_callstatus=" + encodeURI(cmb_callstatus) + "&cmb_cabang=" + encodeURI(cmb_cabang) + "&input_lastwa=" + encodeURI(input_lastwa) + "&cmb_region=" + encodeURI(cmb_region) + "&cmb_labelpriority=" + encodeURI(cmb_labelpriority) + "&input_lastcall=" + encodeURI(input_lastcall) + "&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>"  + "&cmb_dpd_from=" + encodeURI(cmb_dpd_from) + "&cmb_dpd_to=" + encodeURI(cmb_dpd_to) + "&cmb_nominaldenda_from=" + encodeURI(cmb_nominaldenda_from) + "&cmb_nominaldenda_to=" + encodeURI(cmb_nominaldenda_to) + "&input_jatuhtempo=" + encodeURI(input_jatuhtempo),
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);

                                               /*$('#cabang').select2({
										        theme: "bootstrap",
										        placeholder: "--- select type asset ---",
										        multiple: true
										      });*/
                                            }
                                        });

                                        return false;
		                    		}


		                    		function pick_customerpush_wom_teleremedial(page,keyword){
		                    			var channel 			= 25;
		                    			var cmb_callstatus 		= $('#cmb_callstatus3').val();
		                    			var cmb_region 			= $('#cmb_region3').val();
		                    			var cmb_cabang 			= $('#cmb_cabang3').val();
		                    			var cmb_labelpriority 	= $('#cmb_labelpriority3').val();
		                    			var input_lastcall 		= $('#input_lastcall3').val();
		                    			var input_lastwa 		= $('#input_lastwa3').val();
		                    			var account 			= $('#account3').val();
		                    			var input_totalrow      = $('#input_totalrow3').val();

                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpcustWOM','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist_wom_teleremedial&page=' + page + '&totalrow=' + encodeURI(input_totalrow) + '&keyword=' + encodeURI(keyword) + '&channel=' + channel + "&source=" + account  + "&cmb_callstatus=" + encodeURI(cmb_callstatus) + "&cmb_cabang=" + encodeURI(cmb_cabang) + "&input_lastwa=" + encodeURI(input_lastwa) + "&cmb_region=" + encodeURI(cmb_region) + "&cmb_labelpriority=" + encodeURI(cmb_labelpriority) + "&input_lastcall=" + encodeURI(input_lastcall) + "&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>" ,
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);

                                               /*$('#cabang').select2({
										        theme: "bootstrap",
										        placeholder: "--- select type asset ---",
										        multiple: true
										      });*/
                                            }
                                        });

                                        return false;
		                    		}

		                    		function pick_customerpush_wom_telesales(page,keyword){
		                    			var channel 			= 25;
		                    			var cmb_callstatus 		= $('#cmb_callstatus4').val();
		                    			var cmb_region 			= $('#cmb_region4').val();
		                    			var cmb_cabang 			= $('#cmb_cabang4').val();
		                    			var cmb_labelpriority 	= $('#cmb_labelpriority4').val();
		                    			var input_lastcall 		= $('#input_lastcall4').val();
		                    			var input_lastwa 		= $('#input_lastwa4').val();
		                    			var account 			= $('#account4').val();
		                    			var input_totalrow      = $('#input_totalrow4').val();

                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpcustWOM','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist_wom_telesales&page=' + page + '&totalrow=' + encodeURI(input_totalrow) + '&keyword=' + encodeURI(keyword) + '&channel=' + channel + "&source=" + account  + "&cmb_callstatus=" + encodeURI(cmb_callstatus) + "&cmb_cabang=" + encodeURI(cmb_cabang) + "&input_lastwa=" + encodeURI(input_lastwa) + "&cmb_region=" + encodeURI(cmb_region) + "&cmb_labelpriority=" + encodeURI(cmb_labelpriority) + "&input_lastcall=" + encodeURI(input_lastcall) + "&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>" ,
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);

                                               /*$('#cabang').select2({
										        theme: "bootstrap",
										        placeholder: "--- select type asset ---",
										        multiple: true
										      });*/
                                            }
                                        });

                                        return false;
		                    		}

		                    		function pick_customerpush_wom_telekonfirmasi(page,keyword){
		                    			var channel 			= 25;
		                    			var cmb_callstatus 		= $('#cmb_callstatus5').val();
		                    			var cmb_region 			= $('#cmb_region5').val();
		                    			var cmb_cabang 			= $('#cmb_cabang5').val();
		                    			var cmb_labelpriority 	= $('#cmb_labelpriority5').val();
		                    			var input_lastcall 		= $('#input_lastcall5').val();
		                    			var input_lastwa 		= $('#input_lastwa5').val();
		                    			var account 			= $('#account5').val();
		                    			var input_totalrow      = $('#input_totalrow5').val();

                                        var source = $("#direction").val();
                                        var output = "Loading information...";
                                        var OpenWindow = window.open('','popUpcustWOM','height=500px,width=1100px,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
                                        OpenWindow.dataFromParent = output; 
                                        OpenWindow.document.body.innerHTML = "";
                                        OpenWindow.document.write(output);
                                        $.ajax({
                                            type:'GET',
                                            url:'service/sosmed/chat.php',
                                            data:'action=customerlist_wom_telekonfirmasi&page=' + page + '&totalrow=' + encodeURI(input_totalrow) + '&keyword=' + encodeURI(keyword) + '&channel=' + channel + "&source=" + account  + "&cmb_callstatus=" + encodeURI(cmb_callstatus) + "&cmb_cabang=" + encodeURI(cmb_cabang) + "&input_lastwa=" + encodeURI(input_lastwa) + "&cmb_region=" + encodeURI(cmb_region) + "&cmb_labelpriority=" + encodeURI(cmb_labelpriority) + "&input_lastcall=" + encodeURI(input_lastcall) + "&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>" ,
                                            success:function(html){
                                                output = html;
                                                OpenWindow.document.body.innerHTML = "";
                                                OpenWindow.document.write(output);

                                               /*$('#cabang').select2({
										        theme: "bootstrap",
										        placeholder: "--- select type asset ---",
										        multiple: true
										      });*/
                                            }
                                        });

                                        return false;
		                    		}
		                    		function setAdditional(tujuan){
		                    			document.getElementById('breakdown_chat').style.display = "none";
		                    			document.getElementById('breakdown_nochat').style.display = "none";
		                    			document.getElementById(tujuan).style.display = "";
		                    		}
		                    	</script>
		                    	<style>
		                    		.headerClass{
		                    			<?php echo $gradientNave ?>
		                    		}
		                    		.nave_even1{
		                    			background:<?php echo $nave_even1 ?>
		                    		}
		                    		.nave_odd1{
		                    			background:<?php echo $nave_odd1 ?>
		                    		}
		                    	</style>
							</div>	
		                    		<?php

		                    			if ($iddet == "") {
		                    				echo "<center><br /><br /><br />Participant Information will be shown once Blast Information saved<br /><br /><br /></center>";
		                    			}else{
		                    				
		                    				?>
		                    					<script type="text/javascript">
		                    						function showpage(t){
		                    							var blast_content= document.getElementsByClassName('blast_content');
		                    							for (var i = blast_content.length - 1; i >= 0; i--) {
		                    								blast_content[i].style.display = "none";
		                    							}
		                    							document.getElementById(t).style.display = "";
			                    						if (t == 'blast_add') {
			                    							document.getElementById('tabber_custcontact').click();
			                    						}
		                    						}
		                    						function showpage2(t){
		                    							var custcontact= document.getElementsByClassName('custcontact');
		                    							for (var i = custcontact.length - 1; i >= 0; i--) {
		                    								custcontact[i].style.display = "none";
		                    								console.log(i);
		                    							}

		                    							document.getElementById(t).style.display = "";
		                    						}
		                    						showpage('blast_parameters');
		                    					</script>
		                    				<?php
		                    				echo "<div class=\"page-navs mb-4\">
					                                <div class=\"nav-scroller\">
					                                    <div class=\"nav nav-tabs nav-line nav-color-secondary\">
					                                        <a class=\"nav-link active show\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage('blast_summaries');blast_summariesinfo()\">
					                                            Summary
					                                        </a>
					                                        <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage('blast_parameters')\">
					                                            Parameters
					                                        </a>
					                                        <a class=\"nav-link\" data-toggle=\"tab\" id=\"custdatta\" style=\"cursor:pointer\" onclick=\"showpage('blast_destination');viewlist();\">
					                                            Customer Data
					                                        </a>";
					                                        if ($setstatus == '0') {
					                                        	if ($schedule_time == '') {
							                                        echo "<a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage('blast_add')\">
							                                            Add Destination
							                                        </a>";
					                                        	}

					                                        }
					                                    echo "</div>
					                                </div>
					                            </div>

					                            <div id=\"blast_summaries\" class=\"blast_content\" style=\"padding:10px 35px\">
					                            	 
					                            </div>
					                            <div id=\"blast_destination\" class=\"blast_content\" style=\"padding:10px 35px\">
					                            	
					                    			<div id=\"participant_info\" style=\"max-height: 800px;overflow-y: auto;\">
			                    			
						                    		</div>";
						                    		
						                    			/*if ($setstatus != 1) {
						                    				?>
									                    		<br /><br />
									                    		<div class="btn btn-success" id="btnAddParticipant" value="proces" onclick="pick_customerpush('');return false" style="width: 100%;margin-bottom:2px"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Add Participant</div>
									                    		<div class="btn btn-success" id="btnAddParticipant" value="proces" onclick="pick_customerpush_wom('0','');return false" style="width: 100%;margin-bottom:2px"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Add Participant (WOM)</div>
									                    		<div class="btn btn-success" id="btnSendBoardcast" value="proces" onclick="conf_process();return false" style="width: 100%;margin-bottom:2px"><i class="fab fa-telegram-plane"></i>&nbsp;&nbsp;&nbsp;Send Boardcast</div>
								                    		<?php
						                    			}*/
					                            echo "</div>


					                            <div id=\"blast_add\" class=\"blast_content\" style=\"padding:10px 35px\">
						                            <div class=\"page-navs mb-4\">
						                                <div class=\"nav-scroller\">
						                                    <div class=\"nav nav-tabs nav-line nav-color-secondary\" style=\"margin-top: -35px;\">
						                                        <!--a class=\"nav-link active show\" data-toggle=\"tab\" style=\"cursor:pointer\" id=\"tabber_custcontact\" onclick=\"showpage2('custcontact_default')\">
						                                            Customer Contact
						                                        </a-->
						                                        <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_teleupload');rpk()\" >
						                                            Teleupload Data
						                                        </a>";
						                               //if ($_GET['mode'] == 'es') {
						                                        	echo "<a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_telecollection');rpk2()\" >
									                                            Telecollection Data
									                                        </a>
									                                        <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_teleremedial');rpk3()\" >
									                                            Teleremedial Data
									                                        </a>
									                                        <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_telesales');rpk4()\" >
									                                            Telesales Data
									                                        </a>
									                                        <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_telekonfirmasi');rpk5()\" >
									                                            Task Konfirmasi
									                                        </a>";
						                                        //}         
						                               echo "  <a class=\"nav-link\" data-toggle=\"tab\" style=\"cursor:pointer\" onclick=\"showpage2('custcontact_manual')\">
						                                            Manual
						                                        </a>
						                                    </div>
						                                </div>
						                            </div>
						                            <div id=\"custcontact_default\" style=\"display:none\" class=\"custcontact\">
						                            default cari customer
						                            </div>
						                            <div id=\"custcontact_manual\" style=\"display:none\" class=\"custcontact\">
						                            	<table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Name / Initial
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_name\" placeholder=\"John Doe\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Phone No
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_wa\" placeholder=\"62XXXXXXXX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Unit
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_unit\" placeholder=\"YAMAHA XXXX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Tahun Unit
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_tahun\" placeholder=\"2024\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Cabang
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_cabang\" placeholder=\"DKI JA*****\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Cusid
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_cusid\" placeholder=\"P000001\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Order No
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_orderno\" placeholder=\"P000001\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Label
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_label\" placeholder=\"LABEL XXX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        PRODUK
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_produk\" placeholder=\"PRODUK XXXX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Nominal Denda
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_nominaldenda\" placeholder=\"5000000\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        DPD
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_dpd\" placeholder=\"P000001\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        No Polisi
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_nopolisi\" placeholder=\"234XX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Jatuh Tempo
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_jatuhtempo\" placeholder=\"27 AprXXXXX\" autocomplate=\"off\" />
											                    </td>
											                </tr>

											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Angsuran Ke-
											                    </td>
											                    <td>
											                       <input class=\"form-control\" style=\"width:100%\" type=\"text\" id=\"man_angsuranke\" placeholder=\"1\" autocomplate=\"off\" />
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom_manual();return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Insert Data</div>
						                            </div>
						                            
						                            <div id=\"custcontact_teleupload\" style=\"display:none\" class=\"custcontact\">
							                            <table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Status Call
											                    </td>
											                    <td>
											                        <select name=\"cmb_callstatus[]\" id=\"cmb_callstatus\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT a.call_status_id,a.id,CONCAT(b.call_status,' > ',a.call_status_sub1)  as caption
																				from cc_ts_call_status_sub1 a 
																				inner join cc_ts_call_status b on a.call_status_id = b.id
																				where a.status = 1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$callstatus 			= $row12[0];
																			$sub_callstatus 		= $row12[1];
																			$caption_callstatus 	= $row12[2];

																			echo "<option value=\"".$callstatus."|".$sub_callstatus."\">".$caption_callstatus."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Regional
											                    </td>
											                    <td>
											                        <select  name=\"cmb_region[]\" id=\"cmb_region\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT DISTINCT a.region from cc_teleupload_data a WHERE a.region IS NOT NULL AND a.region != ''";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$v_region_name 		= $row12[0];
																			echo "<option value=\"".$v_region_name."\">".$v_region_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Cabang
											                    </td>
											                    <td>
											                        <select  name=\"cmb_cabang[]\" id=\"cmb_cabang\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT DISTINCT a.cabang from cc_teleupload_data a WHERE a.cabang IS NOT NULL AND a.cabang != ''";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$office_name 		= $row12[0];
																			echo "<option value=\"".$office_name."\">".$office_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Label Priority
											                    </td>
											                    <td>
											                        <select  name=\"cmb_labelpriority[]\" id=\"cmb_labelpriority\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT id,label_desc from cc_teleupload_label_priority where label_status = 1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$label_id 			= $row12[0];
																			$label_desc 		= $row12[1];
																			echo "<option value=\"".$label_id."\">".$label_desc."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last Call
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastcall\" name=\"input_lastcall\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last WA
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastwa\" name=\"input_lastwa\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Total rows per-page
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" value=\"20\" id=\"input_totalrow\" name=\"input_totalrow\" >
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom('0','');return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Show Data</div>
										            </div>
					                            


					                            	<div id=\"custcontact_telecollection\" style=\"display:none\" class=\"custcontact\">
							                            <table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Status Call
											                    </td>
											                    <td>
											                        <select name=\"cmb_callstatus2[]\" id=\"cmb_callstatus2\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT 
																					b.status_id,b.id,CONCAT(a.call_status_name,' > ', '[' , b.call_result_code, '] ' , b.call_result_name)  as caption
																				FROM cc_telecollection_status a 
																				inner join cc_telecollection_result b on a.id = b.status_id
																				where 1=1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$callstatus 			= $row12[0];
																			$sub_callstatus 		= $row12[1];
																			$caption_callstatus 	= $row12[2];

																			echo "<option value=\"".$callstatus."|".$sub_callstatus."\">".$caption_callstatus."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Regional
											                    </td>
											                    <td>
											                        <select  name=\"cmb_region2[]\" id=\"cmb_region2\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT distinct region_name from cc_telecollection_cust_data";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$v_region_name 		= $row12[0];
																			echo "<option value=\"".$v_region_name."\">".$v_region_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Cabang</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_cabang2[]\" id=\"cmb_cabang2\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Label Priority</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_labelpriority2[]\" id=\"cmb_labelpriority2\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        
											                        echo "</select>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Nominal Denda
											                    </td>
											                    <td>
											                    	<table width=\"100%\">
											                    		<tr>
													                        <td style=\"width:50%;padding:0px;\">
													                        	<input type=\"number\" name=\"cmb_nominaldenda_from2\" id=\"cmb_nominaldenda_from2\" class=\"form-control\" style=\"width:100%;\" /><div style=\"margin-top:-1px;text-align:left\"><i>Min</i></div>
													                        </td>
													                        <td style=\"width:50%;padding:0px;\">
													                        <input type=\"number\" name=\"cmb_nominaldenda_to2\" id=\"cmb_nominaldenda_to2\" class=\"form-control\" style=\"width:100%;\" /><div style=\"margin-top:-1px;text-align:left\"><i>Max</i></div>
													                        </td>
											                    		</tr>
											                    	</table>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        DPD
											                    </td>
											                    <td>
											                    	<table width=\"100%\">
											                    		<tr>
													                        <td style=\"width:50%;padding:0px;\">
													                        	<input type=\"number\" name=\"cmb_dpd_from2\" id=\"cmb_dpd_from2\" class=\"form-control\" style=\"width:100%;\" /><div style=\"margin-top:-1px;text-align:left\"><i>Min</i></div>
													                        </td>
													                        <td style=\"width:50%;padding:0px;\">
													                        	<input type=\"number\" name=\"cmb_dpd_to2\" id=\"cmb_dpd_to2\" class=\"form-control\" style=\"width:100%;\" /><div style=\"margin-top:-1px;text-align:left\"><i>Max</i></div>
													                        </td>
											                    		</tr>
											                    	</table>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Jatuh Tempo
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_jatuhtempo2\" name=\"input_jatuhtempo2\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last Call
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastcall2\" name=\"input_lastcall2\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last WA
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastwa2\" name=\"input_lastwa2\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Total rows per-page
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" value=\"20\" id=\"input_totalrow2\" name=\"input_totalrow2\" >
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom_telecollection('0','');return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Show Data</div>
										            </div>
					                           

					                            	<div id=\"custcontact_teleremedial\" style=\"display:none\" class=\"custcontact\">
							                            <table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Status Call
											                    </td>
											                    <td>
											                        <select name=\"cmb_callstatus3[]\" id=\"cmb_callstatus3\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT 
																					b.status_id,b.id,CONCAT(a.call_status_name,' > ', '[' , b.call_result_code, '] ' , b.call_result_name)  as caption
																				FROM cc_telecollection_status a 
																				inner join cc_telecollection_result b on a.id = b.status_id
																				where 1=1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$callstatus 			= $row12[0];
																			$sub_callstatus 		= $row12[1];
																			$caption_callstatus 	= $row12[2];

																			echo "<option value=\"".$callstatus."|".$sub_callstatus."\">".$caption_callstatus."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Regional
											                    </td>
											                    <td>
											                        <select  name=\"cmb_region3[]\" id=\"cmb_region3\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT distinct region_name from cc_telecollection_cust_data";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$v_region_name 		= $row12[0];
																			echo "<option value=\"".$v_region_name."\">".$v_region_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Cabang</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_cabang3[]\" id=\"cmb_cabang3\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Label Priority</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_labelpriority3[]\" id=\"cmb_labelpriority3\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        
											                        echo "</select>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last Call
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastcall3\" name=\"input_lastcall3\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last WA
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastwa3\" name=\"input_lastwa3\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Total rows per-page
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" value=\"20\" id=\"input_totalrow3\" name=\"input_totalrow3\" >
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom_teleremedial('0','');return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Show Data</div>
										            </div>

										            <div id=\"custcontact_telesales\" style=\"display:none\" class=\"custcontact\">
							                            <table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Status Call
											                    </td>
											                    <td>
											                        <select name=\"cmb_callstatus4[]\" id=\"cmb_callstatus4\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT 
																					a.id,b.id,CONCAT(a.call_status,' > ',  b.call_status_sub1)  as caption
																				FROM cc_ts_call_status a 
																				inner join cc_ts_call_status_sub1 b on a.id = b.call_status_id
																				where 1=1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$callstatus 			= $row12[0];
																			$sub_callstatus 		= $row12[1];
																			$caption_callstatus 	= $row12[2];

																			echo "<option value=\"".$callstatus."|".$sub_callstatus."\">".$caption_callstatus."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Regional
											                    </td>
											                    <td>
											                        <select  name=\"cmb_region4[]\" id=\"cmb_region4\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT region_code,region_name from cc_master_region";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$v_region_code 		= $row12[0];
																			$v_region_name 		= $row12[1];
																			echo "<option value=\"".$v_region_code."\">".$v_region_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Cabang
											                    </td>
											                    <td>
											                        <select  name=\"cmb_cabang4[]\" id=\"cmb_cabang4\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";
											                            $query12 = "SELECT office_code,office_short_name,office_name from cc_master_cabang";
																		$result12 = mysqli_query($condb,$query12);
																		if ($result12) {
																			while ($row12 				= mysqli_fetch_row($result12)){
																				$v_cabang_code 		= $row12[0];
																				$v_cabang_short 	= $row12[1];
																				$v_cabang_name 		= $row12[2];
																				echo "<option value=\"".$v_cabang_code."\">[".$v_cabang_short."] ".$v_cabang_name."</option>";
																			}
																			mysqli_free_result($result12);
																		}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Label Priority</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_labelpriority4[]\" id=\"cmb_labelpriority4\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        
											                        echo "</select>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last Call
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastcall4\" name=\"input_lastcall4\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last WA
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastwa4\" name=\"input_lastwa4\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Total rows per-page
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" value=\"20\" id=\"input_totalrow4\" name=\"input_totalrow4\" >
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom_telesales('0','');return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Show Data</div>
										            </div>

										            <div id=\"custcontact_telekonfirmasi\" style=\"display:none\" class=\"custcontact\">
							                            <table width=\"100%\">
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Status Call
											                    </td>
											                    <td>
											                        <select name=\"cmb_callstatus5[]\" id=\"cmb_callstatus5\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT 
																					a.id,b.id,CONCAT(a.call_status,' > ',  b.call_status_sub1)  as caption
																				FROM cc_ts_call_status a 
																				inner join cc_ts_call_status_sub1 b on a.id = b.call_status_id
																				where 1=1";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$callstatus 			= $row12[0];
																			$sub_callstatus 		= $row12[1];
																			$caption_callstatus 	= $row12[2];

																			echo "<option value=\"".$callstatus."|".$sub_callstatus."\">".$caption_callstatus."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Regional
											                    </td>
											                    <td>
											                        <select  name=\"cmb_region5[]\" id=\"cmb_region5\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        $query12 = "SELECT region_name from cc_ts_konfirmasi where region_name != '' group by region_name";
																	$result12 = mysqli_query($condb,$query12);
																	if ($result12) {
																		while ($row12 				= mysqli_fetch_row($result12)){
																			$v_region_name 		= $row12[0];
																			echo "<option value=\"".$v_region_name."\">".$v_region_name."</option>";
																		}
																		mysqli_free_result($result12);
																	}  
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Cabang</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_cabang5[]\" id=\"cmb_cabang5\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";
											                            
											                        echo "</select>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        <strike>Label Priority</strike>
											                    </td>
											                    <td>
											                        <select  name=\"cmb_labelpriority5[]\" id=\"cmb_labelpriority5\" class=\"form-control select2\" style=\"width:100%;\" multiple>
											                            ";

											                        
											                        echo "</select>
											                    </td>
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last Call
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastcall5\" name=\"input_lastcall5\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Last WA
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" id=\"input_lastwa5\" name=\"input_lastwa5\" >
											                    </td>
											                </tr>
											                <tr>
											                    <td style=\"text-align:left;width:160px\">
											                        Total rows per-page
											                    </td>
											                    <td>
											                        <input type=\"text\" class=\"form-control formes expressSearch\" style=\"font-size:10px;width:180px;\" value=\"20\" id=\"input_totalrow5\" name=\"input_totalrow5\" >
											                    </td>
											                </tr>
											            </table>
											            <div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"pick_customerpush_wom_telekonfirmasi('0','');return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Show Data</div>
										            </div>
					                            </div>

					                            <div id=\"blast_parameters\" class=\"blast_content\" style=\"padding:10px 35px\">";
					                            
		                    				echo "<div style=\"padding:10px;background:#1572e8;color:white;font-weight:bold;\">You can use these words as subtitute :<br />👉&nbsp;&nbsp;[cust] for Customer Name<br />👉&nbsp;&nbsp;[unit] for Unit Information<br />👉&nbsp;&nbsp;[tahun_unit] for Tahun Unit Information <br />👉&nbsp;&nbsp;[cabang] for Cabang Information <br />👉&nbsp;&nbsp;[cusid] for Customer Identity <br />👉&nbsp;&nbsp;[orderno] for Order Number Information<br />👉&nbsp;&nbsp;[label] for Label Information<br />👉&nbsp;&nbsp;[produk] for Produk Information<br />👉&nbsp;&nbsp;[nominaldenda] for Nominal Denda Information<br />👉&nbsp;&nbsp;[dpd] for DPD Information<br />👉&nbsp;&nbsp;[nopolisi] for No Polisi Information<br />👉&nbsp;&nbsp;[jatuhtempo] for Jatuh Tempo Information<br />👉&nbsp;&nbsp;[angsuranke] for Angsuran Ke Information </div>";

		                    				$x = 0;

		                    				$query12 = "SELECT 
		                    								a.total_header_data,
		                    								a.total_body_data,
		                    								a.template_header_text,
		                    								a.template_body_text,
		                    								a.template_header_type 
		                    						  	FROM cc_wa_template a 
		                    						  	WHERE a.template_id = '$hsm_template'";
											$result12 = mysqli_query($condb,$query12);
											if ($result12) {
												while ($row12 				= mysqli_fetch_row($result12)){
													$total_header_data 		= $row12[0];
													$total_body_data 		= $row12[1];
													$template_header_text 	= str_replace('\n', "<br />", $row12[2]);
													$template_body_text 	= str_replace('\n', "<br />", $row12[3]);
													$template_body_text 	= nl2br($row12[3]);
													$template_header_type 	= $row12[4];

													$txtheader = "";
													$txtbody = "";
													for ($i=0; $i <$total_header_data ; $i++) { 
														$messagebody = "";
														
														$query12T = "SELECT column_value from cc_sosmed_blast_parameters where blast_id = '$iddet' and type = 'header' and column_no = '$i'";
														$result12T = mysqli_query($condb,$query12T);
														if ($result12T) {
															while ($row12T 				= mysqli_fetch_row($result12T)){
																$messagebody 			= $row12T[0];
															}
															mysqli_free_result($result12T);
														}  
														
														if ($template_header_type == 'image') {
															$txtheader .= "<div style=\"width:100%\"><div style=\"font-size:20px;width:60px;float:left;margin-bottom:-30px;text-align:center\">{{".($i+1)."}}</div><div style=\"float:left;width:100%;padding-left:70px;padding-right:50px\">".input_text_temp("header_".$i,"header_".$i,$messagebody,"","","param_header form-control border-primary","")."</div><div style=\"width: 50px;overflow: hidden;float: right;margin-top: -34px;\"><input style=\"opacity:0\" id=\"vupl".$i."\" name=\"vupl".$i."\" onchange=\"uplheader('".$i."')\" type=\"file\" /><div style=\"cursor:pointer;margin-top:-27px;float:left;border: 1px solid #1572e8;margin-left:3px;padding:4px 2px;\">".ucwords($template_header_type)."</div></div><div style=\"clear:both\"></div></div>";
														}else{
															$txtheader .= "<div style=\"width:100%\"><div style=\"font-size:20px;width:60px;float:left;margin-bottom:-30px;text-align:center\">{{".($i+1)."}}</div><div style=\"float:left;width:100%;padding-left:70px\">".input_text_temp("header_".$i,"header_".$i,$messagebody,"","","param_header form-control border-primary","")."</div><div style=\"clear:both\"></div></div>";
														}
							                    		
													}

													for ($i=0; $i <$total_body_data ; $i++) { 
														$query12T = "SELECT column_value from cc_sosmed_blast_parameters where blast_id = '$iddet' and type = 'body' and column_no = '$i'";
														$result12T = mysqli_query($condb,$query12T);
														if ($result12T) {
															while ($row12T 				= mysqli_fetch_row($result12T)){
																$messagebody 			= $row12T[0];
															}
															mysqli_free_result($result12T);
														}  

														$txtbody .= "<div style=\"width:100%\"><div style=\"font-size:20px;width:60px;float:left;margin-bottom:-30px;text-align:center\">{{".($i+1)."}}</div><div style=\"float:left;width:100%;padding-left:70px\">".input_text_temp("body_".$i,"body_".$i,$messagebody,"","","param_body form-control border-primary","")."</div><div style=\"clear:both\"></div></div>";
													}
													if ($txtheader == "") {
														$txtheader = "<i>No header message for this template</i>";
													}

													if ($txtbody == "") {
														$txtbody = "<i>No body message for this template</i>";
													}
													$txtlabel[$x]      = "Header Message";
						                    		$bodycontent[$x]   = "<div style=\"margin-bottom:8px;font-family:courier new;padding-left:20px\">".$template_header_text."</div>".$txtheader;
						                    		$x++;

						                    		$txtlabel[$x]      = "Body Message";
						                    		$bodycontent[$x]   = "<div style=\"margin-bottom:8px;font-family:courier new;padding-left:20px\">".$template_body_text."</div>".$txtbody;
						                    		$x++;

												}
												mysqli_free_result($result12);
											}  
		                    				

				                    		echo label_form_det($txtlabel,$bodycontent,$x);
				                    		if ($setstatus != '1') {
				                    			echo "<div class=\"btn btn-success\" id=\"btnAddParticipant\" value=\"proces\" onclick=\"push_blastparam();return false\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-user-plus\"></i>&nbsp;&nbsp;&nbsp;Apply</div>";
				                    		}

				                    		//if ($messagebody != '') {
				                    			
					                    			
									                    		
						                    	
				                    		//}
				                    		echo "</div>";
		                    			}

		                    		?>
		                    		
							</div>


					</div>
				</div>
			</div>
	</div>

		


</form>

<script type="text/javascript">
	function mshw(t){
		document.getElementById('kontenasi').style.display = "none";
		document.getElementById('kontenasi2').style.display = "none";

		document.getElementById(t).style.display = "";
	}
</script>
<div class="modal fade text-xs-left has-success" id="backdrop_last" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <form id="frmDataDet" name="frmDataDet">
        <input type="number" id="sourceData" name="sourceData" value="0" style="display:none" />

        <div class="modal-dialog" role="document" style="max-width:800px !important;border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px">
            <div class="modal-content" class="border border-primary">
                <div class="modal-header" style="background:#1572E8;color:white">
                    <h4 class="modal-title" id="myModalLabel4">Blast Confirmation</h4>
                </div>
                
                <div class="modal-body" style="background:white">
                    <div class="page-navs mb-4" style="margin-top:-20px;padding-left:0px">
                        <div class="nav-scroller">
                            <div class="nav nav-tabs nav-line nav-color-secondary">
                                <a class="nav-link active" id="wisub" data-toggle="tab" onclick="mshw('kontenasi')">
                                    Direct Blast
                                </a>
                                <a class="nav-link" id="wisub2" data-toggle="tab"  onclick="mshw('kontenasi2')">
                                    Schedule Blast
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="large-12 columns" id="kontenasi">
                    	<br /><br />
                    	<center>
                    		By click this button,<br />all the messages will be assign to be deliver to Participant data<br /><br />
                    		<div class="btn btn-primary" value="proces" style="width: 100%;margin-bottom:2px" onclick="conf_endblast('direct')"><i class="fas fa-send"></i>&nbsp;&nbsp;&nbsp;Send Blast</div>
                    	</center>
                    	<br /><br />
                    </div>
                    <div class="large-12 columns" id="kontenasi2">
                    	<br /><br />
                    	<center>
                    		By click this button,<br />all the messages will be assign to be deliver to Participant data<br /><br />
                    		<input type="date" id="close_date" value="<?php echo date('Y-m-d') ?>" class="form-control" />
                    		<input type="time" id="close_time" value="23:59:59" class="form-control" />
                    		<div class="btn btn-primary" value="proces" style="width: 100%;margin-bottom:2px" onclick="conf_endblast('scheduled')"><i class="fas fa-send"></i>&nbsp;&nbsp;&nbsp;Set Schedule Blast</div>
                    	</center>
                    	<br /><br />
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <div style="display:none">
                        <input type="text" id="push_channel"        value="" />
                        <input type="text" id="push_calltype"       value="" />
                        <input type="text" id="push_customer_id"    value="" />
                        <input type="text" id="push_customer_acc"   value="" />
                        <input type="text" id="push_template_acc"   value="" />
                        <input type="text" id="push_template_id"   value="" />
                        <input type="text" id="push_template_text"   value="" />
                        <input type="text" id="push_template_name"   value="" />
                        
                    </div>
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
                        
                </div>
        </div>
    </form>
</div>
<?php
disconnectDB($condb);
?>

<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- Sweet Alert -->
	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<!-- Bootstrap Toggle -->
	<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<!-- jQuery Scrollbar -->
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
	<!-- Select2 -->
	<script src="assets/js/plugin/select2/select2.full.min.js"></script>
	<!-- jQuery Validation -->
	<script src="assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>
	<!-- Bootstrap Tagsinput -->
	<script src="assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<!-- Atlantis JS -->
	<script src="assets/js/atlantis.min.js"></script>
	<script src="assets/js/setting.js"></script>

<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chart.js/chart.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script type="text/javascript" src="assets/js/plugin/jqvmap/maps/jquery.vmap.world.js" charset="utf-8"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/plugin/moment/moment.min.js"></script>
<script src="assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/atlantis.min.js"></script>

<link rel="stylesheet" type="text/css" href="assets/css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/datetime/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pickers/pickadate/pickadate.css">
    
    <script src="assets/js/plugin/pickers/dateTime/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/dateTime/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.date.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/picker.time.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/pickadate/legacy.js" type="text/javascript"></script>
    <script src="assets/js/plugin/pickers/daterange/daterangepicker.js" type="text/javascript"></script>

<script type="text/javascript">
function reload_imgheader() {
	//alert('ini');
	$.ajax({
	    url: "view/report/reporting_header_value.php?get_reload=1",
	    type: "post",
	    processData: false,
	    contentType: false,
	    success: function(d) {
	    	var warn = d;
	    	document.getElementById("img_view").src = warn;
	    }
	  });
}
function rpk(){
	$('#input_lastcall').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastwa').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});
}
function rpk2(){
	$('#input_jatuhtempo2').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastcall2').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastwa2').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});
}
function rpk3(){
	$('#input_lastcall3').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastwa3').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});
}

function rpk4(){
	$('#input_lastcall4').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastwa4').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});
}

function rpk5(){
	$('#input_lastcall5').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});

	$('#input_lastwa5').daterangepicker({
	    locale: {
	      format: 'YYYY-MM-DD'
	    },
	    	startDate: '<?php echo date('Y-m-d') ?>',
	    	endDate: '<?php echo date('Y-m-d') ?>'
	});
}


</script>

    <script lang="javascript">
	    var form = $( "#frmDataDet" );
		form.validate();

    $("#btnSaveForm").click(function(){ 
    	var fvalid = form.valid();
    	 if(fvalid==true){

    	swal({
						title: 'Are you sure want to save?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							 var data = new FormData();
							 var form_data = $('#frmDataDet').serializeArray();
							 $.each(form_data, function (key, input) {
							    data.append(input.name, input.value);
							 });

							

							 data.append('key', 'value');	
							
							 $.ajax({
						        url: "<?php echo $save_form; ?>",
						        type: "post",
						        data: data,
							    processData: false,
							    contentType: false,
						        success: function(d) {
						        	var warn = d;
					            	if(warn=="Success!") {
					            		var vtype = "success";
					            	} else {
										var vtype = "error";	
					            	}
						            
						            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: true });
						            if(warn=="Success") {
						            	//setTimeout(function(){history.back();}, 1500);
					            		//reload_imgheader();
					            		var alink= "<?php echo $ffolder;?>|<?php echo $fmenu_link_back;?>|<?php echo $fdescription;?>|<?php echo $fmenu_id;?>|<?php echo $ficon;?>|<?php echo $fiddet;?>|<?php echo $fblist;?>"
										var link = "index.php?v="+encodeURI(btoa(alink));
										<?php 
											if ($iddet == "") {
												?>
													window.location.href = link
												<?php
											}else{
												?>
													location.reload();
												<?php
											}

										?>
						            }
						        }
							  });
						} else {
							swal.close();
						}
					});
		}else{
			swal({ title: "Info!", type: "error",  text: "Please fill in all mandatory",   timer: 1000,   showConfirmButton: false });
		}			
        return false;
	}) 
	 $("#btnCancelForm").click(function(){
    	swal({
						title: 'Are you sure to return to the previous page?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							var alink= "<?php echo $ffolder;?>|<?php echo $fmenu_link_back;?>|<?php echo $fdescription;?>|<?php echo $fmenu_id;?>|<?php echo $ficon;?>|<?php echo $fiddet;?>|<?php echo $fblist;?>"
							var link = "index.php?v="+encodeURI(btoa(alink));
							window.location.href = link;
							//window.history.back();
						} else {
							swal.close();
						}
					});
        return false;
	})
	
    $("#btnDeleteForm").click(function(){
		var iddet = document.getElementById("iddet").value;

         swal({
						title: 'Are you sure want to delete?',
						text: "",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Save) => {
						if (Save) {
							 var data = new FormData();
							 var form_data = $('#frmDataDet').serializeArray();
							 $.each(form_data, function (key, input) {
							    data.append(input.name, input.value);
							 });

							 data.append('key', 'value');	
							
							 $.ajax({
						        url: "<?php echo $save_form; ?>?v=del&iddet="+iddet,
						        type: "post",
						        data: data,
							    processData: false,
							    contentType: false,
						        success: function(d) {
						        	var warn = d;
					            	if(warn=="Success") {
					            		var vtype = "success";
					            	} else {
										var vtype = "error";	
					            	}
						            swal({ title: "Save Data!", type: vtype,  text: warn,   timer: 1000,   showConfirmButton: false });
						            if(warn=="Success") {
						            	setTimeout(function(){history.back();}, 1500);
						            } 
						        }
							  });
						} else {
							swal.close();
						}
					});
        return false;    
	}) 
    </script>

<script type="text/javascript">
	$('.off_sunday_st').datetimepicker({
		format: 'H:mm:ss',
	});
	$('.off_sunday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_monday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_monday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_tuesday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_tuesday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_wednesday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_wednesday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_thursday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_thursday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_friday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_friday_en').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_saturday_st').datetimepicker({
		format: 'H:mm:ss',
	});

	$('.off_saturday_en').datetimepicker({
		format: 'H:mm:ss',
	});
	showpage('blast_summaries');blast_summariesinfo()
	
</script>