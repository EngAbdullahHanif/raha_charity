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
$fname = $lname = $father_name = $grandfather_name = $gender = $phone_num = $dateofbirth = $placeofbirth = $address = $numoffamily = $numofsis = $numofbro = $ssn = $school_name = $class = $reasonofschool_leaving = $job = $incomeperday = $houseliving = $sickness = $bloodgroup = $otherfamilymembers = $desc = $skills = $interests = $program_id =  "";

//Errors varibles are decilared to null
$fname_err = $lname_err = $father_name_err = $grandfather_name_err = $gender_err = $phone_num_err = $dateofbirth_err = $placeofbirth_err = $address_err = $numoffamily_err = "";

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
    if (empty($_POST['father_name'])) {
        $father_name_err = " نام پدر الزامی می باشد.";
    } else {
        $father_name = $connection->escape_string(test_input($_POST['father_name']));
    }
    if (empty($_POST['grandfather_name'])) {
        $grandfather_name_err = " نام پدرکلان الزامی می باشد.";
    } else {
        $grandfather_name = $connection->escape_string(test_input($_POST['grandfather_name']));
    }
    if (empty($_POST['gender'])) {
        $gender_err = " جنسیت الزامی می باشد.";
    } else {
        $gender = $connection->escape_string(test_input($_POST['gender']));
    }
    if (empty($_POST['phone_num'])) {
        $phone_num_err = " شماره تماس الزامی می باشد.";
    } else {
        $phone_num = $connection->escape_string(test_input($_POST['phone_num']));
    }
    if (empty($_POST['dateofbirth'])) {
        $dateofbirth_err = " تاریخ تولد الزامی می باشد.";
    } else {
        $dateofbirth = $connection->escape_string(test_input($_POST['dateofbirth']));
    }
    if (empty($_POST['placeofbirth'])) {
        $placeofbirth_err = " محل تولد الزامی می باشد.";
    } else {
        $placeofbirth = $connection->escape_string(test_input($_POST['placeofbirth']));
    }

    if (empty($_POST['address'])) {
        $address_err = " ادرس الزامی می باشد.";
    } else {
        $address = $connection->escape_string(test_input($_POST['address']));
    }
    if (empty($_POST['numoffamily'])) {
        $numoffamily_err = " تعداد اعضای فامیل الزامی می باشد.";
    } else {
        $numoffamily = $connection->escape_string(test_input($_POST['numoffamily']));
    }
    //Get unrequied data
    $numofsis = $connection->escape_string(test_input($_POST['numofsis']));
    $numofbro = $connection->escape_string(test_input($_POST['numofbro']));
    $ssn = $connection->escape_string(test_input($_POST['ssn']));
    $school_name = $connection->escape_string(test_input($_POST['school_name']));
    $class = $connection->escape_string(test_input($_POST['class']));
    $otherfamilymembers = $connection->escape_string(test_input($_POST['otherfamilymembers']));
    $desc = $connection->escape_string(test_input($_POST['desc']));
    $skills = $connection->escape_string(test_input($_POST['skills']));
    $interests = $connection->escape_string(test_input($_POST['interests']));
    $reasonofschool_leaving = $connection->escape_string(test_input($_POST['reasonofschool_leaving']));
    $job = $connection->escape_string(test_input($_POST['job']));
    $incomeperday = $connection->escape_string(test_input($_POST['incomeperday']));
    $houseliving = $connection->escape_string(test_input($_POST['houseliving']));
    $sickness = $connection->escape_string(test_input($_POST['sickness']));
    $bloodgroup = $connection->escape_string(test_input($_POST['bloodgroup']));
    $program_id = $_POST['program_id'];

    if ($fname_err == "" and $lname_err == "" and $father_name_err == "" and $grandfather_name_err == "" and $gender_err == "" and $phone_num_err == "" and $dateofbirth_err == "" and $placeofbirth_err == "" and $address_err == "" and $numoffamily_err == "") {

        //Checks if not duplicate
        $is_child = $child->is_child($fname, $lname, $father_name);
        $result = $is_child->fetch_assoc();
        if ($result > 0) {
            //Duplicated
            header('Location:children.php?msg=duplicate');
        } else {
            //Not duplicated

            $result = $child->insert($fname, $lname, $father_name, $grandfather_name, $gender, $phone_num, $dateofbirth, $placeofbirth, $address, $numoffamily, $numofsis, $numofbro, $ssn, $school_name, $class, $reasonofschool_leaving, $job, $incomeperday, $houseliving, $sickness, $bloodgroup, $otherfamilymembers, $desc, $skills, $interests);
            
            $result_id = $result->fetch_assoc();
        
            
            $program_query = $child->insert_child_program($result_id['LAST_INSERT_ID()'], $program_id);


            if ($program_query) {
                header('Location:children.php?msg=success');
            } else {
                header('Location:children.php?msg=faild');
            }
        }
    }
}


