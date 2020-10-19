<?php
    session_start();

    require_once('includes/child.php');
    $child = new Child();
    $connection = $child->get_conn();

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
        header("Location:index.php");
        exit;
    }

    $username = $password = $type = "";
    $username_err = $password_err = $error = $type_err = "";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(empty(trim($_POST['username']))){
            $username_err = 'نام الزامی می باشد';
        } else {
            $username = trim($_POST['username']);
        }
        if(empty(trim($_POST['password']))){
            $password_err = 'پسورد الزامی می باشد';
        } else {
            $password = trim($_POST['password']);
        }
		if(empty(trim($_POST['type']))){
            $type_err = 'نوعیت الزامی می باشد';
        } else {
            $type = trim($_POST['type']);
        }

        if(empty($username_err) && empty($password_err)){
            // $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
            
            $user = $child->login($username, $password, $type);
            $result = $user->fetch_assoc();

            //user exist
            if($result > 0){

                session_start();            
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
				$_SESSION['type'] = $type;

                header('Location:index.php');
            } else {
                $error = "نام کاربری و یا هم رمزعبورتان اشتباه است لطفا دوباره کوشش نمایید.";
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
    

<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:51 GMT -->
        <?php
            include_once("includes/head.php");
            ?>


    <body class="fixed-left">
        <h1></h1>
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
        <div class="home-فbtn d-none d-sm-block">
            <a href="index.php" class="text-dark"><i class="mdi mdi-home h1"></i></a>
        </div>
        <h1 style="text-center color:white text-bold !important;"></h1>
        <div class="account-pages">
            
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 offset-lg-1">
                        <div class="text-left">
                            <div>
                                <a href="index.php" class="logo logo-admin"><img src="assets/images/logo_raha.png" height="60" alt="logo"></a>
                            </div>
                            <h2 class="font-20 text-white text-strong mb-4"> دیتابیس مدیریت برنامه های بنیاد خیریه رها</h2>
                            <p class="text-muted mb-4">این دیتابیس برای مدیریت برنامه های داخلی بنیاد خیریه رها استفاده می شود.</p>

                            <h5 class="font-14 text-muted mb-4">در حال حاضر بنیاد خیریه رها چهار برنامه برای اشخاص نیازمند در حال اجرا دارد.</h5>
                            <div>
                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>حمایت از دختران کارگر خیابانی</p>
                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>گنجه رخت</p>
                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>حمایت از اطفال معلول ذهنی هلال احمر</p>
                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>توزیع قرطاسیه برای اطفال کارگر</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-2">
                                    <h4 class="text-muted float-right font-18 mt-4">ثبت نام</h4>
                                    <div>
                                        <a href="" class="logo logo-admin"><img src="assets/images/raha.png" height="60" alt="logo"></a>
                                    </div>
                                </div>
        
                                <div class="p-2">
                                     <span style="color: red; font-size:18px;"><?php echo $error; ?></span>
                                    <form class="form-horizontal m-t-20" action="register.php" method="post">
        
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" name="username" value="<?php echo $username?>" required="" placeholder="نام کاربری">
                                            </div>
                                            <span style="color: red ;font-size:17px;"><?php echo $username_err?></span>
                                        </div>
        
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="password" name="password" value="<?php echo $password?>" required="" placeholder="رمز عبور">
                                            </div>
                                            <span style="color: red;font-size:17px;"><?php echo $password_err?></span>
                                        </div>
                                         <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" name="username" value="<?php echo $username?>" required="" placeholder="ایمیل آدرس">
                                            </div>
                                            <span style="color: red ;font-size:17px;"><?php echo $username_err?></span>
                                        </div>
										
										<div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label"> نوعیت کاربر</label>
                                            <div class="col-sm-6">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-light active">
                                                        <input type="radio" name="type" value="admin" checked> ادمین
                                                    </label>
                                                    <label class="btn btn-light ">
                                                        <input type="radio" name="type" value="visitor" id="option2"> ویزیتور
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
        
                                       
        
                                        <div class="form-group text-center row m-t-20">
                                            <div class="col-12">
                                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">ثبت نام</button>
                                            </div>
                                        </div>
        
                                       
                                    </form>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>

</div>

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


<!-- Mirrored from rtl-temp.ir/Theme/Zinzer/vertical-rtl/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2019 05:46:51 GMT -->
</html>