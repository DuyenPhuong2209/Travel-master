<?php
    //Admin Read Query
    $stmt = $pdo->query('SELECT * FROM admins');
    $stmt->execute();

    $admins = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $admins[] = $row;
    }

    //Admin Approve Query
    if(isset($_GET['approve'])){
        $admin_id = $_GET['approve'];

        $stmt = $pdo->prepare('UPDATE admins SET admin_status = :admin_status WHERE admin_id = :admin_id');
        $stmt->execute([':admin_id'     => $admin_id,
                        ':admin_status' => 'Đã phê duyệt']);

        $_SESSION['success'] = 'Trạng thái quản trị viên được đặt thành Đã phê duyệt';
        header('Location: admins.php');
        return;
    }

    //Admin Unapprove Query
    if(isset($_GET['unapprove'])){
        $admin_id = $_GET['unapprove'];

        $stmt = $pdo->prepare('UPDATE admins SET admin_status = :admin_status WHERE admin_id = :admin_id');
        $stmt->execute([':admin_id'     => $admin_id,
                        ':admin_status' => 'Chưa phê duyệt']);

        $_SESSION['success'] = 'Trạng thái quản trị được đặt thành Chưa được phê duyệt';
        header('Location: admins.php');
        return;
    }

    //Admin Delete Query
    if(isset($_GET['delete'])){
        $admin_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM admins WHERE admin_id = :admin_id');
        $stmt->execute([':admin_id' => $admin_id]);

        $_SESSION['success'] = 'Đã xóa thành công thông tin quản trị viên';
        header('Location: admins.php');
        return;
    }
?>

<div class="col-xs-12">
    
    <?php
        include '../includes/flash_msg.php';

        if(empty($admins)){
            echo '<h1 class="text-center pt-4">Không tìm thấy quản trị viên</h1>';
        }else{
    ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usename</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Ngày- tháng - năm</th>
                <th>Đã phê duyệt</th>
                <th>Chưa phê duyệt</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>

            <?php

                $i = 1;
                foreach($admins as $admin){
                    if($admin['admin_status'] == 'Chưa phê duyệt'){
                        echo "<tr class='table-warning'>";
                    }else {
                        echo "<tr>";
                    }
                            echo "<td>". $i++ ."</td>";
                            echo "<td>". $admin['username'] ."</td>";
                            echo "<td>". ucwords($admin['admin_name']) ."</td>";
                            echo "<td>". $admin['admin_email'] ."</td>";
                            echo "<td>". ucwords($admin['admin_status']) ."</td>";
                            echo "<td>". $admin['date'] ."</td>";
                            
                        if($admin['admin_status'] == 'Chưa phê duyệt'){
                            echo "<td><a href='admins.php?approve=". $admin['admin_id'] ."' class='btn btn-success mt-1'>Đã phê duyệt</a></td>";
                            echo "<td><a href='admins.php?unapprove=". $admin['admin_id'] ."' class='btn btn-secondary mt-1'>Chưa phê duyệt</a></td>";
                            echo "<td><a href='admins.php?page=edit_admin&edit=". $admin['admin_id'] ."' class='btn btn-warning mr-1 mt-1'><i class='fas fa-edit'></i></a>";

                            if($_SESSION['admin_id'] === $admin['admin_id']){
                                echo "<button title='Bạn không thể xóa chính mình!!' class='btn btn-danger mt-1'><i class='fas fa-trash-alt'></i></button></td>";
                            }else{
                                echo "<a href='admins.php?delete=". $admin['admin_id'] ."' class='btn btn-danger mt-1'><i class='fas fa-trash-alt'></i></a></td>";
                            }
                            
                        }else{
                            echo "<td><a href='admins.php?approve=". $admin['admin_id'] ."' class='btn btn-outline-success mt-1'>Đã phê duyệt</a></td>";
                            echo "<td><a href='admins.php?unapprove=". $admin['admin_id'] ."' class='btn btn-outline-secondary mt-1'>Chưa phê duyệt</a></td>";
                            echo "<td><a href='admins.php?page=edit_admin&edit=". $admin['admin_id'] ."' class='btn btn-outline-warning mr-1 mt-1'><i class='fas fa-edit'></i></a>";

                            if($_SESSION['admin_id'] === $admin['admin_id']){
                                echo "<button title='Bạn không thể xóa chính mình!!' class='btn btn-outline-danger mt-1'><i class='fas fa-trash-alt'></i></button></td>";
                            }else{
                                echo "<a href='admins.php?delete=". $admin['admin_id'] ."' class='btn btn-outline-danger mt-1'><i class='fas fa-trash-alt'></i></a></td>";
                            }         
                        }
                        echo "</tr>";
                }
            ?>

        </tbody>
    </table>

    <?php
        }
    ?>
</div>