//DLETEING A ROW
if (isset($_GET['d-id'])) {
    $child_id = $_GET['d-id'];

    $result = $child->delete_child_by_id($child_id);

    if ($result) {
        header('Location:children.php?msg=delete_success');
    } else {
        header('Location:children.php?msg=delete_faild');
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
                                            <h4 class="page-title m-0">صفحه ثبت و معلومات اطفال</h4>
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
                                } elseif ($_GET['msg'] == 'delete_faild') {
                                    echo "<p style='color: red'>child fialed to delete</p>";
                                } elseif ($_GET['msg'] == 'delete_success') {
                                    echo "<p style='color: green'>child successfully deleted</p>";
                                } elseif ($_GET['msg'] == 'sta_success') {
                                    echo "<p style='color: green'>child stationary items successfully inserted</p>";
                                } elseif ($_GET['msg'] == 'sta_failed') {
                                    echo "<p style='color: red'>child stationary items failed to insert</p>";
                                }elseif ($_GET['msg'] == 'clo_success') {
                                    echo "<p style='color: green'>child clothes items successfully inserted</p>";
                                } elseif ($_GET['msg'] == 'clo_failed') {
                                    echo "<p style='color: red'>child clothes items failed to insert</p>";
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
                                            style="text-align: center; margin:15px; padding:10px;"> فورم ثبت نام اطفال
                                            کارگر خیابانی</h2>

                                        <form action="children.php" method="post" class="form-horizontal">


                                            <!-- row starts -->
                                            <div class="row">
                                                <!-- col start -->
                                                <div class="col-6">
                                                    <form action="children.php" method="post" class="form-horizontal">
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
                                                                class="col-sm-4 col-form-label">نام پدر</label>

                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $father_name ?>"
                                                                    name="father_name">
                                                                <span
                                                                    style="color: red;"><?php echo $father_name_err; ?></span>
                                                            </div>
                                                        </div>



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

                                                            <label for="example-date-input"
                                                                class="col-sm-4 col-form-label">تاریخ تولد</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="date"
                                                                    value="<?php echo $dateofbirth ?>"
                                                                    name="dateofbirth">
                                                                <span
                                                                    style="color: red;"><?php echo $dateofbirth_err; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">شغل</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" type="text"
                                                                    value="<?php echo $job ?>" name="job">
                                                            </div>
                                                        </div>
                                                </div>
                                                <!-- col ends -->


                                                <div class="col-6">
                                                    <!-- col starts -->
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
                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            نام پدرکلان</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $grandfather_name ?>"
                                                                name="grandfather_name">
                                                            <span
                                                                style="color: red;"><?php echo $grandfather_name_err; ?></span>
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
                                                    <div class="form-group row">

                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">تعداد اعضای فامیل </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $numoffamily_err; ?>"
                                                                name="numoffamily">
                                                            <span
                                                                style="color: red;"><?php echo $numoffamily_err; ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- col ends -->
                                            </div>
                                            <!-- row ends -->



                                            <!-- row starts -->
                                            <div class="row">
                                                <!-- col starts -->
                                                <div class="col-6">

                                                    <div class="form-group row">
                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">تعداد خواهرها </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $numofsis ?>" name="numofsis">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">تعداد برادرها </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $numofbro ?>" name="numofbro">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">درآمد روزانه</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $incomeperday ?>" name="incomeperday">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">بیماری</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $sickness ?>" name="sickness">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">اعضای متفرقه فامیل </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number" value=""
                                                                name="otherfamilymembers">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            جنسیت</label>
                                                        <div class="col-sm-6">
                                                            <div class="btn-group btn-group-toggle"
                                                                data-toggle="buttons">
                                                                <label class="btn btn-light active">
                                                                    <input type="radio" name="gender" value="دختر"
                                                                        checked> دختر
                                                                </label>
                                                                <label class="btn btn-light ">
                                                                    <input type="radio" name="gender" value="پسر"
                                                                        id="option2"> پسر
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col ends -->

                                                <!-- col starts -->
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label for="example-number-input"
                                                            class="col-sm-4 col-form-label">شماره تذکره </label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $ssn ?>" name="ssn" name="ssn">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-4 col-form-label">
                                                            نام مکتب</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $school_name ?>" name="school_name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">صنف</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $class ?>" name="class">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">توضیحات</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $desc ?>" name="desc">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">مهارت ها</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $skills ?>" name="skills">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">علایق</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $interests ?>" name="interests">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col ends -->
                                            </div>
                                            <!-- row ends -->

                                            <!-- row starts -->
                                            <div class="row">
                                                <!-- col starts -->
                                                <div class="col-6">
                                                   
                                                    
                                                         <div class="form-group row">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">دلیل ترک مکتب</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $reasonofschool_leaving ?>" name="reasonofschool_leaving">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">خانه نشیمن</label>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="houseliving">
                                                                <option>منوی انتخاب را باز کنید</option>
                                                                <option value="کرایی" <?php if ($houseliving == 'کرایی') {
                                                                                            echo 'selected';
                                                                                        } ?>>کرایی</option>
                                                                <option value="گروی" <?php if ($houseliving == 'گروی') {
                                                                                            echo 'selected';
                                                                                        } ?>> گروی </option>
                                                                <option value="شخصی" <?php if ($houseliving == 'شخصی') {
                                                                                            echo 'selected';
                                                                                        } ?>> شخصی </option>
                                                                <option value="میراثی" <?php if ($houseliving == 'میراثی') {
                                                                                            echo 'selected';
                                                                                        } ?>> میراثی </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col ends -->
                                                <!-- col starts -->
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">گروپ خون</label>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="bloodgroup">
                                                                <option>منوی انتخاب را باز کنید</option>
                                                                <option value="ORH+" <?php if ($bloodgroup == 'ORH+') {
                                                                                            echo 'selected';
                                                                                        } ?>> ORH+ </option>
                                                                <option value="ORH-" <?php if ($bloodgroup == 'ORH-') {
                                                                                            echo 'selected';
                                                                                        } ?>> ORH- </option>
                                                                <option value="A" <?php if ($bloodgroup == 'A') {
                                                                                        echo 'selected';
                                                                                    } ?>> A </option>
                                                                <option value="B" <?php if ($bloodgroup == 'B') {
                                                                                        echo 'selected';
                                                                                    } ?>> B </option>
                                                                <option value="AB" <?php if ($bloodgroup == 'AB') {
                                                                                        echo 'selected';
                                                                                    } ?>> AB </option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <?php
                                                    $programs = $child->select_program();

                                                    ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">نوعیت پروگرام</label>
                                                        <div class="col-sm-6">
                                                            <select class="custom-select" name="program_id">
                                                                <option>منوی انتخاب را باز کنید</option>
                                                                <?php
                                                                while ($program = $programs->fetch_assoc()) :
                                                                ?>
                                                                <option value="<?php echo $program['id'] ?>"
                                                                    <?php if ($program['id'] == $program_id) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $program['name'] ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                        <?php endif;?>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body primary-card">

                                    <h4 class="mt-0 header-title">جدول اطلاعات</h4>

                                                <p>
													<input type="button" value="Print Table" onclick="myApp.printTable()" />
												</p>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                      dir="rtl" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام</th>
                                                <th>نام پدر</th>
                                                <th>نام پدرکلان</th>
                                                <th>شماره تماس</th>
                                                <th></th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            $num = 1;
                                            $children = $child->select_all();
                                            while ($child = $children->fetch_assoc()) :
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $child['fname']; ?></td>
                                                <td><?php echo $child['father_name']; ?></td>
                                                <td><?php echo $child['Grandfather_name']; ?></td>
                                                <td><?php echo $child['phone_num']; ?></td>
                                                <td style="text-align: center">
                                                    <a href="child_detail.php?id=<?php echo $child['id'] ?>"><span
                                                            class="btn btn-success">جزییات بیشتر</span></a>
                                                    <?php if($_SESSION['type'] == 'admin'):  ?>
                                                    <span class="btn btn-primary">ویرایش</span>
                                                    <a href="child_relative.php?id=<?php echo $child['id'] ?>"><span
                                                            class="btn btn-primary">ثبت اقارب</span></a>
                                                    <a href="child_survey.php?id=<?php echo $child['id'] ?>"><span
                                                            class="btn btn-primary">ثبت سروی</span></a>
                                                    <br>
                                                    <a href="child_stationary.php?id=<?php echo $child['id'] ?>"><span
                                                            class="btn btn-primary">ثبت قرطاسیه</span></a>
                                                    <a href="child_clothes.php?id=<?php echo $child['id'] ?>"><span
                                                            class="btn btn-primary">ثبت لباس</span></a>
                                                    <a href="children.php?d-id=<?php echo $child['id'] ?>"
                                                        onclick="return confirm('آیا مطمئن هستید؟')"><button
                                                            type="submit" name="delete"><span
                                                                class="btn btn-danger">حذف</span></button></a>
                                                    <?php endif;?>
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