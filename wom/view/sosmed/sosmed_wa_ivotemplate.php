<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script><?php
 ###############################################################################################################
#                                                       #
#                   `---:/.                                             #     
#               .--.    `+h.                                            #
#            `--`         om                                            #
#          `:-   `-:-`    :M.     ___________.__                .__                  _____  __          #
#         .:#` :ydy++y    +M`     \_   _____/|  | ___.__.______ |  |__   ___________/ ____\/  |_        #
#        :.  #hm+.   /`   mh       |    __)_ |  |<   |  |\____ \|  |  \ /  ___/  _ \   __\\   __\       #
#       :`  +Ns`     /   oN-       |        \|  |_\___  ||  |_> >   Y  \\___ (  <_> )  |   |  |         #
#      /`  +N+      ::.-oN+       /_______  /|____/ ____||   __/|___|  /____  >____/|__|   |__|       #
#     :.  .No     `:`# /No                \/      \/     |__|        \/     \/                  #
#    `/   +M`   `--`##sN+            _____            _             _      _____           _                #
#    :`   .m/..--`  -dd-           / ____|          | |           | |    / ____|         | |              #
#    +    .:.``   .ymo`           | |     ___  _ __ | |_ __ _  ___| |_  | |     ___ _ __ | |_ ___ _ __    #
#   /:  --     :yms.              | |    / _ \| '_ \| __/ _` |/ __| __| | |    / _ \ '_ \| __/ _ \ '__|   #
#     s+/.  ./smh+`               | |___| (_) | | | | || (_| | (__| |_  | |___|  __/ | | | ||  __/ |      #
#      -oyhhyo:`                   \_____\___/|_| |_|\__\__,_|\___|\__|  \_____\___|_| |_|\__\___|_|      #
#                                                       #
# -------------------------                                         #
#                                                       #
 ###############################################################################################################

//ivosight_fetchtemplate($conDB,$token)
######################################### C O N F I G U R A T I O N   F I L E ###################################
include "service/sosmed/sosmed_configuration.php";

# DATA SOURCE
$link_data_acc  = "view/sosmed/sosmed_wa_ivotemplate_data.php";

# DETAIL PAGE SOURCE
$menu_linkdet = "sosmed_wa_ivotemplate";

# TABLE COLUMN
$field_data   = array(
            array("","ID"),
            array("a.data_id","Template ID"),
            array("a.data_template_name","Namespace"),
            array("a.data_category","Category"),
            array("a.data_created_at","Created at"),
            array("a.data_status","Status"),
            array("","Sync")
          );
# SETTING TABLE COLUMN WHICH WOULD TO HIDE
  // default, 1st Column
$hiddencol    = "1";

# VISIBILITY SEARCH FEATURE
  // 1 = Enable         0 = Disable
$s_time = 0;


# ACTION VISIBILITY
  // 1= Visible   0 = Hidden
  $action_visibility  = 1;

# ACTION BUTTON  
  // 1= Enable Add Button   0 = Disanble
  $add_button  = 1;

  // Format "Href", "Caption"
  // Left Href blank if Disable Goto anywhere
  // The id will be generated As "btn_Action" + array
  $action_arr   = array(
          /*array("","Tombol2"),
          array("http://google.com","Tombol3")
            */
          );



$now      = DATE("Y-m-d");
$modfolder    = $library['folder'];
$menu_link    = $library['menu_link'];
$menu_label   = $library['title'];
$menu_id    = $library['menu_id'];
$menu_icon    = $library['icon'];
$iddet      = $library['iddet'];
$blist      = $library['blist'];
$strblist   = explode(";", $blist);
$librarylastpage= $strblist[12];
if ($librarylastpage == "") {
  $librarylastpage = 0;
}
$v        = get_param("v");
$act_v      = base64_decode(urldecode($v));
$strv       = explode("|", $act_v); 
$v_blist    = $strv[6];
      
$varlock    = $v_blist;


