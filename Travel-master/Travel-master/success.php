<?php
    include 'includes/db.php';
    include 'includes/functions.php';
    $page = 'packages';
    include 'layouts/header.php';
    include 'layouts/navbar.php';


    if(isset($_GET['payment_id'])){
        $payment_id = $_GET['payment_id'];

        $stmt = $pdo->prepare('SELECT * FROM payments WHERE payment_id = :payment_id');
        $stmt->execute([':payment_id'   => $payment_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<head>
    <style>
        .package {
            background-image: url("images/view/success.jpg");
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
    <h1 class="display-4 text-center text-success font-weight-bold">
        <?php
            if(isset($_GET['payment_id'])){
                echo 'Payment';
            }
        ?>
    </h1>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card my-5 effect" style="background: #F4F6F6;">
                <div class="card-body p-5">
                    <h2 class="p-2 text-center font-weight-bold" style="color: #015022;">Giao dịch của bạn đã được hoàn thành</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="text-center mb-5"><span class="border-bottom border-5 border-primary p-2">Chi tiết thanh toán của bạn</span></h3>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-8 mx-auto" style="font-size: 1.2rem;">
                    <div class="card" style="border: none;">
                        <div class="card-body">
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">ID giao dịch: </span><?php echo $payment['txn_id']; ?>
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Trạng thái thanh toán: </span><?php echo ucwords($payment['payment_status']); ?>
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Số lượng: </span><?php echo strtoupper($payment['currency']) ." ". $payment['amount']; ?>/-
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Tên của thẻ: </span><?php echo $payment['card_name']; ?>
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Ngày thanh toán: </span><?php echo $payment['date']; ?>
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Tour: </span>
                                <?php 
                                    $package = readPackage($payment['package_id']); 
                                    echo '<a href="package.php?package_id='. $payment['package_id'] .'">'. ucwords($package['package_name']) .'</a>';
                                ?>
                            </div>
                            <hr>
                            <div class="p-2">
                                <span class="font-weight-bold mr-3">Đại lý: </span>
                                <?php 
                                    $agency= readAgency($payment['agency_id']); 
                                    echo '<a href="agency.php?agency_id='. $payment['agency_id'] .'">'. ucwords($agency['agency_name']) .'</a>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card mt-5" style="border: none;">
                <div class="card-body">
                    <h4 class="text-center text-success font-wight-bold font-italic" style="font-size: 2rem;">Cảm ơn</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'layouts/footer.php';
?>