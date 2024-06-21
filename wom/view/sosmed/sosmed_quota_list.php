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

$ffolder		= $library['folder'];
$fmenu_link		= $library['menu_link'];
$fdescription	= $library['description'];
$fmenu_id		= $library['menu_id'];
$ficon			= $library['icon'];
$fiddet			= $library['iddet'];
$fblist			= $library['blist'];

$fmenu_link_back = "sosmed_quota_list";
    	
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

	$sqlv = "SELECT quota from cc_sosmed_blast_quota where agent_id = '$v_agentid'"; 
	$resv = mysqli_query($condb, $sqlv);
	if($recv = mysqli_fetch_array($resv)){
		$current_quota 			= $recv["quota"];
	} else {
		$current_quota        		= "0";
	}

//file save data
$save_form = "view/sosmed/sosmed_quota_save.php";

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
		        	
                                        

		                    		$chpicker = "<SELECT id=\"channel\" name=\"channel\" class=\"select2 form-control\">  ";
		                    		if ($channel == '') {
		                    			$chpicker .= "<option value=\"\" selected>WhatsApp</option>";
		                    		}
										$query12 = "SELECT CEIL(a.skill_feature/10) as idchannel,c.channel_descr as channelname
                                                    FROM cc_skill_feature a 
                                                    INNER JOIN cc_skill_agent b ON a.skill_id = b.skill_id AND b.agent_id = ".$v_agentid." AND a.skill_feature > 100
                                                    INNER JOIN cc_channel_desc c ON c.channel_id = CEIL(a.skill_feature/10)";
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
		                    		
		                    		$txtlabel[$x]      = "Current Quota";
		                    		$bodycontent[$x]   = input_text_readonly_temp("current_quota","current_quota",$current_quota,"","required","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Propose Quota";
		                    		$bodycontent[$x]   = input_number_temp("propose_quota","propose_quota",$current_quota,"","required","form-control border-primary");
		                    		$x++;

			                    	$txtlabel[$x]      = "Reason";
		                    		$bodycontent[$x]   = input_textarea_temp("reason","reason",$reason,"","required","form-control border-primary");
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
				echo button_priv('1','10','0');
			}else{
				echo "<a data-toggle=\"modal\" onclick=\"document.getElementById('wisub').click()\" data-backdrop=\"false\" data-target=\"#backdrop_last\"><div class=\"btn btn-primary\" value=\"proces\" style=\"width: 100%;margin-bottom:2px\"><i class=\"fas fa-send\"></i>&nbsp;&nbsp;&nbsp;Send Blast</div></a><br /><br />";
				echo button_priv('0','1','0');
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
										$txttitle	= "Logs";
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
                                                //location.reload();
                                                 
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
                                            				vtemp = vtemp + "<td style=\"text-align:left\">Request Sent on " + html.data[i].message_time + "<br />";
                                            				

                                            				if (typeof html.data[i].ack !== 'undefined') {
                                            					for (var j =0;j< html.data[i].ack.length;j++) {
	                                            					vtemp = vtemp + html.data[i].ack[j].status + " on " + html.data[i].ack[j].message_time + "<br />";
                                            					}
                                            					
	                                            				vtemp = vtemp + "</tr>";
                                            				}
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
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Customer Name</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Tahun</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Unit</td>';
												vtemp = vtemp + '<td style="color:white;padding:10px;text-align:left">Contact</td>';
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
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].usercontactname + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].tahun + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].unit + '</td>';
															vtemp = vtemp + '<td style="padding:10px;text-align:center;text-align:left">' + html.data[i].username + '</td>';
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
															vtemp = vtemp + '<td colspan="4" id="participant_' + html.data[i].id + '" class="participants"></td>';
															vtemp = vtemp + '</tr>';
													    }
													}else{
														vtemp = vtemp + '<tr>';
														vtemp = vtemp + '<td colspan="4" style="padding:10px;text-align:center">No participant data available</td>';
														vtemp = vtemp + '</tr>';
													}
												}
												vtemp = vtemp + '</table>';

												document.getElementById('participant_info').innerHTML = vtemp;
                                            }
                                        });
		                    		}
		                    		function pick_customerpush_wom_manual(){
		                    			var channel 	= document.getElementById('channel').value;
                                        var source 		= $("#direction").val();
                                        var man_name 	= $("#man_name").val();
                                        var man_wa 		= $("#man_wa").val();
                                        var man_tahun 	= $("#man_tahun").val();
                                        var man_unit 	= $("#man_unit").val();
                                        if (man_name == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Name / Initial are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_wa == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Phone No are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_tahun == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Tahun Unit are required",   timer: 1000,   showConfirmButton: false });
                                        }else if (man_unit == "") {
                                        	swal({ title: "Ops!", type: "error",  text: "Unit are required",   timer: 1000,   showConfirmButton: false });
                                        }else{
                                        	if (man_wa.substr(0, 2) != '62') {
                                        		swal({ title: "Ops!", type: "error",  text: "WhatsApp No Must be started from 62 instead 0",   timer: 1000,   showConfirmButton: false });
                                        	}else{
                                        		$.ajax({
		                                            type:'GET',
		                                            url:'service/sosmed/chat.php',
		                                            data:'action=blast_addcust_wom_manual&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>&man_name=' + encodeURI(man_name) + '&man_wa='+ encodeURI(man_wa) + '&man_tahun='+ encodeURI(man_tahun) + '&man_unit=' + encodeURI(man_unit) ,
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
		                    		function finsert(t){
		                    			if (t == '') {
		                    				swal({ title: "Ops!", type: "error",  text: "No data available",   timer: 1000,   showConfirmButton: false });
		                    			}else{
		                    				$.ajax({
	                                            type:'GET',
	                                            url:'service/sosmed/chat.php',
	                                            data:'action=blast_addcust_wom&data=' + encodeURI(t) + '&blastid=<?php echo $iddet ?>&agent_id=<?php echo $v_agentid ?>',
	                                            success:function(html){
	                                                document.getElementById('custdatta').click();
	                                            }
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
							<style type="text/css">
								th {
								    text-align: center;
								    height: 40px !important;
								    background: #1e69de;
								    background: -moz-linear-gradient(top, #1e69de 1%, #3690f0 47%, #3690f0 52%, #54a3ee 62%, #6db3f2 100%);
								    background: -webkit-linear-gradient(top, #1e69de 1%, #3690f0 47%, #3690f0 52%, #54a3ee 62%, #6db3f2 100%);
								    background: linear-gradient(to bottom, #1e69de 1%, #3690f0 47%, #3690f0 52%, #54a3ee 62%, #6db3f2 100%);
								    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e69de', endColorstr='#6db3f2',GradientType=0 );
								    color: white;
								    color: white;
								}
							</style>
							<table width="100%;" class="display table table-striped table-hover dataTable no-footer">
								<thead>
									<tr>
										<th>Current Quota</th>
										<th>Proposed Quota</th>
										<th>Reason</th>
										<th>Request time</th>
										<th colspan="3">Status</th>
									</tr>
								</thead>
								<tbody>
		                    		<?php
		                    			$jml = 0;
		                    			$query12 = "SELECT 
		                    							a.request_to,
		                    							a.request_from,
		                    							a.reason,
		                    							a.request_time,
		                    							a.status,
		                    							b.agent_name,
		                    							a.approved_time 
		                    						from cc_sosmed_blast_quota_det a 
		                    						left join cc_agent_profile b on a.approved_by = b.id
		                    						where a.agent_id = '$v_agentid'";
										$result12 = mysqli_query($condb,$query12);
										if ($result12) {
											while ($row12 			= mysqli_fetch_row($result12)){
												$request_to 		= $row12[0];
												$request_from 		= $row12[1];
												$reason 			= $row12[2];
												$request_time 		= $row12[3];
												$status 			= $row12[4];
												$approved_by 		= $row12[5];
												$approved_time 		= $row12[6];
												$jml++;
												?>
													<tr>
														<td><?php echo $request_from ?></td>
														<td><?php echo $request_to ?></td>
														<td><?php echo $reason ?></td>
														<td><?php echo $request_time ?></td>
														<?php
															if ($status == 0) {
																?>
																	<td colspan="3">Waiting</td>
																<?php
															}else{
																if ($status == 1) {
																	$vstatus = "Aproved";
																}else{
																	$vstatus = "Rejected";
																}
																?>
																	<td><?php echo $vstatus ?></td>
																	<td><?php echo $approved_by ?></td>
																	<td><?php echo $approved_time ?></td>
																<?php
															}
														?>
														
													</tr>
												<?php
											}
											mysqli_free_result($result12);
										} 
								?>
								</tbody>
									</table>
		                    		
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