if($s_time==1){
?>
<style>
#setsTime {
 visibility: visible;
}
</style>
<?php
}else{
?>
<style>
#setsTime {
  visibility: hidden;
}
</style>
<?php 
}
?>
<style>
.dataTables_filter {
  display: none; 
}
#datatablelist tr > *:nth-child(<?php echo $hiddencol?>) {
    display: none;
}
.vvscc{
background: linear-gradient(to bottom, #6db3f2 0%,#54a3ee 50%,#3690f0 51%,#1e69de 100%); 
}
</style>

<input type="hidden" name="s_time" id="s_time" value="<?php echo $s_time;?>">
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
                
              ?>
            </ul>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <?php echo $addition_header ?>
                <div style="padding-top:10px;padding-left:30px">
                  <div  style="float:left;margin-left:8px">
                    <div class="btn-group" style="float:left;">
                      <?php
                        if ($action_visibility == 1) {
                          $vsblty = " visibility:visible;";
                        }else{
                          $vsblty = " visibility:hidden;";
                        }
                      ?>
                      <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm btn-border dropdown-toggle" style="padding:9px; <?php echo $vsblty ?>"> 
                        <i class="flaticon-settings"></i>&nbsp;&nbsp;&nbsp;Action </button>
                      <div role="menu" class="dropdown-menu" style="padding:5px;width:200px">
                        <a href="#">
                          <?php
                            if ($add_button == 1) {
                           

                              $queryl0  = "SELECT insert_time FROM cc_wa_template_ivosight LIMIT 1";
                              $resultl0   = mysqli_query($conn,$queryl0);
                              if ($resultl0) {

                                while ($rows0 = mysqli_fetch_row($resultl0)){
                                  ?>
                                    <div class="vvscc" style="color:white;border:1px solid #405189 !important;padding:10px;text-align: center;text-decoration: none !important">Last Synced at<br /><?php echo $rows0[0] ?></div>
                                  <?php         
                                }
                                mysqli_free_result($resultl0);
                              }
                              ?>
                                <button type="button" data-toggle="modal" data-backdrop="false" data-target="#backdrop-request" onclick="make_ascript()" class="btn btn-primary btn-sm btn-border" style="width:100%;text-align: left">
                                  <i class="fas fa-edit"></i>&nbsp;&nbsp;&nbsp;
                                  Request New
                                </button>
                                <button type="button" id="btnSync" class="btn btn-primary btn-sm btn-border" style="width:100%;text-align: left">
                                  <i class="fas fa-sync-alt"></i>&nbsp;&nbsp;&nbsp;
                                  Sync Templates
                                </button>
                                
                              <?php
                            }
                            for ($y=0; $y < count($action_arr) ; $y++) {
                              $thehref = "";
                              if ($action_arr[$y][0] != '') {
                                //autodetect untuk case direct URL, procedure atau function
                                $thehref = "onclick=\"document.location = '".$action_arr[$y][0]."'\" ";
                                if (substr($action_arr[$y][0],strlen($action_arr[$y][0])-1,1) == ')') {
                                  $thehref = "onclick=\"".$action_arr[$y][0]."\" ";
                                }elseif (substr($action_arr[$y][0],strlen($action_arr[$y][0])-1,1) == ';') {
                                  $thehref = "onclick=\"".$action_arr[$y][0]."\" ";
                                }else{
                                  $thehref = "onclick=\"document.location = '".$action_arr[$y][0]."'\" ";
                                } 
                                ?>
                                  <button <?php echo $thehref ?> type="button" id="btn_Action<?php echo $y ?>" class="btn btn-primary btn-sm btn-border" style="width:100%;text-align: left">
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;
                                    <?php echo $action_arr[$y][1] ?>
                                  </button>
                                <?php
                              }
                            }
                          ?>
                          
                        </a>
                        
                      </div>
                    </div>
                  </div>

                  <div class="btn-group" style="float:right;margin-right:20px;">
                    <div class="md_block" style="margin-top:-10px;">
                      <div id="setsTime">
                        <div class="form-group">
                        <div class="input-icon">
                          <span class="input-icon-addon">
                            <i class="fa fa-calendar-check" style="color:#449627"></i>
                          </span>
                          <input type="text" class="form-control formes expressSearch" style="font-size:10px;width:180px;" id="date_period" name="date_period" >
                        </div>
                      </div>
                    </div>
                    </div>
                   
                   


                    <div class="md_block" style="display: none">
                      <!--button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm btn-border dropdown-toggle"  data-toggle="modal" data-target="#exampleModal"--> 
                        <button type="button" class="btn btn-primary btn-sm btn-border dropdown-toggle mlogin" data-target="#loginmodal" data-toggle="modal" style="padding:9px;margin-left:-10px;">
                            <i class="fas fa-search-plus"></i>&nbsp;&nbsp;&nbsp;Keywords 
                      </button>
                          <div class="modal" id="loginmodal" tabindex="-1">
                            <div class="top-gradient" style="width:370px">
                              <table width="350px" border="0">
                                <tr>
                                  <td style="text-align: left;padding-left:20px">&nbsp;&nbsp;Keyword Filter Custom</td>
                                  <td align="right" width="30px">
                                    <button class="close" data-dismiss="modal">&times;</button>
                                  </td>
                                  <td align="right" width="10px"></td>
                                </tr>
                              </table>
                            </div>
                            <table width="340px;" border="0">
                          <?php
                            for ($j=0; $j <5 ; $j++) { 
                              if ($j == 4) {
                                $display = " style=\"display:none\"";
                              }else{
                                $display = "";
                              }
                              ?>
                                <tr <?php echo $display ?> id="rowfilter-<?php echo $j ?>" style="display:none">
                                  <td>
                                    <div class="md_block formes" >        
                                        <select name="cmb_search_<?php echo $j ?>" id="cmb_search_<?php echo $j ?>" class="basic form-control" style="font-size:9px;height:40px;width:100%" onchange="periksaCombo()">
                                          
                                        </select>
                                      </div>
                                  </td>
                                  <td>
                                    <div class="input-group">
                                        <input type="text" id="cmb_key_<?php echo $j ?>" class="form-control expressSearch" placeholder="Type Keyword ..." style="border : 1px solid #42B549;padding:10px;font-size:12px; color:#42B549" />
                                      </div>
                                  </td>
                                </tr>
                              <?php
                            }
                          ?>
                          
                          <tr style="display:none">

                            <td>
                              
                            </td>
                            <td style="text-align:right">
                              
                                
                              <div style="display:none">
                              Show #&nbsp;<input type="number" min="0" max="4" value="0" id="filterActive" name="filterActive" class="btn btn-success btn-sm btn-border" style="background:white" oninput="keywordColumn(this.value)"  />
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <button type="button" id="opsi_filter_0" onclick="setColFil(0)"  class="btn btn-primary btn-sm" style="width:115px;padding:9px;">&nbsp;No Select </button> 
                              <button type="button" id="opsi_filter_1" onclick="setColFil(1)" class="btn btn-primary btn-sm" style="width:50px;padding:9px;">&nbsp;1 </button> 
                              <button type="button" id="opsi_filter_2" onclick="setColFil(2)" class="btn btn-primary btn-sm" style="width:50px;padding:9px;">&nbsp;2 </button> 
                              <button type="button" id="opsi_filter_3" onclick="setColFil(3)" class="btn btn-primary btn-sm" style="width:50px;padding:9px;">&nbsp;3 </button> 
                              <button type="button" id="opsi_filter_4" onclick="setColFil(4)" class="btn btn-primary btn-sm" style="width:50px;padding:9px;">&nbsp;4 </button> 
                            </td>
                          </tr>
                        </table>
                        
                              
                          </div>  
                      </div>
                      <div class="md_block" style="display: none">
                          <button type="button" id="filter" name="filter"  class="btn btn-primary btn-sm" style="width:150px;padding:9px;"><i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;Search </button> 
                    </div>
                      </div>
                  </div>
                  <div style="clear:both"></div>
                  <?php echo $addition_footer ?>
                  

                  <style type="text/css">
                    .slotes_menu{
                      background:blue;
                      width:40px;
                      height:40px;
                      float:left;
                      margin:1px;
                    }
                    .md_block{
                      margin:0px 2px;
                    }
                  </style>
                <!--/div-->
                <hr style="margin:7px;border:0px" />
                <div class="card-body">
                  <div class="table-responsive" style="margin-top:-50px;">
                    <table id="datatablelist" class="display table table-striped table-hover" style="min-width:100%" >
                      <thead>
                        <?php
                          for ($i=0; $i <count($field_data) ; $i++) { 
                            echo "<th>".$field_data[$i][1]."</th>";
                          }
                        ?>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="<?php echo count($field_data) ?>" class="dataTables_empty">Loading data...</td>
                        </tr>   
                      </tbody>
                    </table>
                    <input type="hidden" name="lastPage" id="lastPage" />
                  </div>
                </div>
              </div>
            </div>

            
          </div>
        </div>
<!--   Core JS Files   -->
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.3.2.1.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <!-- jQuery UI -->
  <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
  <script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
  
  <!-- Moment JS -->
  <script src="assets/js/plugin/moment/moment.min.js"></script>
  <!-- Bootstrap Toggle -->
  <script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
  <!-- jQuery Scrollbar -->
  <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
  <!-- Datatables -->
  <script src="assets/js/plugin/datatables/datatables.min.js"></script>
  <!-- DateTimePicker -->
  <!--
  <script src="assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>
  -->
  <!-- Select2 -->
  <script src="assets/js/plugin/select2/select2.full.min.js"></script>
  <!-- Bootstrap Tagsinput -->
  <script src="assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
  <!-- Atlantis JS -->
  <script src="assets/js/atlantis.min.js"></script>
  <!-- Atlantis DEMO methods, don't include it in your project! -->
  <script src="assets/js/setting.js"></script>
  
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
    function keywordColumn(val){
      for (i = 0 ; i < val; i++) {
          document.getElementById('rowfilter-' + i).style.display = 'table-row';  
      }for (j = i ; j < 4; j++) {
          document.getElementById('rowfilter-' + j).style.display = 'none'; 
      }
      var theval = 'opsi_filter_'+val;
      if (val == 0) {
        document.getElementById('loginmodal').style.height = '105px';
      }else if (val == 1) {
        document.getElementById('loginmodal').style.height = '155px';
      }else if (val == 2) {
        document.getElementById('loginmodal').style.height = '205px';
      }else if (val == 3) {
        document.getElementById('loginmodal').style.height = '250px';
      }else if (val == 4) {
        document.getElementById('loginmodal').style.height = '300px';
      }
      document.getElementById(theval).style.background = "lightblue !important";
      //opsi_filter_0
    }
    function setColFil(val){
      document.getElementById('filterActive').value = val;
      keywordColumn(val)
    }
  </script>
  <?php
            //Format 
            // Daterange|jumfilter|filter1_name|filter1_value|filter2_name|filter2_value|filter3_name|filter3_value
            //$varlock      = "2018-01-01 - 2018-02-10;3;a.message_dir;xyz;a.contact_uid;uid nih;;;;;";
            $varlock_explode  = explode(";", $varlock);
            $var_Daterange    = $varlock_explode[0];
            $var_jumfilter    = $varlock_explode[1];
            $var_filter1_name = $varlock_explode[2];
            $var_filter1_value  = $varlock_explode[3];
            $var_filter2_name = $varlock_explode[4];
            $var_filter2_value  = $varlock_explode[5];
            $var_filter3_name = $varlock_explode[6];
            $var_filter3_value  = $varlock_explode[7];

            //cek tanggal default
            if ($var_Daterange == '') {
               $startdate = $now;
               $enddate   = $now;
            }else{
              $ttgl     = explode(" - ",$var_Daterange);
              $startdate  = $ttgl[0];
              $enddate  = $ttgl[1];
              //echo "$startdate|$enddate";
            }

            //push data filter
            if ($var_jumfilter != "") {
              ?>

                <script type="text/javascript">
                  var var_jumfilter = parseInt("<?php echo $var_jumfilter ?>");
                  document.getElementById('filterActive').value = var_jumfilter;
                  keywordColumn(var_jumfilter);
                </script>
              <?php
            }

            //puter data value
            if($var_filter1_value != ''){
              ?>
                <script type="text/javascript">
                  document.getElementById('cmb_key_0').value = "<?php echo $var_filter1_value ?>";
                </script>
              <?php
            }

            if($var_filter2_value != ''){
              ?>
                <script type="text/javascript">
                  document.getElementById('cmb_key_1').value = "<?php echo $var_filter2_value ?>";
                </script>
              <?php
            }

            if($var_filter3_value != ''){
              ?>
                <script type="text/javascript">
                  document.getElementById('cmb_key_2').value = "<?php echo $var_filter3_value ?>";
                </script>
              <?php
            }

            if($var_filter4_value != ''){
              ?>
                <script type="text/javascript">
                  document.getElementById('cmb_key_3').value = "<?php echo $var_filter4_value ?>";
                </script>
              <?php
            }
            


            $stll = " style=\"display:none\"";
            if (isset($_GET['mode'])) {
              $mode = $_GET['mode'];
              if ($mode == 'es') {
                $stll = " style=\"display:block\"";
              }
            }
          ?>
          <div <?php echo $stll ?>>
            Filter #1 : <span id="col_search1"><?php echo $var_filter1_name  ?></span><br />
            Filter #2 : <span id="col_search2"><?php echo $var_filter2_name  ?></span><br />
            Filter #3 : <span id="col_search3"><?php echo $var_filter3_name  ?></span><br />
            Filter #4 : <span id="col_search4"><?php echo $var_filter4_name  ?></span>
            <hr />

            Var lock : <?php echo $varlock ?>
          </div>

  <script>
    //removeOptions(document.getElementById("cmb_search_0"));

    function filter_isi(default_data,hidden1,hidden2,hidden3,hidden4,target){
      var col = new Array();
      var val = new Array();
      <?php
        //import kolom via php ke javascript
        for ($i=0;$i<count($field_data);$i++) {
          if ($field_data[$i][0] != '') {
            ?>

              val.push("<?php echo addslashes($field_data[$i][0]) ?>");
              col.push("<?php echo addslashes($field_data[$i][1]) ?>");
            <?php
            //echo "<option value=".$field_data[$i][0].">".$field_data[$i][1]."</option>";
          }         
        }

      ?>
      //alert(col.length);
      temp = "";
      temp = temp + "<option value=\"\">-- Select -- </option>";
      for (i=0;i<col.length;i++) {
        if (default_data == val[i]) {
          //console.log("compare jika "+ default_data + " ke " + val[i]);
          temp = temp + "<option selected value=\"" + val[i] + "\">" + col[i] + "</option>";
        }else if (hidden1 == val[i]) {
          //temp = temp + "<option disabled value=\"" + val[i] + "\">" + col[i] + "</option>";
        }else if (hidden2 == val[i]) {
          //temp = temp + "<option disabled value=\"" + val[i] + "\">" + col[i] + "</option>";
        }else if (hidden3 == val[i]) {
          //temp = temp + "<option disabled value=\"" + val[i] + "\">" + col[i] + "</option>";
        }else if (hidden4 == val[i]) {
          //temp = temp + "<option disabled value=\"" + val[i] + "\">" + col[i] + "</option>";
        }else{
          temp = temp + "<option value=\"" + val[i] + "\">" + col[i] + "</option>";
        }

      } 
      //alert(target.innerHTML);

      removeOptions(document.getElementById(target));
      document.getElementById(target).innerHTML = temp;
      //alert('<?php echo $field_data ?>');
    }

    filter_isi(document.getElementById('col_search1').innerHTML,'','','','','cmb_search_0');
    filter_isi(document.getElementById('col_search2').innerHTML,'','','','','cmb_search_1');
    filter_isi(document.getElementById('col_search3').innerHTML,'','','','','cmb_search_2');
    filter_isi(document.getElementById('col_search4').innerHTML,'','','','','cmb_search_3');
    //periksaCombo();


    function periksaCombo(){
      //cmb_search_

      //periksa data pertama
      var val1 = $("#cmb_search_0").val();
      filter_isi(val1,'','','','','cmb_search_0');
      //alert(val1);
      //periksa data kedua
      var val2 = $("#cmb_search_1").val();
      filter_isi(val2,val1,'','','','cmb_search_1');

      //periksa data ketiga
      var val3 = $("#cmb_search_2").val();
      filter_isi(val3,val2,val1,'','','cmb_search_2');

      //periksa data keempat
      var val4 = $("#cmb_search_3").val();
      filter_isi(val4,val3,val2,val1,'','cmb_search_3');
    }
    function removeOptions(selectbox){
        var i;
        for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
        {
            selectbox.remove(i);
        }
    }

    $('#date_period').daterangepicker({
        locale: {
          format: 'YYYY-MM-DD'
        },
          startDate: '<?php echo $startdate;?>',
          endDate: '<?php echo $enddate;?>'
    });

    $('.basic').select2({
      theme: "bootstrap",
      width: "200px" 
    });


  </script>
  <script lang="javascript">
        
$(document).ready(function() {
  //<div role="menu" class="dropdown-menu keyword-search" 

  // <li class="dropdown mega-dropdown "> <a href="javascript:;" class="dropdown-toggle">
  $('div.dropdown-menu.keyword-search').on('click', function (event) {
      //$(this).parent().toggleClass("open");
      alert(event);
      //event.stopPropagation();
      //alert('sa');
  });

  $('body').on('click', function (e) {
      if (!$('div.dropdown-menu.keyword-search').is(e.target) && $('div.dropdown-menu.keyword-search').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
          $('div.dropdown-menu.keyword-search').removeClass('open');
      }
  });

    var oTable = $('#datatablelist').dataTable({
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
     dom: 'Bfrtip<"top"><"bottom"l><"clear">',

     buttons: [
        {
            extend: 'collection',
            text: 'Action',
            className: 'my-1'
        }],
        "info": false,
        "searching": false,
      "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": "<?php echo $link_data_acc;?>",
    "fnServerParams": function (aoData) {
                aoData.push(
                    { "name": "date_period", "value": $("#date_period").val() },
                    { "name": "cmb_key_0",  "value": $("#cmb_key_0").val() },
                    { "name": "cmb_key_1",  "value": $("#cmb_key_1").val() },
                    { "name": "cmb_key_2",  "value": $("#cmb_key_2").val() },
                    { "name": "cmb_key_3",  "value": $("#cmb_key_3").val() },
                    { "name": "cmb_key_4",  "value": $("#cmb_key_4").val() },
                    { "name": "cmb_search_0",  "value": $("#cmb_search_0").val() },
                    { "name": "cmb_search_1",  "value": $("#cmb_search_1").val() },
                    { "name": "cmb_search_2",  "value": $("#cmb_search_2").val() },
                    { "name": "cmb_search_3",  "value": $("#cmb_search_3").val() },
                    { "name": "cmb_search_4",  "value": $("#cmb_search_4").val() }, 
                    { "name": "filterActive",  "value": $("#filterActive").val() }, 
                    { "name": "s_time",  "value": $("#s_time").val() }
                );
            },
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var oSettings = $('#datatablelist').dataTable().fnSettings();
            document.getElementById('lastPage').value = (oSettings._iDisplayStart/oSettings._iDisplayLength);
        }
            
});

<?php
  if ($menu_linkdet != "") {
    ?>
      $('#datatablelist tbody').on('dblclick', 'tr', function () {
       var idIndex = $(this).find("td:first").html(); 
       document.getElementById('vtemplate_id').value = idIndex;
       document.getElementById('tbltplt').click();
    } );
    <?php
  }
?>
  
    
$("div.dataTables_filter input").unbind();

 $('#filter').click(function(e){
  oTable.fnFilter($("div.dataTables_filter input").val());
});

$('div.dataTables_filter input').bind('keyup', function(e) {
   if(e.keyCode == 13) {
    oTable.fnFilter(this.value);   
}
});

$(function() {
    $('body').each(function() {
        $(this).find('.expressSearch').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                $('#datatablelist').dataTable().fnPageChange(0);
            }
        });
    });
});

