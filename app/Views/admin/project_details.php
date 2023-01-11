<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo Project</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href=".<?php echo base_url(); ?>/public/assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/dropzone/min/dropzone.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/dist/css/radiobutton.css">
</head>
<style type="text/css">
  .modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 450px;
    overflow-y: auto;
}
.select2-container--default .select2-selection--single .select2-selection__clear{display: none;}
</style>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?= $this->include('layout/head') ?>
  <!-- Main Sidebar Container -->
  <?php 
    echo $this->include('layout/adminsidebar');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Project Excel Import</h1>
          </div>
          <div class="col-sm-4">
            <div id="impdiv" class="alert alert-success alert-dismissible" role="alert" style="display:none"></div>
            <?php
              if(session()->getFlashdata('status')){
            ?>
                <div id="status_div" class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong><?= session()->getFlashdata('status'); ?></strong> 
                  <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php
              }
            ?>
            <?php $validation =  \Config\Services::validation(); ?>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Import</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- <form enctype="multipart/form-data" action="<?= base_url('patientinfo/importfile'); ?>" method="post"> -->
                  <!-- <h3 class="card-title">Baseline Patient Information</h3> -->
                  <div class="row">

                    <div class="col-md-3 form-group ">
                      <!-- <button class="btn btn-success btn-sm" id="imptdata">Bulk Import Patient Basic Data</button> -->

                      <!-- Basic Details Modal -->
                      <div class="modal" id="impexpmodal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Information</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form id="exlform" method="post" action="<?= base_url('projectinfo/importfile'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                  <div class="col-md-3">
                                    <input type="file" name="csv" id="csv"><br>
                                  </div>
                                  <div class="col-md-3">
                                    <button id="prevfile" class="btn btn-sm mt-2 mb-2 btn-outline-success">Preview Data</button>
                                      <div class="custom-file pull-right">
                                        <!-- <a href="<?= base_url('patientinfo/export'); ?>" class="btn btn-sm mt-2 mb-2 btn-outline-primary">Download Sample</a> -->
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div style="background-color:red;height:10px;width:10px;"></div> Empty/Wrong Input                                      
                                  </div>
                                  <div class="col-md-3">
                                      <div style="background-color:gray;height:10px;width:10px;"></div> Duplicate Record                                      
                                  </div>
                                  <div class="col-md-12">
                                    <div style="overflow-x: auto; overflow-y: auto;" >
                                      
                                      <table id="viewTable" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th>Sr. No.</th>
                                            <th>SapID</th>
                                            <th>Hostname</th>
                                            <th>Loopback</th>
                                            <th>Mac Address</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" id="submitimport" disabled>Save</button>
                              <!-- <button type="submit" class="btn btn-primary" id="submit">Save</button> -->
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="btn-group">
                        <button class="btn btn-success btn-sm" href="javascript:void(0)" id="imptdata">Import Excel Data</button>
                      </div>
                    </div>
                  </div>
                <!-- </form> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr.No.</th>
                    <th class="duplifer-highlightdups">SapID</th>
                    <th>Hostname</th>
                    <th>Loopback</th>
                    <th>Mac Address</th>
                    <!-- <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $this->include('layout/footer') ?>
  <!-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer> -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/popper/popper.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>/public/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>/public/assets/dist/js/demo.js"></script>
<script src="<?php echo base_url(); ?>/public/assets/dist/js/jquery-duplifer.js"></script>
<!-- Page specific script -->
<script type="text/javascript">
  $('#status_div').delay(800).fadeOut('slow');
  $(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
  
</script>
<script>
///////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// Validate all fields using Functions //////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
  function isValidMACAddress(str) {
      // Regex to check valid
      // MAC_Address 
      let regex = new RegExp(/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})|([0-9a-fA-F]{4}.[0-9a-fA-F]{4}.[0-9a-fA-F]{4})$/);
   
      // if str
      // is empty return false
      if (str == null) {
          return false;
      }
   
      // Return true if the str
      // matched the ReGex
      if (regex.test(str) == true) {
          return true;
      }
      else {
          return false;
      }
  }

  function ValidateIPaddress(ipaddress) {  
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress)) {  
      return (true);
    }  
    // alert("You have entered an invalid IP address!");
    return (false);
  }

  function validateDomain(domain){
    // var pattern = /^[a-zA-Z\-]{3,}(\.(com|net|in|org|gov|edu|mil))?$/;
    // if(pattern.test(domain)) {
    //     return (true);
    // }
    // return (false);
    // alert(domain);
    var status = false;
    $.ajax({
      url: site_url + "/projectdata/validateDom",
      type: "post",
      data: ({ domain:domain }),
      async: false,
      success: function(data){
        console.log(data);
        var parsejson = JSON.parse(data);
        status = parsejson.status;
        // // alert(parsejson.status);
        // if(parsejson.status=="true"){
        //   // alert(parsejson.status);
        //   var status = true;
        //   // return true;
        //   return status;
        // }else{
        //   var status = false;
        //   // return false;
        //   return status;
        // }
      },error:function(){
        alert('error'); return false;
      }
    });
    // alert(status);
    return status;
  }

