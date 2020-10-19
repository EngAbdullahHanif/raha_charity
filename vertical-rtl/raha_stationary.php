
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
                                            <h4 class="page-title m-0">معلومات قرطاسیه اداری </h4>
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
                            
                        </div>

                        <div class="row">
						<?php if($_SESSION['type'] == 'admin'):  ?>
                            <div class="col-12">
                                <div class="card text-white m-b-30 ">
                                    <div class="card-body special-card">

                                        <h4 class="mt-0 header-large " style="text-align: center; margin:15px; padding:10px;"> فورم ثبت قرطاسیه اداری</h4>

                                        <form action="raha_stationary.php" method="post" class="">
                                            <input type="hidden" name="child_id" value="<?php echo $child_id; ?>">
                                            <div class="form-group row">
                                                <?php
                                                $stationary = $child->select_stationary();
                                                ?>
                                                <label class="col-sm-2 col-form-label">نام</label>
                                                <span style="color: red;"><?php echo $name_err; ?></span>
                                                <div class="col-sm-4">
                                                    <select class="custom-select" name="name">
                                                        <option selected>منوی انتخاب را باز کنید</option>

                                                        <?php
                                                        while ($result = $stationary->fetch_assoc()) :
                                                        ?>
                                                            <option value="<?php echo $result['id']; ?>" <?php if ($result['id'] == $name) {
                                                                                                                echo 'selected';
                                                                                                            } ?>> <?php echo $result['name']; ?> </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="quantity" class="col-sm-2 col-form-label">تعداد</label>
                                                <span style="color: red;"><?php echo $quantity_err; ?></span>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="number" id="quantity" value="<?php echo $quantity ?>" name="quantity">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-2 col-form-label">تاریخ</label>
                                                <span style="color: red;"><?php echo $date_err; ?></span>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="date" id="date" value="<?php echo $date ?>" name="date">
                                                </div>
                                            </div>
                                            <div class="form-actions ">
                                                <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light"> ذخیره</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light"> انصراف</button>
                                            </div>
                                        </form>
                                    </div>
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
                                    

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام</th>
                                                <th>تعداد</th>
                                                <th>تاریخ</th>
                                                <th></th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $number = 1;
                                            $query = $child->select_child_stationary($child_id);
                                            while ($child_stationary = $query->fetch_assoc()) :
                                            ?>
                                                <tr class="odd gradeX">
                                                    <td><?php echo $number; ?></td>
                                                    <td><?php echo $child_stationary['name'] ?></td>
                                                    <td><?php echo $child_stationary['quantity'] ?></td>
                                                    <td><?php echo $child_stationary['date'] ?></td>
													<?php if($_SESSION['type'] == 'admin'):  ?>
                                                    <td class="hidden-phone">
                                                        <a href="#"><span class="btn btn-primary">ویرایش</span></a>
                                                        <a href="#" onclick="return confirm('ایا مطمن هستید؟')"><span class="btn btn-danger">حذف </span></a>
                                                    </td>
													<?php endif?>
                                                </tr>
                                            <?php $number++;
                                            endwhile; ?>
                                        </tbody>
                                    </table>

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