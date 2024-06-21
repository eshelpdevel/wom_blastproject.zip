<?php
include "../../sysconf/con_reff.php";
include "../../sysconf/global_func.php";
include "../../sysconf/session.php";
include "../../sysconf/db_config.php";

$condb = connectDB();
$v_agentid      = get_session("v_agentid");
$v_agentlevel   = get_session("v_agentlevel");
$tbl_name 		= "cc_wa_webhook";
$iddet 			= $library['iddet'];

$ffolder		= $library['folder'];
$fmenu_link		= $library['menu_link'];
$fdescription	= $library['description'];
$fmenu_id		= $library['menu_id'];
$ficon			= $library['icon'];
$fiddet			= $library['iddet'];
$fblist			= $library['blist'];

$fmenu_link_back = "sosmed_distribution_list";
    	
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

	$sqlv = "SELECT b.channel_name,b.id as channel_id,a.* FROM cc_channel_desc a 
			 INNER JOIN cc_ticket_channel b ON a.channel_id = b.id
	         WHERE a.id = '$iddet' "; 
	$resv = mysqli_query($condb, $sqlv);
	if($recv = mysqli_fetch_array($resv)){
		$channel_name 			= $recv["channel_name"];
		$limit_distribution     = $recv["limit_distribution"];
		$delay_autoreply		= $recv["delay_autoreply"];
		$autoreply_while_busy   = $recv["autoreply_while_busy"];
		$autoreply_while_off    = $recv["autoreply_while_off"];
		$session_close     		= $recv["session_close"];
		$session_close_bot     	= $recv["session_close_bot"];
		$show_bot_answer 		= $recv["show_autoreply"];
		$aux_can_reply 			= $recv["aux_can_reply"];
		$channel_id 			= $recv["channel_id"];
		$autogreeting 			= $recv["autogreeting"];
		$autotransfering 		= $recv["autotransfering"];
		$show_transfersession 	= $recv["show_transfersession"];
		$autoclosing 			= $recv["autoclosing"];
		$autoclosing_bot 		= $recv["autoclosing_bot"];
		$resent 				= $recv["resent"];
		$draftpick 				= $recv["show_draft"];
		$auto_close 			= $recv["auto_close"];	
		$offclose 				= $recv["offclose"];	
		$queueinfo 				= $recv["queueinfo"];	
		$entertoSend 			= $recv["entertoSend"];
		$autogreeting_fromblast = $recv["autogreeting_fromblast"];
		$show_monitoring_botscript 			= $recv["show_monitoring_botscript"];	
		
	} else {
		$channel_name        	= "";
		$limit_distribution     = "";
		$delay_autoreply		= "";
		$autoreply_while_busy	= "";
		$autoreply_while_off    = "";
		$session_close     		= "";
		$session_close_bot 		= "";
		$show_bot_answer 		= "";
		$aux_can_reply 			= "";
		$channel_id 			= "";
		$autogreeting 			= "";
		$autotransfering 		= "";
		$show_transfersession 	= "";
		$autoclosing 			= "";
		$autoclosing_bot 		= "";
		$resent 				= "";
		$draftpick 				= "";
		$auto_close 			= "";
		$offclose 				= "";
		$offclose 				= "";
		$entertoSend 			= "";
		$show_monitoring_botscript = "";
		$autogreeting_fromblast = "";

	}

