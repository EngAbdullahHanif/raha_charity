<?php 
    require_once('includes/child.php');
    $child = new Child();
    $connection = $child->get_conn();

    //Every pages
	session_start();
	
	if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
		header('Location:login.php');
		exit();
	}
	
	

    $su_name = $su_date = $responsible_person = $attachment = $description = $child_id = "";

    $su_name_err = $su_date_err = $responsible_person_err = $attachment_err = $description_err = "";

    if(isset($_GET['id'])){
        $child_id = $_GET['id']; 
    }

    if(isset($_POST['submit'])){
        if(empty($_POST['su_name'])){
            $su_name_err = " نام الزامی می باشد.";
        } else {
            $su_name = $connection->escape_string(test_input($_POST['su_name']));
        }
        if(empty($_POST['su_date'])){
            $su_date_err = " تاریخ الزامی می باشد.";
        } else {
            $su_date = $connection->escape_string(test_input($_POST['su_date']));
        }
        if(empty($_POST['responsible_person'])){
            $responsible_person_err = " شخص مسول الزامی می باشد.";
        } else {
            $responsible_person = $connection->escape_string(test_input($_POST['responsible_person']));
        }
        if(empty($_POST['description'])){
            $description_err = " توضیحات الزامی می باشد.";
        } else {
            $description = $connection->escape_string(test_input($_POST['description']));
        }

        $child_id = $_POST['child_id'];
        
        $attachment = $_FILES['attachment']['name'];
        $image_dir = 'img/'.basename($attachment);
        move_uploaded_file($_FILES['attachment']['tmp_name'], $image_dir);

        if($su_name_err == "" AND $su_date_err == "" AND $responsible_person_err == "" AND $description_err == ""){
            //Insert survey data
            $survey = $child->insert_survey($child_id, $su_name, $su_date , $responsible_person, $attachment, $description);

            if($survey){
                //Data inserted successfully
                header('Location:child_survey.php?msg=success');
            } else {
                //Data failed to insert
                header('Location:child_survey.php?msg=faild');
            }
        } else {
             echo "this is not working";
        }
    }

    // INPUT TEST FUNCTION 
    function test_input($data) {
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
                                            <h4 class="page-title m-0">معلومات سروی <?php
                                                                                    $query = $child->select_child_by_id($child_id);
                                                                                    $child_name = $query->fetch_assoc();
                                                                                    echo $child_name['fname']
                                                                                    ?></h4>
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
                              <div class="msg" > 
                                <?php
                                    if(isset($_GET['msg'])){
                                        if($_GET['msg'] == 'success'){
                                            echo "<p style='color: green'>child registerd successfully</p>";
                                        } elseif ($_GET['msg'] == 'faild'){
                                            echo "<p style='color: red'>child registerd fialed</p>";
                                        } elseif ($_GET['msg'] == 'duplicate'){
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
            
                                            <h4 class="mt-0 header-large " style="text-align: center; margin:15px; padding:10px;"> فورم ثبت سروی اطفال کارگر خیابانی</h4>
                                            
                                            <form action="child_survey.php" method="post" class="form-horizontal">
                                                <input type="hidden" name="child_id" value="<?php echo $child_id;?>">
                                            <div class="form-group row">
                                                
                                                <label for="example-text-input" class="col-sm-2 col-form-label"> نام سروی</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $su_name?>" name="su_name">
                                                    <span style="color: red;"><?php echo $su_name_err;?></span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group row">
                                                
                                                <label for="example-date-input" class="col-sm-2 col-form-label">تاریخ</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="date" value="<?php echo $su_date?>" name="su_date">
                                                    <span style="color: red;"><?php echo $su_date_err;?></span>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group row">
                                                
                                                <label for="example-text-input" class="col-sm-2 col-form-label"> شخص مسئول</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $responsible_person?>" name="responsible_person">
                                                    <span style="color: red;"><?php echo $responsible_person_err;?></span>
                                                </div>
                                            </div>
                                                
                                          
                                            
                                            <div class="form-group row">
                                                
                                                <label for="example-url-input" class="col-sm-2 col-form-label">توضیحات</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="text" value="<?php echo $description?>" name="description">
                                                    <span style="color: red;"><?php echo $description;?></span>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="form-actions">
                                    <button type="submit" name="submit" class="btn btn-success waves-effect waves-light"> دخیره</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light"> انصراف</button>
                                </div>
                                            </form>
                                            </div>
                                        </div>
                            </div>
						
                        </div><!-- container fluid -->
						<?php endif;?>
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

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:51 GMT -->
</html>