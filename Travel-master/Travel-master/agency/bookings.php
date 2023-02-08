<?php
    include '../includes/db.php';
    include '../includes/functions.php';
    include 'layouts/agency_header.php';
    include 'layouts/agency_navbar.php';

    if(empty($_SESSION['agency_login']) || $_SESSION['agency_login'] == ''){
        header('Location: ../includes/login.php');
        return;
    }

    if(isset($_SESSION['agency_id'])){
        $agency_id = $_SESSION['agency_id'];

        //Booking Read Query
        $stmt = $pdo->prepare('SELECT * FROM bookings WHERE agency_id = :agency_id ORDER BY booking_id DESC');
        $stmt->execute([':agency_id' => $agency_id]);
        $bookings = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $bookings[] = $row;
        }
    }

    //Booking Confirm Query
    if(isset($_GET['confirm'])){
        $booking_id = $_GET['confirm'];

        $stmt = $pdo->prepare('UPDATE bookings SET booking_status = :booking_status WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id'       => $booking_id,
                        ':booking_status'   => 'Xác nhận']);
        $_SESSION['success'] = 'Trạng thái đăng ký được đặt thành Xác nhận';
        header('Location: bookings.php');
        return;
    }

    //Booking Pending Query
    if(isset($_GET['pending'])){
        $booking_id = $_GET['pending'];

        $stmt = $pdo->prepare('UPDATE bookings SET booking_status = :booking_status WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id'       => $booking_id,
                        ':booking_status'   => 'Chưa xác nhận']);
        $_SESSION['success'] = 'Trạng thái đăng ký được đặt thành Đang chờ xử lý';
        header('Location: bookings.php');
        return;
    }

    //Booking Reject Query
    if(isset($_GET['reject'])){
        $booking_id = $_GET['reject'];

        $stmt = $pdo->prepare('UPDATE bookings SET booking_status = :booking_status WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id'       => $booking_id,
                        ':booking_status'   => 'Từ chối']);
        $_SESSION['success'] = 'Trạng thái đăng ký được đặt thành Từ chối';
        header('Location: bookings.php');
        return;
    }
?>

<!-- <head>
    <link rel="stylesheet" href="../css/agency.php">
</head> -->

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
                        echo ucwords($_SESSION['agency_name']) ." ";
                    }
                ?>
                </h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Chi tiết tour</li>
                </ol>
                <div class="container-fluid">

                <?php

                    include '../includes/flash_msg.php';

                    if(empty($bookings)){
                        echo '<h1 class="text-center pt-4">Không có tour để hiển thị</h1>';
                    }else {
                    
                ?>

                    <div class="col-xs-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Đặt bởi</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Tên tour</th>
                                    <th>Phong cách du lịch</th>
                                    <th>Người</th>
                                    <th>Giá tour</th>
                                    <th>Tình trạng đặt</th>
                                    <th>Ngày</th>
                                    <th>Xác nhận</th>
                                    <th>Chưa giải quyết</th>
                                    <th>Từ chối</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $i = 1;
                                foreach($bookings as $booking){
                                    if($booking['booking_status'] == 'Chưa xác nhận'){
                                        echo '<tr class="table-warning">';
                                    }elseif ($booking['booking_status'] == 'Từ chối') {
                                        echo '<tr class="table-danger">';
                                    }else{
                                        echo '<tr>';
                                    }
                                            echo '<td>'. $i++ .'</td>';
                                            echo '<td>'. $booking['tourist_name']  .'</td>';
                                            echo '<td>'. $booking['tourist_email'] .'</td>';
                                            echo '<td>'. $booking['tourist_contact'] .'</td>';

                                            //Package Name Read Query
                                            $package = readPackage($booking['package_id']);

                                            echo '<td><a href="../package.php?package_id='. $booking['package_id'] .'">'. $package['package_name'] .'</a></td>';

                                            echo '<td>'. ucwords($booking['travel_style']) .'</td>';
                                            echo '<td>'. $booking['persons'] .'</td>';

                                            if($booking['travel_style'] == 'Sang trọng'){
                                                $total = $package['lux_price'] * $booking['persons'];
                                            }elseif($booking['travel_style'] == 'Tiện nghi'){
                                                $total = $package['comfort_price'] * $booking['persons'];
                                            }else{
                                                $total = $package['budget_price'] * $booking['persons'];
                                            }
                                            echo '<td>'. $total .'</td>';
                                            echo '<td>'. ucwords($booking['booking_status']) .'</td>';
                                            echo '<td>'. $booking['date'] .'</td>';

                                        if($booking['booking_status'] == 'Chưa xác nhận' || $booking['booking_status'] == 'Từ chối'){
                                            echo '<td><a href="bookings.php?confirm='. $booking['booking_id'] .'" class="btn btn-success mt-1">Xác nhận</a></td>';
                                            echo '<td><a href="bookings.php?pending='. $booking['booking_id'] .'" class="btn btn-secondary mt-1">Chưa xác nhận</a></td>';
                                            echo '<td><a href="bookings.php?reject='. $booking['booking_id'] .'" class="btn btn-danger mt-1">Từ chối</a></td>';
                                        }else{
                                            echo '<td><a href="bookings.php?confirm='. $booking['booking_id'] .'" class="btn btn-outline-success mt-1">Xác nhận</a></td>';
                                            echo '<td><a href="bookings.php?pending='. $booking['booking_id'] .'" class="btn btn-outline-secondary mt-1">Chưa xác nhận</a></td>';
                                            echo '<td><a href="bookings.php?reject='. $booking['booking_id'] .'" class="btn btn-outline-danger mt-1">Từ chối</a></td>';
                                        }
                                        echo '</tr>';
                                }
                            ?>

                            </tbody>
                        </table>
                    </div>

                <?php        
                    }
                ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
    include 'layouts/agency_footer.php';
?>