<?php
    if(isset($_SESSION['tourist_email'])){
        if(isset($_GET['package_id'])){
            if(isset($_POST['book'])){
                $tourist_id     = $_SESSION['tourist_id'];
                $package_id     = $_GET['package_id'];
                $travel_style   = $_POST['travel_style'];
                $persons        = $_POST['persons'];
                $name           = htmlentities($_POST['tourist_name']);
                $email          = htmlentities($_POST['tourist_email']);
                $contact        = htmlentities($_POST['tourist_contact']);
                $message        = $_POST['enquiry_message'];
                $date           = date("y.m.d");

                $stmt = $pdo->prepare('SELECT * FROM packages WHERE package_id = :package_id');
                $stmt->execute([':package_id' => $package_id]);
                $package = $stmt->fetch(PDO::FETCH_ASSOC);

                //contact no validation
                $tourist_contact = '';
                if(!empty($contact)){
                    $pattern = '/^(0|84)+([0-9]{9})$/';
                    if(!preg_match($pattern, $contact)){
                        $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
                        header('Location: booking.php?package_id='. $package_id);
                        return;
                    }else{
                        $tourist_contact = $contact;
                    }
                }

                if($travel_style == '' || $persons == '' ||$name == '' || $email == ''){
                    $_SESSION['error'] = 'Hãy điền vào mẫu';
                    header('Location: booking.php?package_id='. $package_id);
                    return;
                }else {
                    $stmt = $pdo->prepare('INSERT INTO bookings(package_id, tourist_id, agency_id, persons, travel_style, tourist_name, tourist_email, tourist_contact, enquiry_msg, booking_status, date) VALUES(:package_id, :tourist_id, :agency_id, :persons, :travel_style,  :tourist_name, :tourist_email, :tourist_contact, :enquiry_msg, :booking_status, :date)');

                    $stmt->execute([':package_id'           => $package_id,
                                    ':tourist_id'           => $tourist_id,
                                    ':agency_id'            => $package['agency_id'],
                                    ':persons'              => $persons,
                                    ':travel_style'         => $travel_style,
                                    ':tourist_name'         => $name,
                                    ':tourist_email'        => $email,
                                    ':tourist_contact'      => $tourist_contact,
                                    ':enquiry_msg'          => $message,
                                    ':booking_status'       => 'Chưa xác nhận',
                                    ':date'                 => $date]);

                    $_SESSION['success'] = "Yêu cầu của bạn đã được gửi. Vui lòng chờ...";
                    header('Location: mybookings.php');
                    return;
                }
            }
        }
    }
?>

<div class="row">
    <div class="col-sm-8">
        
        <?php
            include 'includes/flash_msg.php';

            if(isset($_GET['package_id'])){
                $package_id = $_GET['package_id'];

                $stmt = $pdo->prepare('SELECT * FROM packages WHERE package_id = :package_id');
                $stmt->execute([':package_id' => $package_id]);
                $package = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>

        <form action="" method="post">
            <div class="my-5 pb-3">
                <h2 class="p-2">Vui lòng điền vào mẫu này</h2>
                <div class="form-group p-2">
                    <label for="person">Người</label>
                    <input type="number" name="persons" min='1' id="" class="form-control">
                </div>
                <div class="form-group p-2">
                    <label for="travel_style">Chọn loại giá</label>
                    <select name="travel_style" id="" class="custom-select">
                        <option value="Tiết kiệm">Tiết kiệm - <?php echo ucwords($package['budget_details']); ?></option>
                        <option value="Tiện nghi">Tiện nghi - <?php echo ucwords($package['comfort_details']); ?></option>
                        <option value="Sang trọng">Sang trọng - <?php echo ucwords($package['lux_details']); ?></option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="my-5 pt-2">
                <h2 class="p-2">Thông tin cá nhân của bạn</h2>
                <div class="form-group p-2">
                    <label for="name">Họ và tên</label>
                    <input type="text" name="tourist_name" id="" class="form-control">
                </div>
                <div class="form-group p-2">
                    <label for="email">Email</label>
                    <input type="email" name="tourist_email" id="" class="form-control">
                </div>
                <div class="form-group p-2">
                    <label for="contact">Liên hệ</label>
                    <input type="text" name="tourist_contact" id="" class="form-control">
                </div>
                <div class="form-group p-2">
                    <label for="enquiry_message">Ghi chú</label></label>
                    <textarea name="enquiry_message" id="body" cols="30" rows="10" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group p-2">
                <input type="submit" value="Đặt" name="book" class="btn btn-primary">
                <a href="packages.php" class="btn btn-secondary float-right">Thoát</a>
            </div>
        </form>
    </div>

    <div class="col-sm-4">
        <div class="card mt-5 effect">
            <div class="container">
                <h2 class="p-2">Thông tin tour</h2>
                <div>
                    <h3 class="font-italic p-2"><a href="package.php?package_id=<?php echo $package_id; ?>"> <?php echo $package['package_name']; ?></a></h3>
                    <h5 class="font-italic text-info" style="font-size: 1rem;"><i class="fas fa-map-marker-alt"></i> <?php echo $package['location']; ?></h5>
                </div>
                <hr>

                <?php
                    $agency_id = $package['agency_id'];

                    $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_id = :agency_id');
                    $stmt->execute([':agency_id' => $agency_id]);
                    $agency = $stmt->fetch(PDO::FETCH_ASSOC)
                ?>

                <div class="ml-2">
                    Đại lý: <a href="agency.php?agency_id=<?php echo $package['agency_id']; ?>" class="mr-3"><?php echo $agency['agency_name']; ?></a>
                </div>
                <hr>
                <div class="">
                    <p class="ml-2">
                        <span class="mr-1"><i class="far fa-clock"></i></span>
                        <?php echo $package['num_days']. ' ngày '. $package['num_nights'] .' đêm'; ?>
                    </p>
                </div>
                <hr>
                <div class="">
                    <p class="font-weight-bold font-italic ml-2">Giá/mỗi người:</p>
                    <p class="font-italic" style="font-weight: 600;">
                        <span class="ml-3">Tiết kiệm: <?php echo number_format($package['budget_price'], 0 , $c = "," , $d = "." )?> VND</span>
                    </p>
                    <p class="font-italic" style="font-weight: 600;">
                        <span class="ml-3">Tiện nghi: <?php echo number_format($package['comfort_price'], 0 , $c = "," , $d = "." ) ?> VND </span>
                    </p>
                    <p class="font-italic" style="font-weight: 600;">
                        <span class="ml-3">Sang trọng: <?php echo number_format($package['lux_price'], 0 , $c = "," , $d = "." ) ?> VND </span>
                    </p>
                </div>
                <hr>
                <div class="">
                    <p class="font-weight-bold font-italic">
                        <span class="mx-2">Phần trăm đặt tour = </span><?php echo $package['booking_percentage'];?>%<span class="ml-2">/ tổng giá</span>
                    </p> 
                </div>
            </div>
        </div>
    </div>
</div>