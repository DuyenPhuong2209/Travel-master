<?php
    //date insert query
    if(isset($_SESSION['agency_id'])){
        if(isset($_POST['set_date'])){
            $agency_id      = $_SESSION['agency_id'];
            $package_id     = $_GET['package'];
            $last_date      = $_POST['last_date'];
            $travel_date    = $_POST['travel_date'];
            $date           = date("y.m.d");

            if(empty($last_date) || empty($travel_date)){
                $_SESSION['error'] = 'Tất cả các chỗ trống là bắt buộc';
                header('Location: packages.php?page=add_date&package='. $package_id);
                return;
            }else{
                $stmt = $pdo->prepare('INSERT INTO package_dates(package_id, agency_id, last_date, travel_date, status, date)
                 VALUES(:package_id, :agency_id, :last_date, :travel_date, :status, :date)');

                $stmt->execute([':package_id'   => $package_id,
                                ':agency_id'     => $agency_id,
                                ':last_date'    => $last_date,
                                ':travel_date'  => $travel_date,
                                ':status'       => 'Đang mở',
                                ':date'         => $date]);

                $_SESSION['success'] = 'Ngày được thêm vào';
                header('Location: packages.php?page=package_date');
                return;
            }
        }
    }
?>

<div class="container">
    <h2 class="p-2 pb-5">Thêm ngày đi và đặt tour cuối cùng</h2>

    <?php
        include '../includes/flash_msg.php';
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group pb-2">
            <label for="last_date">Ngày đặt tour cuối cùng</label>
            <input type="date" name="last_date" id="" class="form-control">
        </div>
        <div class="form-group pb-2">
            <label for="travel_date">Ngày du lịch</label>
            <input type="date" name="travel_date" id="" class="form-control">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Đặt ngày" name="set_date" class="btn btn-primary">
            <a href="packages.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>