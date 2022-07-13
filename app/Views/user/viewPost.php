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
                        <h1 class="h3 mb-0 text-gray-800">All Post</h1> 
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
.addnew{
    margin: auto;background-color: #d8eafa;color: #33ecff; font-size: 200px; line-height: 1px; cursor:pointer;
}
.addnew:hover{
    background-color: #f7d8fa;
    color: #ff33b7;
   
}
.bg{
    background-image: url('<?= base_url(); ?>/assets/images/bg.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: 400px 285px;
}
</style>
 <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
<div class="bg">
    <div class="card-body" style="text-align: center;">
        <div class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3 addnew" onclick="myFunction()">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </div>
    </div>
</div>

</div>

                        <!-- Area profile -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Make A New Content</h6>
                                </div>
                            <div class="card-body" id="postdiv" style="display: none;">
<form method="post" name="postform" action="createPost" enctype="multipart/form-data">
 <div class="form-group row"> 
  <label for="select" class="col-4 col-form-label">Select Photo</label> 
  <div class="col-8">
    <input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/*" required>
  </div>
</div>
<div class="form-group row">
  <label for="publicinfo" class="col-4 col-form-label">Description</label> 
  <div class="col-8">
    <textarea id="Description" name="Description" placeholder="Description" required cols="40" rows="4" class="form-control"></textarea>
  </div>
</div>
<div class="form-group row">
  <div class="offset-4 col-8">
    <button name="submit" type="submit" class="btn btn-primary btn-block">Post</button>
  </div>
</div>
</form>
                             </div>
                            </div>
<script type="text/javascript">
function myFunction() {
    var check = document.getElementById('postdiv');
    if (check.style.display === 'none') {
        check.style.display = 'block';
    } else {
        check.style.display = 'none';
    }
}
</script> 

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