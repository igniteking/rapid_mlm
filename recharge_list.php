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
            <h3>Recharge List</h3>
        </div>
        <div class="page-content">
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
                    Toast(
                        "sucess",
                        "Succesfully Submitted Recharge Request.."
                    );
                    echo "<meta http-equiv=\"refresh\" content=\"0; url=./request_recharge.php\">";
                }
            }

            ?>
            <!-- Hoverable rows start -->
            <section class="section">
                <div class="row" id="table-hover-row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="demo" class="card-title">Hoverable rows</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- table hover -->
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>NAME</th>
                                                    <th>AMOUNT</th>
                                                    <th>Status</th>
                                                    <th>Reference SS</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (@$_GET['code'] == 1) {
                                                    Toast('success', 'Request Accepted Succesfully ...');
                                                } else if (@$_GET['code'] == 2) {
                                                    Toast('success', 'Request Rejected Succesfully ...');
                                                }
                                                $get_requests = mysqli_query($conn, "SELECT * FROM request_recharge ORDER BY id DESC");
                                                while ($row = mysqli_fetch_array($get_requests)) {
                                                    $req_id = $row['id'];
                                                    $user_id = $row['user_id'];
                                                    $amount = $row['amount'];
                                                    $reference_ss = $row['reverence_ss'];
                                                    $status = $row['status'];
                                                    $get_user = mysqli_query($conn, "SELECT * FROM user_data WHERE id = '$user_id'");
                                                    while ($rows = mysqli_fetch_array($get_user)) {
                                                        $username = $rows['user_name'];
                                                    }
                                                    if ($status == 'pending') {
                                                        $color = "warning";
                                                    } else if ($status == 'accept') {
                                                        $color = "success";
                                                    }
                                                    if ($status == 'reject') {
                                                        $color = "danger";
                                                    }
                                                    echo '
                                                    <tr>
                                                <td class="text-bold-500">' . $username . '</td>
                                                <td>' . $amount . ' INR</td>
                                                <td class="text-bold-500 m-3"><p class="mt-3 badge bg-' . $color . '">' . $status . '</p></td>
                                                <td><a target="_blank" href="' . $reference_ss . '">Image Rederence</a></td>
                                                <td>';
                                                    if ($status == 'pending') {
                                                        echo '
                                                <button onclick="accept(' . $req_id . ',' . $amount . ', ' . $user_id . ')" class="btn icon btn-success"><i class="bi bi-check-lg"></i></button>
                                                <button onclick="reject(' . $req_id . ',' . $amount . ', ' . $user_id . ')" class="btn icon btn-danger"><i class="bi bi-x-lg"></i></button>';
                                                    }
                                                    echo '</td>
                                                </tr>
                                                ';
                                                }
                                                ?>
                                                <script>
                                                    function accept(req_id, amount, user_id) {
                                                        var xhttp = new XMLHttpRequest();
                                                        xhttp.onreadystatechange = function() {
                                                            if (this.readyState == 4 && this.status == 200) {
                                                                window.location.href = this.response;
                                                            }
                                                        };
                                                        xhttp.open("GET", "./helpers/recharge.php?req_id=" + req_id + "&&amount=" + amount + "&&user_id=" + user_id + "&&status=accept", true);
                                                        xhttp.send();
                                                    }

                                                    function reject(req_id, amount, user_id) {
                                                        var xhttp = new XMLHttpRequest();
                                                        xhttp.onreadystatechange = function() {
                                                            if (this.readyState == 4 && this.status == 200) {
                                                                window.location.href = this.response;
                                                            }
                                                        };
                                                        xhttp.open("GET", "./helpers/recharge.php?req_id=" + req_id + "&&amount=" + amount + "&&user_id=" + user_id + "&&status=reject", true);
                                                        xhttp.send();
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- Hoverable rows end -->
        </div>

        <?php include("./components/footer.php"); ?>