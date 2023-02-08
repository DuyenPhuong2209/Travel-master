<?php
    //Package Read Query.. for only one Agency
    if($_SESSION['agency_id']){
        $agency_id = $_SESSION['agency_id'];

        $stmt = $pdo->prepare('SELECT * FROM packages WHERE agency_id = :agency_id ORDER BY package_name');
        $stmt->execute([':agency_id' => $agency_id]);
        $packages = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $packages[] = $row;
        }
    }

    //Package Available Query
    if(isset($_GET['available'])){
        $package_id = $_GET['available'];

        $stmt = $pdo->prepare('UPDATE packages SET package_status = :package_status WHERE package_id = :package_id');
        $stmt->execute([':package_id'       => $package_id,
                        ':package_status'   => 'Có sẵn']);
        $_SESSION['success'] = 'Trạng thái tour được đặt thành Có sẵn';
        header('Location: packages.php');
        return;
    }

    //Package unvailable Query
    if(isset($_GET['unavailable'])){
        $package_id = $_GET['unavailable'];

        $stmt = $pdo->prepare('UPDATE packages SET package_status = :package_status WHERE package_id = :package_id');
        $stmt->execute([':package_id'       => $package_id,
                        ':package_status'   => 'Không có sẵn']);
        $_SESSION['success'] = 'Trạng thái tour được đặt thành Không có sẵn';
        header('Location: packages.php');
        return;
    }

    //Package Delete Query
    if(isset($_GET['delete'])){
        $package_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM packages WHERE package_id = :package_id');
        $stmt->execute([':package_id' => $package_id]);

        $_SESSION['success'] = 'Tour đã bị xóa';
        header('Location: packages.php');
        return;
    }
?>

<div class="container-fluid">

<?php
    include '../includes/flash_msg.php';

    if(empty($packages)){
        echo '<h1 class="text-center pt-4"> Không tìm thấy tour nào</h1>';
    }else{
?>

    <div class="col-xs-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Tên tour</th>
                <th>Địa điểm</th>
                <th>Giá</th>
                <th>Giá đặt(%)</th>
                <th>Đặt tour tối thiểu</th>
                <th>Đã đặt trước</th>
                <th>Trạng thái</th>
                <th>Bình luận</th>
                <th>Ngày tháng năm</th>
                <th>Tạo </th>
                <th>Có sẵn</th>
                <th>Không có sẵn</th>
                <th>Hoạt động</th>
                <?php
                    if( $_SESSION['agency_login'] == '' ){
                ?>
            
                <?php
                    }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
                //$i = 1;
                foreach($packages as $key => $package){
                    if($package['package_status'] == 'Không có sẵn'){
                        echo '<tr class="table-warning">';
                    }else{
                        echo '<tr>';
                    }
                            // echo '<td>'. $package['package_id'] .'</td>';
                            echo '<td>'. ++$key .'</td>';
                            echo '<td><a href="../package.php?package_id='. $package['package_id'] .'">'. $package['package_name'] .'</a></td>';
                            echo '<td>'. $package['location'] .'</td>';
                            echo '<td>'. $package['budget_price'] .'(Tiết kiệm)<br>
                                    '. $package['comfort_price'] .'(Tiện nghi)<br>
                                    '. $package['lux_price'] .'(Sang trọng)</td>';
                            echo '<td>'. $package['booking_percentage'] .'%</td>';
                            echo '<td>'. $package['min_people'] .'</td>';

                            //Counting Already booked packages
                            $stmt = $pdo->prepare('SELECT * FROM bookings WHERE package_id = :package_id AND booking_status = :booking_status');
                            $stmt->execute([':package_id'       => $package['package_id'],
                                            ':booking_status'   => 'Xác nhận']);
                            $books = [];
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $books[] = $row['persons'];
                            }
                            $size = sizeof($books);
                            $book_person = 0;
                            for($i=0; $i<$size; $i++){
                                $book_person += $books[$i];
                            }
                            echo '<td>'. $book_person .'</td>';
                            echo '<td>'. ucwords($package['package_status']) .'</td>';

                            //Counting Package Comment
                            $stmt = $pdo->prepare('SELECT count(*) FROM comments WHERE package_id = :package_id AND comment_status = :comment_status');
                            $stmt->execute([':package_id'       => $package['package_id'],
                                            ':comment_status'   => 'Đã phê duyệt']);
                            $comment_count = $stmt->fetchColumn();
                            echo '<td>'. $comment_count .'</td>';

                            $stmt = $pdo->prepare('SELECT count(*) FROM package_dates WHERE package_id = :package_id');
                            $stmt->execute([':package_id'   => $package['package_id']]);
                            $found = $stmt->fetchColumn();
                            if(empty($found)){
                                echo '<td><a href="packages.php?page=add_date&package='. $package['package_id'] .'" class="btn btn-primary mt-1" style="background-color: #62A6F9;border: none;">Set</a></td>';
                            }else{
                                echo '<td><a href="packages.php?page=package_date">Xem</a></td>';
                            }
                            
                            echo '<td>'. $package['package_date'] .'</td>';

                        if($package['package_status'] == 'Không có sẵn'){
                            echo '<td><a  href="packages.php?available='. $package['package_id'] .'" class="btn btn-success mt-1">Có sẵn</a></td>';
                            echo '<td><a  href="packages.php?unavailable='. $package['package_id'] .'" class="btn btn-secondary mt-1">Không có sẵn</a></td>';
                        }else {
                            echo '<td><a  href="packages.php?available='. $package['package_id'] .'" class="btn btn-outline-success mt-1">Có sẵn</a></td>';
                            echo '<td><a  href="packages.php?unavailable='. $package['package_id'] .'" class="btn btn-outline-secondary mt-1">Không có sẵn</a></td>';
                        }

                        if( $_SESSION['agency_login'] ='unavailable'){
                            if($package['package_status'] == 'unavailable'){
                                echo '<td><a  href="packages.php?page=edit_package&edit='. $package['package_id'] .'" class="btn btn-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                                echo '<a href="packages.php?delete='. $package['package_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                            }else{
                                echo '<td><a  href="packages.php?page=edit_package&edit='. $package['package_id'] .'" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                                echo '<a href="packages.php?delete='. $package['package_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                            }
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