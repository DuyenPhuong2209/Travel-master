<?php

    //Add Employee by Agency Owner
    if(isset($_SESSION['agency_id'])){
        if(isset($_POST['create_employee'])){
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
                    header("Location: employees.php?page=add_employee");
                    return;
                }else{
                    $contact = $employee_contact;
                }
            }

            //Empty Field Validation
            if(empty($employee_name)  || empty($employee_email) || empty($employee_password) || empty($employee_contact) || empty($employee_address) || empty($role)){
                $_SESSION['error'] = 'Tất cả các chỗ trống được yêu cầu';
                header('Location: employees.php?page=add_employee');
                return;
            }else{
                $hash_password = password_hash($employee_password, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare('INSERT INTO agency_employees(agency_id,  employee_name, employee_email, employee_password, employee_contact, employee_address, role, date)
                 VALUES(:agency_id, :employee_name,  :employee_email, :employee_password, :employee_contact, :employee_address, :role, :date)');

                $stmt->execute([':agency_id'            => $agency_id,
                                ':employee_name'        => $employee_name,
                                ':employee_email'       => $employee_email,
                                ':employee_password'    => $hash_password,
                                ':employee_contact'     => $contact,
                                ':employee_address'     => $employee_address,
                                ':role'                 => $role,
                                ':date'                 => $date]); 
                                
                $_SESSION['success'] = 'Nhân viên mới được thêm vào';
                header('Location: employees.php');
                return;
            }
        }
    }
?>

<br>
<div class="container">
    <h2 class="p-2 pb-5">Thêm nhân viên</h2>

    <?php
        include '../includes/flash_msg.php';
    ?>
    
    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="employee_name">Tên nhân viên</label>
            <input type="text" class="form-control" id="" name="employee_name">
        </div>
        <div class="form-group p-2">
            <label for="employee_email">Email </label>
            <input type="email" class="form-control" id="" name="employee_email">
        </div>
        <div class="form-group p-2">
            <label for="agency_password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="employee_password">
        </div>
        <div class="form-group p-2">
            <label for="agency_role">Vai trò</label><br>
            <select name="agency_role" id="" class="custom-select">
                <option value="">Lựa chọn</option>
                <option value="Người quản lý">Người quản lý</option>
                <option value="Nhân viên">Nhân viên</option>
            </select>
        </div>
        <div class="form-group p-2">
            <label for="agency_contact">Số điện thoại</label>
            <input type="text" class="form-control" id="" name="employee_contact">
        </div>
        <div class="form-group p-2">
            <label for="agency_address">Địa chỉ</label>
            <input type="text" class="form-control" id="" name="employee_address">
        </div>
        <div class="form-group p-2">
            <label for="date">Ngày tham gia</label>
            <input type="date" class="form-control" id="" name="date">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Thêm nhân viên" name="create_employee" class="btn btn-primary">

            <a href="employees.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>