///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Datattable Declare for Display Records //////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    var site_url = "<?php echo base_url(); ?>";
    var table = "";
    $(document).ready( function () {
        table = $('#example1').DataTable({
          lengthMenu: [[ 10, 30, -1], [ 10, 30, "All"]], // page length options
          bProcessing: true,
          serverSide: true,
          scrollY: "400px",
          scrollCollapse: true,
          ajax: {
            url: site_url + "/projectdata/projectdata_ajax", // json datasource
            type: "post",
            data: function ( d ) {
                d.project_id = ''
            },
            error: function (respon) {  // error handling
                console.log(respon);
            }
          },
          columnDefs: [
            { orderable: false, targets: [0, 1, 2, 3] }
          ],
          bFilter: true, // to display datatable search
        });
    });

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Open Modal /////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#imptdata', function(){
      $('#exlform')[0].reset();
      $('#viewTable').DataTable().rows().remove().draw();
      $('#impexpmodal').modal('show');
    });

    function reload_table(){
        // alert("hi");
        table.clear().draw();
        table.ajax.reload();
    }

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Declare Datatable //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    var dataTable = "";
    $(document).ready(function() {
        dataTable = $("#viewTable").DataTable();
    });

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Highlight Records //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
  function highlight(){
    var tableRows = $("#viewTable tr td:nth-child(2)"); //find all the rows
    // alert(tableRows);
    var colors = ["gray"];
    var rowValues = {};
    tableRows.each(function() {
      var rowValue = $(this).find("input[type='text']").val();
      if(rowValue==""){
        $(this).css('backgroundColor', "red");
        $('#submitimport').prop('disabled', true);
      }else{
        $(this).css('backgroundColor', "white");
        $('#submitimport').prop('disabled', false);
      }
      if (!rowValues[rowValue]) {
        var rowComposite = new Object();
        rowComposite.count = 1;
        rowComposite.row = this;
        rowComposite.color = colors.shift();
        rowValues[rowValue] = rowComposite;
      } else {
        var rowComposite = rowValues[rowValue];
        rowComposite.count++;
        $(this).css('backgroundColor', "gray");
        $(rowComposite.row).css('backgroundColor', "gray");
        $('#submitimport').prop('disabled', true);
      }
    });

    // Second column
    var tableRows = $("#viewTable tr td:nth-child(3)"); //find all the rows
    var rowValues = {};
    tableRows.each(function() {
      // var rowValue = $(this).text();
      var rowValue = $(this).find("input[type='text']").val();
      var result = validateDomain(rowValue);
      // alert(result);
      if(rowValue==""){
        $(this).css('backgroundColor', "red");
        $('#submitimport').prop('disabled', true);
      }else{
        // console.log(validateDomain(rowValue));
        if(result=="true"){
          $(this).css('backgroundColor', "white");
          $('#submitimport').prop('disabled', false);
        }else{
          $(this).css('backgroundColor', "red");
          $('#submitimport').prop('disabled', true);
        }
      }
      if (!rowValues[rowValue]) {
        var rowComposite = new Object();
        rowComposite.count = 1;
        rowComposite.row = this;
        rowComposite.color = colors.shift();
        rowValues[rowValue] = rowComposite;
      } else {
        var rowComposite = rowValues[rowValue];
        rowComposite.count++;
        $(this).css('backgroundColor', "gray");
        $(rowComposite.row).css('backgroundColor', "gray");
        $('#submitimport').prop('disabled', true);
      }
    });

    // Third column
    var tableRows = $("#viewTable tr td:nth-child(4)"); //find all the rows
    var rowValues = {};
    tableRows.each(function() {
      // var rowValue = $(this).text();
      var rowValue = $(this).find("input[type='text']").val();
      console.log(rowValue);
      if(rowValue==""){
        $(this).css('backgroundColor', "red");
        $('#submitimport').prop('disabled', true);
      }else{
        if(ValidateIPaddress(rowValue)){
          $(this).css('backgroundColor', "white");
          $('#submitimport').prop('disabled', false);
        }else{
          $(this).css('backgroundColor', "red");
          $('#submitimport').prop('disabled', true);
        }
      }
      if (!rowValues[rowValue]) {
        var rowComposite = new Object();
        rowComposite.count = 1;
        rowComposite.row = this;
        rowComposite.color = colors.shift();
        rowValues[rowValue] = rowComposite;
      } else {
        var rowComposite = rowValues[rowValue];
        rowComposite.count++;
        $(this).css('backgroundColor', "gray");
        $(rowComposite.row).css('backgroundColor', "gray");
        $('#submitimport').prop('disabled', true);
      }
    });

    // Fourth column
    var tableRows = $("#viewTable tr td:nth-child(5)"); //find all the rows
    var rowValues = {};
    tableRows.each(function() {
      // var rowValue = $(this).text();
      var rowValue = $(this).find("input[type='text']").val();
      if(rowValue==""){
        $(this).css('backgroundColor', "red");
        $('#submitimport').prop('disabled', true);
      }else{
        // alert(isValidMACAddress(rowValue));
        if(isValidMACAddress(rowValue)){
          $(this).css('backgroundColor', "white");
          $('#submitimport').prop('disabled', false);
        }else{
          $(this).css('backgroundColor', "red");
          $('#submitimport').prop('disabled', true);
        }
      }
      if (!rowValues[rowValue]) {
        var rowComposite = new Object();
        rowComposite.count = 1;
        rowComposite.row = this;
        rowComposite.color = colors.shift();
        rowValues[rowValue] = rowComposite;
      } else {
        var rowComposite = rowValues[rowValue];
        rowComposite.count++;
        $(this).css('backgroundColor', "gray");
        $(rowComposite.row).css('backgroundColor', "gray");
        $('#submitimport').prop('disabled', true);
      }
    });
  }

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Onchange Event /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
function change_data(input_value,dataid,type){
    console.log(input_value+" "+dataid+" "+type);
    highlight();
}


