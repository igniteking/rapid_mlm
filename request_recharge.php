<?php include("./connections/connection.php"); ?>
<?php include("./connections/functions.php"); ?>
<?php include("./connections/global.php"); ?>
<?php include("./components/header.php"); ?>
<?php
if (@$_GET["status"] == 1) {
    Toast("success", "Login Successfull :) ");
}
?>
<div id="app">
    <?php include("./components/sidebar.php") ?>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Request Recharge</h3>
        </div>
        <div class="page-content">
            <section class="h-100 gradient-custom-2">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Request Recharge</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php
                                        $reg = @$_POST['request'];
                                        if ($reg) {
                                            $amount = security_check(@$_POST['amount']);
                                            $ref_id = security_check(@$_POST['ref_id']);
                                            $screen_shot = security_check(@$_POST['screen_shot']);
                                            $created_at = date("Y-m-d H:i:s");
                                            $status = "pending";
                                            $length = 10;
                                            $random = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
                                            $folder = mkdir("./picture/$random");
                                            $target_dir = "./picture/$random/";
                                            $filename2 = $_FILES['screen_shot']['name'];
                                            $array_content2 = move_uploaded_file($_FILES['screen_shot']['tmp_name'], $target_dir . $filename2);
                                            $final2 =  $target_dir . $filename2;
                                            $insert_request = mysqli_query($conn, "INSERT INTO `request_recharge`(`amount`, `created_at`, `id`, `reverence_ss`, `status`, `user_id`) VALUES
                                             ('$amount','$created_at', NULL ,'$final2','$status','$user_id')");

                                            if ($insert_request) {

                                                echo "<meta http-equiv=\"refresh\" content=\"0; url=./request_recharge.php?code=1\">";
                                            }
                                        }
                                        if (@$_GET['code'] == 1) {
                                            Toast(
                                                "success",
                                                "Succesfully Submitted Recharge Request.."
                                            );
                                        }

                                        ?>
                                        <form class="form form-horizontal" method="post" action="./request_recharge.php" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Amount</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group has-icon-left">
                                                            <div class="position-relative">
                                                                <input type="number" class="form-control" name="amount" placeholder="Amount" id="first-name-icon">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-currency-rupee"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Reference Id</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group has-icon-left">
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" name="ref_id" placeholder="Reference Id" id="first-name-icon">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-receipt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Reference Screen Shot</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="position-relative">
                                                                <input type="file" class="form-control" name="screen_shot">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <input type="submit" class="btn btn-primary me-1 mb-1" name="request" value="Submit"></input>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <?php include("./components/footer.php"); ?>