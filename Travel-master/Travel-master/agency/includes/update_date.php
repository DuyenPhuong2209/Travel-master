<?php

    function readDates($date_id){
        include '../includes/db.php';

        $stmt = $pdo->prepare('SELECT * FROM package_dates WHERE date_id = :date_id');
        $stmt->execute([':date_id' => $date_id]);
        $package_dates = $stmt->fetch(PDO::FETCH_ASSOC);
        return $package_dates;

    }
    function updateDates($status, $date_id, $date, $agency_id, $package_id){
        include '../includes/db.php';

        if(isset($_POST['update_date'])){
            $last_date      = $_POST['last_date'];
            $travel_date    = $_POST['travel_date'];
            
            if(empty($last_date) || empty($travel_date)){
                $_SESSION['error'] = 'Tất cả các chỗ trống là bắt buộc';
                header('Location: packages.php?page=add_date&package='. $package_id);
                return;
            }else{
                $stmt = $pdo->prepare('UPDATE package_dates SET package_id = :package_id, agency_id = :agency_id, last_date = :last_date, travel_date = :travel_date, status = :status, date = :date WHERE date_id = :date_id');

                $stmt->execute(['date_id'       => $date_id,
                                ':package_id'   => $package_id,
                                ':agency_id'    => $agency_id,
                                ':last_date'    => $last_date,
                                ':travel_date'  => $travel_date,
                                ':status'       => $status,
                                ':date'         => $date]);

                $_SESSION['success'] = 'Ngày được cập nhật';
                header('Location: packages.php?page=package_date');
                return;
            }
        }
    }

    if(isset($_SESSION['agency_id'])){
        $agency_id  = $_SESSION['agency_id'];
        
        if(isset($_GET['edit'])){
            $date_id    = $_GET['edit'];

            $dates = readDates($date_id);

            $package_id = $dates['package_id'];
            $status     = 'booking on';
            $date       = $dates['date'];

            updateDates($status, $date_id, $date, $agency_id, $package_id);
        }
        else if(isset($_GET['extend'])){
            $date_id    = $_GET['extend'];

            $dates = readDates($date_id);

            $package_id = $dates['package_id'];
            $status     = 'extended';
            $date       = $dates['date'];

            updateDates($status, $date_id, $date, $agency_id, $package_id);
        }
    }

?>

<div class="container">
    <h2 class="p-2 pb-5">Cập nhật tour và Ngày đặt cuối cùng</h2>

    <?php
        include '../includes/flash_msg.php';
    ?>

    <form action="" method="post" class="col-md-8">
        <div class="form-group pb-2">
            <label for="last_date">Ngày đặt tour cuối cùng</label>
            <input type="date" name="last_date" value="<?php echo $dates['last_date']; ?>" id="" class="form-control">
        </div>
        <div class="form-group pb-2">
            <label for="travel_date">Ngày du lịch</label>
            <input type="date" name="travel_date" value="<?php echo $dates['travel_date']; ?>" id="" class="form-control">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Cập nhật" name="update_date" class="btn btn-primary">
            <a href="packages.php?page=package_date" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>
