<?php
    include 'includes/db.php';
    include 'includes/functions.php';
    include 'layouts/header.php';
    include 'layouts/navbar.php';

    if(empty($_SESSION['tourist_login']) || $_SESSION['tourist_login'] == ''){
        header('Location: includes/login.php');
        return;
    }

    if(isset($_SESSION['tourist_email'])){
        $tourist_id = $_SESSION['tourist_id'];

        $stmt = $pdo->prepare('SELECT * FROM bookings WHERE tourist_id = :tourist_id ORDER BY booking_id DESC');
        $stmt->execute([':tourist_id' => $tourist_id]);
        $bookings = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $bookings[] = $row;
        }
    }
    if(isset($_GET['delete'])){
        $booking_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM bookings WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id' => $booking_id]);

        $_SESSION['success'] = 'Đặt trước của bạn bị xóa';
        header('Location: mybookings.php');
        return;
    }

    if (isset($_POST['btn'])==true){
        SendMail();
    }
    
    
    function SendMail(){ 
        require "PHPMailer-master/src/PHPMailer.php";
        require "PHPMailer-master/src/SMTP.php";
        require "PHPMailer-master/src/Exception.php";
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'phuongdv.02@gmail.com';                     //SMTP username
            $mail->Password   = 'rnzqwjlreogtdkoh';                               //SMTP password
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;    
            //Recipients
            $mail->setFrom('phuongdv.02@gmail.com', 'Travel');
            $mail->addAddress('duyenntp15082003@gmail.com', 'Duyen');     //Add a recipient
         
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Booking';
            
            $mail->Body    = ' 
         
                  <h4 style="text-align: center">Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi,<br>
                      Booking của quý khách đã được chúng tôi tiếp nhận
                  </h4>
                  <h2>Phiếu tiếp nhận booking</h2>
            
            <p>Tên tour: Cù lao chàm <br>
            Ngày đặt: 23/12/2022<br> 
            Số lượng: 2<br>
            Ngày du lịch 1/11/2023 </p>
            <b style="color:red">Xin quý khách vui lòng nhớ số booking để thuận tiện cho giao dịch sau này</b><br>
            <b style="color:red"> Quý khách có thể quản lý booking tại thông tin khách hàng</b><br>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->smtpConnect( array(
                "ssl" => array(
                    "verify_peer" => false, //
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )                
            ));
            $mail->send();
            header("location:payment.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>

<head>
    <style>
       
        .mybooking {
            background-image: url("images/view/mybooking.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            height: 50vh;
        }
    </style>
</head>

<br><br><br>
<div class="jumbotron jumbotron-fluid mybooking">
  <div class="container"><br>
    <h1 class="display-4 text-white text-center font-weight-bold">Thông tin tour của tôi</h1>
  </div>
</div>

<div class="container-fluid">

    <?php
        include 'includes/flash_msg.php';

        if(empty($bookings)){
            echo '<h1 class="text-center pt-4">Không có đặt chỗ để hiển thị</h1>';
        }else{

    ?>

    <table class="table table-bordered table-hover mt-5" style="background: #F6F4F6;">
        <thead>
            <tr>
                <th>ID Đặt</th>
                <th>Tên Tour</th>
                <th>Tên Đại lý</th>
                <th>Tình trạng đặt</th>
                <th>Phong cách du lịch</th>
                <th>Số Lượng</th>
                <th>Ngày đặt</th>
                <th>Giá tour</th>
                <th>Phần trăm đặt tour</th>
                <th>Tình trạng thanh toán</th>
                <!-- <th>Ngày đặt cuối cùng </th> -->
                <th>Ngày du lịch</th>
                <th>Ghi chú cho đại lý</th>
                <th>Tình trạng Tour</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = 1;
            foreach($bookings as $booking){
                //Reading Payment data
                $stmt = $pdo->prepare('SELECT * FROM payments WHERE booking_id = :booking_id');
                $stmt->execute([':booking_id' => $booking['booking_id']]);
                $payment = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!empty($payment) && $payment['tour_status'] == 'Đang du lịch'){
                    echo '<tr class="table table-info">';
                }elseif(!empty($payment) && $payment['tour_status'] == 'Đã hoàn thành'){
                    echo '<tr class="table table-danger">';
                }else{
                    
                }
                    echo '<td>'. $i++ .'</td>';

                    //Package Name Reading From packages Table
                    $package = readPackage($booking['package_id']);

                    echo '<td><a href="package.php?package_id='. $booking['package_id'] .'">'. $package['package_name'] .'</a></td>';

                    //Agency Name Reading From agencies Table
                    $agency = readAgency($booking['agency_id']);

                    echo '<td><a href="agency.php?agency_id='. $booking['agency_id'] .'">'. $agency['agency_name'] .'</a></td>';
                    echo '<td>'. ucwords($booking['booking_status']) .'</td>';
                    echo '<td>'. ucwords($booking['travel_style']) .'</td>';
                    echo '<td>'. $booking['persons'] .'</td>';
                    echo '<td>'. $booking['date'] .'</td>';

                    if($booking['travel_style'] == 'Tiết kiệm'){
                        $total = $package['budget_price'] * $booking['persons'];
                        $book =  ceil(($package['booking_percentage'] / 100) * $total);
                    }elseif($booking['travel_style'] == 'Tiện nghi'){
                        $total = $package['comfort_price'] * $booking['persons'];
                        $book =  ceil(($package['booking_percentage'] / 100) * $total);
                    }else{
                        $total = $package['lux_price'] * $booking['persons'];
                        $book =  ceil(($package['booking_percentage'] / 100) * $total);
                    }
                    echo '<td>'. $total .'</td>';
                    echo '<td>'. $book .'</td>';

                   
                    if($booking['booking_status'] == 'Xác nhận' && empty($payment)){
                        echo ' <form action="" method="post">
                        <td><button href="payment.php?booking_id='. $booking['booking_id'] .'" class="btn btn-primary" name="btn" type="submit">Thanh toán</button></td>
                        
                        </form>';

                    }elseif($booking['booking_status'] == 'Xác nhận' && !empty($payment)){
                        
                        echo '<td class="font-weight-bold"><a href="success.php?payment_id='. $payment['payment_id'] .'">Thanh toán</a></td>';

                    }else {
                        echo '<td><a href="payment.php?booking_id='. $booking['booking_id'] .'" class="btn btn-primary disabled">Thanh toán</a></td>';

                    }

                    //read package date data
                    $date = readPackageDates($package['package_id']);
                    if(!empty($payment) && $payment['tour_status'] !== 'Chưa bắt đầu'){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }else if(empty($date)){
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                    }else{
                        // echo '<td>'. $date['last_date'] .'</td>';
                       
                        echo '<td>'. $date['travel_date'] .'</td>';

                        if($date['status'] == 'Kéo dài'){
                            echo '<td class="text-danger font-weight-bold">Xin lỗi!! Chúng tôi đã phải KÉO DÀI ngày </td>';
                        }else if($date['status'] == 'Kết thúc'){
                            echo '<td class="text-success font-weight-bold">Chúng tôi đã sẵn sàng để DU LỊCH</td>';
                        }else{
                            echo '<td>Đặt tour vẫn đang diễn ra</td>';
                        }
                        
                    }

                    if(!empty($payment)){
                        echo '<td>'. ucwords($payment['tour_status']) .'</td>';
                    }else{
                        echo '<td></td>';
                    }
                    if($booking['booking_status'] == 'Chưa xác nhận' || (!empty($date) && $date['status'] == 'Kéo dài')){
                        echo '<td><a  href="booking.php?page=edit_booking&edit='. $booking['booking_id'] .'" class="btn btn-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                        echo '<a href="mybookings.php?delete='. $booking['booking_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                    }else {
                        echo '<td><a  href="mybooking.php?page=edit_mybooking&edit='. $booking['booking_id'] .'" class="btn btn-warning mt-1 mr-1 disabled"><i class="fas fa-edit"></i></a>';
                        echo '<a href="mybookings.php?delete='. $booking['booking_id'] .'" class="btn btn-danger mt-1 disabled"><i class="fas fa-trash-alt"></i></a></td>';
                    }

                echo '</tr>';
            }
        ?> 
        </tbody>
    </table>

    <?php
        }
    ?>
</div>
<?php
    include 'layouts/footer.php';
?>