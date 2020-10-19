<?php
require_once('includes/child.php');
$child = new Child();
$connection = $child->get_conn();

//Every pages
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location:login.php');
    exit();
}




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
                                            <h4 class="page-title m-0">صفحه خالی</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="float-right d-none d-md-block">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings mr-1"></i> تنظیمات
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                                        <a class="dropdown-item" href="#">عملیات</a>
                                                        <a class="dropdown-item" href="#">اقدام دیگر</a>
                                                        <a class="dropdown-item" href="#">چیز های دیگر</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">پیوند جدا شده</a>
                                                    </div>
                                                </div>
                                            </div>
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
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-large " style="text-align: center; margin:15px; padding:10px;"> صفحه راپور اطفال </h4>
                                        <div class="card-body">
                                            <?php
                                            $query1 = $child->select_gender_boy();
                                            $boys = $query1->fetch_assoc();
                                            $query2 = $child->select_gender_girl();
                                            $girls = $query2->fetch_assoc();

                                            ?>
                                            <h4 class="mt-0 header mb-4"> تعداداطفال نظر به جنسیت</h4>
                                            <ol class="activity-feed mb-0">
                                                <li class="feed-item">
                                                    <div class="feed-item-list">
                                                        <span class="activity-text text-white">مذکر: <?php echo $boys['boys'] ?></span>
                                                    </div>
                                                </li>
                                                <li class="feed-item">
                                                    <div class="feed-item-list">
                                                        <span class="activity-text text-white">مونث: <?php echo $girls['girls'] ?></span>
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-30">
                                            <div class="card-body primary-card">
                                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
                                                </p>
                                                <h4 class="mt-0 header-large">تعدادنظر به سن</h4>
                                                
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>عمر (سال)</th>
                                                            <th>مذکر</th>
                                                            <th>مونث</th>
                                                            <th>مجموع</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = $child->select_ages();
                                                        while ($year = $query->fetch_assoc()) :
                                                            $query1 = $child->select_age_children_boys($year['year']);
                                                            $boys = $query1->fetch_assoc();
                                                            $query2 = $child->select_age_children_girls($year['year']);
                                                            $girls = $query2->fetch_assoc();
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td><?php echo (date("Y") - $year['year']); ?></td>
                                                                <td><?php echo $boys['boy'] ?></td>
                                                                <td><?php echo $girls['girls'] ?></td>
                                                                <td><?php echo $boys['boy'] + $girls['girls'] ?></td>
                                                            </tr>
                                                        <?php
                                                        endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <hr>
                                            <div class="card-body primary-card">
                                                <h4 class="mt-0 header-large">تعداد نظر به منطقه</h4>
                                                
                                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
                                                </p>
                                                <table id="datatable1" class="table table-bordered dt-responsive nowrap" dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>منطقه</th>
                                                            <th>مذکر</th>
                                                            <th>مونث</th>
                                                            <th>مجموع</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = $child->select_places();
                                                        while ($place = $query->fetch_assoc()) :
                                                        $query2 = $child->select_places_girls($place['place']);
                                                        $girls = $query2->fetch_assoc();
                                                        $query1 = $child->select_places_boys($place['place']);
                                                        $boys = $query1->fetch_assoc();
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td><?php echo $place['place']; ?></td>
                                                                <td><?php echo $boys['boys'] ?></td>
                                                                <td><?php echo $girls['girls'] ?></td>
                                                                <td><?php echo $boys['boys'] + $girls['girls'] ?></td>
                                                            </tr>
                                                        <?php
                                                        endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <hr>
                                            <div class="card-body primary-card">
                                                 
                                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
                                                </p>
                                                <h4 class="mt-0 header-large">تعداد نظر به شغل</h4>
                                                <table id="datatable2" class="table table-bordered dt-responsive nowrap" dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>شغل</th>
                                                            <th>مذکر</th>
                                                            <th>مونث</th>
                                                            <th>مجموع</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = $child->select_jobs();
                                                        while ($job = $query->fetch_assoc()) :
                                                        $query2 = $child->select_jobs_girls($job['jobs']);
                                                        $girls = $query2->fetch_assoc();
                                                        $query1 = $child->select_jobs_boys($job['jobs']);
                                                        $boys = $query1->fetch_assoc();
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td><?php echo $job['jobs']; ?></td>
                                                                <td><?php echo $boys['boys'] ?></td>
                                                                <td><?php echo $girls['girls'] ?></td>
                                                                <td><?php echo $boys['boys'] + $girls['girls'] ?></td>
                                                            </tr>
                                                        <?php
                                                        endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->


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
     <script>
  var myApp = new function () {
        this.printTable = function () {
            var divToPrint = document.getElementById('datatable1');
			
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
    
         <script>
  var myApp = new function () {
        this.printTable = function () {
            var divToPrint = document.getElementById('datatable2');
			
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