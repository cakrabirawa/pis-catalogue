<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Gramedia SIT Orders Form</title>
	<link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon1.png" />

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/AdminLTE.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.app/app.css" />
  <link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.bootstrapselect/dist/css/bootstrap-select.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.viewer.office2013.whiteblue.css" />
  <link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.timeline.5/styles.css" />
	<script src="<?php print site_url(); ?>plugins/jquery/jquery-2.1.4.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.bootstrapdialog/bootstrap-dialog.min.js"></script>
  <script src="<?php print site_url(); ?>plugins/jquery.bootstrapselect/dist/js/bootstrap-select.min.js"></script>
  <script src="<?php print site_url(); ?>plugins/jquery.numeric/autoNumeric-1.9.41.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.ado/ado.js"></script>
  <script src="<?php print site_url(); ?>plugins/jquery.timeago/timeago.min.js"></script>
  <script src="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.reports.pack.js"></script>
  <script src="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.viewer.pack.js"></script>
</head>
<body style="background-color: #fafafa;">
  <div class="container">
    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
      <div class="row">
        <div>
          <h2><i class="fa fa-codepen text-green"></i> SIT Gramedia Orders Form</h2>
        </div>
        <div>
          <h5>Selamat datang di Sistem Informasi Orders Service dan Peminjaman Hardware !. Di form ini anda bisa melakukan request service dan peminjaman dari SIT Gramedia. Silahkan klik Orders Form untuk melakukan proses tersebut.</h5>
        </div>
        <p>&nbsp;</p>
      </div>
    </div>
    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12" id="divButton" style="margin-bottom: 10px;">
      <div class="row">
        <div class="btn-group" role="group" aria-label="">
          <button id="cmdDashboard" type="button" class="btn btn-lg btn-success"><i class="fa fa-cog"></i> Dashboard</button>
          <button id="cmdOrders" type="button" class="btn btn-lg btn-default"><i class="fa fa-cart-plus"></i> Orders Form</button>
        </div>
      </div>
    </div>    
    <div class="row"></div>
    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12" id="divWrap">
      <div class="row">
        <form id="form_61355dc33e254" action="<?php print site_url(); ?>orders/submit" method="post">
          <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12" id="divDashboard" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="row">
              <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 form-group">
                <div class="row">
                  <div class="input-group">
                    <input type="text" id="txtSearch" class="form-control input-lg text-bold" placeholder="Search Ticket No..." aria-describedby="basic-addon1">
                    <span class="input-group-btn"><button id="cmdSearchData" class="btn btn-default btn-lg" type="button"><span class="fa fa-search"></span></button></span>
                  </div>
                  <small class="text-info">Use Comma to search multiple Ticket No</small>
                </div>
              </div>
              <div id="divResult" class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                <div class="row text-center">
                  <i class="fa fa-bullhorn fa-4x"></i><br />Untuk memantau Order Anda, Ketik 1 atau lebih No Ticket Anda. <br />Pisahkan dengan tanda koma setiap No Ticket Anda. 1 Order dapat terdiri dari 1 atau lebih No Ticket.<br /> Pastikan Anda memiliki No Ticket tersebut dan telah mencetak untuk di sertakan pada saat pengajuan Order.
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 hidden" id="divFeed" style="margin-top: 10px;">
            <div class="row">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-12 col-md-4 col-sm-4 col-lg-2 form-group">
                      <label>NIK</label>
                      <input type="text" allow-empty="false" class="form-control input-lg" id="sSRNIK" name="sSRNIK" placeholder="NIK">
                    </div>
                    <div class="col-sm-4 col-xs-12 col-md-4 col-lg-5 form-group"><label>Departemen</label><select name="nSRIdVendor_fk" placeholder="Unit" allow-empty="false" id="nSRIdVendor_fk" class="form-control selectpicker" data-style="btn-default btn-lg" data-size="8" data-live-search="true">
                    <?php print $o_vendor_source; ?>
                    </select>
                    </div>
                    <div class="col-sm-4 col-xs-12 col-md-4 col-lg-5 form-group"><label>Type Orders</label><select name="nIdTypeOrders_fk" placeholder="Type Orders" allow-empty="false" id="nIdTypeOrders_fk" data-style="btn-default btn-lg" class="form-control selectpicker" data-size="8" data-live-search="true">
                    <?php print $o_type_orders; ?>
                    </select>
                    </div>
                    <div class="row"></div>
                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 form-group">
                      <label>Nama</label>
                      <input type="text" allow-empty="false" class="form-control input-lg text-bold" name="sSRNama" id="sSRNama" placeholder="Nama">
                    </div>
                    <div class="row"></div>
                    <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 form-group">
                      <label>Email</label>
                      <input content-mode="email" type="text" allow-empty="false" class="form-control input-lg" name="sSREmail" id="sSREmail" placeholder="Email">
                    </div>
                    <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 form-group">
                      <label>No HP</label>
                      <input type="text" allow-empty="false" class="form-control input-lg" name="sSRNoHP" id="sSRNoHP" placeholder="No HP">
                    </div>
                    <div class="row"></div>
                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 form-group">
                      <div class="btn-group" role="group" aria-label="">
                        <button id="cmdAdd" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Orders</button>
                        <button id="cmdClear" type="button" class="btn btn-default"><i class="fa fa-trash"></i> Clear Orders</button>
                      </div>
                      <button id="cmdSubmit" type="button" class="btn btn-success pull-right"><i class="fa fa-send"></i> Submit Orders</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 form-group">
                <div class="row">
                  <div class="row" id="divOrders">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>      
      </div>    
    </div>    
    <div>
  </div>
