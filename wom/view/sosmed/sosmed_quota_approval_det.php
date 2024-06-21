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

$fmenu_link_back = "sosmed_quota_approval_list";
    	
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

	$sqlv = "SELECT 
				concat(b.agent_name,' / ',b.agent_id) as agent_id,
				d.channel_descr as channel,
				a.request_from,
				a.request_to,
				a.reason,
				a.request_time,
				a.approved_time,
				concat(c.agent_name,' / ',c.agent_id) as approved_by,
				a.status 
			from cc_sosmed_blast_quota_det a 
			left join cc_agent_profile b on a.agent_id = b.id
			left join cc_agent_profile c on a.approved_by = c.id
			left join cc_channel_desc d on a.channel = d.channel_id
			where a.id =  '$iddet' "; 
	$resv = mysqli_query($condb, $sqlv);
	if($recv = mysqli_fetch_array($resv)){
		$agent_id 							= $recv["agent_id"];
		$channel							= $recv["channel"];
		$request_from						= $recv["request_from"];
		$request_to							= $recv["request_to"];
		$reason								= $recv["reason"];
		$request_time						= $recv["request_time"];
		$approved_time						= $recv["approved_time"];
		$approved_by						= $recv["approved_by"];
		$status								= $recv["status"];

	} 

//file save data
$save_form = "view/sosmed/sosmed_quota_approval_save.php";

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
		<div class="col-md-12">
			<div class="card">
				<div style="margin:10px 10px 10px 10px;">
					<div>
							<div class="form-body">		
								<?php
								
									$txttitle	= $library['title'];
		                    		$icofrm	  = "fas fa-list-ul";
		                    		echo title_form_det($txttitle,$icofrm);
									
									$x						 		 = 0;
		        
		                    		$txtlabel[$x]      = "Channel";
		                    		$bodycontent[$x]   = input_text_readonly_temp("channel","channel",$channel,"","","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Current Quota";
		                    		$bodycontent[$x]   = input_text_readonly_temp("request_from","request_from",$request_from,"","","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Quota Requested";
		                    		$bodycontent[$x]   = input_text_readonly_temp("request_from","request_from",$request_to,"","","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Requester";
		                    		$bodycontent[$x]   = input_text_readonly_temp("agent_id","agent_id",$agent_id,"","","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Request Time";
		                    		$bodycontent[$x]   = input_text_readonly_temp("request_time","request_time",$request_time,"","","form-control border-primary");
		                    		$x++;

		                    		$txtlabel[$x]      = "Request Reason";
		                    		$bodycontent[$x]   = input_textarea_readonly_temp("reason","reason",$reason,"","","form-control border-primary");
		                    		$x++;

		                    		/*if ($status == 0) {
		                    			$rstatus = "Waiting";
		                    		}elseif ($status == 1) {
		                    			$rstatus = "Aproved";
		                    		}elseif ($status == 2) {
		                    			$rstatus = "Rejected";
		                    		}else{
		                    			$rstatus = "Unknown";
		                    		}
		                    		$txtlabel[$x]      = "Status";
		                    		$bodycontent[$x]   = input_text_readonly_temp("status","status",$rstatus,"","","form-control border-primary");
		                    		$x++;*/
		                    		
		                    		$sel0 = "";
		                    		$sel1 = "";
		                    		if ($status == "0")
								       $sel0 = "selected";
								    else if ($status == "1")   
								       $sel1 = "selected";
								  	else if ($status == "2")   
								       $sel2 = "selected";
		                    		$selectout = "<SELECT id=\"status\" name=\"status\" class=\"select2 form-control\" style=\"width:100%;\">     
								                    <option value=\"0\" $sel0>Waiting</option>
								                    <option value=\"1\" $sel1>Aprove</option>
								                    <option value=\"2\" $sel2>Reject</option>
								                  </SELECT>";

		                    		$txtlabel[$x]      = "Action";
		                    		$bodycontent[$x]   = $selectout;
		                    		$x++;

		                    		if ($status != 0) {
		                    			$txtlabel[$x]      = "Reaction By";
			                    		$bodycontent[$x]   = input_textarea_readonly_temp("approved_by","approved_by",$approved_by,"","","form-control border-primary");
			                    		$x++;

			                    		$txtlabel[$x]      = "Reaction Time";
			                    		$bodycontent[$x]   = input_text_readonly_temp("approved_time","approved_time",$approved_time,"","","form-control border-primary");
			                    		$x++;
		                    		}

		                    		
		                    		echo label_form_det($txtlabel,$bodycontent,$x);
		                    	?>
		                    	
							</div>


					</div>
				</div>
			</div>
			<div class="card-action">
			<?php
			if ($status == 0) {
				echo button_priv('1','1','0');
			}else{
				echo button_priv('0','1','0');
			}
				/*if ($iddet != "") {
					echo button_priv('1','1','1');
					echo $rv;
				}else{
					echo button_priv('1','1','0');
					
				}*/
			?>
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
						            location.reload()
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