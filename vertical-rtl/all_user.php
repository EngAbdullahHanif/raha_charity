<?php 
    require_once('includes/child.php');
    $child = new Child();
    $connection = $child->get_conn();


    //Every pages
	session_start();
	
	if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
		header('Location:login.php');
		exit();
	}
	
	
    
//    $user_id = $_GET['id'];

   $query = $child->select_users();
   $user = $query->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
    

<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:51 GMT -->
<?php
    include_once("includes/head.php");
    ?>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <?php 
            include_once("includes/sidebar.php");
            ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                   <?php
                    include_once("includes/header.php");
                    ?>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h2 class="page-title m-0">مشخصات کاربران </h2>
                                            </div>
                                           
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end page-title-box -->
                                </div>
                            </div> 
                            <!-- end page title -->

                            <div class="row">
                                
                            
                                 <div class="card-body">
                                    
                                     <p>
								    <input type="button" value="Print Table" onclick="myApp.printTable()" />
                                    </p>
                                            <h2 class="mt-0 header-title">جزییات بیشتر</h2>
                                          
                                            <div class="table-responsive">
                                                <table id="datatable" class="table table-dark mb-0" dir="rtl" >
                                                    <thead style="color:white !important">
                                                    <tr>
                                                        
                                                        <th>نام کاربری</th>
                                                        <th>تاریخ راجستر</th>
                                                        <th>نوت</th>
                                                        <th>ایمیل</th>
                                                        <th>نوع کاربر</th>
                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        
                                                        <td><?php echo $user['username']?></td>
                                                        <td><?php echo $user['register_date']?></td>
                                                        <td><?php echo $user['notes']?></td>
                                                        <td><?php echo $user['email']?></td>
                                                        <td><?php echo $user['type']?></td>
                                                      
                                                        <td></td>
                                                    </tr>
                                                   
                                                   
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                
                            </div>
                          

                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <?php
                include_once("includes/footer.php");
                ?>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->
 <script>
  var myApp = new function () {
        this.printTable = function () {
            var divToPrint = document.getElementById('datatable');
			
			 var htmlToPrint = '' +
								'<style type="text/css">' +
								'table th, table td {' +
								'border:1px solid #000;' +
								'padding:0.5em;' +
								'}' +
								'</style>';
			 
			 htmlToPrint += divToPrint.outerHTML;
			 
			    win = window.open("");

			win.document.write(htmlToPrint);
            win.document.close();
            win.print();
        }
    }
    </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:51 GMT -->
</html>