</body>
</html>
<script>
  var nOrderNo = 1,
      SERVICE = parseInt("<?php print intval($o_config['SERVICE_ORDER']); ?>"),
      PEMINJAMAN = parseInt("<?php print intval($o_config['PEMINJAMAN_ORDER']); ?>");

  $(function()
  {
    $("select").selectpicker('refresh');
    $("#cmdDashboard").on("click", function (e) 
    { 
      e.preventDefault();
      $(this).removeClass("btn-default").addClass("btn-success");
      $("#cmdOrders").addClass("btn-default").removeClass("btn-success");
      $("#divDashboard").removeClass("hidden");
      $("#divFeed").addClass("hidden");
    });
    $("#cmdOrders").on("click", function (e) 
    { 
      e.preventDefault();
      $(this).removeClass("btn-default").addClass("btn-success");
      $("#cmdDashboard").addClass("btn-default").removeClass("btn-success");
      $("#divDashboard").addClass("hidden");
      $("#divFeed").removeClass("hidden");
    });
    $("#cmdAdd").on("click", function()
    { 
      if($.trim($("#nIdTypeOrders_fk").find("option:selected").val()) === "")
      {
        $.gf_msg_info({
          oObjDivAlert: $("#divWrap"),
          oAddMarginLR: false,
          oMessage: "Type Order Belum di pilih !"
        });
        return false;
      }

      if($("#divOrders").html() === "Orders Empty")
        $("#divOrders").empty();
      var sHTML = "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Order No: <span id=\"spanNo\">"+nOrderNo+"</span><span class=\"pull-right\"><i id=\"iRemove\" class=\"fa fa-trash cursor-pointer\" title=\"Remove this Order\"></i></span></div><div class=\"panel-body\"><div class=\"row\">";
      //Component
      sHTML += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6 form-group\"><label>Nama Produk</label><input allow-empty=\"false\" type=\"text\" placeholder=\"Nama Produk\" name=\"sSRProductName[]\" id=\"sSRProductName\" class=\"form-control\" maxlength=\"100\"/></div>";
      sHTML += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6 form-group "+(parseInt($("#nIdTypeOrders_fk").find("option:selected").val()) === SERVICE ? "hidden" : "")+"\"><label>Qty</label><input allow-empty=\"false\" content-mode=\"numeric\" type=\"text\" placeholder=\"Qty\" name=\"nSRQty[]\" id=\"nSRQty\" class=\"form-control\" maxlength=\"3\"/></div>";
      sHTML += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6 form-group "+(parseInt($("#nIdTypeOrders_fk").find("option:selected").val()) === PEMINJAMAN ? "hidden" : "")+"\"><label>Serial Number</label><input type=\"text\" name=\"sSRSN[]\" placeholder=\"Serial Number\" allow-empty=\"false\" id=\"sSRSN\" class=\"form-control\" maxlength=\"50\"/></div>";
      sHTML += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><label>Keterangan</label><textarea placeholder=\"Keterangan\" allow-empty=\"false\" name=\"sSRDeskripsi[]\" id=\"sSRDeskripsi\" class=\"form-control\" maxlength=\"200\"></textarea></div>";      
      //End Component
      sHTML += "</div></div></div></div>";
      $("#divOrders").prepend(sHTML);
      $("input[id='sSRProductName']:first").focus();
      nOrderNo++;
      $("i[id='iRemove']").on("click", function()
      {
        $(this).parent().parent().parent().parent().remove();
        nOrderNo--;
        gf_reset_no();
      });
      gf_reset_no();
    });
    $("#cmdClear").on("click", function()
    {
      $("i[id='iRemove']").trigger("click");
    });
    $("#nIdTypeOrders_fk").on("change", function()
    {
      if($.trim($(this).find("option:selected").val()) !== "")
      {
        var nTypeOrderId = parseInt($(this).find("option:selected").val());
        if(nTypeOrderId === SERVICE) //Service
        {
          $("input[id='sSRSN']").parent().removeClass("hidden");
          $("input[id='sSRSN']").prop("allow-empty", "false");
          $("input[id='nSRQty']").parent().addClass("hidden");
          $("input[id='nSRQty']").prop("allow-empty", "true");
        }
        else if(nTypeOrderId === PEMINJAMAN) //Peminjaman
        {
          $("input[id='sSRSN']").parent().addClass("hidden");
          $("input[id='sSRSN']").prop("allow-empty", "true");
          $("input[id='nSRQty']").parent().removeClass("hidden");
          $("input[id='nSRQty']").prop("allow-empty", "false");
        }
      }
    });
    $("button[id='cmdSubmit']").click(function() 
    {
      $("#nIdTypeOrders_fk").trigger("click");
      var bNext = true;
      var objForm = $("#form_61355dc33e254");
      //------------------------------------------ 
      var oRet = $.gf_valid_form({
        "oForm": objForm,
        "oAddMarginLR": true,
        oObjDivAlert: $("#divWrap")
      });
      bNext = oRet.oReturnValue;
      if (bNext)
      {
        if($("div[class='panel panel-default']").length === 0)
        {
          bNext = false;
          $.gf_msg_info({
                oObjDivAlert: $("#divWrap"),
                oAddMarginLR: true,
                oMessage: "<b>Order</b> tidak boleh kosong. Masukan Order minimal 1."
              });
        }
      }
      if (!bNext)
        return false;
      //------------------------------------------ 
      $.gf_custom_ajax({
        "oForm": objForm,
        "success": function(r) {
          var JSON = $.parseJSON(r.oRespond);
          if (JSON.status === 1)
          {
            $.gf_remove_all_modal();
            BootstrapDialog.show({
            title: 'Informasi',
            message: 'Terima kasih, No Order Anda adalah:  <br /><p class=\'text-center\'><h1>'+JSON.orderno+'</h1></p><br /> dan sudah kami terima. Untuk service silahkan Klik tombol Cetak Resi untuk dikirimkan bersamaan dengan Produk yang akan di Service..',
            closable: false,
            closeByBackdrop: false,
            closeByKeyboard: false,
            buttons: [{
              label: 'Preview Summary Order',
              closable: false,
              cssClass: 'btn btn-success',
              id: 'cmdCetakResi',
              action: function(dialog) {                  
                  dialog.close();
                  gf_cetak_resi({orderno: JSON.orderno});
                  $("#cmdClear").trigger("click");
                  objForm.find("input[type='text']").val("");
                  objForm.find("select").find("option:eq(0)").prop("selected", true);
                  $("select").selectpicker('refresh');
                  dialog.close();
                  $("#sSRNIK").focus();
              }
              }, {
                label: 'Close',
                id: 'cmdClose',
                action: function(dialog) {
                  //window.location.href = "<?php print site_url(); ?>orders/";
                  $("#cmdClear").trigger("click");
                  objForm.find("input[type='text']").val("");
                  objForm.find("select").find("option:eq(0)").prop("selected", true);
                  $("select").selectpicker('refresh');
                  dialog.close();
                  $("#sSRNIK").focus();
                }
              }]
            });
          }
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
		});
    $("#cmdSearchData").on("click", function()
    {
      var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_inv_services/gf_load_ticket/"});
      objForm.append("<input type=\"hidden\" name=\"sNoTicket\" id=\"sNoTicket\" value=\""+$.trim($("#txtSearch").val()).replace(/'/g, "`")+"\" />");
      $.gf_custom_ajax({
        "oForm": objForm,
        "success": function(r) {
          var JSON = $.parseJSON(r.oRespond);
          $("#divResult").empty();
          var d = "";
          $.each(JSON.oData, function(i, n)
          {
            if($.trim(n.nOrdersId_fk) !== "")
            { 
              d += "<div class=\"col-xs-12 col-md-4 col-sm-12 col-lg 3 form-group\"><div class=\"panel panel-success\"><div class=\"panel-heading\">Order No: <b>"+n.nOrdersId_fk+"</b><span class=\"pull-right\" id=\"smallTimeSatamp\">"+timeago.format(n.dCreateOn)+"</span></div>";
              d += "<div class=\"panel-body\">";
              d += "<p><i class=\"fa fa-clock-o\"></i> Order Date: <b>"+n.dCreateOn+"</b></p>";
              d += "<p>Order Type: <b>"+n.sNamaTypeOrders+"</b></p>";
              d += "<p>Serial Number: <b>"+n.sSRSN+"</b></p>";
              d += "<p>Nama Produk: <b>"+n.sSRProductName+"</b></p>";
              d += "<p>No Ticket: <b>"+n.sSRNoTicket+"</b></p>";
              d += "<p>Deskripsi: <br /><b>"+n.sSRDeskripsi+"</b></p>";
              d += "<p>Qty: <b>"+n.nSRQty+"</b></p>";
              d += "<p>No Ticket: <b>"+n.sSRNoTicket+"</b></p>";
              d += "<hr />";
              d += "<p>Last Status: <a noorder=\""+n.nOrdersId_fk+"\" class=\"text-green\" noticket=\""+n.sSRNoTicket+"\" href=\"#\" id=\"aTrackingDetail\" title=\"Click here to View Detail Tracking.\"><b>"+n.sLastStatus+"</b></a></p>";
              d += "</div>";
              //if(parseInt(n.nIdStatus_fk) === 5)
              //  d += "<div class=\"panel-footer\"><button class=\"btn-block btn btn-danger\" type=\"button\" title=\"Batalkan Order Ini !\">BATALKAN</button></div>";
              d += "</div></div>";
            }
          });
          $("#divResult").html("Data tidak ditemukan. Masukan No Ticket yang valid.")
          if($.trim(d) !== "")
            $("#divResult").empty().append("<div class=\"row\"><div class=\"row\">"+d+"</div></div>");

          $("a[id='aTrackingDetail']").unbind("click").on("click", function()
          {
            var oObj = $(this);
            var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_inv_services/gf_load_tracking_orders/"});
            objForm.append("<input type=\"hidden\" name=\"nOrdersId\" id=\"nOrdersId\" value=\""+$.trim(oObj.attr("noorder"))+"\" />");
            objForm.append("<input type=\"hidden\" name=\"sNoTicket\" id=\"sNoTicket\" value=\""+$.trim(oObj.attr("noticket"))+"\" />");
            var d = null;
            $.gf_custom_ajax({
              "oForm": objForm,
              "success": function(r) {
                var JSON = $.parseJSON(r.oRespond);
                var s = "";
                $.each(JSON.oData, function(i, n)
                {
                  s += "<li class=\"timeline-item\"><div class=\"timeline-info\"><span><i class=\"fa fa-calendar text-green\"></i> "+n.dStatusDateTime+"</span></div><div class=\"timeline-marker\"></div><div class=\"timeline-content\">";
                  s += "<p style=\"font-weight: bold;\">"+n.sNamaStatus+"</p>";
                  if($.trim(n.sNotes) !== "null" && n.sNotes !== null)
                    s += "<p>Notes: <b>"+n.sNotes+"</b></p>";
                  s += "<p><i class=\"fa fa-user-o\"></i> "+n.sCreateBy+"</p>";
                  s += "</div></li>";
                });
                d.getModalBody().html("<div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><ul class=\"timeline\">"+s+"</ul></div></div>");
              },
              "validate": true,
              "beforeSend": function(r) {
              d = BootstrapDialog.show({
                  title: 'Tracking Detail Order No: <b>'+$.trim(oObj.attr("noorder"))+'</b> & No Ticket: <b>'+$.trim(oObj.attr("noticket"))+'</b>',
                  message: '<div id=\"divTrackingInfo\">Info Tracking</div>',
                  buttons: [{
                      label: 'Close',
                      action: function(dialog) {
                          d.close();
                      }
                  }]
                });
              },
              "beforeSendType": "custom",
              "error": function(r) {}
            });     
          });      
        },
        "validate": true,
        "beforeSend": function(r) {
          $("#divResult").html("<div class=\"text-center\"><i class=\"fa fa-spin fa-4x text-green\"></i><br />Loading...</div>");
        },
        "beforeSendType": "custom",
        "error": function(r) {}
      });
    });
  });
  function gf_cetak_resi(options)
  {
    var nOrderId = options.orderno;
    $.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nOrdersId", sFieldNameValue: nOrderId, nIdReport: 11, sFieldNameLabel: "Order Id", sTitleDialog: "Print Order: <b>"+nOrderId+"</b>"});
  }
  function gf_reset_no()
  {
    $("span[id='spanNo']").each(function(i, n)
    {
      $(this).html(i+1);
    });
    $("input[content-mode='numeric']").autoNumeric('init', {
			mDec: '0',
      vMin: 1,
      vMax: 999
		}).addClass("text-right");
  }
</script>