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



$name = $code = $type = $description = "";

$name_err = $code_err = $type_err = $description_err = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $name_err = " نام الزامی می باشد.";
    } else {
        $name = $connection->escape_string(test_input($_POST['name']));
    }
    if (empty($_POST['code'])) {
        $code_err = " کد الزامی می باشد.";
    } else {
        $code = $connection->escape_string(test_input($_POST['code']));
    }

    if (empty($_POST['description'])) {
        $description_err = " توضیحات الزامی می باشد.";
    } else {
        $description = $connection->escape_string(test_input($_POST['description']));
    }

    if ($name_err == "" and $code_err == "" and $description_err == "") {
        $result = $child->insert_stationary($name, $code, $description);

        if ($result) {
            //Data inserted successfully 
            header('location:add_stationary.php?msg=success');
        } else {
            //Data faild to insert
            header('location:add_stationary.php?msg=faild');
        }
    }
}

//DLETEING A ROW
if (isset($_GET['d-id'])) {
    $stationary_id = $_GET['d-id'];

    $result = $child->delete_stationary($stationary_id);

    if ($result) {
        header('Location:add_stationary.php?msg=delete_success');
    } else {
        header('Location:add_stationary.php?msg=delete_faild');
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
                        <div class="msg">
                            <?php
                            if (isset($_GET['msg'])) {
                                if ($_GET['msg'] == 'success') {
                                    echo "<p style='color: green'>stationary item registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'faild') {
                                    echo "<p style='color: red'>stationary item registeration fialed</p>";
                                } elseif ($_GET['msg'] == 'delete_faild') {
                                    echo "<p style='color: red'>stationary item fialed to delete</p>";
                                } elseif ($_GET['msg'] == 'delete_success') {
                                    echo "<p style='color: green'>stationary item successfully deleted</p>";
                                }
                            }
                            ?>
                        </div>
                        <div class="row">
						<?php if($_SESSION['type'] == 'admin'):  ?>
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-large " style="text-align: center; margin:15px; padding:10px;"> فرم ثبت اقلام قرطاسیه</h4>

                                        <form action="add_stationary.php" method="post" class="form-horizontal">

                                            <div class="form-group row">

                                                <label for="example-text-input" class="col-sm-2 col-form-label"> نام </label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $name ?>" name="name">
                                                    <span style="color: red;"><?php echo $name_err; ?></span>
                                                </div>
                                            </div>




                                            <div class="form-group row">

                                                <label for="example-text-input" class="col-sm-2 col-form-label"> کد</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $code ?>" name="code">
                                                    <span style="color: red;"><?php echo $code_err; ?></span>
                                                </div>
                                            </div>



                                            <div class="form-group row">

                                                <label for="example-url-input" class="col-sm-2 col-form-label">توضیحات</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $description ?>" name="description">
                                                    <span style="color: red;"><?php echo $description; ?></span>
                                                </div>
                                            </div>



                                            <div class="form-actions">
                                                <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light"> ذخیره</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light"> انصراف</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
								<?php endif;?>
                            </div>

                        </div><!-- container fluid -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body primary-card">

                                        <h4 class="mt-0 header-title">جدول اطلاعات</h4>
                                        

                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>شماره</th>
                                                    <th>نام</th>
                                                    <th>کد</th>
                                                    <th>توضیحات</th>
                                                    <th></th>

                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                $stationary_items = $child->select_stationary();
                                                while ($stationary = $stationary_items->fetch_assoc()) :
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td><input type="checkbox" class="checkboxes" value="1" /></td>

                                                        <td><?php echo $stationary['name'] ?></td>
                                                        <td><?php echo $stationary['code'] ?></td>
                                                        <td><?php echo $stationary['description'] ?>
														<td <?php if($_SESSION['type'] == 'admin'):  ?>
                                                         class="hidden-phone">
                                                            <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                            <a href="add_stationary.php?d-id=<?php echo $stationary['id'] ?>" onclick="return confirm('ایا مطمئن هستید؟')"><span class="btn btn-danger">حذف </span></a>
                                                        
														<?php endif;?>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- Page content Wrapper -->
                </div>
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