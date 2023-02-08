<?php
    include 'includes/db.php';
    include 'includes/functions.php';

    if(isset($_GET['booking_id'])){
        $booking_id = $_GET['booking_id'];

        $stmt = $pdo->prepare('SELECT * FROM bookings WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id' => $booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        $package = readPackage($booking['package_id']);
        $tourist = readTourist($booking['tourist_id']);

        $tourist_id     = $booking['tourist_id'];
        $package_id     = $booking['package_id'];
        $agency_id      = $booking['agency_id'];

        if($booking['travel_style'] == 'Sang trọng'){
            $total      = $package['lux_price'] * $booking['persons'];
            $half       = $total / 2;
            $book_per   = ceil(($package['booking_percentage'] / 100) * $total);
        }elseif($booking['travel_style'] == 'Tiện nghi'){
            $total       = $package['comfort_price'] * $booking['persons'];
            $half        = $total / 2;
            $book_per    = ceil(($package['booking_percentage'] / 100) * $total);
        }else{ 
            $total       = $package['budget_price'] * $booking['persons'];
            $half        = $total / 2;
            $book_per    = ceil(($package['booking_percentage'] / 100) * $total);
        }


        $payment_type   = $_POST['payment'];
        $card_name      = htmlentities($_POST['card_name']);
        $date           = date("y.m.d");

        $amount = '';
        if($payment_type == 'Đầy đỷ'){
            $amount = $book;
        }elseif($payment_type == 'Nửa'){
            $amount = $half;
        }else{
            $amount = $total;
        }

        if(empty($card_name)){
            $_SESSION['error'] = 'Vui lòng điền tên chủ thẻ';
            header('Location: payment.php?booking_id='. $booking_id);
            return;
        }else{
            $stmt = $pdo->prepare('INSERT INTO payments(booking_id, package_id, agency_id, tourist_id, amount, currency, txn_id, payment_type, payment_status, card_name,  tour_status, date) 
            VALUES(:booking_id, :package_id,  :agency_id, :tourist_id, :amount, :currency, :txn_id, :payment_type, :payment_status, :card_name, :tour_status, :date)');

            $stmt->execute([':booking_id'       => $booking_id,
                            ':package_id'       => $package_id,
                            ':agency_id'        => $agency_id,
                            ':tourist_id'       => $tourist_id,
                            ':amount'           => $amount,
                            ':currency'         => $charge->currency,
                            ':txn_id'           => $charge->balance_transaction,
                            ':payment_type'     => $payment_type,
                            ':payment_status'   => $charge->status,
                            ':card_name'        => $card_name,
                            ':tour_status'      => 'Chưa bắt đầu',
                            ':date'             => $date]);

            //$_SESSION['success'] = "Thank You For Trusting Us..";
            header('Location: success.php?payment_id='. $pdo->lastInsertId());
            return;
        }
    }
?>