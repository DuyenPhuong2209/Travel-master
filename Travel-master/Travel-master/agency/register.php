<?php
    include '../includes/db.php';
    include 'layouts/agency_header.php';

    //Agency Insert Query... Agency Registration
    if(isset($_POST['agency_register'])){
        $agency_name     = htmlentities($_POST['agency_name']);
        $owner_name      = htmlentities($_POST['owner_name']);
        $agency_email    = htmlentities($_POST['agency_email']);
        $agency_contact  = htmlentities($_POST['agency_contact']);
        $agency_address  = htmlentities($_POST['agency_address']);
        $date            = date("y.m.d");

        $agency_password = htmlentities($_POST['agency_password']);

        //Empty Field Validation
        if($agency_name == '' ||  $owner_name == '' || $agency_email == '' || $agency_password == '' || $agency_contact == '' || $agency_address == ''){
            $_SESSION['error'] = ' Điền tất cả được yêu cầu';
            header('Location: register.php');
            return;
        }

        //contact no validation
        $pattern = '/^(0|84)+([0-9]{9})$/';
        $contact = '';
        if(!preg_match($pattern, $agency_contact)){
            $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
            header("Location: register.php");
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
            header('Location: register.php');
            return;
        }

        //Agency email Validation
        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_email = :agency_email');
        $stmt->execute([':agency_email' => $agency_email]);
        $agency_emails = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $agency_emails[] = $row;
        }
        if(!empty($agency_emails)){
            $_SESSION['error'] = 'Địa chỉ email đã tồn tại. Vui lòng thử cái khác';
            header('Location: register.php');
            return;
        }
        else{
            $hash_password = password_hash($agency_password, PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare('INSERT INTO `agencies`(`agency_name`, `owner_name`, `agency_email`, `agency_password`, `logo_image`, `cover_image`, `agency_contact`, `agency_address`, `agency_status`, date) 
            VALUES(:agency_name, :owner_name, :agency_email, :agency_password, :logo_image, :cover_image, :agency_contact, :agency_address, :agency_status, :date)');

            $stmt->execute(array(
                            ':agency_name'      => $agency_name,
                            ':owner_name'       => $owner_name,
                            ':agency_email'     => $agency_email,
                            ':agency_password'  => $hash_password,
                            ':logo_image'       => '',
                            ':cover_image'      => '',
                            ':agency_contact'   => $contact,
                            ':agency_address'   => $agency_address,
                            ':agency_status'    => 'Chưa phê duyệt',
                            ':date'             => $date
            ));

            $_SESSION['success'] = 'Đăng ký của bạn đã được gửi tới Quản trị viên';
            header('Location: register.php');
            return;
        }
    }

?>

<br><br>
<div class="container">
    <h2 class="text-secondary text-center p-2 pb-4">Đăng ký đại lý</h2><br>
    <form action="" method="post" class="mx-auto col-md-8">
        <?php
            include '../includes/flash_msg.php';
        ?>
        <div class="form-group p-2">
            <label for="agency_name">Tên đại lý</label>
            <input type="text" class="form-control" id="" name="agency_name">
        </div>
        <div class="form-group p-2">
            <label for="owner_name">Tên chủ sở hữu</label>
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
            <input type="submit" value="Đăng kí" name="agency_register" class="btn btn-primary">

            <a href="../index.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>
<br>

<?php
    include 'layouts/agency_footer.php';
?>