$('#templatesave').click(function(e){
    var templatesave = document.getElementById('templatesave').style.display;
    if (templatesave == "none") {
      swal({ title: "Sorry!", type: 'warning',  text: 'Prohibited to do this because this feature are disabled due System Handler issue',   timer: 1000,   showConfirmButton: false });
    }else{
      $.ajax({
            type:'POST',
            url:'service/sosmed/chat.php?action=ivosight_reqtemplate&agent_id=<?php echo get_session("v_agentid") ?>',
            data: { data: globalThis.jsonarr }
      }).done(function( msg ) {
          //var msg = JSON.parse(msg);
          swal({ title: "Request Proceed", type: 'success',  text: 'Please check your request in this list',   timer: 1000,   showConfirmButton: false });
          actok();
          //document.getElementById('custdatta').click();
      }).fail(function( jqXHR, textStatus ) {
          swal({ title: "Network issue", type: 'error',  text: 'Please check your connectivity',   timer: 1000,   showConfirmButton: false });
          //document.getElementById('custdatta').click();
      });
    }
});

$('#installtemplate').click(function(e){
  var vtemplate_id = document.getElementById('vtemplate_id').value;
  swal({
      title: 'Are you sure?',
      text: "We will save this information to WhatsApp template in order to be use in your Blast template select box. \nIf that data exist we will overwrite it",
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
         installtemplatee(vtemplate_id);
      } else {
        swal.close();
      }
    });
    /*var templatesave = document.getElementById('templatesave').style.display;
    if (templatesave == "none") {
      swal({ title: "Sorry!", type: 'warning',  text: 'Prohibited to do this because this feature are disabled due System Handler issue',   timer: 1000,   showConfirmButton: false });
    }else{
      $.ajax({
            type:'POST',
            url:'service/sosmed/chat.php?action=ivosight_reqtemplate&agent_id=<?php echo get_session("v_agentid") ?>',
            data: { data: globalThis.jsonarr }
      }).done(function( msg ) {
          //var msg = JSON.parse(msg);
          swal({ title: "Request Proceed", type: 'success',  text: 'Please check your request in this list',   timer: 1000,   showConfirmButton: false });
          actok();
          //document.getElementById('custdatta').click();
      }).fail(function( jqXHR, textStatus ) {
          swal({ title: "Network issue", type: 'error',  text: 'Please check your connectivity',   timer: 1000,   showConfirmButton: false });
          //document.getElementById('custdatta').click();
      });
    }*/
});


$('#btnSync').click(function(e){
      

      swal({
            title: 'Are you sure?',
            text: "We will truncate all ivosight template information and rescan to their data and reinsert again.\nyou will lose your existing data in moment",
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
               actok();
            } else {
              swal.close();
            }
          });
        
        return false;
     /* */
});

    
} );

function installtemplatee(vtemplate_id){
  if (vtemplate_id == "") {
      swal({ title: "Template identity not found", type: 'error',  text: 'Something went wrong from getting template identity information',   timer: 1000,   showConfirmButton: false });
    }else{
      $.ajax({
            type:'POST',
            url:'service/sosmed/chat.php?action=ivosight_totemplate&data=' + vtemplate_id,
            data: { token: new Date().getTime() }
      }).done(function( msg ) {
          swal({ title: msg, type: 'success',  text: '',   timer: 1000,   showConfirmButton: false });
          document.getElementById('filter').click()
      }).fail(function( jqXHR, textStatus ) {
          swal({ title: "Network issue", type: 'error',  text: 'Please check your connectivity',   timer: 1000,   showConfirmButton: false });
      });
    }
}
function gettmplt(){
    var vtemplate_id = document.getElementById('vtemplate_id').value;
    if (vtemplate_id == "") {
      document.getElementById('templainfo').innerHTML = "Can't retrieve request information<br />Try again";
    }else{
      document.getElementById('templainfo').innerHTML = "Loading...";
      $.ajax({
            type:'POST',
            url:'service/sosmed/chat.php?action=ivosight_showtemplates&data=' + vtemplate_id,
            data: { token: new Date().getTime() }
      }).done(function( msg ) {
          document.getElementById('templainfo').innerHTML = msg;
      }).fail(function( jqXHR, textStatus ) {
          document.getElementById('templainfo').innerHTML = "Check your network or connectifity";
          //document.getElementById('custdatta').click();
      });
    }
  }

