<?php

    //Admin Insert Query
    if(isset($_POST['create_admin'])){
        $username        = htmlentities($_POST['username']);
        $admin_name      = htmlentities($_POST['admin_name']);
        $admin_email     = htmlentities($_POST['admin_email']);
        $date            = date("y.m.d");

        $admin_password = htmlentities($_POST['admin_password']);

        //Empty Field Validation
        if($username == '' || $admin_name == '' || $admin_email == '' || $admin_password == ''){
            $_SESSION['error'] = 'Tất cả các lĩnh vực được yêu cầu';
            header('Location: admins.php?page=add_admin');
            return;
        }
        
        //Username Validation
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $username_validate = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $username_validate[] = $row;
        }
        if(!empty($username_validate)){
            $_SESSION['error'] = 'Tên người dùng đã tồn tại. Vui lòng thử cái khác';
            header('Location: admins.php?page=add_admin');
            return;
        }

        //Email Validation
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE admin_email = :admin_email');
        $stmt->execute([':admin_email' => $admin_email]);
        $email_validate = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $email_validate[] = $row;
        }
        if(!empty($email_validate)){
            $_SESSION['error'] = 'Địa chỉ email đã tồn tại. Vui lòng thử địa chỉ khác';
            header('Location: admins.php?page=add_admin');
            return;
        }
        
        else{
            $hash_password = password_hash($admin_password, PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare('INSERT INTO admins(username, admin_name, admin_email, admin_password, admin_status, date)
             VALUES(:username, :admin_name, :admin_email, :admin_password, :admin_status, :date)');

            $stmt->execute([':username'        => $username,
                            ':admin_name'      => $admin_name,
                            ':admin_email'     => $admin_email,
                            ':admin_password'  => $hash_password,
                            ':admin_status'    => 'Chưa phê duyệt',
                            ':date'            => $date]);
            $_SESSION['success'] = 'Đã thêm quản trị viên mới';
            header('Location: admins.php');
            return;
        }
    }
    
?>

<br><br>
<div class="container" >
    <h2 class="p-2 pb-4">Thêm quản trị viên</h2>
    
    <?php
        include '../includes/flash_msg.php';
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group p-2">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="" name="username">
        </div>
        <div class="form-group p-2">
            <label for="lastname">Họ và tên</label>
            <input type="text" class="form-control" id="" name="admin_name">
        </div>
        <div class="form-group p-2">
            <label for="email">Email </label>
            <input type="email" class="form-control" id="" name="admin_email">
        </div>
        <div class="form-group p-2">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="admin_password">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Tạo quản trị viên" name="create_admin" class="btn btn-primary">

            <a href="admins.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>