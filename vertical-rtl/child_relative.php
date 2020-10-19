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



//Variables are decilared to null
$fname = $lname = $father_name = $dob = $job = $incomeperday = $class = $school = $relation_status = $maritalstatus = $is_responsible = $child_id = "";


//Errors varibles are decilared to null
$fname_err = $lname_err = $father_name_err = $dob_err = $job_err = $incomeperday_err = $class_err = $school_err = $relation_status_err = $maritalstatus_err = $is_responsible_err = "";


if (isset($_GET['id'])) {
    $child_id = $_GET['id'];
}

if (isset($_POST['submit'])) {
    if (empty($_POST['fname'])) {
        $fname_err = " نام الزامی می باشد.";
    } else {
        $fname = $connection->escape_string(test_input($_POST['fname']));
    }
    if (empty($_POST['lname'])) {
        $lname_err = "  نام فامیلی الزامی می باشد.";
    } else {
        $lname = $connection->escape_string(test_input($_POST['lname']));
    }
    if (empty($_POST['fathername'])) {
        $father_name_err = " نام پدر الزامی می باشد.";
    } else {
        $father_name = $connection->escape_string(test_input($_POST['fathername']));
    }
    if (empty($_POST['dob'])) {
        $dob_err = "  تاریخ تولد الزامی می باشد.";
    } else {
        $dob = $connection->escape_string(test_input($_POST['dob']));
    }
    if (empty($_POST['job'])) {
        $job_err = "  شغل  الزامی می باشد.";
    } else {
        $job = $connection->escape_string(test_input($_POST['job']));
    }
    if (empty($_POST['incomeperday'])) {
        $incomeperday_err = "   در امد روزانه الزامی می باشد.";
    } else {
        $incomeperday = $connection->escape_string(test_input($_POST['incomeperday']));
    }
    if (empty($_POST['class'])) {
        $class_err = "  صنف الزامی می باشد.";
    } else {
        $class = $connection->escape_string(test_input($_POST['class']));
    }
    if (empty($_POST['school'])) {
        $school_err = "  مکتب الزامی می باشد.";
    } else {
        $school = $connection->escape_string(test_input($_POST['school']));
    }
    if (empty($_POST['relation_status'])) {
        $relation_status_err = "  نسبت با طفل الزامی می باشد.";
    } else {
        $relation_status = $connection->escape_string(test_input($_POST['relation_status']));
    }
    if (empty($_POST['maritalstatus'])) {
        $maritalstatus_err = "    حالت مدنی الزامی می باشد.";
    } else {
        $maritalstatus = $connection->escape_string(test_input($_POST['maritalstatus']));
    }
    if (empty($_POST['is_responsible'])) {
        $is_responsible_err = "   در امد اور خانه الزامی می باشد.";
    } else {
        $is_responsible = $connection->escape_string(test_input($_POST['is_responsible']));
    }
    //hidden field child id
    $child_id = $_POST['child_id'];

    //Checks if not duplicate
    $has_relative = $child->has_relative($child_id, $fname);
    $result = $has_relative->fetch_assoc();
    if ($result > 0) {
        //Duplicated
        header('Location:child_relative.php?msg=duplicate');
    } else {
        //Not duplicated
        //checking for requierd fields
        if ($fname_err == "" and $lname_err == "" and $father_name_err == "" and $dob_err == "" and $job_err == "" and $incomeperday_err == "" and  $class_err == "" and $school_err == "" and $relation_status_err == "" and $maritalstatus_err == "" and $is_responsible_err == "") {
            //checking passed
            $result = $child->insert_relatives($child_id, $fname, $lname, $father_name, $dob, $job, $incomeperday, $class, $school, $relation_status, $maritalstatus, $is_responsible);

            if ($result) {
                //inserted successfully
                header('Location:child_relative.php?msg=success');
            } else {
                //failed to insert
                header('Location:child_relative.php?msg=faild');
            }
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
                        <div class="msg">
                            <?php
                            if (isset($_GET['msg'])) {
                                if ($_GET['msg'] == 'success') {
                                    echo "<p style='color: green'>child registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'faild') {
                                    echo "<p style='color: red'>child registerd fialed</p>";
                                } elseif ($_GET['msg'] == 'duplicate') {
                                    echo "<p style='color:darkorange'>Duplicate Entry, child relative is already saved</p>";
                                }
                            }
                            ?>
                        </div>

                        <div class="row">
                            <?php if($_SESSION['type'] == 'admin'):  ?>
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-large "
                                            style="text-align: center; margin:15px; padding:10px;"> فورم ثبت اقارب اطفال
                                        </h4>

                                        <form action="child_relative.php" method="post" class="form-horizontal">
                                            <input type="hidden" name="child_id" value="<?php echo $child_id ?>">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">نسبت با طفل</label>
                                                        <span
                                                            style="color: red;"><?php echo $relation_status_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="relation_status">
                                                                <option>منوی انتخاب را باز کنید</option>
                                                                <option value="مادر" <?php if ($relation_status == 'مادر') {
                                                                                            echo 'selected';
                                                                                        } ?>>مادر</option>
                                                                <option value="پدر" <?php if ($relation_status == 'پدر') {
                                                                                        echo 'selected';
                                                                                    } ?>> پدر </option>
                                                                <option value="خواهر" <?php if ($relation_status == 'خواهر') {
                                                                                            echo 'selected';
                                                                                        } ?>> خواهر </option>
                                                                <option value="برادر" <?php if ($relation_status == 'برادر') {
                                                                                            echo 'selected';
                                                                                        } ?>> برادر </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">نام فامیلی</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $lname ?>" name="lname">
                                                            <span style="color: red;"><?php echo $lname_err; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-date-input"
                                                            class="col-sm-4 col-form-label">تاریخ تولد</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="date"
                                                                value="<?php echo $dob ?>" name="dob">
                                                            <span style="color: red;"><?php echo $dob_err; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">درآمد روزانه</label>
                                                        <span
                                                            style="color: red;"><?php echo $incomeperday_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $incomeperday ?>" name="incomeperday">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            نام مکتب</label>
                                                        <span style="color: red;"><?php echo $school_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $school ?>" name="school">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">درآمد آورخانه</label>
                                                        <span
                                                            style="color: red;"><?php echo $is_responsible_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="is_responsible">
                                                                <option>منوی انتخاب را باز کنید</option>
                                                                <option value="1" <?php if ($is_responsible == '1') {
                                                                                        echo 'selected';
                                                                                    } ?>> بله </option>
                                                                <option value="2" <?php if ($is_responsible == '2') {
                                                                                        echo 'selected';
                                                                                    } ?>> نخیر </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">نام</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $fname ?>" name="fname">
                                                            <span style="color: red;"><?php echo $fname_err; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">نام پدر</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $father_name ?>" name="fathername">
                                                            <span
                                                                style="color: red;"><?php echo $father_name_err; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">شغل</label>
                                                        <span style="color: red;"><?php echo $job_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $job ?>" name="job">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">صنف</label>
                                                        <span style="color: red;"><?php echo $class_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $class ?>" name="class">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            حالت مدنی</label>
                                                        <span
                                                            style="color: red;"><?php echo $maritalstatus_err; ?></span>
                                                        <div class="col-sm-6">
                                                            <div class="btn-group btn-group-toggle"
                                                                data-toggle="buttons">
                                                                <label class="btn btn-light active">
                                                                    <input type="radio" name="maritalstatus"
                                                                        value="مجرد" checked>
                                                                    مجرد
                                                                </label>
                                                                <label class="btn btn-light">
                                                                    <input type="radio" name="maritalstatus"
                                                                        value="متاهل" id="option2"> متاهل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" name="submit"
                                                    class="btn btn-success waves-effect waves-light"> ذخیره</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light">
                                                    انصراف</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-30">
                                            <div class="card-body primary-card">

                                                <h4 class="mt-0 header-title">جدول اطلاعات</h4>


                                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                   dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>شماره</th>
                                                            <th>نام</th>
                                                            <th>نام پدر</th>
                                                            <th>شغل</th>
                                                            <th>درآمدروزانه</th>
                                                            <th>نسبت با طفل</th>
                                                            <th>نام طفل</th>
                                                            <th>معلومات بیشتر</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $num = 1;
                                                        $relatives = $child->select_relatives();
                                                        while ($relative = $relatives->fetch_assoc()) :
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo $num; ?></td>
                                                            <td><?php echo $relative['fname'] . $relative['lname']; ?>
                                                            </td>
                                                            <td class="hidden-phone">
                                                                <?php echo $relative['fathername']; ?></td>
                                                            <td class="hidden-phone"><?php echo $relative['job']; ?>
                                                            </td>
                                                            <td class="center hidden-phone">
                                                                <?php echo $relative['incomeperday']; ?></td>
                                                            <td class="hidden-phone">
                                                                <?php echo $relative['relation_status']; ?></td>
                                                            <td class="hidden-phone">
                                                                <?php echo $relative['child_name']; ?></td>
                                                            <td class="hidden-phone"><a
                                                                    href="child_relative.php?id=<?php echo $relative['Child_id'] ?>"><span
                                                                        class="btn btn-primary">جزییات بیشتر</span></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            $num++;
                                                        endwhile;
                                                        ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->


                            </div>
                        </div> <!-- end col -->
                    </div>

                </div><!-- container fluid -->

            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        <?php
        include_once("includes/footer.php");
        ?>

    </div>
    <!-- End Right content here -->



    <!-- END wrapper -->


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