function actok(){
  $.ajax({
          type:'POST',
          url:'service/sosmed/chat.php?action=ivosight_fetchtemplate&token=123',
          data: { data: t }
    }).done(function( msg ) {
        //var msg = JSON.parse(msg);
        //alert('Success\n\nRequest proceed');
        location.reload();
        //document.getElementById('custdatta').click();
    }).fail(function( jqXHR, textStatus ) {
        swal({ title: "Network issue", type: 'error',  text: 'Please check your connectivity',   timer: 1000,   showConfirmButton: false });
        //document.getElementById('custdatta').click();
    });
}
function openform(file){
  var link;
    link = file;
    window.location = link;
}




</script>
<style type="text/css">
  .dataTables tbody tr {
    height: 35px; /* or whatever height you need to make them all consistent */
}

td{
  padding:3px !important;
  height:40px !important;
}
th{
  text-align: center;
  height:40px !important;
  <?php echo $gradientNave; ?>
  color:white;
}
.top-gradient{
  text-align: center;
  height:40px !important;
  <?php echo $gradientNave; ?>
  
}


.nav.navbar-nav li{
    float:left;
  }
  .nav.navbar-nav li a.mlogin{
    position:relative;
  }
  div.modal#loginmodal{
    position:absolute;
    width:370px;
    height:90px;
    top:36px;
    left:-75px;
    padding:0;
    margin:0;
    border: 3px <?php echo $nave_color; ?> solid;
    border-radius: 5px;
    background:white;
  }
  div.modal#loginmodal .modal-footer{
    padding:5px;
    margin:0;
  }
  div.modal#loginmodal .modal-body{
    padding:10px 20px;
    margin:0;
  }
  div.modal#loginmodal .modal-header{
    padding:0px;
    margin:0;
  }
  .modal-backdrop{
    display:none;
  }
  .btn-success{
    background : <?php echo $nave_color; ?> !important;
    border : 1px solid <?php echo $nave_color; ?> !important;
  }

</style>
<script type="text/javascript">
  function autoColor(){
    xver = document.getElementsByClassName('escolor');
    jmlDiver = xver.length;

    if (jmlDiver > 0) {
      for (var i = 0; i < jmlDiver; i++) {
        rmz  = xver[i].id;
        rmza = rmz.replace("es_","");
        document.getElementsByClassName('escolor')[i].parentElement.parentElement.style.backgroundColor = rmza;
        document.getElementsByClassName('escolor')[i].parentElement.parentElement.style.color = "white";

        document.getElementsByClassName('escolor')[i].parentElement.parentElement.className = "";
      }
      //<span class="redcolor">SHOLAT</span>
    }

    setTimeout(function(){
        autoColor();
    }, 3000);
    
  }
</script>

<!-- green
<style>
  .page-item.active .page-link{
    background    :#42B549;
    border-color  :#42B549;
  }
</style>
-->
<?php

  if ($librarylastpage != 0) {
    ?>
      <script type="text/javascript">
        function showMeLastPage(){
          var oTable = $('#datatablelist').dataTable();
          oTable.fnPageChange(<?php echo $librarylastpage ?>);
        }

        setTimeout(function(){
            showMeLastPage();
        }, 1000);
      </script>

    <?php
  }
?>
<script type="text/javascript">
  setTimeout(function(){
      autoColor();
  }, 500);
  
</script>
<style type="text/css">
  #footer1{display:none;}
  .odd{
    background:<?php echo $nave_odd1 ?> !important;
  }
  .odd:hover{
    background:<?php echo $nave_odd2 ?> !important;
  }
  .even{
    background:<?php echo $nave_even1 ?> !important;
  }
  .even:hover{
    background:<?php echo $nave_even2 ?> !important;
  }
  .formes{
    color:<?php echo $nave_color; ?>;
    border: 1px solid <?php echo $nave_color; ?> !important;
  }

</style>

