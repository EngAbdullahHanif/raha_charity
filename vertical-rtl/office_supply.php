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



$name = $code = $specification = $responsible_person = $section = $stock_id = $type = $status = $unit_price = $quantity = $date = $transaction_type = "";

$name_err = $responsible_person_err = $stock_err = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $name_err = " نام الزامی می باشد.";
    } else {
        $name = $connection->escape_string(test_input($_POST['name']));
    }

    if (empty($_POST['responsible_person'])) {
        $responsible_person_err = " شخص مربوطه الزامی می باشد.";
    } else {
        $responsible_person = $connection->escape_string(test_input($_POST['responsible_person']));
    }
    if (empty($_POST['stock'])) {
        $stock_err = " گدام الزامی می باشد.";
    } else {
        $stock_id = $connection->escape_string(test_input($_POST['stock']));
    }

    $specification =  $connection->escape_string(test_input($_POST['specification']));

    $type =  $connection->escape_string(test_input($_POST['type']));
    $status =  $connection->escape_string(test_input($_POST['status']));
    $section = $_POST['section'];
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $transaction_type = $_POST['transaction_type'];


    if ($name_err == ""  and $responsible_person_err == "" and $stock_err == "") {
        $query = $child->check_office_items($name, $specification, $responsible_person, $section, $stock_id, $type, $status);
        $office_item = $query->fetch_assoc();
        if ($office_item > 0) {
            $office_id = $office_item['id'];
            $result = $child->insert_suplies_transaction($office_id, $quantity, $date, $unit_price, $transaction_type);

            if ($result) {
                //Data inserted successfully
                header('Location:office_supply.php?msg=success');
            } else {
                //Data failed to be inserted
                header('Location:office_supply.php?msg=faild');
            }
        } else {
            $result = $child->insert_office_supplies($name, $specification, $responsible_person, $section, $stock_id, $type, $status);
            $query = $child->check_office_items($name, $specification, $responsible_person, $section, $stock_id, $type, $status);
            $office_item = $query->fetch_assoc();
            $office_id = $office_item['id'];
            $result = $child->insert_suplies_transaction($office_id, $quantity, $date, $unit_price, $transaction_type);

            if ($result) {
                //Data inserted successfully
                header('Location:office_supply.php?msg=success');
            } else {
                //Data failed to be inserted
                header('Location:office_supply.php?msg=faild');
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
                                            <h2 class="page-title m-0">لوازم اداری</h2>
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
                                    echo "<p style='color: green'>Supply registerd successfully</p>";
                                } elseif ($_GET['msg'] == 'faild') {
                                    echo "<p style='color: red'>Supply registeration fialed</p>";
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
                                            style="text-align: center; margin:15px; padding:10px;"> فورم ثبت اموال اداری
                                            بنیاد خیریه رها</h4>

                                        <form action="office_supply.php" method="post" class="form-horizontal">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">نام</label>
                                                        <div class="col-sm-6">
                                                            <span style="color: red;"><?php echo $name_err; ?></span>
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $name ?>" name="name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">شخص مسئول</label>
                                                        <div class="col-sm-6">
                                                            <span
                                                                style="color: red;"><?php echo $responsible_person_err; ?></span>
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $responsible_person ?>"
                                                                name="responsible_person">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            وضعیت</label>
                                                        <div class="col-sm-6">
                                                            <div class="btn-group btn-group-toggle"
                                                                data-toggle="buttons">
                                                                <label class="btn btn-light active">
                                                                    <input type="radio" name="status" value="1" checked> <?php if ($status == 'فعال') {
                                                                     echo 'checked';
                                                                           } ?>
                                                                    فعال
                                                                </label>
                                                                <label class="btn btn-light">
                                                                    <input type="radio" name="status" value="0"
                                                                        id="option2"><?php if ($status == 'غیر فعال') {
                                                                echo 'checked';
                                                                  } ?>
                                                                    غیرفعال
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">قیمت واحد</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $unit_price ?>" name="unit_price">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">تاریخ</label>
                                                        <div class="col-sm-6">
                                                            <span
                                                                style="color: red;"><?php echo $responsible_person_err; ?></span>
                                                            <input class="form-control" type="date"
                                                                value="<?php echo $date ?>" name="date">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            نوع معامله</label>
                                                        <div class="col-sm-6">
                                                            <div class="btn-group btn-group-toggle"
                                                                data-toggle="buttons">
                                                                <label class="btn btn-light active">
                                                                    <input type="radio" name="transaction_type"
                                                                        value="sales" checked>
                                                                    <?php if ($transaction_type == 'sales') {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>
                                                                    خریده شده
                                                                </label>
                                                                <label class="btn btn-light">
                                                                    <input type="radio" name="transaction_type"
                                                                        value="purchased"
                                                                        id="option2"><?php if ($transaction_type == 'purchased') {
                                                                                                                                                    echo 'checked';
                                                                    }?>
                                                                    فروخته شده
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">مشخصات</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $specification ?>"
                                                                name="specification">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">بخش مربوطه</label>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="section">
                                                                <option selected>منوی انتخاب را باز کنید</option>
                                                                <option value="ریاست" <?php if ($section == 'ریاست') {
                                                                                            echo 'selected';
                                                                                        } ?>> ریاست </option>
                                                                <option value="مدیریت" <?php if ($section == 'مدیریت') {
                                                                                            echo 'selected';
                                                                                        } ?>> مدیریت </option>
                                                                <option value="اداری و مالی" <?php if ($section == 'اداری و مالی') {
                                                                                                    echo 'selected';
                                                                                                } ?>> اداری و مالی
                                                                </option>
                                                                <option value="آشپزخانه" <?php if ($section == 'آشپزخانه') {
                                                                                                echo 'selected';
                                                                                            } ?>> آشپزخانه </option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">نوع</label>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="type">
                                                                <option selected>منوی انتخاب را باز کنید</option>
                                                                <option value="sta" <?php if ($type == 'sta') {
                                                                                        echo 'selected';
                                                                                    } ?>> STA </option>
                                                                <option value="fur" <?php if ($type == 'fur') {
                                                                                        echo 'selected';
                                                                                    } ?>> FUR </option>
                                                                <option value="com" <?php if ($type == 'com') {
                                                                                        echo 'selected';
                                                                                    } ?>> COM </option>
                                                                <option value="adm" <?php if ($type == 'adm') {
                                                                                        echo 'selected';
                                                                                    } ?>> ADM </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">تعداد</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $quantity ?>" name="quantity">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">گدام مربوطه</label>
                                                        <div class="col-sm-6">
                                                            <span style="color: red;"><?php echo $stock_err; ?></span>
                                                            <?php
                                                            $stock = $child->select_stock();
                                                            ?>
                                                            <select class="custom-select" name="stock">
                                                                <option selected>منوی انتخاب را باز کنید</option>

                                                                <?php
                                                                while ($result = $stock->fetch_assoc()) :
                                                                ?>
                                                                <option value="<?php echo $result['id']; ?>"
                                                                    <?php if ($result['id'] == $stock_id) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>> <?php echo $result['name']; ?>
                                                                </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!--  <div class="form-group row">
                                               <label for="example-text-input" class="col-sm-2 col-form-label">تعداد</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="text" value="<?php echo $quantity ?>" name="quantity">
                                                </div>
                                            </div> 
                                                   <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">قیمت فی واحد</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="text" value="<?php echo $unit_price ?>" name="unit_price">
                                                </div>
                                            </div>
                                                <div class="form-group row">
                                                
                                                <label for="example-date-input" class="col-sm-2 col-form-label"> تاریخ خرید</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="date" value="<?php echo $date ?>" name="date">
                                                    <span style="color: red;"><?php echo $date_err; ?></span>
                                                </div>
                                            </div>
                                                
                                                <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">نوعیت</label>
                                                <div class="col-sm-2-">
                                                    <select class="custom-select" name="type">
                                                        <option selected>منوی انتخاب را باز کنید</option>
                                                        <option value="sales" <?php if ($type == 'sales') {
                                                                                    echo 'selected';
                                                                                } ?>>  Sales  </option>
                                                         <option value="purchased" <?php if ($type == 'purchased') {
                                                                                        echo 'selected';
                                                                                    } ?>>  Purchased  </option>
                                                    </select>
                                                </div>
                                            </div>-->

                                            <div class="form-actions">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary waves-effect waves-light"> ذخیره</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light">
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
                                                <th style="width: 30px;">شماره</th>
                                                <th style="width: 30px;">نام</th>
                                                <th style="width: 200px;">مشخصات</th>
                                                <th style="width: 30px;">شخص مسئول</th>
                                                <th style="width: 20px;">بخش</th>
                                                <th style="width: 30px;">قیمت واحد</th>
                                                <th style="width: 30px;">تعداد</th>
                                                <th style="width: 30px;">قیمت کل</th>
                                                <th style="width: 90px;">تاریخ خرید</th>
                                                <!-- <th></th> -->

                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            $offices = $child->select_office_supplies();
                                            $number = 1;
                                            while ($office = $offices->fetch_assoc()) :
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $number ?></td>
                                                <td><?php echo $office['name'] ?></td>
                                                <td style="width: 200px;"><?php echo $office['specification'] ?></td>
                                                <td><?php echo $office['responsible_person'] ?></td>
                                                <td><?php echo $office['section'] ?></td>
                                                <td><?php echo $office['unit_price'] ?></td>
                                                <td><?php echo $office['quantity'] ?></td>
                                                <td><?php echo $office['unit_price'] * $office['quantity'] ?></td>
                                                <td><?php echo $office['date'] ?></td>
                                                <!-- <td class="hidden-phone">
                                                        <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                        <a href="#"><span class="btn btn-danger">حذف </span></a>
                                                    </td> -->
                                            </tr>
                                            <?php $number++;
                                            endwhile; ?>


                                        </tbody>
                                    </table>
                                    <?php 
                                        $query = $child->select_all_price();
                                        $price = $query->fetch_assoc();
                                    ?>
                                    <h3> مجموعه قیمت = <?php echo $price['price']?></h3>

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