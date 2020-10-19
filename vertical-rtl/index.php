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


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:42:14 GMT -->
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
                                            <h4 class="page-title m-0">داشبورد</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="float-right d-none d-md-block">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti-settings mr-1"></i> تنظیمات
                                                    </button>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
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
                            <div class="col-xl-6 col-md-12 ">
                                <div class="card bg-primary mini-stat text-white ">
                                    <div class="p-3 mini-stat-desc">
                                        <div class="clearfix">
                                            <?php
                                            $query1 = $child->select_gender_boy();
                                            $boys = $query1->fetch_assoc();
                                            $query2 = $child->select_gender_girl();
                                            $girls = $query2->fetch_assoc();

                                            ?>
                                            <h4 class="text-uppercase mt-0 float-left "> اطفال تحت پوشش</h4>
                                            <h4 class="mb-3 mt-0 float-right"><?php echo $girls['girls'] ?></h4>
                                        </div>
                                        <div>
                                            <span class="ml-8"> فرشته های رها: <?php echo $girls['girls'] ?> </span>
                                            <br>
                                            <span class="ml-8"> اطفال تحت پوشش قرطاسیه: <?php echo $boys['boys'] ?> </span>
                                        </div>

                                    </div>
                                    <div class="p-3">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i
                                                    class="mdi mdi-cube-outline h5"></i></a>
                                        </div>
                                        <p class="font-14 m-0">مجموع : <?php echo  $girls['girls'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="card bg-info mini-stat text-white">
                                    <div class="p-3 mini-stat-desc">
                                        <div class="clearfix">
                                            <?php
                                            $query1 = $child->select_sum_registeration_stationary();
                                            $stationary = $query1->fetch_assoc();
                                            $query2 = $child->select_sum_given_products_stationary();
                                            $give_products = $query2->fetch_assoc();
                                            ?>
                                            <h4 class="text-uppercase mt-0 float-left ">تعداد اقلام قرطاسیه</h4>
                                            <!-- <h4 class="mb-3 mt-0 float-right">1,587</h4> -->
                                        </div>
                                        <div>
                                            <span class="ml-8"> ورودی: <?php echo $stationary['quantity'] ?> </span>
                                            <br>
                                            <span class="ml-8"> خروجی: <?php echo $give_products['quantity'] ?>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="p-3">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i
                                                    class="mdi mdi-cube-outline h5"></i></a>
                                        </div>
                                        <p class="font-14 m-0"> باقی مانده :
                                            <?php echo ($stationary['quantity'] - $give_products['quantity']); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="card bg-pink mini-stat text-white">
                                    <div class="p-3 mini-stat-desc">
                                        <div class="clearfix">
                                            <?php
                                            $query1 = $child->select_sum_registeration_clothes();
                                            $clothes = $query1->fetch_assoc();
                                            $query2 = $child->select_sum_given_products_clothes();
                                            $give_products = $query2->fetch_assoc();
                                            ?>
                                            <h4 class="text-uppercase mt-0 float-left ">تعداد اقلام لباس</h4>
                                        </div>
                                        <div>
                                            <span class="ml-8"> ورودی: <?php echo $clothes['quantity'] ?> </span>
                                            <br>
                                            <span class="ml-8"> خروجی: <?php echo $give_products['quantity'] ?> </span>
                                        </div>

                                    </div>
                                    <div class="p-3">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i
                                                    class="mdi mdi-cube-outline h5"></i></a>
                                        </div>
                                        <p class="font-14 m-0">باقی مانده  :
                                            <?php echo ($clothes['quantity'] - $give_products['quantity']); ?></p>
                                       
                                    </div>
                                </div>
                            </div>
                             <div class="col-xl-6 col-md-12">
                                <div class="card bg-success mini-stat text-white">
                                    <div class="p-3 mini-stat-desc">
                                        <div class="clearfix">
                                            <?php
                                            $query1 = $child->select_program();

                                            $query2 = $child->select_count_programs();
                                            $programs = $query2->fetch_assoc();
                                            ?>
                                            <h4 class="text-uppercase mt-0 float-left ">پروگرام ها</h4>

                                            <h4 class="mb-3 mt-0 float-right"><?php echo $programs['programs'] ?></h4>
                                        </div>
                                        <?php
                                        while ($programs = $query1->fetch_assoc()) :
                                        ?>
                                        <div>
                                            <span class="ml-8"> <?php echo $programs['name'] ?> </span>
                                        </div>
                                        <?php endwhile; ?>

                                    </div>
                                    <div class="p-3">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i
                                                    class="mdi mdi-cube-outline h5"></i></a>
                                        </div>
                                        <!-- <p class="font-14 m-0">مجموع باقی مانده : </p> -->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- end row -->

                        <div class="row">
                           

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

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js"></script>
        <script src="../plugins/raphael/raphael.min.js"></script>
        <script src="assets/pages/morris.init.js"></script>        

        <!-- App js -->
        <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:42:42 GMT -->

</html>