<script type="text/javascript">
    
    function syntaxHighlight(json) {
        if (typeof json != 'string') {
             json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }
    var jsonarr = {};
    function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 
    function stringno(t){
      if (t == "true") {
        return true;
      }else if (t == "false") {
        return false;
      }else{
        if (isNumber(t)) {
          return parseInt(t);
        }else{
          return t;
        }
      }
    }
    function add_json(ref,label){
      if (label != '') {
        if (label == '[ok]') {
          label = true;
          globalThis.jsonarr[ref] = label;
        }else if(label == '[nok]'){
          label = false;
          globalThis.jsonarr[ref] = label;
        }else{
          var refs = ref.split(".");
          if (refs.length == 1) {
              globalThis.jsonarr[stringno(refs[0])] = label;
          }else if (refs.length == 2) {
              if (globalThis.jsonarr[stringno(refs[0])] === undefined){
                globalThis.jsonarr[stringno(refs[0])] = {};
              }
              globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] = label;

          }else if (refs.length == 3) {
              if (globalThis.jsonarr[stringno(refs[0])] === undefined){
                globalThis.jsonarr[stringno(refs[0])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] = {};
              }
              globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])] = label;
          }else if (refs.length == 4) {
              if (globalThis.jsonarr[stringno(refs[0])] === undefined){
                globalThis.jsonarr[stringno(refs[0])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])] = {};
              }
              globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])][stringno(refs[3])] = label;
          }else if (refs.length == 5) {
              if (globalThis.jsonarr[stringno(refs[0])] === undefined){
                globalThis.jsonarr[stringno(refs[0])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])] = {};
              }
              if (globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])][stringno(refs[3])] === undefined){
                globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])][stringno(refs[3])] = {};
              }
              globalThis.jsonarr[stringno(refs[0])][stringno(refs[1])][stringno(refs[2])][stringno(refs[3])][stringno(refs[4])] = label;

          }
          
          /*for (var i = 0; i < refs.length; i++) {
            
          }*/
        }

        
      }
    }
    function getPars(t){
      var maxPrm = 9;
      var prmNow = 1;
      var maxputer = 20;
      var puterdata = 0;
      var isend = 0;
      var text = t;
      var position = -1;
      var ketemu = 0;
      while(isend == 0){

        position = text.indexOf('{{' + prmNow + '}}');
        if (position >= 0) {
          prmNow = prmNow + 1;
          ketemu++;
          position = position + 5;
          var text = text.substring(position);  
        }
        puterdata = puterdata +1;
        if (maxputer == puterdata) {
          isend = 1;
        }
      }

      var matchmatch = 0;
      for(i = 1;i<=maxPrm;i++){
        matchmatch = matchmatch + (t.split('{{' + i + '}}').length - 1);
      } 

      if (ketemu == matchmatch) {
          return ketemu;
      }else{
        return 0;
        //return '-';
      }
      
      

    }
    function header_ch2(){
      var header        = document.getElementById('header').value;
      if (header == '[ok]') {
        var vh = "table-row";
      }else{
        var vh = "none";
      }
      var header_champ = document.getElementsByClassName('header_champ');
      for (var i = header_champ.length - 1; i >= 0; i--) {
        header_champ[i].style.display = vh;
      }
      
      
    }
    function header_ch3(){
      var header        = document.getElementById('header').value;
      var header_format     = document.getElementById('header_format').value;
        
      if (header_format == 'TEXT') {
        document.getElementById('p_header_text').style.display = "";
        document.getElementById('headercount').value = 0;
      }else{
        document.getElementById('p_header_text').style.display = "none";
         document.getElementById('headercount').value = 1;
      }
      
      header_che();
    }
    function header_che(){
      var header        = document.getElementById('header').value;
      var header_text     = document.getElementById('header_text').value;
      var header_format     = document.getElementById('header_format').value;
      if (header == '[ok]') {
        if (header_format == 'TEXT') {
          var headerCount = getPars(header_text);
          if (headerCount == '-') {
            console.log('header tidak valid');
          }else{
            var headerExp = "";
            if (headerCount == 0) {
                console.log('abaikan header');
            }else{
              for(i = 0; i < headerCount;i++){
                headerExp = headerExp + "<input oninput=\"make_ascript()\" placeholder=\"{{" + (i+1) + "}} Example\" class=\"c_headerExp\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"headerExp_" + i + "\" />";
              }

            }
            if (headerExp == "") {
              headerExp = "No example form available";
            }
            if (headerCount == '-') {
              document.getElementById('headercount').value = 0;
            }else{
              document.getElementById('headercount').value = headerCount;
            }
            document.getElementById('place_headerExp').innerHTML = headerExp;
            
          }
        }else{
          var headerExp = "";
          var i = 0;
          headerExp = headerExp + "<input oninput=\"make_ascript()\" class=\"c_headerExp\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"headerExp_" + i + "\" />";
          document.getElementById('place_headerExp').innerHTML = headerExp;
          document.getElementById('headercount').value = 1;
        }
      }else{
        document.getElementById('place_headerExp').innerHTML = "";
      }
    }

    function body_che(){
      var body_text     = document.getElementById('body_text').value;
      var bodyCount = getPars(body_text);

      if (bodyCount == '-') {
        console.log('header tidak valid');
      }else{
        var bodyExp = "";
        if (bodyCount == 0) {
            console.log('abaikan header');
        }else{
          for(i = 0; i < bodyCount;i++){
            bodyExp = bodyExp + "<input oninput=\"make_ascript()\" placeholder=\"{{" + (i+1) + "}} Example\" class=\"c_bodyExp\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"bodyExp_" + i + "\" />";
          }

        }
        if (bodyExp == "") {
          bodyExp = "No example form available";
        }
        if (bodyCount == '-') {
          document.getElementById('bodycount').value = 0;
        }else{
          document.getElementById('bodycount').value = bodyCount;
        }
        document.getElementById('place_bodyExp').innerHTML = bodyExp;
        
      }
    }
    function act_button(t){
      var button_type = document.getElementById('button_type' + t).value;
      document.getElementById('tbutton_text' + t).style.display = "none";
      document.getElementById('tbutton_countrycode' + t).style.display = "none";
      document.getElementById('tbutton_phonenumber' + t).style.display = "none";
      document.getElementById('tbutton_url' + t).style.display = "none";
      document.getElementById('tbutton_urldyn' + t).style.display = "none";
      
      //gadipake
      document.getElementById('tbutton_urltype' + t).style.display = "none";
      document.getElementById('tbutton_examples' + t).style.display = "none";
      ///
      if (button_type == 'PHONE_NUMBER') {
        document.getElementById('tbutton_text' + t).style.display = "";
        document.getElementById('button_text' + t).value = "";

        document.getElementById('tbutton_countrycode' + t).style.display = "";
        document.getElementById('tbutton_phonenumber' + t).style.display = "";

        document.getElementById('button_countrycode' + t).value = "+62";
        document.getElementById('button_phonenumber' + t).value = "";

      }else if (button_type == 'URL') {
        document.getElementById('tbutton_text' + t).style.display = "";
        document.getElementById('button_text' + t).value = "";
        document.getElementById('button_count' + t).value = "0";

        document.getElementById('tbutton_url' + t).style.display = "";
        document.getElementById('tbutton_urldyn' + t).style.display = "";
        document.getElementById('button_url' + t).value = "";
      }else if (button_type == 'QUICK_REPLY') {
        document.getElementById('tbutton_text' + t).style.display = "";
        document.getElementById('button_text' + t).value = "";
      }
    }
    function button_text_che(t){
      var button_url    = document.getElementById('button_url' + t).value;
      var buttonTextCount   = getPars(button_url);

      if (buttonTextCount == '-') {
        console.log('header tidak valid');
      }else{
        var buttonTextExp = "";
        if (buttonTextCount == 0) {
            console.log('abaikan header');
        }else{
          for(i = 0; i < buttonTextCount;i++){
            buttonTextExp = buttonTextExp + "<input oninput=\"make_ascript()\" placeholder=\"{{" + (i+1) + "}} Example\" class=\"c_buttonTextExp_" + t +  "\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"buttonTextExp_" + t + '_' + i + "\" />";
          }

        }
        if (buttonTextExp == "") {
          buttonTextExp = "No example form available";
        }
        if (buttonTextCount == '-') {
          document.getElementById('buttonTextcount' + t).value = 0;
        }else{
          document.getElementById('buttonTextcount' + t).value = buttonTextCount;
        }
        document.getElementById('place_buttonBodyExp' + t).innerHTML = buttonTextExp;
        
      }
    }
    function button_che(){
      var button        = document.getElementById('button').value;
      if (button == "") {
        button = 0;

      }

      var buttonTYpe = "";
      var buttonExp = "";
      for (var i = 0; i < button; i++) {
        buttonExp = buttonExp + "<tr>";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Type";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonTYpe = "";
        buttonTYpe = buttonTYpe + "<select oninput=\"act_button('" + i + "');make_ascript()\" style=\"padding:10px;width: 100%\" id=\"button_type" + i + "\">";
        buttonTYpe = buttonTYpe + "<option value=\"PHONE_NUMBER\">PHONE_NUMBER</option>";
        buttonTYpe = buttonTYpe + "<option value=\"URL\">URL</option>";
        buttonTYpe = buttonTYpe + "<option selected value=\"QUICK_REPLY\">QUICK_REPLY</option>";
        buttonTYpe = buttonTYpe + "</select>";
        buttonExp = buttonExp + buttonTYpe;
        //buttonExp = buttonExp + "<input oninput=\"make_ascript()\" class=\"c_bodyExp\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"bodyExp_" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";


        buttonExp = buttonExp + "<tr id=\"tbutton_text" + i + "\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Text";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input oninput=\"make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_text" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_count" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Count";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input oninput=\"make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_count" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_countrycode" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Country Code";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        
        
        buttonTYpe = "";
        buttonTYpe = buttonTYpe + "<select onchange=\"make_ascript()\" style=\"padding:10px;width: 100%\" id=\"button_countrycode" + i + "\">";
        //kodearea
        var kodearea = '{"countries":[{"code":"+7 840","name":"Abkhazia"},{"code":"+93","name":"Afghanistan"},{"code":"+355","name":"Albania"},{"code":"+213","name":"Algeria"},{"code":"+1 684","name":"American Samoa"},{"code":"+376","name":"Andorra"},{"code":"+244","name":"Angola"},{"code":"+1 264","name":"Anguilla"},{"code":"+1 268","name":"Antigua and Barbuda"},{"code":"+54","name":"Argentina"},{"code":"+374","name":"Armenia"},{"code":"+297","name":"Aruba"},{"code":"+247","name":"Ascension"},{"code":"+61","name":"Australia"},{"code":"+672","name":"Australian External Territories"},{"code":"+43","name":"Austria"},{"code":"+994","name":"Azerbaijan"},{"code":"+1 242","name":"Bahamas"},{"code":"+973","name":"Bahrain"},{"code":"+880","name":"Bangladesh"},{"code":"+1 246","name":"Barbados"},{"code":"+1 268","name":"Barbuda"},{"code":"+375","name":"Belarus"},{"code":"+32","name":"Belgium"},{"code":"+501","name":"Belize"},{"code":"+229","name":"Benin"},{"code":"+1 441","name":"Bermuda"},{"code":"+975","name":"Bhutan"},{"code":"+591","name":"Bolivia"},{"code":"+387","name":"Bosnia and Herzegovina"},{"code":"+267","name":"Botswana"},{"code":"+55","name":"Brazil"},{"code":"+246","name":"British Indian Ocean Territory"},{"code":"+1 284","name":"British Virgin Islands"},{"code":"+673","name":"Brunei"},{"code":"+359","name":"Bulgaria"},{"code":"+226","name":"Burkina Faso"},{"code":"+257","name":"Burundi"},{"code":"+855","name":"Cambodia"},{"code":"+237","name":"Cameroon"},{"code":"+1","name":"Canada"},{"code":"+238","name":"Cape Verde"},{"code":"+ 345","name":"Cayman Islands"},{"code":"+236","name":"Central African Republic"},{"code":"+235","name":"Chad"},{"code":"+56","name":"Chile"},{"code":"+86","name":"China"},{"code":"+61","name":"Christmas Island"},{"code":"+61","name":"Cocos-Keeling Islands"},{"code":"+57","name":"Colombia"},{"code":"+269","name":"Comoros"},{"code":"+242","name":"Congo"},{"code":"+243","name":"Congo, Dem. Rep. of (Zaire)"},{"code":"+682","name":"Cook Islands"},{"code":"+506","name":"Costa Rica"},{"code":"+385","name":"Croatia"},{"code":"+53","name":"Cuba"},{"code":"+599","name":"Curacao"},{"code":"+537","name":"Cyprus"},{"code":"+420","name":"Czech Republic"},{"code":"+45","name":"Denmark"},{"code":"+246","name":"Diego Garcia"},{"code":"+253","name":"Djibouti"},{"code":"+1 767","name":"Dominica"},{"code":"+1 809","name":"Dominican Republic"},{"code":"+670","name":"East Timor"},{"code":"+56","name":"Easter Island"},{"code":"+593","name":"Ecuador"},{"code":"+20","name":"Egypt"},{"code":"+503","name":"El Salvador"},{"code":"+240","name":"Equatorial Guinea"},{"code":"+291","name":"Eritrea"},{"code":"+372","name":"Estonia"},{"code":"+251","name":"Ethiopia"},{"code":"+500","name":"Falkland Islands"},{"code":"+298","name":"Faroe Islands"},{"code":"+679","name":"Fiji"},{"code":"+358","name":"Finland"},{"code":"+33","name":"France"},{"code":"+596","name":"French Antilles"},{"code":"+594","name":"French Guiana"},{"code":"+689","name":"French Polynesia"},{"code":"+241","name":"Gabon"},{"code":"+220","name":"Gambia"},{"code":"+995","name":"Georgia"},{"code":"+49","name":"Germany"},{"code":"+233","name":"Ghana"},{"code":"+350","name":"Gibraltar"},{"code":"+30","name":"Greece"},{"code":"+299","name":"Greenland"},{"code":"+1 473","name":"Grenada"},{"code":"+590","name":"Guadeloupe"},{"code":"+1 671","name":"Guam"},{"code":"+502","name":"Guatemala"},{"code":"+224","name":"Guinea"},{"code":"+245","name":"Guinea-Bissau"},{"code":"+595","name":"Guyana"},{"code":"+509","name":"Haiti"},{"code":"+504","name":"Honduras"},{"code":"+852","name":"Hong Kong SAR China"},{"code":"+36","name":"Hungary"},{"code":"+354","name":"Iceland"},{"code":"+91","name":"India"},{"code":"+62","name":"Indonesia"},{"code":"+98","name":"Iran"},{"code":"+964","name":"Iraq"},{"code":"+353","name":"Ireland"},{"code":"+972","name":"Israel"},{"code":"+39","name":"Italy"},{"code":"+225","name":"Ivory Coast"},{"code":"+1 876","name":"Jamaica"},{"code":"+81","name":"Japan"},{"code":"+962","name":"Jordan"},{"code":"+7 7","name":"Kazakhstan"},{"code":"+254","name":"Kenya"},{"code":"+686","name":"Kiribati"},{"code":"+965","name":"Kuwait"},{"code":"+996","name":"Kyrgyzstan"},{"code":"+856","name":"Laos"},{"code":"+371","name":"Latvia"},{"code":"+961","name":"Lebanon"},{"code":"+266","name":"Lesotho"},{"code":"+231","name":"Liberia"},{"code":"+218","name":"Libya"},{"code":"+423","name":"Liechtenstein"},{"code":"+370","name":"Lithuania"},{"code":"+352","name":"Luxembourg"},{"code":"+853","name":"Macau SAR China"},{"code":"+389","name":"Macedonia"},{"code":"+261","name":"Madagascar"},{"code":"+265","name":"Malawi"},{"code":"+60","name":"Malaysia"},{"code":"+960","name":"Maldives"},{"code":"+223","name":"Mali"},{"code":"+356","name":"Malta"},{"code":"+692","name":"Marshall Islands"},{"code":"+596","name":"Martinique"},{"code":"+222","name":"Mauritania"},{"code":"+230","name":"Mauritius"},{"code":"+262","name":"Mayotte"},{"code":"+52","name":"Mexico"},{"code":"+691","name":"Micronesia"},{"code":"+1 808","name":"Midway Island"},{"code":"+373","name":"Moldova"},{"code":"+377","name":"Monaco"},{"code":"+976","name":"Mongolia"},{"code":"+382","name":"Montenegro"},{"code":"+1664","name":"Montserrat"},{"code":"+212","name":"Morocco"},{"code":"+95","name":"Myanmar"},{"code":"+264","name":"Namibia"},{"code":"+674","name":"Nauru"},{"code":"+977","name":"Nepal"},{"code":"+31","name":"Netherlands"},{"code":"+599","name":"Netherlands Antilles"},{"code":"+1 869","name":"Nevis"},{"code":"+687","name":"New Caledonia"},{"code":"+64","name":"New Zealand"},{"code":"+505","name":"Nicaragua"},{"code":"+227","name":"Niger"},{"code":"+234","name":"Nigeria"},{"code":"+683","name":"Niue"},{"code":"+672","name":"Norfolk Island"},{"code":"+850","name":"North Korea"},{"code":"+1 670","name":"Northern Mariana Islands"},{"code":"+47","name":"Norway"},{"code":"+968","name":"Oman"},{"code":"+92","name":"Pakistan"},{"code":"+680","name":"Palau"},{"code":"+970","name":"Palestinian Territory"},{"code":"+507","name":"Panama"},{"code":"+675","name":"Papua New Guinea"},{"code":"+595","name":"Paraguay"},{"code":"+51","name":"Peru"},{"code":"+63","name":"Philippines"},{"code":"+48","name":"Poland"},{"code":"+351","name":"Portugal"},{"code":"+1 787","name":"Puerto Rico"},{"code":"+974","name":"Qatar"},{"code":"+262","name":"Reunion"},{"code":"+40","name":"Romania"},{"code":"+7","name":"Russia"},{"code":"+250","name":"Rwanda"},{"code":"+685","name":"Samoa"},{"code":"+378","name":"San Marino"},{"code":"+966","name":"Saudi Arabia"},{"code":"+221","name":"Senegal"},{"code":"+381","name":"Serbia"},{"code":"+248","name":"Seychelles"},{"code":"+232","name":"Sierra Leone"},{"code":"+65","name":"Singapore"},{"code":"+421","name":"Slovakia"},{"code":"+386","name":"Slovenia"},{"code":"+677","name":"Solomon Islands"},{"code":"+27","name":"South Africa"},{"code":"+500","name":"South Georgia and the South Sandwich Islands"},{"code":"+82","name":"South Korea"},{"code":"+34","name":"Spain"},{"code":"+94","name":"Sri Lanka"},{"code":"+249","name":"Sudan"},{"code":"+597","name":"Suriname"},{"code":"+268","name":"Swaziland"},{"code":"+46","name":"Sweden"},{"code":"+41","name":"Switzerland"},{"code":"+963","name":"Syria"},{"code":"+886","name":"Taiwan"},{"code":"+992","name":"Tajikistan"},{"code":"+255","name":"Tanzania"},{"code":"+66","name":"Thailand"},{"code":"+670","name":"Timor Leste"},{"code":"+228","name":"Togo"},{"code":"+690","name":"Tokelau"},{"code":"+676","name":"Tonga"},{"code":"+1 868","name":"Trinidad and Tobago"},{"code":"+216","name":"Tunisia"},{"code":"+90","name":"Turkey"},{"code":"+993","name":"Turkmenistan"},{"code":"+1 649","name":"Turks and Caicos Islands"},{"code":"+688","name":"Tuvalu"},{"code":"+1 340","name":"U.S. Virgin Islands"},{"code":"+256","name":"Uganda"},{"code":"+380","name":"Ukraine"},{"code":"+971","name":"United Arab Emirates"},{"code":"+44","name":"United Kingdom"},{"code":"+1","name":"United States"},{"code":"+598","name":"Uruguay"},{"code":"+998","name":"Uzbekistan"},{"code":"+678","name":"Vanuatu"},{"code":"+58","name":"Venezuela"},{"code":"+84","name":"Vietnam"},{"code":"+1 808","name":"Wake Island"},{"code":"+681","name":"Wallis and Futuna"},{"code":"+967","name":"Yemen"},{"code":"+260","name":"Zambia"},{"code":"+255","name":"Zanzibar"},{"code":"+263","name":"Zimbabwe"}]}';
        kodearea = JSON.parse(kodearea);
        for (var j = kodearea.countries.length - 1; j >= 0; j--) {
          if (kodearea.countries[j].code =='+62') {
            buttonTYpe = buttonTYpe + "<option selected value=\"" + kodearea.countries[j].code + "\">" + kodearea.countries[j].code + " / " + kodearea.countries[j].name + "</option>";
          }else{
            buttonTYpe = buttonTYpe + "<option value=\"" + kodearea.countries[j].code + "\">" + kodearea.countries[j].code + " / " + kodearea.countries[j].name + "</option>";
          }
        }
        
        
        buttonTYpe = buttonTYpe + "</select>";
        buttonExp  = buttonExp + buttonTYpe;
        //buttonExp = buttonExp + "<input oninput=\"make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_countrycode" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_phonenumber" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Phone Number";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input oninput=\"make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_phonenumber" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_urltype" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button URL Type";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonTYpe = "";
        buttonTYpe = buttonTYpe + "<select oninput=\"make_ascript()\" style=\"padding:10px;width: 100%\" id=\"button_urltype" + i + "\">";
        buttonTYpe = buttonTYpe + "<option value=\"static\">STATIC</option>";
        buttonTYpe = buttonTYpe + "<option value=\"dynamic\">DYNAMIC</option>";
        buttonTYpe = buttonTYpe + "</select>";
        buttonExp = buttonExp + buttonTYpe;
        //buttonExp = buttonExp + "<input oninput=\"make_ascript()\" class=\"c_bodyExp\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"bodyExp_" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_url" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button URL";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input oninput=\"button_text_che('" + i + "');make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_url" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        

        buttonExp = buttonExp + "<tr id=\"tbutton_urldyn" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button URL Dynamic Examples";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td id=\"place_buttonBodyExp" + i + "\">";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbuttonTextcount" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button Text Count";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input  type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"buttonTextcount" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        buttonExp = buttonExp + "<tr id=\"tbutton_examples" + i + "\" style=\"display:none\">";
        buttonExp = buttonExp + "<td class=\"vtempl_1\">";
        buttonExp = buttonExp + "#" + (i +1) + " Button URL Dynamic Examples [dummy]";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "<td>";
        buttonExp = buttonExp + "<input oninput=\"make_ascript()\" type=\"text\" style=\"width: 100%;padding:10px;\" value=\"\" id=\"button_examples" + i + "\" />";
        buttonExp = buttonExp + "</td>";
        buttonExp = buttonExp + "</tr>";

        
      }
      document.getElementById('place_buttonExp').innerHTML = buttonExp;
      if (button == 0) {
        document.getElementById('vbtnns').innerHTML = "Button";
      }else{
        document.getElementById('vbtnns').innerHTML = "Buttons";
      }
    }
    var psn = "";
    function promm(newpsn){
      if (newpsn != "") {
        globalThis.psn = globalThis.psn + '<br />';
      }
      globalThis.psn = globalThis.psn + " - " + newpsn;;
    }
    function make_ascript(){
      globalThis.psn = "";
      globalThis.jsonarr = {};

      var urltipe = "";
      var label         = document.getElementById('label').value;
      if (label == "") {
        promm('Template Name not defined');
        //label = "Generated Label " + new Date().getTime();
      }
      var category_id     = document.getElementById('category_id').value;
      var language_id     = document.getElementById('language_id').value;
      var is_propose      = document.getElementById('is_propose').value;
      var header        = document.getElementById('header').value;
      var header_format     = document.getElementById('header_format').value;
      var header_text     = document.getElementById('header_text').value;

      var body_text       = document.getElementById('body_text').value;

      //var header_examples   = document.getElementById('header_examples').value;
      var footer        = document.getElementById('footer').value;

      var button        = document.getElementById('button').value;
      if (button == "") {
        button = 0;
      }
      
      add_json('label',label);
      add_json('category_id',category_id);
      add_json('language_id',language_id);
      add_json('is_propose',is_propose);
      if (header == '[ok]') {
        add_json('header.format',header_format);
        if (header_format == 'TEXT') {
          add_json('header.text',header_text);
        }
        var headercount = document.getElementById('headercount').value;
        var headercountfill = 0;
        for (i=1;i<=headercount;i++) {
          add_json('header.examples.' + (i-1),document.getElementById('headerExp_' + (i-1)).value);
          if (document.getElementById('headerExp_' + (i-1)).value != "") {
            headercountfill = headercountfill + 1;
          }
        }
        //add_json('header.examples',header_examples);

        //fungsi pengecekan
        if (header_format == 'TEXT') {
          if(header_text == ''){
            promm('Need Header text filled for Header format text');
          }
        }
        

        if (headercount > 0) {
          if (headercount != headercountfill) {
            promm((headercount-headercountfill) + ' of ' + headercount + ' for header example variables form must be filled');
          }
        }
        /*if (globalThis.jsonarr['body'] === undefined){
          promm('Body form must be filled');
        }*/
      }

      
      add_json('body.text',body_text);
      var bodycount = document.getElementById('bodycount').value;
      var bodycountfill = 0;
      for (i=1;i<=bodycount;i++) {
        add_json('body.examples.' + (i-1),document.getElementById('bodyExp_' + (i-1)).value);
        if (document.getElementById('bodyExp_' + (i-1)).value != "") {
          bodycountfill = bodycountfill + 1;
        }
      }

      if (bodycount > 0) {
        if (bodycount != bodycountfill) {
          promm((bodycount-bodycountfill) + ' of ' + bodycount + ' for body example variables form must be filled');
        }
      }

      var button = document.getElementById('button').value;
      var buttoncountfill = 0;
      for (i=1;i<=button;i++) {
        add_json('body.buttons.' + (i-1) + '.type',document.getElementById('button_type' + (i-1)).value);
        add_json('body.buttons.' + (i-1) + '.text',document.getElementById('button_text' + (i-1)).value);
        if (document.getElementById('button_text' + (i-1)).value != '') {
          buttoncountfill = buttoncountfill+1;
        }

        if (document.getElementById('button_type' + (i-1)).value == 'PHONE_NUMBER') {
          add_json('body.buttons.' + (i-1) + '.country_code',document.getElementById('button_countrycode' + (i-1)).value);
          add_json('body.buttons.' + (i-1) + '.phone_number',document.getElementById('button_phonenumber' + (i-1)).value);

          if (document.getElementById('button_countrycode' + (i-1)).value == "") {
            promm('Country Code form for #' + i + " are must be filled because your button type is PHONE NUMBER");
          }
          if (document.getElementById('button_phonenumber' + (i-1)).value == "") {
            promm('Phone Number form for #' + i  + " are must be filled because your button type is PHONE NUMBER");
          }

        }else if (document.getElementById('button_type' + (i-1)).value == 'URL') {
          
          add_json('body.buttons.' + (i-1) + '.url',document.getElementById('button_url' + (i-1)).value);
          if (document.getElementById('button_url' + (i-1)).value == "") {
            promm('URL form for #' + i  + " are must be filled because your button type is URL");
          }
          if ((document.getElementById('buttonTextcount' + (i-1)).value == "")||(document.getElementById('buttonTextcount' + (i-1)).value == "0")) {
            urltipe = 'static';
          }else{
            urltipe = 'dynamic';
            var scnt = 0;
            for (var j=0;j<parseInt(document.getElementById('buttonTextcount' + (i-1)).value); j++) {
              add_json('body.buttons.' + (i-1) + '.example.' + j,document.getElementById('buttonTextExp_' + (i-1) + '_' + j).value);
              if (document.getElementById('buttonTextExp_' + (i-1) + '_' + j).value != "") {
                scnt = scnt +1;
              }
            }
            if ((parseInt(document.getElementById('buttonTextcount' + (i-1)).value)) != scnt) {
              promm(((parseInt(document.getElementById('buttonTextcount' + (i-1)).value))-scnt) + ' of ' + (parseInt(document.getElementById('buttonTextcount' + (i-1)).value)) + ' for URL example text form must be filled');
            }

          }
          add_json('body.buttons.' + (i-1) + '.url_type',urltipe);
          
        }else if (document.getElementById('button_type' + (i-1)).value == 'QUICK_REPLY') {
          
        }
      }

      if (button > 0) {
        //button_text0
        if (button != buttoncountfill) {
          promm((button-buttoncountfill) + ' of ' + button + ' for button text form must be filled');
        }

      }

      if (category_id == 'AUTHENTICATION') {
        add_json('otp.0.type','OTP');
        add_json('otp.0.otp_type',document.getElementById('otp_typepe').value);
        add_json('otp.0.text',document.getElementById('otp_text').value);
        var otp_typepe = document.getElementById('otp_typepe').value;
        if (document.getElementById('otp_text').value == '') {
          promm('OTP Text are required');
        }
        if (otp_typepe == 'ONE_TAP') {
          add_json('otp.0.autofill_text',document.getElementById('otp_autofill_text').value);
          add_json('otp.0.package_name',document.getElementById('otp_package_name').value);
          add_json('otp.0.signature_hash',document.getElementById('otp_package_signature_hash').value);
          if (document.getElementById('otp_autofill_text').value == '') {
            promm('OTP Autofill text are required because your OTP Type is ONE TAP');
          }
          if (document.getElementById('otp_package_name').value == '') {
            promm('OTP Package name are required because your OTP Type is ONE TAP');
          }
          if (document.getElementById('otp_package_signature_hash').value == '') {
            promm('OTP Signature Hash are required because your OTP Type is ONE TAP');
          }
        }
        add_json('add_security_recommendation',document.getElementById('otp_add_security_recommendation').value);
        add_json('code_expiration_minutes',document.getElementById('otp_code_expiration_minutes').value);
        if ((document.getElementById('otp_code_expiration_minutes').value > 0) && (document.getElementById('otp_code_expiration_minutes').value <= 90)) {
          //oke aja
        }else{
          promm('OTP Code Expiration minimum 1 and maximum 90');
        }
      }

      if (globalThis.jsonarr['body'] === undefined){
        promm('Body Template must be filled');
      }

      add_json('footer',footer);



      var myJsonString = JSON.stringify(globalThis.jsonarr);
      var str = JSON.stringify(globalThis.jsonarr, null, 2); 
      document.getElementById('json_raw').innerHTML = "<pre>" + str + "</pre>";
      if (globalThis.psn == "") {
        document.getElementById('templatesave').style.display = "";
        document.getElementById('json_resp').innerHTML = "No issues found";
      }else{
        document.getElementById('templatesave').style.display = "none";
        document.getElementById('json_resp').innerHTML = "<b>Need attention</b><br />" + globalThis.psn;
      }
    }
    function otptypecheck(){
      var category_id = document.getElementById('category_id').value;
      if (category_id == 'AUTHENTICATION') {
        var otp_typepe = document.getElementById('otp_typepe').value;
        document.getElementById('otp_text').value               = "";
        document.getElementById('otp_autofill_text').value          = "";
        document.getElementById('otp_package_name').value           = "";
        document.getElementById('otp_package_signature_hash').value     = "";
        document.getElementById('ttotp_autofill').style.display       = "none";
        document.getElementById('ttotp_signaturehash').style.display    = "none";
        document.getElementById('ttotp_packagename').style.display      = "none";


        if (otp_typepe == 'ONE_TAP') {
          document.getElementById('ttotp_autofill').style.display       = "table-row";
          document.getElementById('ttotp_signaturehash').style.display    = "table-row";
          document.getElementById('ttotp_packagename').style.display      = "table-row";
        }
      }
    }
    function ccatchck(){
      var category_id = document.getElementById('category_id').value;
      var vt = "none";
      if (category_id == 'AUTHENTICATION') {
        vt = "table-row";
        var ttotptype = "";
        ttotptype = ttotptype + "<select onchange=\"otptypecheck();make_ascript()\" style=\"padding:10px;width: 100%\" id=\"otp_typepe\">";
        ttotptype = ttotptype + "<option value=\"COPY_CODE\" selected>COPY CODE</option>";
        ttotptype = ttotptype + "<option value=\"ONE_TAP\">ONE TAP</option>";
        document.getElementById('ttotptype').innerHTML            = ttotptype;
        document.getElementById('otp_text').value               = "";
      }
      var ttotp = document.getElementsByClassName('ttotp');
      for (var i = ttotp.length - 1; i >= 0; i--) {
        ttotp[i].style.display = vt;
      }

      otptypecheck();

      /*if (category_id == 'AUTHENTICATION') {
        
        
      }*/
      

    }
  </script>
  <style type="text/css">
    .vtempl_1{
      vertical-align: top;
      text-align:left
    }
  </style>

