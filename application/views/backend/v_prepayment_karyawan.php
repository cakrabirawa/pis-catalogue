<?php 
/*
------------------------------
Menu Name: Karyawan
File Name: V_prepayment_karyawan.php
File Path: D:\Project\PHP\prepayment\application\views\v_prepayment_karyawan.php
Create Date Time: 2020-01-16 11:40:20
------------------------------
*/
$oTab1 = $oTab2 = $oButton = "";
if (trim($o_mode) === "I") {
	$oTab1 = "active";
	$oButton = $o_extra['o_save'];
} else {
	$oTab2 = "active";
	$oButton = $o_extra['o_update'] . " " . $o_extra['o_delete'];
}
$oButton .= " " . $o_extra['o_cancel'];
?> 
<div class="nav-tabs-custom"> 
  <ul class="nav nav-tabs"> 
    <li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Karyawan</a></li> 
    <!--<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Import Karyawan</a></li>-->
    <li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Karyawan</a></li> 
    <li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li> 
  </ul> 
  <div class="tab-content"> 
    <div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
      <form id="form_5ca2dcddb1a39" role="form" action="<?php print site_url(); ?>c_prepayment_karyawan/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
					<div class="row">
						<div class="col-sm-4 col-xs-12 col-md-4 col-lg-2 form-group" id="div-top"><label>NIK</label><input allow-empty="false" type="text" placeholder="NIK" name="txtNIK" id="txtNIK" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "" : trim($o_data[0]['sNIK']); ?>">
              <input type="hidden" name="txtNIKOld" id="txtNIKOld" value="<?php print trim($o_data[0]['sNIK']); ?>" />
						</div>
            <div class="col-sm-12 col-xs-12 col-md-10 col-lg-6 form-group"><label>NIK Atasan</label>
              <div class="input-group">
                <input type="text" class="form-control" value="<?php print trim($o_data[0]['sNIKAtasan']); ?>" id="txtNIKAtasan" name="txtNIKAtasan" placeholder="NIK Atasan">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="button" id="cmdLookupAtasan">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
              </div>
              <span id="spanInfo">Nama Atasan: <b><?php print trim($o_mode) === "I" ? "Not Found" : $o_data[0]['sNamaAtasan']; ?></b></span>
            </div>
            <div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-md-6 col-lg-4 form-group"><label>Nama Karyawan</label><input allow-empty="false" type="text" placeholder="Nama Karyawan" name="txtNamaKaryawan" id="txtNamaKaryawan" class="form-control text-bold" maxlength="100" value="<?php print trim($o_data[0]['sNamaKaryawan']); ?>">
							<input type="hidden" name="txtNamaKaryawanOld" id="txtNamaKaryawanOld" value="<?php print trim($o_data[0]['sNamaKaryawan']); ?>" />
					  </div>
            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Jabatan</label><select name="selPosisi" placeholder="Posisi" allow-empty="false" id="selPosisi" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_unitusaha; ?></select>
            </div>
            <div class="row"></div>
            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Unit Usaha</label><select name="selUnitUsaha" placeholder="Unit Usaha" allow-empty="false" id="selUnitUsaha" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_posisi; ?></select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-2 form-group"><label>Divisi</label><select name="selDivisi" placeholder="Divisi" allow-empty="false" id="selDivisi" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_divisi; ?></select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Departemen</label><select name="selDepartemen" placeholder="Departemen" allow-empty="false" id="selDepartemen" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_departemen; ?></select>
            </div>
            <div class="row"></div>
            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Bank</label><select name="selBank" placeholder="Bank" allow-empty="false" id="selBank" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_bank; ?></select>
            </div>
            <div class="col-sm-8 col-xs-12 col-md-4 col-lg-5 form-group"><label>Cabang Bank</label><input allow-empty="false" type="text" placeholder="Cabang Bank" name="txtCabangBank" id="txtCabangBank" class="form-control" maxlength="100" value="<?php print $o_data[0]['sCabangBank']; ?>">
            </div>
            <div class="row"></div>
            <div class="col-sm-8 col-xs-12 col-md-4 col-lg-4 form-group"><label>No Rekening</label><input allow-empty="false" type="text" placeholder="Cabang Bank" name="txtNoRekening" id="txtNoRekening" class="form-control text-bold" maxlength="100" value="<?php print $o_data[0]['sNoRekening']; ?>">
            </div>
            <div class="col-sm-8 col-xs-12 col-md-4 col-lg-4 form-group"><label>Atas Nama Rekening</label><input allow-empty="false" type="text" placeholder="Atas Nama Rekening" name="txtAtasNamaRekening" id="txtAtasNamaRekening" class="form-control" maxlength="100" value="<?php print $o_data[0]['sAtasNamaRekening']; ?>">
            </div>
            <div class="row"></div>
            <div class="col-sm-8 col-xs-12 col-md-4 col-lg-4 form-group"><label>Email</label><input allow-empty="false" type="text" placeholder="Atas Nama Rekening" name="txtEmail" id="txtEmail" content-mode="email" class="form-control" maxlength="100" value="<?php print $o_data[0]['sEmail']; ?>">
            <input type="hidden" name="txtEmailOld" id="txtEmailOld" value="<?php print trim($o_data[0]['sEmail']); ?>" />
            </div>
            <div class="col-sm-8 col-xs-12 col-md-4 col-lg-4 form-group"><label>No HP</label><input allow-empty="false" type="text" placeholder="Atas Nama Rekening" name="txtNoHP" id="txtNoHP" class="form-control" maxlength="100" value="<?php print $o_data[0]['sNoHP']; ?>">
            <input type="hidden" name="txtNoHPOld" id="txtNoHPOld" value="<?php print trim($o_data[0]['sNoHP']); ?>" />
            </div>
            <div class="row"></div>
            <!--<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>User Group</label><select name="selUserGroup" placeholder="User Group" allow-empty="false" id="selUserGroup" class="form-control selectpicker" data-size="8" data-live-search="true">
                <?php print $o_user_group; ?></select>
            </div>-->
					</div> 
					<div class="box-footer no-padding"> 
						<br /> 
						<?php print $oButton; ?> 
					</div> 
					<input type="hidden" name="hideMode" id="hideMode" value="" /> 
				</div>
			</form> 
    </div> 
    <div id="tab_1" class="tab-pane <?php print $oTab1; ?>"> 
      <div id="div-list-user">  
      </div> 
    </div> 
    <!--
    <div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
      <form id="form_5e1fe9340e789" role="form" action="<?php print site_url(); ?>c_prepayment_karyawan/gf_transact" method="post"> 
        <div class="box-body no-padding"> 
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group" id="div-top"><p>Please Select File Karyawan !. File Type is <b>CSV</b><br /></p>
              <a class="cursor-pointer btn btn-primary" title="Click here to Change Profile Picture" id="aUploadImage">Upload File</a>
      <span id="spanProgress"></span>
            </div>
          </div> 
        <input type="hidden" name="hideMode" id="hideMode" value="" /> 
      </form> 
    </div> 
  	-->
  </div> 
