<?php
    
    $stmt = $pdo->prepare('SELECT * FROM package_dates WHERE agency_id = :agency_id ORDER BY status');
    $stmt->execute([':agency_id'  => $_SESSION['agency_id']]);
    $dates = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $dates[] = $row;
    }

    //booking on
    if(isset($_GET['b_on'])){
        $date_id = $_GET['b_on'];

        $stmt = $pdo->prepare('UPDATE package_dates SET status = :status WHERE date_id = :date_id');
        $stmt->execute([':status'   => 'Đang mở',
                        ':date_id'  => $date_id]);

        $_SESSION['success'] = 'Đặt trước đang diễn ra';
        header('Location: packages.php?page=package_date');
        return;
    }

    //booking off
    if(isset($_GET['b_off'])){
        $date_id = $_GET['b_off'];

        $stmt = $pdo->prepare('UPDATE package_dates SET status = :status WHERE date_id = :date_id');
        $stmt->execute([':status'   => 'Kết thúc',
                        ':date_id'  => $date_id]);

        $_SESSION['success'] = 'Đặt tour kết thúc';
        header('Location: packages.php?page=package_date');
        return;
    }

    //delete
    if(isset($_GET['delete'])){
        $date_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM package_dates WHERE date_id = :date_id');
        $stmt->execute([':date_id' => $date_id]);

        $_SESSION['success'] = 'Ngày tour đã bị xóa';
        header('Location: packages.php?page=package_date');
        return;
    }
?>

<div class="container-fluid">

<?php
    include '../includes/flash_msg.php';

    if(empty($dates)){
        echo '<h1 class="text-center pt-4">Không có gì để hiển thị</h1>';
    }else{
?>
    <div class="col-xs-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Ngày đặt tour cuối cùng</th>
                    <th>Ngày du lịch</th>
                    <th>Trạng thái</th>
                    <th>Kéo dài</th>
                    <th>Đặt</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                foreach($dates as $date){
                    if($date['status'] == 'Kết thúc'){
                        echo '<tr class="table table-secondary">';
                    }else if($date['status'] == 'Kéo dài'){
                        echo '<tr class="table table-danger">';
                    }else{
                        echo '<tr>';
                    }
                        echo '<td>'. $i++ .'</td>';
                        
                        $stmt = $pdo->prepare('SELECT * FROM packages WHERE package_id = :package_id');
                        $stmt->execute([':package_id' => $date['package_id']]);
                        $package = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<td><a href="../package.php?package_id='. $date['package_id'] .'">'. $package['package_name'] .'</a></td>';

                        echo '<td>'. $date['last_date'] .'</td>';
                        echo '<td>'. $date['travel_date'] .'</td>';
                        echo '<td>'. ucwords($date['status']) .'</td>';

                    if($date['status'] != 'Đang mở'){
                        echo '<td><a href="packages.php?page=update_date&extend='. $date['date_id'] .'" class="btn btn-info mt-1">Kéo dài</a></td>';

                        echo '<td><a href="packages.php?page=package_date&b_on='. $date['date_id'] .'" class="btn btn-success mt-1 mr-1">Đang mở</a>';
                        echo '<a href="packages.php?page=package_date&b_off='. $date['date_id'] .'" class="btn btn-secondary mt-1">Kết thúc</a></td>';

                        echo '<td><a href="packages.php?page=update_date&edit='. $date['date_id'] .'" class="btn btn-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                        echo '<a href="packages.php?page=package_date&delete='. $date['date_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                    }else{
                        echo '<td><a href="packages.php?page=update_date&extend='. $date['date_id'] .'" class="btn btn-outline-info mt-1">Kéo dài</a></a></td>';

                        echo '<td><a href="packages.php?page=package_date&b_on='. $date['date_id'] .'" class="btn btn-outline-success mt-1 mr-1">Đang mở</a></a>';
                        echo '<a href="packages.php?page=package_date&b_off='. $date['date_id'] .'" class="btn btn-outline-secondary mt-1">Kết thúc</a></td>';

                        echo '<td><a href="packages.php?page=update_date&edit='. $date['date_id'] .'" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                        echo '<a href="packages.php?page=package_date&delete='. $date['date_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
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