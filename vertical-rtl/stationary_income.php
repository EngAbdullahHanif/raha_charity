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

$name = $stock_id = $quantity = $unit_price = $type = $date = "";

$name_err = $stock_err = $type_err = $quantity_err = $unit_price_err = $date_err = "";


if (isset($_POST['submit'])) {

    if (empty($_POST['name'])) {
        $name_err = " نام الزامی می باشد.";
    } else {
        $name = $connection->escape_string(test_input($_POST['name']));
    }
    if (empty($_POST['stock'])) {
        $stock_err = " گودام مربوطه الزامی می باشد.";
    } else {
        $stock_id = $connection->escape_string(test_input($_POST['stock']));
    }
    if (empty($_POST['quantity'])) {
        $quantity_err = " تعداد الزامی می باشد.";
    } else {
        $quantity = $connection->escape_string(test_input($_POST['quantity']));
    }
    if (empty($_POST['unit_price'])) {
        $unit_price_err = " قیمت الزامی می باشد.";
    } else {
        $unit_price = $connection->escape_string(test_input($_POST['unit_price']));
    }
    if (empty($_POST['date'])) {
        $date_err = " تاریخ الزامی می باشد.";
    } else {
        $date = $connection->escape_string(test_input($_POST['date']));
    }
    if (empty($_POST['type'])) {
        $type_err = " نوع الزامی می باشد.";
    } else {
        $type = $connection->escape_string(test_input($_POST['type']));
    }

    if ($name_err == "" and $quantity_err == "" and $unit_price_err == ""  and $type_err == "" and $date_err == "" and $stock_err == "") {

        $result = $child->insert_registeration_products_stationary($name, $stock_id, $quantity, $unit_price, $type, $date);

        if ($result) {
            //Data inserted successfully 
            header('Location:stationary_income.php?msg=success');
        } else {
            //Data failed to insert
            header('Location:stationary_income.php?msg=faild');
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



//DLETEING A ROW
if (isset($_GET['d-id'])) {
    $donate_id = $_GET['d-id'];

    $result = $child->delete_donated_by_id($donate_id);

    if ($result) {
        header('Location:stationary_income.php?msg=delete_success');
    } else {
        header('Location:stationary_income.php?msg=delete_faild');
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
                                            <h2 class="page-title m-0">قرطاسیه</h2>
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
                                    echo "<p style='color: green'>Stationary registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'faild') {
                                    echo "<p style='color: red'>Stationary registerd fialed</p>";
                                }
                            }
                            ?>
                        </div>
                        <div class="row">
                            <?php if($_SESSION['type'] == 'admin'):  ?>
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-title"> فرم ثبت اقلام قرطاسیه</h4>

                                        <form action="stationary_income.php" method="post" class="form-horizontal">
                                            <?php
                                            $stationary = $child->select_stationary();
                                            $stock = $child->select_stock();


                                            ?>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">نام</label>
                                                <span style="color: red;"><?php echo $name_err; ?></span>
                                                <div class="col-sm-3">
                                                    <select class="custom-select" name="name">
                                                        <option>منوی انتخاب را باز کنید</option>

                                                        <?php
                                                        while ($result = $stationary->fetch_assoc()) :
                                                        ?>
                                                        <option value="<?php echo $result['id']; ?>" <?php if ($result['id'] == $name) {
                                                                                                                echo 'selected';
                                                                                                            } ?>>
                                                            <?php echo $result['name']; ?> </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">گدام مربوطه</label>
                                                <div class="col-sm-3">
                                                    <select class="custom-select" name="stock">
                                                        <option>منوی انتخاب را باز کنید</option>

                                                        <?php
                                                        while ($result = $stock->fetch_assoc()) :
                                                            ?>
                                                        <option value="<?php echo $result['id']; ?>" <?php if ($result['id'] == $stock_id) {
                                                            echo 'selected';
                                                        } ?>>
                                                            <?php echo $result['name']; ?> </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                    <span style="color: red;"><?php echo $stock_err; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">تعداد</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="number"
                                                        value="<?php echo $quantity ?>" name="quantity">
                                                    <span style="color: red;"><?php echo $quantity_err; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">قیمت فی
                                                    واحد</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text"
                                                        value="<?php echo $unit_price ?>" name="unit_price">
                                                    <span style="color: red;"><?php echo $unit_price_err; ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">

                                                <label for="example-date-input"
                                                    class="col-sm-2 col-form-label">تاریخ</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="date" value="<?php echo $date ?>"
                                                        name="date">
                                                    <span style="color: red;"><?php echo $date_err; ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">نوعیت</label>
                                                <div class="col-sm-3">
                                                    <select class="custom-select" name="type">
                                                        <option>منوی انتخاب را باز کنید</option>
                                                        <option value="sales" <?php if ($type == 'sales') {
                                                            echo 'selected';
                                                        } ?>> Sales </option>
                                                        <option value="purchased" <?php if ($type == 'purchased') {
                                                                                        echo 'selected';
                                                                                    } ?>> Purchased </option>
                                                    </select>
                                                    <span style="color: red;"><?php echo $type_err; ?></span>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary waves-effect waves-light"> ذخیره</button>
                                                <button type="reset" class="btn btn-danger waves-effect waves-light">
                                                    انصراف</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div><!-- container fluid -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body primary-card">

                                    <h4 class="mt-0 header-title">جدول اطلاعات</h4>

                                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
												</p>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                      dir="rtl"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام</th>
                                                <th>نوع</th>
                                                <th>گدام</th>
                                                <th>تعداد</th>
                                                <th>قیمت واحد</th>
                                                <th>قیمت کل</th>
                                                <th>تاریخ</th>
                                                <th></th>

                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            $products = $child->select_registeration_product();
                                            $number = 1;
                                            while ($product = $products->fetch_assoc()) :
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $number ?></td>
                                                <td><?php echo $product['stationary_name'] ?></td>
                                                <td><?php echo $product['type'] ?></td>
                                                <td><?php echo $product['stock_name'] ?></td>
                                                <td><?php echo $product['quantity'] ?></td>
                                                <td><?php echo $product['unit_price'] ?></td>
                                                <td><?php echo ($product['unit_price'] * $product['quantity']) ?></td>
                                                <td><?php echo $product['date'] ?></td>
                                                <td<?php if($_SESSION['type'] == 'admin'):  ?> class="hidden-phone">
                                                    <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                    <a href="stationary_income.php?d-id=<?php echo $product['regis_id'] ?>"
                                                        onclick="return confirm('آیا مطمئن هستید؟')" class="btn btn-danger">حذف</a>

                                                    <?php endif;?>
                                                    </td>
                                            </tr>
                                            <?php $number++;
                                            endwhile; ?>


                                        </tbody>
                                    </table>
                                    <?php
                                    $query = $child->select_all_stationary_price();
                                    $price = $query->fetch_assoc();
                                    ?>
                                    <h3> مجموعه قیمت های قرطاسیه = <?php echo $price['price'] ?></h3>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

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