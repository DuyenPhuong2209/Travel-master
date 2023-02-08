<?php
    include 'includes/db.php';
    include 'includes/functions.php';
    $page = 'packages';
    include 'layouts/header.php';
    include 'layouts/navbar.php';


    if(isset($_GET['booking_id'])){
        $booking_id = $_GET['booking_id'];

        $stmt = $pdo->prepare('SELECT * FROM bookings WHERE booking_id = :booking_id');
        $stmt->execute([':booking_id' => $booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        $package_id = $booking['package_id'];
        $package = readPackage($booking['package_id']);

        $tourist_id     = $booking['tourist_id'];
        $package_id     = $booking['package_id'];
        $agency_id      = $booking['agency_id'];

        if($booking['travel_style'] == 'Sang trọng'){
            $total  = $package['lux_price'] * $booking['persons'];
            $half   = $total / 2;
            $book   = ceil(($package['booking_percentage'] / 100) * $total);
        }elseif($booking['travel_style'] == 'Tiện nghi'){
            $total  = $package['comfort_price'] * $booking['persons'];
            $half   = $total / 2;
            $book   = ceil(($package['booking_percentage'] / 100) * $total);
        }else{
            $total  = $package['budget_price'] * $booking['persons'];
            $half   = $total / 2;
            $book   = ceil(($package['booking_percentage'] / 100) * $total);
        }
    }

?>
<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .package {
            background-image: url("images/view/payment.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            height: 50vh;
        }

        .effect:hover{
            box-shadow: 4px 4px 15px 0px rgba(0,0,0,0.44);
            -webkit-box-shadow: 4px 4px 15px 0px rgba(0,0,0,0.44);
            -moz-box-shadow: 4px 4px 15px 0px rgba(0,0,0,0.44);
            transition: box-shadow 0.2s ease-in-out;
        }
        
    </style>
    
</head>

<br><br><br>
<div class="jumbotron jumbotron-fluid package">
  <div class="container">
    <h1 class="display-4 text-white text-center font-weight-bold">Đặt tour</h1>
  </div>
</div>

<div class="container">
    <div class="row">
    <div class="col-sm-6">
            

            <br>
            <br><br>
            <br>
            <br><br><h3 style="color: red; font-weight: bold;" >Xin vui lòng kiểm tra email!!!</h3>
                    <h3 style="color: red; font-weight: bold;" >Tiếp nhận đặt thành công</h3>
                   <p>Mọi thắc mắc xin liên hệ  qua hotline <b style="color: red;"> 1900 1177</b></p>
                   <br>
            <br><br>
            <br>
            <br><br> <br>
            <br><br>
            <br>
            <br><br>
                
        </div>
        <div class="col-sm-6">
        <?php
            include 'includes/flash_msg.php'
        ?>
            <form action="charge.php?booking_id=<?php if(isset($_GET['booking_id'])){echo $_GET['booking_id'];} ?>" method="post" id="payment-form">
                <div class="my-5">
            
                    <img src="./images/globe.png" alt="">
                </div>
            </form>
        </div>

       
    </div>
</div>
<script src="js/stripe.js"></script>

<?php
    include 'layouts/footer.php';
?>