//file save data
$save_form = "view/sosmed/sosmed_distribution_save.php";

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
		
		<!-- table 1 start -->
		<div class="col-md-6">
			<div class="card">
				<div style="margin:10px 10px 10px 10px;">
					<div>
							<?php
								//tanpa direct message
								if (
										($channel_id == 11)
										OR
										($channel_id == 21)
										OR
										($channel_id == 28)
										OR
										($channel_id == 29)
								   ) {
									?>
										<style type="text/css">
											#breakdown_data{
												display:none;
											}
											#breakdown_data2{
												display:;
											}
										</style>
									<?php
								}else{
									?>
										<style type="text/css">
											#breakdown_data{
												display:;
											}
											#breakdown_data2{
												display:none;
											}
										</style>
									<?php
								}

								//tanpa non-direct message
								if (
										($channel_id == 12)
										OR
										($channel_id == 14)
										OR
										($channel_id == 22)
										OR
										($channel_id == 25)
										OR
										($channel_id == 26)
										OR
										($channel_id == 27)
								   ) {
									?>
										<style type="text/css">
											#breakdown_data3{
												display:none;
											}
											#breakdown_data4{
												display:;
											}
										</style>
									<?php
								}else{
									?>
										<style type="text/css">
											#breakdown_data3{
												display:;
											}
											#breakdown_data4{
												display:none;
											}
										</style>
									<?php
								}
							?>
							<div class="form-body">		
								<?php
								
									$txttitle	= $library['title'];
		                    		$icofrm	  = "fas fa-list-ul";
		                    		echo title_form_det($txttitle,$icofrm);
									
									$x						 		 = 0;
		        
		                    		$txtlabel[$x]      = "Channel Name";
		                    		$bodycontent[$x]   = input_text_temp("channel_name","channel_name",$channel_name,"","required","form-control border-primary");
		                    		$x++;
		                    		
		                    		$txtlabel[$x]      = "Max ACD / Agent";
		                    		$bodycontent[$x]   = input_number_temp("limit_distribution","limit_distribution",$limit_distribution,"","required","form-control border-primary")."<font color=red>Customer handle per-agent</font>";
		                    		$x++;

		                    		$txtlabel[$x]      = "Resent Feature";
			                    	$bodycontent[$x]   = select_status_temp("resent", "resent", $resent)."<font color=blue>Additional feature to repush messages if failed in 5 times</font>";
			                    	$x++;

			                    	$txtlabel[$x]      = "Draft Picker";
			                    	$bodycontent[$x]   = select_status_temp("draftpick", "draftpick", $draftpick);
			                    	$x++;

			                    	$txtlabel[$x]      = "AUX Can Reply";
			                    	$bodycontent[$x]   = select_status_temp("aux_can_reply", "aux_can_reply", $aux_can_reply);
			                    	$x++;

			                    	$txtlabel[$x]      = "Enter Key for Autopush";
		                    		$bodycontent[$x]   = select_status_temp("entertoSend", "entertoSend", $entertoSend)."<font color=\"blue\">Choose no for showing alert confirmation first</font>";
		                    		$x++;


									$txtlabel[$x]      = "Monitoring Show Bot Script";
		                    		$bodycontent[$x]   = select_status_temp("show_monitoring_botscript", "show_monitoring_botscript", $show_monitoring_botscript);
		                    		$x++;

		                    		echo label_form_det($txtlabel,$bodycontent,$x);
		                    	?>
		                    	
							</div>


					</div>
				</div>
			</div>

			<div class="card-action">
			<?php
				echo button_priv('1','1','0');
			?>
		</div>
	</div>
	<div class="col-md-6">
			<div class="card">
				<div style="margin:10px 10px 10px 10px;">
					<div>
							<div class="form-body">	
							<div class="card-head-row">
								<div class="card-title">
									<?php
										$txttitle	= "Additional Default Config";
			                    		$icofrm	  = "fas fa-list-ul";
			                    		echo title_form_det($txttitle,$icofrm);	
			                    	?>
		                    	</div>
		                    	<script type="text/javascript">
		                    		function setAdditional(tujuan){
		                    			document.getElementById('breakdown_chat').style.display = "none";
		                    			document.getElementById('breakdown_nochat').style.display = "none";
		                    			document.getElementById(tujuan).style.display = "";
		                    		}
		                    	</script>
								<div class="card-tools" style="float:right;margin-top:-70px">
									<ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
										<li class="nav-item submenu">
											<a class="nav-link active show" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true" onclick="setAdditional('breakdown_chat')">Interaction (Non-Group)</a>
										</li>
										<li class="nav-item submenu">
											<a class="nav-link" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false" onclick="setAdditional('breakdown_nochat')">Non-interaction</a>
										</li>
									</ul>
								</div>
							</div>	
								
		                    	
			                    	<div id="breakdown_chat">
				                    	<div id="breakdown_data">
				                    		<?php
				                    		             		
				                    			$x 			= 0;

				                    			$txtlabel[$x]      = "Auto-Reply Interval";
					                    		$bodycontent[$x]   = input_number_temp("delay_autoreply","delay_autoreply",$delay_autoreply,"","required","form-control border-primary")."<font color=red>0 = Always Response while Auto-Reply described<br />Else = Number of Minute</font>";
					                    		$x++;

					                    		$txtlabel[$x]      = "Auto-Reply While Agent Busy / No Agent";
					                    		$bodycontent[$x]   = input_textarea_temp("autoreply_while_busy","autoreply_while_busy",$autoreply_while_busy,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>";
					                    		$x++;

					                    		$txtlabel[$x]      = "Auto-Reply While Off";
					                    		$bodycontent[$x]   = input_textarea_temp("autoreply_while_off","autoreply_while_off",$autoreply_while_off,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>";
					                    		$x++;

					                    		$txtlabel[$x]      = "Auto End Session While Off";
					                    		$bodycontent[$x]   = select_status_temp("offclose", "offclose", $offclose);
					                    		$x++;

					                    		$txtlabel[$x]      = "Distributed to Agent Greeting";
					                    		$bodycontent[$x]   = input_textarea_temp("autogreeting","autogreeting",$autogreeting,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information<br /><font color=red>[agent]</font> Subtitute for Agent Name Information";
					                    		$x++;

					                    		$txtlabel[$x]      = "Distributed to Agent Greeting (From WOM Blast Contact)";
					                    		$bodycontent[$x]   = input_textarea_temp("autogreeting_fromblast","autogreeting_fromblast",$autogreeting_fromblast,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information<br /><font color=red>[agent]</font> Subtitute for Agent Name Information";
					                    		$x++;

					                    		

					                    		$txtlabel[$x]      = "Session Auto-Close (On Agent)";
					                    		$bodycontent[$x]   = input_number_temp("session_close","session_close",$session_close,"","required","form-control border-primary")."<font color=red>0 = Longlast Session<br />Else = Max of minute while no activities</font>";
					                    		$x++;

					                    		$txtlabel[$x]      = "Session Close Greeting (On Agent)";
					                    		$bodycontent[$x]   = input_textarea_temp("autoclosing","autoclosing",$autoclosing,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information<br /><font color=red>[agent]</font> Subtitute for Agent Name Information";
					                    		$x++;

					                    		$txtlabel[$x]      = "Session Auto-Close (No Agent)";
					                    		$bodycontent[$x]   = input_number_temp("session_close_bot","session_close_bot",$session_close_bot,"","required","form-control border-primary")."<font color=red>0 = Longlast Session<br />Else = Max of minute while no activities</font>";
					                    		$x++;

					                    		$txtlabel[$x]      = "Session Close Greeting (No Agent)";
					                    		$bodycontent[$x]   = input_textarea_temp("autoclosing_bot","autoclosing_bot",$autoclosing_bot,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information";
					                    		$x++;


					                    		$txtlabel[$x]      = "Show Bot Answer";
					                    		$bodycontent[$x]   = select_status_temp("show_bot_answer", "show_bot_answer", $show_bot_answer);
					                    		$x++;

					                    		$txtlabel[$x]      = "Enable Session-Transfer";
					                    		$bodycontent[$x]   = select_status_temp("show_transfersession", "show_transfersession", $show_transfersession);
					                    		$x++;

					                    		$txtlabel[$x]      = "Session-Transfer Greeting";
					                    		$bodycontent[$x]   = input_textarea_temp("autotransfering","autotransfering",$autotransfering,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information<br /><font color=red>[agent_from]</font> Subtitute for Transfering Agent Name Information<br /><font color=red>[agent_to]</font> Subtitute for Transfered Agent Name Information";
					                    		$x++;

					                    		$txtlabel[$x]      = "Queue Info";
					                    		$bodycontent[$x]   = input_textarea_temp("queueinfo","queueinfo",$queueinfo,"","","form-control border-primary","")."<font color=\"blue\">Let it blank if don't want use this feature</font>,<br /><font color=red>[cust]</font> Subtitute for Customer Name Information<br /><font color=red>[queue_info]</font> Subtitute for Queue Info in number format";
					                    		$x++;


					                    		

					                    		echo label_form_det($txtlabel,$bodycontent,$x);
											?>
										</div>
										<div id="breakdown_data2">
											<br><br><br><center>Interaction additional configuration are deprecated<br />since this channel has no feature on it</center><br /><br />
										</div>
			                    	</div>
			                    	<div id="breakdown_nochat" style="display: none;">
			                    		<div id="breakdown_data3">
			                    			<?php
				                    		             		
				                    			$x 			= 0;

				                    			$txtlabel[$x]      = "Auto End Session after reply";
					                    		$bodycontent[$x]   = select_status_temp("auto_close", "auto_close", $auto_close);
					                    		$x++;

					                    		echo label_form_det($txtlabel,$bodycontent,$x);
											?>
										</div>
										<div id="breakdown_data4">
											<br><br><br><center>Non-interaction additional configuration are deprecated<br />since this channel has no feature on it</center><br /><br />
										</div>
			                    	</div>
								
								
		                    	
							</div>


					</div>
				</div>
			</div>
	</div>

		


</form>
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
										window.location.href = link
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

	getaccess();
</script>