</div> 


<script> 
$(function() 
{ 
  gf_load_data();   
  $("a[href='#tab_1']").on("click", function()
  {
    gf_load_data(); 
  });
  $("#cmdLookupAtasan").on("click", function()
  {   
    var sNamaKaryawan = "";
    var oObjPerspective = $(this);
    $.ajax({
        type: "POST",
        url: "<?php print site_url(); ?>c_prepayment_karyawan/gf_load_data_karyawan/",
        beforeSend: function()
        {
          dialog = new BootstrapDialog({
                    title: 'Browse Atasan',
                    message: $.gf_spinner() + " <center>Loading Data...</center><br /><br /><br /><br />",
                    type : BootstrapDialog.TYPE_DEFAULT,
                    buttons: [{
                              id:'cmdOkay',
                              label: 'Okay',
                              cssClass: 'btn-primary',
                              action: function(d)
                              {
                                var JSON = '{\"oData\": ['+window.DATA+']}';
                                var JSON = $.parseJSON(JSON);
                                var sNamaVendor = "";
                                $.each(JSON.oData, function(i, n)
                                {
                                  $("#txtNIKAtasan").val(this.NIK);
                                  $("#spanInfo").html("Nama Atasan: <b>" + this.Nama_Karyawan + "</b>");
                                  sNamaKaryawan = this.Nama_Karyawan;
                                });
                                if($.trim(sNamaKaryawan) === "")
                                  $("#spanInfo").html("Nama Atasan: <b>-</b>");
                                d.close();
                              },
                            },{
                              id:'cmdClose',
                              label: 'Close',
                              cssClass: 'btn-default',
                              action: function(d)
                              {
                                d.close();
                              },
                            }
                            ]
                    });   
          dialog.setSize(BootstrapDialog.SIZE_WIDE);
          dialog.setClosable(false);
          dialog.open();
        },
        success: function(r)
        {
          dialog.getModalBody().html(r);
        }
     });
  });
  $("#txtNIKAtasan").on("blur", function()
  {
    var oObj = $(this);
    if($.trim($(this).val()) !== "")
    {
      var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_karyawan/gf_load_data_karyawan_detail"});
      objForm.append("<input type=\"hidden\" id=\"sNIK\" name=\"sNIK\" value=\""+oObj.val()+"\" />");
      $.gf_custom_ajax({"oForm": objForm,  
      "success": function(r)
      {
        var JSON = $.parseJSON(r.oRespond); 
        if(JSON.oData.length > 0)
          $("#spanInfo").html("Nama Atasan: <b>"+JSON.oData[0].sNamaKaryawan+"</b>");
        else
          $("#spanInfo").html("Nama Atasan: <b>Not Found</b>");
      }, 
      "validate": true,
      "beforeSend": function(r) {
        $("#spanInfo").html("Nama Atasan: <b>Not Found</b>");
      },
      "beforeSendType": "custom", 
      "error": function(r) {} 
      }); 
    }
  });
  $("#txtNamaKaryawan").on("keyup", function()
  {
    $("#txtAtasNamaRekening").val($.trim($(this).val()));
  });
  $("button[id='button-submit']").click(function() {
		if ($.trim($(this).html()) === "Cancel")
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else {
			var bNext = true;
			var objForm = $("#form_5ca2dcddb1a39");
			//------------------------------------------ 
			if ($.trim($(this).html()) === "Save")
				$("#hideMode").val("I");
			else if ($.trim($(this).html()) === "Update")
				$("#hideMode").val("U");
			else if ($.trim($(this).html()) === "Delete")
				$("#hideMode").val("D");
			//------------------------------------------ 
			if (parseInt($.inArray($.trim($("#hideMode").val()), ["I", "U"])) !== -1) {
				var oRet = $.gf_valid_form({
					"oForm": objForm,
					"oAddMarginLR": true,
					oObjDivAlert: $("#div-top")
				});
				bNext = oRet.oReturnValue;
			}
			if (!bNext)
				return false;
			//------------------------------------------ 
			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$.gf_remove_all_modal();
					if (JSON.status === 1)
						$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
					else {
						$.gf_msg_info({
							oObjDivAlert: $("#div-top"),
							oAddMarginLR: true,
							oMessage: JSON.message
						});
					}
				},
				"validate": true,
				"beforeSend": function(r) {},
				"beforeSendType": "standard",
				"error": function(r) {}
			});
		}
	}); 
  $("select").selectpicker('refresh');
}); 
function gf_init_plupload()
{
  var sArrayFile = Array(), sArraySize = Array(), oJSONObj = [], oLength = 25, oAddPath = "csv";
  var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'aUploadImage', 
    divUploadContainer: $("#divUploadContainer"), 
    url : "<?php print site_url(); ?>c_core_upload/gf_upload/",
    chunk_size: '500kb',
    multiple_queues:true,
    multi_selection: false,
    unique_names: true,
    filters : {
        max_file_size : '50mb',
        mime_types: [
            {title : "CSV files", extensions : "csv"}
        ]
    },
    multipart_params : {
        "oAddPath" : oAddPath
    },
    flash_swf_url : '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.swf',
    silverlight_xap_url : '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.xap',
    init: 
    {
      PostInit: function() {},
      FilesAdded: function(up, files) 
      {
        uploader.start();
      }, 
      UploadProgress: function(up, file) 
      {
        $("#spanProgress").html('<span><b>' + file.percent + "</b>%</span>");
      }, 
      Error: function(up, err) 
      {
        $("<p>Error: " + err.code + ": " + err.message+"</p>").insertAfter($("#aUploadImage").prev());
      },
      BeforeUpload: function(up, file)
      {       
        $("#aUploadImage").prev().attr("src", "<?php print site_url(); ?>img/loading.gif").css("max-width", "50px");
        $("p").remove();
      },
      UploadComplete: function(uploader, files)
      {
        var objForm = $("#form_5938b5bb933d2"); 
        var sSingleFileName = "";
        objForm.append("<input type=\"hidden\" name=\"hidePath\" id=\"hidePath\" value=\""+$.trim(oAddPath)+"\" />");
        objForm.find("input[id='hideFileName']").remove();
        $.each(oJSONObj, function(i, n)
        {
          var JSON = $.parseJSON(n.oFile);
          objForm.append("<input type=\"hidden\" name=\"hideFileName[]\" id=\"hideFileName\" value=\""+$.trim(JSON.fnameoriginal)+"\" />");
          sSingleFileName = $.trim(JSON.fnameoriginal);
        });
        //$("button#button-submit:eq(0)").trigger("click")
        $("#aUploadImage").prev().attr("src", "<?php print site_url(); ?>uploads/uploads/" + sSingleFileName).css("max-width", "200px");
        $("#aUploadImage").prev().hide();
        $("#aUploadImage").hide();
        $("#spanProgress").html("<center><p><i class=\"fa fa-cog fa-spin fa-4x text-blue\" /><br />Please wait while system Importing the Data !, Warning, Please don't press refresh button or (F5) in your browser! </p></center>");
        var objForm = $.gf_create_form({"action": "<?php print site_url(); ?>c_prepayment_karyawan/gf_begin_import"});
        objForm.append("<input type=\"hidden\" name=\"hideFileName\" id=\"hideFileName\" value=\""+sSingleFileName+"\" />");
        $.gf_custom_ajax({"oForm": objForm,  
        "success": function(r)
        {
          $("#spanProgress").html("<center><p><i class=\"fa fa-smile-o fa-4x\" /><br />Congratulation, you have successfully importing the data.</p><a class=\"btn btn-primary\" href=\"<?php print site_url(); ?>c_prepayment_karyawan\">Import again !</a></center>");
          var JSON = $.parseJSON(r.oRespond); 
        }, 
        "validate": true,
        "beforeSend": function(r) {},
        "beforeSendType": "custom", 
        "error": function(r) {} 
        }); 
      },
      FileUploaded: function(upldr, file, object) 
      {
        var JSON = $.parseJSON(object.response);
        item = {}
        item["oFile"] = object.response;
        oJSONObj.push(item);
      }
    }
  }); 
  uploader.init();
}
function gf_load_data() 
{ 
  $("#div-list-user").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_karyawan/gf_load_data/"}); 
} 
</script>