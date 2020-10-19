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

$name = $quantity = $date = $unit_quantity = $step = "";

$name_err = $quantity_err = $date_err = $unit_quantity_err = $step_err = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $name_err = "نام الزامی می باشد";
    } else {
        $name = $connection->escape_string(test_input($_POST['name']));
    }
    if (empty($_POST['quantity'])) {
        $quantity_err = "تعداد الزامی می باشد";
    } else {
        $quantity = $connection->escape_string(test_input($_POST['quantity']));
    }if (empty($_POST['date'])) {
        $date_err = "تاریخ الزامی می باشد";
    } else {
        $date = $connection->escape_string(test_input($_POST['date']));
    }
    
    if (empty($_POST['unit_quantity'])) {
        $unit_quantity_err = "واحد شمارش الزامی می باشد";
    } else {
        $unit_quantity = $connection->escape_string(test_input($_POST['unit_quantity']));
    }

    if (empty($_POST['step'])) {
        $step_err = "مرحله الزامی می باشد";
    } else {
        $step = $connection->escape_string(test_input($_POST['step']));
    }
    $unit_price = 0;

    if ($name_err == "" and $quantity_err == "" and $date_err == "" and $unit_quantity_err == "" and $step_err == "") {
        $insert = $child->insert_donated_red_crescent_given($name, $quantity, $date, $unit_quantity, $unit_price, $step);

        if($insert){
            //object successfully inserted
            header("Location:red_crescent_out.php?msg=red_success");
            
        } else {
            //failed to insert object
            header("Location:red_crescent_out.php?msg=red_faild");
        }

        
    } 
}


// INPUT TEST FUNCTION 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


//DLETEING AN OBJECT
if (isset($_GET['d-id'])) {
    $needy_id = $_GET['d-id'];

    $result = $child->delete_needy_by_id($needy_id);

    if ($result) {
        header('Location:needy_person.php?msg=delete_success');
    } else {
        header('Location:needy_person.php?msg=delete_faild');
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
                                            <h4 class="page-title m-0">هلال احمر</h4>
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
                        <div class="msg">
                            <?php
                            if (isset($_GET['msg'])) {
                                if ($_GET['msg'] == 'red_success') {
                                    echo "<p style='color: green'>Items registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'red_faild') {
                                    echo "<p style='color: red'>Items fialed to register</p>";
                                }elseif ($_GET['msg'] == 'delete_faild') {
                                    echo "<p style='color: red'>item fialed to delete</p>";
                                } elseif ($_GET['msg'] == 'delete_success') {
                                    echo "<p style='color: green'>item successfully deleted</p>";
                                }
                            }
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card text-white m-b-30">
                                    <div class="card-body special-card">

                                        <h2 class="mt-0 header-large "
                                            style="text-align: center; margin:15px; padding:10px;"> فرم لیست اجناس خروجی هلال
                                            احمر</h2>

                                        <form action="red_crescent_out.php" method="post" class="form-horizontal">

                                            <!-- row starts -->
                                            <div class="row">
                                                <!-- col start -->
                                                <div class="col-6">
                                                    <form action="red_crescent.php" method="post"
                                                        class="form-horizontal">
                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label"> نام جنس</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $name?>" name="name">
                                                                <span
                                                                    style="color: red;"><?php echo $name_err; ?></span>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <label for="example-date-input"
                                                                class="col-sm-4 col-form-label"> تاریخ اهدا</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="date"
                                                                    value="<?php echo $date?>" name="date">
                                                                <span
                                                                    style="color: red;"><?php echo $date_err; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <label for="example-date-input"
                                                                class="col-sm-4 col-form-label"> مرحله اهدا</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $step?>" name="step">
                                                                <span
                                                                    style="color: red;"><?php echo $step_err; ?></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <!-- col ends -->
                                                <div class="col-6">
                                                    <!-- col starts -->
                                                    <div class="form-group row">

                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">تعداد </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $quantity ?>" name="quantity">
                                                            <span
                                                                style="color: red;"><?php echo $quantity_err; ?></span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">

                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">واحد شمارش </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" name="unit_quantity" value="<?php echo $unit_quantity ?>">
                                                                
                                                            <span
                                                                style="color: red;"><?php echo $unit_quantity_err; ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- col ends -->
                                            </div>
                                            <!-- row ends -->



                                            <!-- row starts -->

                                            <!-- row starts -->

                                            <div class="form-actions">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary waves-effect waves-light"> ذخیره</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light">
                                                    انصراف</button>
                                            </div>

                                            <!-- this is last of the first -->
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body primary-card">

                                <h4 class="mt-0 header-title">جدول اطلاعات </h4>
                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
                                </p>
                               

                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>شماره</th>
                                            <th> نام </th>
                                            <th>تعداد</th>
                                            <th>تاریخ</th>
                                            <th>مرحله</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $products = $child->select_donated_red_crescent_given();
                                            $number = 1;
                                            while ($product = $products->fetch_assoc()) :
                                            ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $number ?></td>
                                            <td><?php echo $product['name'] ?></td>
                                            <td><?php echo $product['quantity'] ?></td>
                                            <td><?php echo $product['date'] ?></td>
                                            <td><?php echo $product['step'] ?></td>
                                            <td <?php if($_SESSION['type'] == 'admin'):  ?> class="hidden-phone">
                                                <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                <a href="#"><span class="btn btn-danger">حذف </span></a>

                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php $number++;
                                            endwhile; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->






            </div><!-- container fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    <?php
        include_once("includes/footer.php");
        ?>

    </div>
    <!-- End Right content here -->


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

    <!-- Required datatable js -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/datatables/jszip.min.js"></script>
    <script src="../plugins/datatables/pdfmake.min.js"></script>
    <script src="../plugins/datatables/vfs_fonts.js"></script>
    <script src="../plugins/datatables/buttons.html5.min.js"></script>
    <script src="../plugins/datatables/buttons.print.min.js"></script>
    <script src="../plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:40 GMT -->

</html>