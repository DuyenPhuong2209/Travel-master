<?php

    if(isset($_GET['edit'])){
        if(isset($_POST['update_employee'])){
            $employee_id        = $_GET['edit'];
            $agency_id          = $_SESSION['agency_id'];
            $employee_name      = htmlentities($_POST['employee_name']);
            $employee_email     = htmlentities($_POST['employee_email']);
            $employee_password  = htmlentities($_POST['employee_password']);
            $employee_contact   = htmlentities($_POST['employee_contact']);
            $employee_address   = htmlentities($_POST['employee_address']);
            $role               = $_POST['agency_role'];
            $date               = $_POST['date'];

            //contact no validation
            $contact = '';
            if(!empty($employee_contact)){
                $pattern = '/^(0|84)+([0-9]{9})$/';
                
                if(!preg_match($pattern, $employee_contact)){
                    $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
                    header("Location: employees.php?page=edit_employee&edit=". $employee_id);
                    return;
                }else{
                    $contact = $employee_contact;
                }
            }

            //Empty Field Validation
            if(empty($employee_name)|| empty($employee_email) || empty($employee_password) || empty($employee_contact) || empty($employee_address) || empty($role)){
                $_SESSION['error'] = 'Tất cả các chỗ trống được yêu cầu';
                header("Location: employees.php?page=edit_employee&edit=". $employee_id);
                return;
            }else{
                $hash_password = password_hash($employee_password, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare('UPDATE agency_employees SET agency_id = :agency_id, employee_name = :employee_name, employee_email = :employee_email,
                 employee_password = :employee_password, employee_contact = :employee_contact, employee_address = :employee_address, role = :role, date = :date WHERE employee_id = :employee_id');

                $stmt->execute([':employee_id'          => $employee_id,
                                ':agency_id'            => $agency_id,
                                ':employee_name'        => $employee_name,
                                ':employee_email'       => $employee_email,
                                ':employee_password'    => $hash_password,
                                ':employee_contact'     => $contact,
                                ':employee_address'     => $employee_address,
                                ':role'                 => $role,
                                ':date'                 => $date]);
                $_SESSION['success'] = 'Cập nhật thông tin nhân viên';
                header('Location: employees.php');
                return;
            }
        }
    }
?>

<br>
<div class="container">
    <h2 class="p-2 pb-5">Chỉnh sửa nhân viên</h2>

    <?php
        include '../includes/flash_msg.php';

        if(isset($_GET['edit'])){
            $employee_id = $_GET['edit'];

            $stmt = $pdo->prepare('SELECT * FROM agency_employees WHERE employee_id = :employee_id');
            $stmt->execute([':employee_id' => $employee_id]);
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    
    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="employee_name">Tên nhân viên</label>
            <input type="text" class="form-control" id="" value="<?php echo $employee['employee_name']; ?>" name="employee_name">
        </div>
        <div class="form-group p-2">
            <label for="employee_email">Email</label>
            <input type="email" class="form-control" id="" value="<?php echo $employee['employee_email']; ?>" name="employee_email">
        </div>
        <div class="form-group p-2">
            <label for="agency_password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="employee_password">
        </div>
        <div class="form-group p-2">
            <label for="agency_role">Vai trò</label><br>
            <select name="agency_role" id="" class="custom-select">
                <option value="<?php echo $employee['role'] ?>"><?php echo $employee['role'] ?></option>
                <?php
                    if($employee['role'] == 'Người quản lý'){
                        echo '<option value="Nhân viên">Nhân viên</option>';
                    }else{
                        echo '<option value="Người quản lý"> Người quản lý</option>';
                    }
                ?>
            </select>
        </div>
        <div class="form-group p-2">
            <label for="agency_contact">Số điện thoại</label>
            <input type="text" class="form-control" id="" value="<?php echo $employee['employee_contact'] ?>" name="employee_contact">
        </div>
        <div class="form-group p-2">
            <label for="agency_address">Địa chỉ</label>
            <input type="text" class="form-control" id="" value="<?php echo $employee['employee_address'] ?>" name="employee_address">
        </div>
        <div class="form-group p-2">
            <label for="date">Ngày tham gia</label>
            <input type="date" class="form-control" id="" value="<?php echo $employee['date']; ?>" name="date">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Cập nhật nhân viên" name="update_employee" class="btn btn-primary">

            <a href="employees.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>