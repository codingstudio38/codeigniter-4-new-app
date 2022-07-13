<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/images/favicon.ico">
    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/dashboard/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="<?= base_url(); ?>/dashboard/vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
      <?php include_once('components/slider-menu.php'); ?>
        

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include_once('components/header.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">User Profile</h1> 
<?php if (session()->getFlashdata('successMsg') !== NULL) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Status</strong> <?php echo session()->getFlashdata('successMsg'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('errorsMsg') !== NULL) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Status</strong> <?php echo session()->getFlashdata('errorsMsg'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
<?php $errors = null; if (session()->getFlashdata('errorC') !== NULL) : ?>
<?php $errors = session()->getFlashdata('errorC'); ?>

 <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Status</strong> <br>
<?php foreach($errors as $key => $error) { ?>
<?= $error."<br>"; ?>
<?php  }?>      
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

<style type="text/css">
.profile-image-pic {
    height: 200px;
    width: 200px;
    object-fit: cover;
}
.rounded-circle {
    border-radius: 50% !important;
}
.img-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    max-width: 100%;
}
</style>
 <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
<div class="card shadow mb-4">
    <div style="background-color: #074066;" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold" style="color:white;"><i class="fas fa-user fa-sm fa-fw" aria-hidden="true"></i>Profile</h6>
    </div>
    <div class="card-body" style="text-align: center;">
        <button class="btn btn-info" id="editPbtn" style="float: right; margin-top: -15px ;"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        <button class="btn btn-info" id="cancel" style="float: right; margin-top: -15px ; display: none;"><i class="fa fa-times" aria-hidden="true"></i>
</button>
        <br>
<?php if($userdata['pthumbnail']==null) { ?>
    <p style="display: none;" id="photo"><?= base_url('assets/images/p.JPG'); ?></p>
    <img src="<?= base_url('assets/images/p.JPG'); ?>" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" alt="profile" id="imgProfile" width="200px">
<?php } else { ?>        
    <p style="display: none;" id="photo"><?= base_url('/uploads/profile_pic'); ?>/<?= $userdata['pthumbnail']; ?></p>
    <img src="<?= base_url('/uploads/profile_pic'); ?>/<?= $userdata['pthumbnail']; ?>" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" alt="profile" id="imgProfile" width="200px">
<?php }?>
<form action="updatephoto" name="userProfiel" id="userProfiel" style="display:none;" method="post" enctype="multipart/form-data">    
<?= csrf_field(); ?>  
<div class="input-group">
  <div class="input-group-prepend">
    <button type="submit" class="input-group-text" id="Upload" style="cursor: pointer;">Upload</button>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input" required name="profileInput" accept="image/png, image/gif, image/jpeg" id="profileInput" aria-describedby="Upload">
    <label class="custom-file-label" id="imgname" for="profileInput">Choose file</label>
  </div>
</div>
</form>  
<br>
<?php if (session()->getFlashdata('successMsgP') !== NULL) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Status</strong> <?php echo session()->getFlashdata('successMsgP'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div> 
<?php endif; ?>
<?php if (session()->getFlashdata('errorsMsgP') !== NULL) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Status</strong> <?php echo session()->getFlashdata('errorsMsgP'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
<?php $errorsP = null; if (session()->getFlashdata('errorsP') !== NULL) : ?>
<?php $errorsP = session()->getFlashdata('errorsP'); ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Status</strong> <?php echo $errorsP['profileInput']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
       <h3><?php echo $userdata['uname']; ?> <c><i style="color: #20d820;" class="fa fa-star" aria-hidden="true"></c></i>
</h3>
    </div>
</div>
<div class="card shadow mb-4">
<div style="background-color: #ffa935;" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold" style="color:white;" ><i class="fa fa-lock" aria-hidden="true"></i>
Login Details</h6>
</div>
<div class="card-body">
    <b><i class="fa fa-envelope" aria-hidden="true"></i> </b><?php echo $userdata['uemail']; ?>
    <div class="dropdown-divider"></div>
    <b><i class="fa fa-phone-square" aria-hidden="true"></i> </b><?php echo $userdata['uphone']; ?>
    <div class="dropdown-divider"></div>
    <b><i class="fas fa-sign-in-alt" aria-hidden="true"></i> </b><?php echo $userLogindata['logintime']; ?>
    <div class="dropdown-divider"></div>
    <b><i class="fa fa-desktop" aria-hidden="true"></i> <c style="color: #17e817;">Active On</c></b>
    <p><?php echo $userLogindata['system']; ?></p>
    <div class="dropdown-divider"></div>
     <button name="submit" type="button" class="btn btn-danger btn-block">Delete Account</button>
</div>
</div>

<div class="card shadow mb-4">
<div style="background-color: #22ce08;" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold"  style="color:white;" ><i class="fa fa-map-marker" aria-hidden="true"></i>
 Address Details</h6>
</div>
<div class="card-body">
    <b>Address: </b><?= $userdata['paddress']?$userdata['paddress']:"N/A"; ?>
    <div class="dropdown-divider"></div>
    <b>City: </b><c id="htcity"><?=  $userdata['pcity']?$userdata['pcity']:"N/A"; ?></c>
    <div class="dropdown-divider"></div>
    <b>State: </b><c id="htstate"><?=  $userdata['pstate']?$userdata['pstate']:"N/A"; ?></c>
    <div class="dropdown-divider"></div>
    <b>Country: </b><c id="htcountry"><?= $userdata['pcountry']?$userdata['pcountry']:"N/A"; ?></c>
</div>
</div>
    </div>

                        <!-- Area profile -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Name</h6>
<button class="btn btn-info"  id="nedit"  onclick="{$('#namediv').css('display','block');$('#ncancel').css('display','block');$('#nedit').css('display','none');}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<button style="display: none;" id="ncancel" class="btn btn-info" onclick="{$('#namediv').css('display','none');$('#ncancel').css('display','none');$('#nedit').css('display','block');}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            <div class="card-body" id="namediv" style="display: none;">
                            <form action="updateName" method="post" name="updateName" id="updateName">
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">Name*</label> 
                                <div class="col-8">
                                  <input id="Name" name="Name" placeholder="Full Name" class="form-control here" required="required" type="text" value="<?php echo $userdata['uname']; ?>">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Update Name</button>
                                </div>
                              </div>
                            </form>
                             </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Email Id</h6>
<button class="btn btn-info"  id="eedit"  onclick="{$('#emaildiv').css('display','block');$('#ecancel').css('display','block');$('#eedit').css('display','none');}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<button style="display: none;" id="ecancel" class="btn btn-info" onclick="{$('#emaildiv').css('display','none');$('#ecancel').css('display','none');$('#eedit').css('display','block');}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            <div class="card-body" style="display:none;" id="emaildiv">
                           <form action="updateEmail" method="post" name="updateEmail" id="updateEmail">
                            <?= csrf_field(); ?>  
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">Email Id*</label> 
                                <div class="col-8">
                                  <input id="Email_Id" name="Email_Id" placeholder="Email Id" class="form-control here" required="required" value="<?php echo $userdata['uemail']; ?>" type="email">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Update Email</button>
                                </div>
                              </div>
                            </form>
                             </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Phone No</h6>
<button class="btn btn-info"  id="pedit"  onclick="{$('#phonediv').css('display','block');$('#pcancel').css('display','block');$('#pedit').css('display','none');}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<button style="display: none;" id="pcancel" class="btn btn-info" onclick="{$('#phonediv').css('display','none');$('#pcancel').css('display','none');$('#pedit').css('display','block');}"><i class="fa fa-times" aria-hidden="true"></i></button>                                    
                                </div>
                            <div class="card-body" style="display:none;" id="phonediv">
                            <form action="updatePhone" method="post" name="updatePhone" id="updatePhone">
                                <?= csrf_field(); ?>  
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">Phone No*</label> 
                                <div class="col-8">
                                  <input id="Phone_No" name="Phone_No" placeholder="Phone No" class="form-control here" required="required" value="<?php echo $userdata['uphone']; ?>" type="text" onkeypress="return isNumberKey(event)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Update Phone</button>
                                </div>
                              </div>
                            </form>
                             </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
<button class="btn btn-info"  id="passedit"  onclick="{$('#passdiv').css('display','block');$('#passcancel').css('display','block');$('#passedit').css('display','none');}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<button style="display: none;" id="passcancel" class="btn btn-info" onclick="{$('#passdiv').css('display','none');$('#passcancel').css('display','none');$('#passedit').css('display','block');}"><i class="fa fa-times" aria-hidden="true"></i></button>   
                                </div>
                            <div class="card-body" style="display:none;" id="passdiv">
                           <form action="updatePassword" method="post" name="updatePassword" id="updatePassword">
                            <?= csrf_field(); ?>  
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">Current Password*</label> 
                                <div class="col-8">
                                  <input id="Current_Password" name="Current_Password" placeholder="Current Password" class="form-control here" required="required" type="password">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="username" class="col-4 col-form-label">New Password*</label> 
                                <div class="col-8">
                                  <input id="New_Password" name="New_Password" placeholder="New Password" class="form-control here" required="required" type="password">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                              </div>
                            </form>
                             </div>
                            </div>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Address</h6>
<button class="btn btn-info"  id="addedit"  onclick="{$('#adddiv').css('display','block');$('#addcancel').css('display','block');$('#addedit').css('display','none');}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<button style="display: none;" id="addcancel" class="btn btn-info" onclick="{$('#adddiv').css('display','none');$('#addcancel').css('display','none');$('#addedit').css('display','block');}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            <div class="card-body" style="display:none;" id="adddiv">
                             <form method="post" name="addressform" action="updateAddress" >
                                <?= csrf_field(); ?>
                              <div class="form-group row"> 
                                <label for="select" class="col-4 col-form-label">Country</label> 
                                <div class="col-8">
                                  <select id="Country" name="Country" class="custom-select">
                                    <option value="">Select Country</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="select" class="col-4 col-form-label">State</label> 
                                <div class="col-8">
                                  <select id="State" name="State" class="custom-select">
                                    <option value="">Select State</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="select" class="col-4 col-form-label">City</label> 
                                <div class="col-8">
                                  <select id="City" name="City" class="custom-select">
                                    <option value="">Select City</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="publicinfo" class="col-4 col-form-label">Location/Land Mark</label> 
                                <div class="col-8">
                                  <textarea id="address" name="address" placeholder="Location/Land Mark" cols="40" rows="4" class="form-control"><?php echo $userdata['paddress']; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Update Address</button>
                                </div>
                              </div>
                            </form>
                             </div>
                            </div>



                        </div>

                       
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Copyright 2021 All Rights Reserved. Developer By <a href="https://www.softwareflame.com/" target="_blank">Softwareflame</a></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="userlogout">Logout</a>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
 function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
}    
$(document).ready(function(){
    getcountry();


let state = $("#htstate").html().trim();
if(!(state=="N/A")){
$("#State").empty();        
var optionss = document.createElement("option");
optionss.value = state;
optionss.text = state;
optionss.setAttribute('selected','selected');
$("#State").append(optionss);    
}

let city = $("#htcity").html().trim();
if(!(city=="N/A")){
$("#City").empty();    
var optioncc = document.createElement("option");
optioncc.value = city;
optioncc.text = city;
optioncc.setAttribute('selected','selected');
$("#City").append(optioncc);    
}

  $("#editPbtn").click(function(){
    $("#editPbtn").css('display','none');
    $("#cancel").css('display','block');
    $("#userProfiel").css('display','block');
  });
  $("#cancel").click(function(){
    $("#editPbtn").css('display','block');
    $("#cancel").css('display','none');
    $("#userProfiel").css('display','none');
    $("#imgname").html("Choose file");
    $("#profileInput").val("");
    $("#imgProfile").attr('src', $("#photo").html().trim());
  });

    $('#profileInput').on('change', function () {
        var fileName = $(this).val().split("\\").pop();
        $("#imgname").html(fileName);
       if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgProfile').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
//htcity,htstate,htcountry
    function getcountry(){
    let setcountry = $("#htcountry").html().trim();
    $.ajax({
    method:"GET",
    url: '<?php echo base_url("user/getcountry") ?>',
    success: function (data) {
      //console.log(data.country);return;
    if(data.status== 400){
            alert("Soorry No Records Found..");return;
        } else {
            $("#Country").empty();
            var optiont = document.createElement("option");
            optiont.value = "";
            optiont.text = "Select Country";
            $("#Country").append(optiont);
            data.country.forEach((i, key) => {
                if(i.name==setcountry){
                    var option = document.createElement("option");
                    option.value = i.id.trim();
                    option.text = i.name.trim();
                    option.setAttribute('selected','selected');
                    $("#Country").append(option);
                } else {
                    var option = document.createElement("option");
                    option.value = i.id.trim();
                    option.text = i.name.trim();
                    $("#Country").append(option);
                }
            });
        }
      }
    });
    }
    $("#Country").change(function(){
        let setstate = $("#htstate").html().trim();
        let country = $("#Country").val();
        if(country==""){
           alert("Please Select Country..");return; 
        } else {
            $.ajax({
            method:"POST",
            url: '<?php echo base_url("user/getstate") ?>',
            data:{'country':country},
            success: function (data) {
            //console.log(data);return;
            if(data.status== 400){
                 alert("Soorry No Records Found..");return;
            } else {
                $("#State").empty();
                data.state.forEach((i, key) => {
                    if(i.statename==setstate){
                        var options = document.createElement("option");
                        options.value = i.id.trim();
                        options.text = i.statename.trim();
                        options.setAttribute('selected','selected');
                        $("#State").append(options);
                    } else {
                        var options = document.createElement("option");
                        options.value = i.id.trim();
                        options.text = i.statename.trim();
                        $("#State").append(options);
                    }
                });
                }
              }
            });
        }
    });

    $("#State").change(function(){
        let setcity = $("#htcity").html().trim();
        let state = $("#State").val();
        if(state==""){
           alert("Please Select State..");return; 
        } else {
            $.ajax({
            method:"POST",
            url: '<?php echo base_url("user/getcity") ?>',
            data:{'state':state},
            success: function (data) {
            //console.log(data); return;
            if(data.status== 400){
                    alert("Soorry No Records Found..");return;
                } else {
                    $("#City").empty();
                    data.city.forEach((i, key) => {
                        if(i.cityName==setcity){
                            var optionc = document.createElement("option");
                            optionc.value = i.id.trim();
                            optionc.text = i.cityName.trim();
                            optionc.setAttribute('selected','selected');
                            $("#City").append(optionc);
                        } else {
                            var optionc = document.createElement("option");
                            optionc.value = i.id.trim();
                            optionc.text = i.cityName.trim();
                            $("#City").append(optionc);
                        }
                    });
                }
              }
            });
        }
    });

});
</script>

    <!-- Bootstrap core JavaScript-->
   
    <script src="<?= base_url(); ?>/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>/dashboard/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url(); ?>/dashboard/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url(); ?>/dashboard/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url(); ?>/dashboard/js/demo/chart-pie-demo.js"></script>

</body>

</html>