<div class="modal fade text-xs-left has-success" id="backdrop-request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <form id="frmDataDet" name="frmDataDet">
            <input type="number" id="sourceData" name="sourceData" value="0" style="display:none" />

            <div class="modal-dialog" role="document" style="max-width:1024px !important;border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px">
                <div class="modal-content" class="border border-primary">
                    <div class="modal-header" style="background:#2b4c71;color:white">
                        <h4 class="modal-title" id="myModalLabel4">Request Template</h4>
                    </div>
                    
                    <div class="modal-body" style="background:white">
                        <div class="large-12 columns" id="kontenasi">
                          <div class="row">
                            <div class="col-md-8" style="max-height: 700px;overflow-y: auto">
                              <table width="100%">
                                <tr>
                                  <td class="vtempl_1" width="240px">Template Name</td>
                                  <td>
                                    <input type="text" oninput="make_ascript()" id="label" style="width: 100%;padding:10px;" />
                                  </td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Category</td>
                                  <td>
                                    <select style="padding:10px;width: 100%" id="category_id" onchange="ccatchck();make_ascript()">
                                      <option value="UTILITY">UTILITY</option>
                                      <option value="MARKETING">MARKETING</option>
                                      <option value="AUTHENTICATION">AUTHENTICATION</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Language code</td>
                                  <td>
                                    <select style="padding:10px;width: 100%" id="language_id" onchange="make_ascript()">
                                      <?php
                                        $lang = 'af,sq,ar,az,bn,bg,ca,zh_CN,zh_HK,zh_TW,hr,cs,da,nl,en,en_GB,en_US,et,fil,fi,fr,de,el,gu,ha,he,hi,hu,id,ga,it,ja,kn,kk,ko,lo,lv,lt,mk,ms,ml,mr,nb,fa,pl,pt_BR,pt_PT,pa,ro,ru,sr,sk,sl,es,es_AR,es_ES,es_MX,sw,sv,ta,te,th,tr,uk,ur,uz,vi,zu';
                                        $lang = explode(",", $lang);
                                        for ($i=0; $i <count($lang) ; $i++) { 
                                          if ($lang[$i] == 'id') {
                                            ?>
                                              <option value="<?php echo $lang[$i] ?>" selected><?php echo $lang[$i] ?></option>
                                            <?php
                                          }else{
                                            ?>
                                              <option value="<?php echo $lang[$i] ?>"><?php echo $lang[$i] ?></option>
                                            <?php
                                          }
                                        }
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Is Propose</td>
                                  <td style="text-align: left">
                                    <select style="padding:10px;width: 100%" id="is_propose" onchange="make_ascript()">
                                      <option value="[ok]">Enable</option>
                                      <option value="[nok]">Disable</option>
                                    </select>
                                    <br />
                                    <i>Propose means your template will be proposed to Ivosights team for approval before submitted to WhatsApp.</i>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="6"><hr /></td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Header Template</td>
                                  <td>
                                    <select style="padding:10px;width: 100%" id="header" onchange="header_ch2();make_ascript();">
                                      <option value="[ok]">Enable</option>
                                      <option value="[nok]" selected>Disable</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr class="header_champ" style="display: none">
                                  <td class="vtempl_1">Header Format</td>
                                  <td>
                                    <select style="padding:10px;width: 100%" onchange="header_ch3();make_ascript();" id="header_format">
                                      <option value="TEXT">TEXT</option>
                                      <option value="DOCUMENT">DOCUMENT</option>
                                      <option value="IMAGE">IMAGE</option>
                                      <option value="VIDEO">VIDEO</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr class="header_champ" style="display: none">
                                  <td class="vtempl_1">Header Text</td>
                                  <td>
                                    <div id="p_header_text">
                                      <textarea oninput="header_che();make_ascript()" id="header_text" style="width: 100%;padding:10px;" rows="3"></textarea>
                                      <div style="display: none"><input type="text" id="headercount" value="0"></div>
                                    </div>
                                  </td>
                                </tr>
                                <tr class="header_champ" style="display: none">
                                  <td class="vtempl_1">Header Examples</td>
                                  <td id="place_headerExp" style="text-align: left">
                                    <!-- <textarea oninput="make_ascript()" id="header_examples" style="width: 100%;padding:10px;" rows="3"></textarea> -->
                                  </td>
                                </tr>
                                 <tr>
                                  <td colspan="6"><hr /></td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Body Template</td>
                                  <td>
                                    <textarea oninput="body_che();make_ascript()" id="body_text" style="width: 100%;padding:10px;" rows="3"></textarea>
                                    <div style="display: none">
                                      <input type="text" id="bodycount" value="0">
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Body Example</td>
                                  <td id="place_bodyExp" style="text-align: left">
                                    <!-- <textarea oninput="make_ascript()" id="body_examples" style="width: 100%;padding:10px;" rows="3"></textarea> -->
                                  </td>
                                </tr>
                                 <tr>
                                  <td colspan="6"><hr /></td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1">Footer Template</td>
                                  <td>
                                    <input type="text" oninput="make_ascript()" id="footer" style="width: 100%;padding:10px;" />
                                  </td>
                                </tr>
                                 <tr>
                                  <td colspan="6"><hr /></td>
                                </tr>
                                <tr>
                                  <td class="vtempl_1" id="vbtnns">Button</td>
                                  <td>
                                    <input type="number" value="0" style="width: 100%;padding:10px;" id="button" oninput="button_che();make_ascript();">
                                  </td>
                                </tr>
                                <tbody id="place_buttonExp">
                                  
                                </tbody>
                                

                                <tr class="ttotp" style="display:none">
                                  <td>otp.type</td>
                                  <td>
                                    <select style="padding:10px;width: 100%" id="otp_type">
                                      <option value="OTP">OTP</option>
                                      
                                    </select>
                                  </td>
                                </tr>
                                <tr class="ttotp" style="display:none">
                                  <td>otp.otp_type </td>
                                  <td id="ttotptype">

                                  </td>
                                </tr>
                                <tr class="ttotp" style="display:none">
                                  <td>otp.text   </td>
                                  <td>
                                    <textarea oninput="make_ascript()" id="otp_text" style="width: 100%;padding:10px;" rows="3"></textarea>
                                  </td>
                                </tr>
                                <tr class="ttotp" id="ttotp_autofill" style="display:none">
                                  <td>otp.autofill_text   </td>
                                  <td>
                                    <textarea oninput="make_ascript()" id="otp_autofill_text" style="width: 100%;padding:10px;" rows="3"></textarea>
                                  </td>
                                </tr>
                                <tr class="ttotp" id="ttotp_packagename" style="display:none">
                                  <td>otp.package_name   </td>
                                  <td>
                                    <textarea oninput="make_ascript()" id="otp_package_name" style="width: 100%;padding:10px;" rows="3"></textarea>
                                  </td>
                                </tr>
                                <tr class="ttotp" id="ttotp_signaturehash" style="display:none">
                                  <td>otp.signature_hash   </td>
                                  <td>
                                    <textarea oninput="make_ascript()" id="otp_package_signature_hash" style="width: 100%;padding:10px;" rows="3"></textarea>
                                  </td>
                                </tr>
                                <tr class="ttotp" style="display:none">
                                  <td>otp.add_security_recommendation</td>
                                  <td>
                                    <select onchange="make_ascript()" style="padding:10px;width: 100%" id="otp_add_security_recommendation">
                                      <option value="[ok]">TRUE</option>
                                      <option value="[nok]">FALSE</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr class="ttotp" style="display:none">
                                  <td>otp.code_expiration_minutes  </td>
                                  <td>
                                    <input oninput="make_ascript()" type="number" value="5" min="1" max="90" style="width: 100%;padding:10px;" id="otp_code_expiration_minutes"></textarea>
                                  </td>
                                </tr>
                              </table>
                            </div>
                            <div class="col-md-4">
                              <div style="background:#2b4c71;border-radius:10px 10px 0px 0px;padding:10px;color:white">RAW</div>
                              <div id="json_raw" style="font-family:courier new;max-height:500px;overflow-y: auto;background: #bcc8d4;padding:10px;margin-bottom:10px;";><pre></pre></div>
                              <div style="background:#712b53;border-radius:10px 10px 0px 0px;padding:10px;color:white">System Handler</div>
                              <div style="background: #d4bcc6;padding:10px;margin-bottom:10px;" id="json_resp"></div>

                            </div>
                          </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="templatesave" class="btn btn-primary" data-dismiss="modal">Process</button>
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                            
                    </div>
            </div>
        </form>
    </div>
<script type="text/javascript">

  
</script>

<div style="display: none">
  <input type="text" id="vtemplate_id" / >
<button type="button" id="tbltplt" data-toggle="modal" data-backdrop="false" data-target="#backdrop-preview" onclick="gettmplt()">tampil</button>
</div>

    <div class="modal fade text-xs-left has-success" id="backdrop-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">

            <div class="modal-dialog" role="document" style="max-width:600px !important;border: 2px solid #0a4fa7;border-radius:10px 10px 0px 0px">
                <div class="modal-content" class="border border-primary">
                    <div class="modal-header" style="background:#2b4c71;color:white">
                        <h4 class="modal-title" id="myModalLabel4">Preview Template</h4>
                    </div>
                    
                    <div class="modal-body" style="background:white">
                        <div class="large-12 columns">
                          <div class="row">
                            <div class="col-md-12" id="templainfo" style="max-height: 700px;overflow-y: auto">
                              
                            </div>
                            <div class="col-md-4">
                             

                            </div>
                          </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="installtemplate" class="btn btn-primary" data-dismiss="modal">Install</button>
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                            
                    </div>
            </div>
    </div>