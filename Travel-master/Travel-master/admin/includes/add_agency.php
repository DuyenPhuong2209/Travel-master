<?php

    //Agency Insert Query....Added by Admin
    if(isset($_POST['create_agency'])){
        $agency_name     = htmlentities($_POST['agency_name']);
        $owner_name      = htmlentities($_POST['owner_name']);
        $agency_email    = htmlentities($_POST['agency_email']);
        $agency_contact  = htmlentities($_POST['agency_contact']);
        $agency_address  = htmlentities($_POST['agency_address']);
        $date            = date("y.m.d");

        $agency_password = htmlentities($_POST['agency_password']);

         //Empty Field Validation
        if($agency_name == '' ||  $owner_name == '' || $agency_email == '' || $agency_password == '' || $agency_contact == '' || $agency_address == ''){
            $_SESSION['error'] = 'Tất cả các chỗ trống được yêu cầu';
            header('Location: agencies.php?page=add_agency');
            return;
        }

        //contact no validation
        $pattern = '/^(0|84)+([0-9]{9})$/';
        $contact = '';
        if(!preg_match($pattern, $agency_contact)){
            $_SESSION['error'] = ' Thông tin liên hệ không hợp lệ';
            header("Location: agencies.php?page=add_agency");
            return;
        }else{
            $contact = $agency_contact;
        }

        //Agency Name Validation
        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_name = :agency_name');
        $stmt->execute([':agency_name' => $agency_name]);
        $agency_names = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $agency_names[] = $row;
        }
        if(!empty($agency_names)){
            $_SESSION['error'] = 'Tên đại lý đã tồn tại. Vui lòng thử cái khác';
            header('Location: agencies.php?page=add_agency');
            return;
        }

        //Agency Email Validation
        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_email = :agency_email');
        $stmt->execute([':agency_email' => $agency_email]);
        $agency_emails = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $agency_emails[] = $row;
        }
        if(!empty($agency_emails)){
            $_SESSION['error'] = 'Địa chỉ email đã tồn tại. Vui lòng thử cái khác';
            header('Location: agencies.php?page=add_agency');
            return;
        }
        else{
            $stmt = $pdo->prepare('INSERT INTO agencies(agency_name, owner_name, agency_email, agency_password, logo_image, cover_image, agency_contact, agency_address, agency_status, date)
             VALUES(:agency_name, :owner_name, :agency_email, :agency_password, :logo_image, :cover_image, :agency_contact, :agency_address, :agency_status, :date)');

            $stmt->execute([':agency_name'      => $agency_name,
                            ':owner_name'       => $owner_name,
                            ':agency_email'     => $agency_email,
                            ':agency_password'  => $agency_password,
                            ':logo_image'       => '',
                            ':cover_image'      => '',
                            ':agency_contact'   => $contact,
                            ':agency_address'   => $agency_address,
                            ':agency_status'    => 'Chưa phê duyệt',
                            ':date'             => $date]);

            $_SESSION['success'] = 'Đại lý mới được thêm vào';
            header('Location: agencies.php');
            return;
        }
    }
?>

<br>
<div class="container">
    <h2 class="p-2 pb-4">Thêm đại lý</h2>

    <?php
        include '../includes/flash_msg.php';
    ?>
    
    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="agency_name">Tên đại lý</label>
            <input type="text" class="form-control" id="" name="agency_name">
        </div>
        <div class="form-group p-2">
            <label for="owner_name"> Tên chủ sở hữu</label>
            <input type="text" class="form-control" id="" name="owner_name">
        </div>
        <div class="form-group p-2">
            <label for="agency_email">Email</label>
            <input type="email" class="form-control" id="" name="agency_email">
        </div>
        <div class="form-group p-2">
            <label for="agency_password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="agency_password">
        </div>
        <div class="form-group p-2">
            <label for="agency_contact">Số điện thoại</label>
            <input type="text" class="form-control" id="" name="agency_contact">
        </div>
        <div class="form-group p-2">
            <label for="agency_address">Địa chỉ văn phòng</label>
            <input type="text" class="form-control" id="" name="agency_address">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Thêm đại lý" name="create_agency" class="btn btn-primary">

            <a href="agencies.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>