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

$from_date = $to_date = $type = $step =   "";

$from_date_err = $to_date_err =  $type_err = $step_err ="";

if (isset($_POST['submit'])) {
    if (empty($_POST['from_date'])) {
        $from_date_err = "شروع تاریخ الزامی میباشد";
    } else {
        $from_date = $_POST['from_date'];
    }

    if (empty($_POST['to_date'])) {
        $to_date_err = "ختم تاریخ الزامی میباشد";
    } else {
        $to_date = $_POST['to_date'];
    }

    if (empty($_POST['type'])) {
        $type_err = "نوعیت الزامی میباشد";
    } else {
        $type = $_POST['type'];
    }



    if ($from_date_err == "" and $to_date_err == "" and $type_err == "") {
        if ($type == 'purchased') {
            $sql = $child->select_red_crescent_purchased_date_report($from_date, $to_date);
            $result = $sql->fetch_assoc();
        } else {
            if (empty($_POST['step'])) {
                $sql = $child->select_red_crescent_given_date_report($from_date, $to_date);
            } else {
                $step = $_POST['step'];
                $sql = $child->select_red_crescent_given_date_report_stepped($from_date, $to_date, $step);
            }
            $result = $sql->fetch_assoc();
        }
    }
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
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-large "
                                            style="text-align: center; margin:15px; padding:10px;"> صفحه راپور هلال احمر
                                        </h4>
                                        <form action="red_crescent_report.php" method="post" class="form-group">
                                            <div class="row">
                                                <div class="form-group row col-6">
                                                    <span style="color: red;"><?php echo $from_date_err; ?></span>
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">از
                                                        تاریخ </label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="date"
                                                            value="<?php echo $from_date ?>" name="from_date">
                                                    </div>
                                                </div>
                                                <div class="form-group row col-6">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">الی
                                                        تاریخ </label>
                                                    <span style="color: red;"><?php echo $to_date_err; ?></span>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="date"
                                                            value="<?php echo $to_date  ?>" name="to_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group row col-6">
                                                    <label class="col-sm-4 col-form-label"> نوعیت جنس </label>
                                                    <span style="color: red;"><?php echo $type_err; ?></span>
                                                    <div class="col-sm-6">
                                                        <select class="custom-select" name="type">
                                                            <option selected>منوی انتخاب را باز کنید</option>
                                                            <option value="purchased" <?php if ($type == 'purchased') {
                                                                                            echo 'selected';
                                                                                        } ?>> وارد شده </option>
                                                            <option value="given" <?php if ($type == 'given') {
                                                                                        echo 'selected';
                                                                                    } ?>> خارج شده </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row col-6">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">
                                                        مرحله </label>
                                                    <span style="color: red;"><?php echo $step_err; ?></span>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="text"
                                                            value="<?php echo $step  ?>" name="step">
                                                    </div>
                                                </div>
                                                <div class="form-actions col-6 ">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary waves-effect waves-light pl-4 pr-4 ">
                                                        تایید</button>
                                                </div>
                                            </div>
                                            <?php
                                            if ($from_date != "" and $to_date != "" and $type != "") :
                                            ?>
                                            <div class="row mt-3 mr-3">
                                                <h5>از تاریخ <?php echo $from_date ?> الی تاریخ <?php echo $to_date ?>‌
                                                    مجموعا <span
                                                        style="font-size: 23px;"><?php if ($result['quantity'] == NULL) {
                                                                                                                                                                        echo "<span style='color:red;'> هیچ </span>   اقلام وارد نشده اند";
                                                                                                                                                                    } else {
                                                                                                                                                                        echo $result['quantity'];
                                                                                                                                                                      ?></span>
                                                    <?php if ($type == 'purchased') {
                                                                                                                                                                                                                                                                        echo 'اقلام  وارد شده اند';
                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                        echo 'خارج شده اند';
                                                                                                                                                                                                                                                                    } }?>
                                                </h5>
                                            </div>
                                            <?php endif; ?>


                                        </form>
                                    </div>
                                </div>




                                <?php
                                if ($from_date != "" and $to_date != "" ) :

                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-30">
                                            <div class="card-body primary-card">
                                                <h4 class="mt-2 header-large mb-3"> راپور اقلام وارد شده از تاریخ
                                                    <?php echo $from_date ?> الی تاریخ <?php echo $to_date ?></h4>
												<p>
													<input type="button" value="Print Table" onclick="myApp3.printTable3()" />
												</p>
                                                <table id="datatable3" class="table table-bordered dt-responsive nowrap" dir="rtl"
                                                  dir="rtl"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>اسم جنس</th>
                                                            <th>مجموع وارد شده</th>
                                                            <th> مجموع خارج شده</th>
                                                            <th> واحد شمارش</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $query = $child->select_red_crescent_items();
                                                            while ($item = $query->fetch_assoc()) :
                                                                $query1 = $child->select_red_cresecnt_puchased_item_date_report($item['name'], $from_date, $to_date);
                                                                $purchased = $query1->fetch_assoc();
                                                                $query2 = $child->select_red_cresecnt_given_item_date_report($item['name'], $from_date, $to_date);
                                                                $given = $query2->fetch_assoc();

                                                            ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $item['name']; ?></td>
                                                            <td><?php echo $purchased['quantity']; ?></td>
                                                            <td><?php echo $given['quantity']  ?></td>
                                                        </tr>
                                                        <?php
                                                            endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <?php endif?>
                                <?php 
                                    if  ($step != ""):
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-30">
                                            <div class="card-body primary-card">
                                                <h4 class="mt-2 header-large mb-3"> راپور اقلام وارد شده از تاریخ
                                                    <?php echo $from_date ?> الی تاریخ <?php echo $to_date ?></h4>
												<p>
													<input type="button" value="Print Table" onclick="myApp3.printTable3()" />
												</p>
                                                <table id="datatable3" class="table table-bordered dt-responsive nowrap" dir="rtl"
                                                  dir="rtl"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>اسم جنس</th>
                                                            <th>مجموع وارد شده</th>
                                                            <th> مجموع خارج شده</th>
                                                            <th> واحد شمارش</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $query = $child->select_red_crescent_items();
                                                            while ($item = $query->fetch_assoc()) :
                                                                $query1 = $child->select_red_cresecnt_puchased_item_date_report_stepped($item['name'], $from_date, $to_date);
                                                                $purchased = $query1->fetch_assoc();
                                                                $query2 = $child->select_red_cresecnt_given_item_date_report_stepped($item['name'], $from_date, $to_date);
                                                                $given = $query2->fetch_assoc();

                                                            ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $item['name']; ?></td>
                                                            <td><?php echo $purchased['quantity']; ?></td>
                                                            <td><?php echo $given['quantity']  ?></td>
                                                        </tr>
                                                        <?php
                                                            endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            <?php endif;?>
    

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-30">
                                            <div class="card-body primary-card">
                                                <h4 class="mt-0 header-large">مجموع اقلام وارد شده</h4>
												
												<p>
													<input type="button" value="Print Table" onclick="myApp2.printTable2()" />
												</p>

                                                <table id="datatable2" class="table table-bordered dt-responsive nowrap" dir="rtl"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>اسم جنس</th>
                                                            <th>مجموع وارد شده</th>
                                                            <th> مجموع خارج شده</th>
                                                            <th> واحد شمارش</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = $child->select_red_crescent_items();
                                                        while ($item = $query->fetch_assoc()) :
                                                            $query1 = $child->select_red_crescent_purchased_item_quantiy($item['name']);
                                                            $purchased = $query1->fetch_assoc();
                                                            $query2 = $child->select_red_crescent_given_item_quantiy($item['name']);
                                                            $given = $query2->fetch_assoc();
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $item['name']; ?>
                                                            </td>
                                                            <td><?php echo $purchased['quantity'] ?></td>
                                                            <td><?php echo $given['quantity'] ?></td>
                                                            <td><?php echo $item['unit_quantity'] ?></td>
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

    var myApp2 = new function () {
        this.printTable2 = function () {
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
	
    var myApp3 = new function () {
        this.printTable3 = function () {
            var divToPrint = document.getElementById('datatable3');
			
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
	
	var myApp4 = new function () {
        this.printTable4 = function () {
            var divToPrint = document.getElementById('datatable4');
			
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