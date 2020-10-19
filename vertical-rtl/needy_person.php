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

$fname = $lname = $dob = $referal = $phone_num = $placeofbirth = $address =  "";

$fname_err = $lname_err = $dob_err = $phone_num_err = $placeofbirth_err = $address_err = $referal_err =  "";

if (isset($_POST['submit'])) {
    if (empty($_POST['fname'])) {
        $fname_err = "نام الزامی می باشد";
    } else {
        $fname = $connection->escape_string(test_input($_POST['fname']));
    }

    if (empty($_POST['lname'])) {
        $lname_err = "تخلص الزامی می باشد";
    } else {
        $lname = $connection->escape_string(test_input($_POST['lname']));
    }

    if (empty($_POST['dob'])) {
        $dob_err = "نام الزامی می باشد";
    } else {
        $dob = $connection->escape_string(test_input($_POST['dob']));
    }

    if (empty($_POST['phone_num'])) {
        $phone_num_err = "نام الزامی می باشد";
    } else {
        $phone_num = $connection->escape_string(test_input($_POST['phone_num']));
    }

    if (empty($_POST['placeofbirth'])) {
        $placeofbirth_err = "نام الزامی می باشد";
    } else {
        $placeofbirth = $connection->escape_string(test_input($_POST['placeofbirth']));
    }

    if (empty($_POST['address'])) {
        $address_err = "نام الزامی می باشد";
    } else {
        $address = $connection->escape_string(test_input($_POST['address']));
    }

    if (empty($_POST['referal'])) {
        $referal_err = "نام الزامی می باشد";
    } else {
        $referal = $connection->escape_string(test_input($_POST['referal']));
    }

    if ($fname_err == "" and $lname_err == "" and $dob_err == "" and $phone_num_err == "" and $placeofbirth_err == ""  and $address_err == ""  and $referal_err == "") {
        $check = $child->check_needy_person($fname, $lname, $referal);
        $result = $check->fetch_assoc();
        if($result > 0){
            //object allready exist, duplicated
            header("Location:needy_person.php?msg=needy_duplicate");
        } else {
            $insert = $child->insert_needy_person($fname, $lname,  $dob, $phone_num, $placeofbirth, $address, $referal);
            if($insert){
                //object successfully inserted
                header("Location:needy_person.php?msg=needy_success");
                
            } else {
                //failed to insert object
                header("Location:needy_person.php?msg=needy_failed");
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
                                            <h4 class="page-title m-0">افراد نیازمند</h4>
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
                                if ($_GET['msg'] == 'needy_success') {
                                    echo "<p style='color: green'>Items registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'needy_failed') {
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
                            <?php if($_SESSION['type'] == 'admin'):  ?>
                            <div class="col-12">
                                <div class="card text-white m-b-30">
                                    <div class="card-body special-card">

                                        <h2 class="mt-0 header-large "
                                            style="text-align: center; margin:15px; padding:10px;"> فرم ثبت افراد
                                            نیازمند</h2>

                                        <form action="needy_person.php" method="post" class="form-horizontal">


                                            <!-- row starts -->
                                            <div class="row">
                                                <!-- col start -->
                                                <div class="col-6">
                                                    <form action="needy_person.php" method="post"
                                                        class="form-horizontal">
                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">نام</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $fname ?>" name="fname">
                                                                <span
                                                                    style="color: red;"><?php echo $fname_err; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">نام فامیلی</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $lname ?>" name="lname">
                                                                <span
                                                                    style="color: red;"><?php echo $lname_err; ?></span>
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
                                                                class="col-sm-4 col-form-label">مرجع معرفی کننده
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $referal ?>" name="referal">
                                                                <span
                                                                    style="color: red;"><?php echo $referal_err; ?></span>
                                                            </div>
                                                        </div>

                                                </div>
                                                <!-- col ends -->


                                                <div class="col-6">
                                                    <!-- col starts -->

                                                    <div class="form-group row">

                                                        <label for="example-tel-input"
                                                            class="col-sm-4 col-form-label">شماره تماس</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="tel"
                                                                value="<?php echo $phone_num ?>" name="phone_num">
                                                            <span
                                                                style="color: red;"><?php echo $phone_num_err; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">محل تولد</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $placeofbirth ?>" name="placeofbirth">
                                                            <span
                                                                style="color: red;"><?php echo $placeofbirth_err; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="example-url-input"
                                                            class="col-sm-4 col-form-label">آدرس</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $address ?>" name="address">
                                                            <span style="color: red;"><?php echo $address_err; ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- col ends -->
                                            </div>
                                            <!-- row ends -->

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
                <?php endif;?>


                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body primary-card">

                                <h4 class="mt-0 header-title">جدول اطلاعات</h4>
                                
                                                    <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
                                                    </p>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                 dir="rtl"   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>شماره</th>
                                            <th>نام</th>
                                            <th>نام فامیلی</th>
                                            <th>مرجع معرفی کننده</th>
                                            <th>شماره تماس</th>
                                            <th>تاریخ تولد</th>
                                            <th>محل تولد</th>
                                            <th>ادرس</th>
                                            <th></th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php 
                                            $num = 1;
                                            $needies = $child->select_needy_person();
                                            while($needy = $needies->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo $num;?></td>
                                            <td><?php echo $needy['fname'];?></td>
                                            <td><?php echo $needy['lname'];?></td>
                                            <td><?php echo $needy['referal'];?></td>
                                            <td><?php echo $needy['phone_num'];?></td>
                                            <td><?php echo $needy['DOB'];?></td>
                                            <td><?php echo $needy['placeofbirth'];?></td>
                                            <td><?php echo $needy['address'];?></td>
                                            <?php if($_SESSION['type'] == 'admin'):  ?>
                                            <td>
                                                <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                <a href="needy_person.php?d-id=<?php echo $needy['idNeedy_Person'] ?>"
                                                    onclick="return confirm('ایا مطمین مستید؟')"><button type="submit"
                                                        name="delete"><span
                                                            class="btn btn-danger">حذف</span></button></a>
                                                <a href="needy_clothes.php?id=<?php echo $needy['idNeedy_Person'] ?>"><span
                                                        class="btn btn-primary">ثبت لباس</span></a>
                                            </td>
                                            <?php endif;?>
                                        </tr>
                                        <?php $num++; endwhile;?>
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