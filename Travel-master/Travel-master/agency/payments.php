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

        //Payment Read Query
        $stmt = $pdo->prepare('SELECT * FROM payments WHERE agency_id = :agency_id ORDER BY tour_status DESC');
        $stmt->execute([':agency_id' => $agency_id]);
        $payments = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $payments[] = $row;
        }
    }

    //Tour Travel Query
    if(isset($_GET['travel'])){
        $payment_id = $_GET['travel'];

        $stmt = $pdo->prepare('UPDATE payments SET tour_status = :tour_status WHERE payment_id = :payment_id');
        $stmt->execute([':payment_id'       => $payment_id,
                        ':tour_status'   => 'Đang du lịch']);
        $_SESSION['success'] = 'Trạng thái chuyến tham quan được đặt thành Đang đi du lịch';
        header('Location: payments.php');
        return;
    }

    //tour complete Query
    if(isset($_GET['complete'])){
        $payment_id = $_GET['complete'];

        $stmt = $pdo->prepare('UPDATE payments SET tour_status = :tour_status WHERE payment_id = :payment_id');
        $stmt->execute([':payment_id'       => $payment_id,
                        ':tour_status'   => 'Hoàn thành']);
        $_SESSION['success'] = 'Trạng thái chuyến tham quan được đặt thành Đã hoàn thành';
        header('Location: payments.php');
        return;
    }

    //tour not_start Query
    if(isset($_GET['not_start'])){
        $payment_id = $_GET['not_start'];

        $stmt = $pdo->prepare('UPDATE payments SET tour_status = :tour_status WHERE payment_id = :payment_id');
        $stmt->execute([':payment_id'    => $payment_id,
                        ':tour_status'   => 'Chưa bắt đầu']);
        $_SESSION['success'] = 'Trạng thái chuyến tham quan được đặt thành Chưa bắt đầu';
        header('Location: payments.php');
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
                    <li class="breadcrumb-item active">Chi tiết thanh toán</li>
                </ol>
                <div class="container-fluid">

                <?php

                    include '../includes/flash_msg.php';

                    if(empty($payments)){
                        echo '<h1 class="text-center pt-4"> Không có khoản thanh toán nào để hiển thị</h1>';
                    }else {
                    
                ?>

                    <div class="col-xs-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên tour</th>
                                    <th>Đặt bởi</th>
                                    <th>Tên thẻ</th>
                                    <th>Tổng tiền</th>
                                    <th>Hình thức thanh toán</th>
                                    <th>Tình trạng thanh toán</th>
                                    <th>ID giao dịch</th>
                                    <th>Ngày</th>                                 
                                    <th>Tình trạng du lịch</th>
                                    <th>Đi du lịch</th>
                                    <th>Hoàn thành</th>
                                    <th>Chưa bắt đầu</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $i = 1;
                                foreach($payments as $payment){
                                    if($payment['tour_status'] == 'Đang du lịch'){
                                        echo '<tr class="table-warning">';
                                    }elseif ($payment['tour_status'] == 'Chưa bắt đầu') {
                                        echo '<tr class="table-danger">';
                                    }else{
                                        echo '<tr>';
                                    }
                                            echo '<td>'. $i++ .'</td>';
                                            
                                            //Package Name Read Query
                                            $package = readPackage($payment['package_id']);

                                            echo '<td><a href="../package.php?package_id='. $package['package_id'] .'">'. $package['package_name'] .'</a></td>';

                                            $stmt = $pdo->prepare('SELECT * FROM bookings WHERE booking_id = :booking_id');
                                            $stmt->execute([':booking_id' => $payment['booking_id']]);
                                            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

                                            echo '<td>'. ucwords($booking['tourist_name']) .'</td>';
                                            echo '<td>'. $payment['card_name'] .'</td>';
                                            echo '<td>'. strtoupper($payment['amount']) ." ". $payment['currency'] .'</td>';

                                        if($payment['payment_type'] == 'Đầy đủ'){
                                            echo '<td>Đầy đủ</td>';
                                        }elseif($payment['payment_type'] == 'Nửa'){
                                            echo '<td>Nửa</td>';
                                        }else{
                                            echo '<td></td></td>';
                                        }
                                            echo '<td>'. ucwords($payment['payment_status']) .'</td>';
                                            echo '<td>'. $payment['txn_id'] .'</td>';
                                            echo '<td>'. $payment['date'] .'</td>';
                                            echo '<td>'. ucwords($payment['tour_status']) .'</td>';

                                        if($payment['tour_status'] == 'Đang du lịch' || $payment['tour_status'] == 'Hoàn thành'){
                                            echo '<td><a href="payments.php?travel='. $payment['payment_id'] .'" class="btn btn-success mt-1">Đang du lịch</a></td>';
                                            echo '<td><a href="payments.php?complete='. $payment['payment_id'] .'" class="btn btn-secondary mt-1">Hoàn thành</a></td>';
                                            echo '<td><a href="payments.php?not_start='. $payment['payment_id'] .'" class="btn btn-danger mt-1">Chưa bắt đầu</a></td>';
                                        }else{
                                            echo '<td><a href="payments.php?travel='. $payment['payment_id'] .'" class="btn btn-outline-success mt-1">Đang du lịch</a></td>';
                                            echo '<td><a href="payments.php?complete='. $payment['payment_id'] .'" class="btn btn-outline-secondary mt-1">Hoàn thành</a></td>';
                                            echo '<td><a href="payments.php?not_start='. $payment['payment_id'] .'" class="btn btn-outline-danger mt-1">Chưa bắt đầu</a></td>';
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