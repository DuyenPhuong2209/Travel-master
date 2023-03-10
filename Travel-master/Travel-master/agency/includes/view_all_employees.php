<?php
    //Employee Read Query.. for only one Agency
    if($_SESSION['agency_id']){
        $agency_id = $_SESSION['agency_id'];

        $stmt = $pdo->prepare('SELECT * FROM agency_employees WHERE agency_id = :agency_id');
        $stmt->execute([':agency_id' => $agency_id]);
        $employees = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $employees[] = $row;
        }
    }

    //Employee Delete Query
    if(isset($_GET['delete'])){
        $employee_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM agency_employees WHERE employee_id = :employee_id');
        $stmt->execute([':employee_id' => $employee_id]);

        $_SESSION['success'] = 'Nhân viên đã bị xóa';
        header('Location: employees.php');
        return;
    }
?>

<div class="container-fluid">

<?php
    include '../includes/flash_msg.php';

    if(empty($employees)){
        echo '<h1 class="text-center pt-4">Không tìm thấy nhân viên</h1>';
    }else{
?>

    <div class="col-xs-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ
                <th>Vai trò</th>
                <th>Ngày tham gia</th>
                
                <?php
                    if($_SESSION['agency_login'] == 'Chủ đại lý'){
                ?>
               <th>Hoạt động</th>

                <?php
                    }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                foreach($employees as $employee){
                    echo '<tr>';
                        echo '<td>'. $i++ .'</td>';
                        echo '<td>'. $employee['employee_name'] .'</td>';
                        echo '<td>'. $employee['employee_email'] .'</td>';
                        echo '<td>'. $employee['employee_contact'] .'</td>';
                        echo '<td>'. $employee['employee_address'] .'</td>';
                        echo '<td>'. ucwords($employee['role']) .'</td>';
                        echo '<td>'. $employee['date'] .'</td>';

                    if($_SESSION['agency_login'] == 'Chủ đại lý'){
                        echo '<td><a  href="employees.php?page=edit_employee&edit='. $employee['employee_id'] .'" class="btn btn-outline-warning mt-1 mr-1"><i class="fas fa-edit"></i></a>';
                        echo '<a href="employees.php?delete='. $employee['employee_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
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