///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Preview Records ////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click','#prevfile', function(event){
      event.preventDefault();
      $('#viewTable').DataTable().rows().remove().draw();
      var counter = 1;
      var ext = $('#csv').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['xlsx']) == -1) {
          $('#exlform')[0].reset();
          alert('Invalid Extension! Please Choose Only Xlsx Format'); return false;
      }
      else{
        $.ajax({
          url: site_url + "/projectdata/previewexcel_ajax",
          type: "post",
          encType: 'multipart/form-data',
          contentType: false,
          processData: false,
          data: new FormData($('#exlform')[0]),
          success: function(data){
             var parsejson = JSON.parse(data);
             $.each(parsejson, function(i, value) {
              //dataTable.row.Add
                $.each(value,function(j, dt){
                  dataTable.row.add( [
                    dt.sr_no,
                    "<input type=\"text\" onchange=\"change_data(this.value,'sapid"+dt.sr_no+"', 'sapid')\" class=\"form-control\" id=\"sapid"+dt.sr_no+"\" name=\"sapid[]\" value=\""+dt.sapid+"\">",
                    "<input type=\"text\" onchange=\"change_data(this.value,'hostname"+dt.sr_no+"', 'hostname')\" class=\"form-control\" id=\"hostname"+dt.sr_no+"\" name=\"hostname[]\" value=\""+dt.hostname+"\">",
                    "<input type=\"text\" onchange=\"change_data(this.value,'loopback"+dt.sr_no+"', 'loopback')\" class=\"form-control\" id=\"loopback"+dt.sr_no+"\" name=\"loopback[]\" value=\""+dt.loopback+"\">",
                    "<input type=\"text\" onchange=\"change_data(this.value,'macaddress"+dt.sr_no+"', 'macaddress')\" class=\"form-control\" id=\"macaddress"+dt.sr_no+"\" name=\"macaddress[]\" value=\""+dt.macaddress+"\">",
                    dt.action,
                  ] ).draw( false );
                  counter++;
                });
                $("#viewTable tr td:empty").css('background-color', 'red');
                // $(".find-duplicates").duplifer();
                highlight();
             });
          },error:function(){
            alert('error'); return false;
          }
        });
      }
    });

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Delete Records /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.deleterow', function() {
  var id = $(this).attr('at');
  // alert(id);
  if (confirm('Are You Sure Want To Delete This Record ? ')) {  
    $("#availability"+id).val('');
    $(this).closest('tr').remove();
    highlight();
  }
})
</script>
<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Save Data Records //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////

  $(document).on('click', '#submitimport',function(){
    // var validresult = highlight();
    // if(validresult){
      var fileInput = $.trim($("#csv").val());
      if (fileInput == '') {      
              alert('Please Select File');
              return false;    
      }else{
        $.ajax({
          url: site_url + "/projectinfo/importfile",
          type: "post",
          encType: 'multipart/form-data',
          contentType: false,
          processData: false,
          data: new FormData($('#exlform')[0]),
          success:function(data){
            var msg = JSON.parse(data);
            if (msg.status == 'success') {
              $('#exlform')[0].reset();
              $('#impexpmodal').modal('hide');
              $('#impdiv').html('<strong>'+msg.message+'</strong>').fadeIn(300).delay(1000).fadeOut(300);
              $('#example1').DataTable().ajax.reload();
            }
          },error:function(){
            alert('Error');
          }
        });
      }
    // }else{
    //   alert("Kindly check all records");
    // }
  });
</script>
</body>
</html>
