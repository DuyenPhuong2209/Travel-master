<?php
    include '../includes/db.php';
    include 'layouts/agency_header.php';
    include 'layouts/agency_navbar.php';

    if(empty($_SESSION['agency_login']) || $_SESSION['agency_login'] == ''){
        header('Location: ../includes/login.php');
        return;
    }
?>

<div id="layoutSidenav">
    <?php
        include 'layouts/agency_sidenav.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Welcome to 
                <?php
                    if(isset($_SESSION['employee_id'])){
                        echo ucwords($_SESSION['agency_name']) ." (". ucwords($_SESSION['role']) .")";
                    }elseif($_SESSION['agency_id']){
                        echo ucwords($_SESSION['agency_name']) ."";
                    }
                ?>
                </h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Bảng điều khiển</li>
                </ol>
                <div class="container-fluid">
                    <div class="row">

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM packages WHERE agency_id = :agency_id');
                            $stmt->execute([':agency_id' => $_SESSION['agency_id']]);
                            $package_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card text-white bg-dark mb-3">
                                <div class="card-body">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $package_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-3"><i class="fas fa-list"></i></span>Tour</p>
                                </div>
                                <div class="card-footer  d-flex align-items-center justify-content-between">
                                    <a class=" text-white stretched-link" href="packages.php">Xem chi tiết</a>
                                    <div class=" text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM bookings WHERE agency_id = :agency_id');
                            $stmt->execute([':agency_id' => $_SESSION['agency_id']]);
                            $booking_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body ">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $booking_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-3"><i class="far fa-file"></i></span>Đặt tour</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="text-white stretched-link" href="bookings.php">Xem chi tiết</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM agency_employees WHERE agency_id = :agency_id');
                            $stmt->execute([':agency_id' => $_SESSION['agency_id']]);
                            $employee_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card text-white bg-secondary mb-3">
                                <div class="card-body">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $employee_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-1"><i class="fas fa-user fa-fw"></i></span>Nhân viên</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class=" text-white stretched-link" href="employees.php">Xem chi tiết</a>
                                    <div class=" text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM payments WHERE agency_id = :agency_id');
                            $stmt->execute([':agency_id' => $_SESSION['agency_id']]);
                            $payment_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $payment_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-3"><i class="far fa-credit-card"></i></span>Thanh toán</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class=" text-dark stretched-link" href="payments.php">Xem chi tiết</a>
                                    <div class=" text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE agency_id = :agency_id AND review_status = :review_status');
                            $stmt->execute([':agency_id'        => $_SESSION['agency_id'],
                                            ':review_status'    => 'Đã phê duyệt']);
                            $review_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card mb-3" style="background: #EBCA47;">
                                <div class="card-body">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $review_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-3"><i class="far fa-star"></i></span>Xếp hạng</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="text-dark stretched-link" href="reviews.php">Xem chi tiết</a>
                                    <div class="text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $pdo->prepare('SELECT count(*) FROM comments WHERE agency_id = :agency_id AND comment_status = :comment_status');
                            $stmt->execute([':agency_id'        => $_SESSION['agency_id'],
                                            ':comment_status'   => 'Đã phê duyệt']);
                            $comment_count = $stmt->fetchColumn();
                        ?>

                        <div class="col-sm-4">
                            <div class="card mb-3" style="background: #36A0FC;">
                                <div class="card-body">
                                    <h1 class="card-title text-right" style="font-size: 50px;"><?php echo $comment_count; ?></h1>
                                    <p style="font-size: 35px;"><span class="mr-3"><i class="far fa-comments"></i></span>Bình luận</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class=" text-dark stretched-link" href="comments.php">Xem chi tiết</a>
                                    <div class=" text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    $stmt = $pdo->prepare('SELECT count(*) FROM agency_employees WHERE agency_id = :agency_id AND role = :role');
                    $stmt->execute([':agency_id'    => $_SESSION['agency_id'],
                                    ':role'         => 'Nhân viên']);
                    $staff_count = $stmt->fetchColumn();

                    $stmt = $pdo->prepare('SELECT count(*) FROM packages WHERE agency_id = :agency_id AND package_status = :package_status');
                    $stmt->execute([':agency_id'        => $_SESSION['agency_id'],
                                    ':package_status'   => 'Không có sẵn']);
                    $unavailPackage_count = $stmt->fetchColumn();

                    $stmt = $pdo->prepare('SELECT count(*) FROM package_dates WHERE agency_id = :agency_id AND status = :status');
                    $stmt->execute([':agency_id'    => $_SESSION['agency_id'],
                                    ':status'       => 'Kết thúc']);
                    $bookOff_count = $stmt->fetchColumn();

                    $stmt = $pdo->prepare('SELECT count(*) FROM bookings WHERE agency_id = :agency_id AND booking_status = :booking_status');
                    $stmt->execute([':agency_id'        => $_SESSION['agency_id'],
                                    ':booking_status'   => 'Chưa xác nhận']);
                    $pendBook_count = $stmt->fetchColumn();
                ?>

                <div class="container my-5">
                    <div class="row">
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['bar']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    
                                    ['Dữ liệu  ', 'Tổng'],
                                    ['Tổng nhân viên',          <?php echo $employee_count; ?>],
                                    ['Nhân viên',               <?php echo $staff_count; ?>],
                                    ['Tour',                    <?php echo $package_count; ?>],
                                    ['Tour kéo dài',            <?php echo $unavailPackage_count; ?>],
                                    ['Tour kết thúc',           <?php echo $bookOff_count; ?>],
                                    ['Đặt trước',               <?php echo $booking_count; ?>],
                                    ['Tour chờ xử lý',          <?php echo $pendBook_count; ?>],
                                    ['Thanh toán',              <?php echo $payment_count; ?>],
                                    ['Xếp hạng',                <?php echo $review_count; ?>],
                                    ['Bình luận',               <?php echo $comment_count; ?>]
                                
                                ]);

                                var options = {
                                chart: {
                                    title: '',
                                    subtitle: '',
                                }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }
                        </script>

                        
                        <div id="columnchart_material" style="width: 1500px; height: 500px;"></div>

                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

<?php
    include 'layouts/agency_footer.php';
?>
