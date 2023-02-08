<?php
    include '../includes/db.php';
    include '../layouts/header.php';
    //Tourist Insert Query.... Tourist Registration

    
    if(isset($_POST['tourist_register'])){
        $username   = htmlentities($_POST['tourist_username']);
        $name       = htmlentities($_POST['tourist_name']);
        $email      = htmlentities($_POST['tourist_email']);
        $contact    = htmlentities($_POST['tourist_contact']);
        $address    = htmlentities($_POST['tourist_address']);
        $date       = date("y.m.d");
        $password   = htmlentities($_POST['tourist_password']);

         //uploading image in images folder
        $profile_img = $_FILES['profile_image']['name'];
        $profile_img_temp = $_FILES['profile_image']['tmp_name'];
        move_uploaded_file($profile_img_temp, "../images/$profile_img");

        //Empty Field Validation
        if($username == '' || $name == '' || $email == '' || $password == '' || $contact == ''){
            $_SESSION['error'] = 'Hãy điền vào mẫu';
            // header('Location: registration.php');
            // return;
                
        }else{ //Username Validation
        $pattern = '/^(0|84)+([0-9]{9})$/';
                if(!preg_match($pattern, $contact)){
                    $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
                    header("Location: registration.php");
                    return;
                }else{
                    $tourist_contact = $contact;
                }
        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_username = :tourist_username');
        $stmt->execute([':tourist_username' => $username]);
        $tourist_usernames = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $tourist_usernames[] = $row;
        }
        if(!empty($tourist_usernames)){
            $_SESSION['error'] = 'Tên người dùng đã tồn tại. Vui lòng thử cái khác';
            header('Location: registration.php');
            return;
        }

        //Email Validation
        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_email = :tourist_email');
        $stmt->execute([':tourist_email' => $email]);
        $tourist_emails = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $tourist_emails[] = $row;
        }
        if(!empty($tourist_emails)){
            $_SESSION['error'] = 'Địa chỉ email đã tồn tại. Vui lòng thử cái khác';
            header('Location: registration.php');
            return;
        }
        else{
            $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare('INSERT INTO `tourists`(`tourist_username`, `tourist_name`, `tourist_email`, `tourist_password`, `profile_image`, `tourist_contact`, `tourist_address`, `tourist_status`, `date`) VALUES(:tourist_username, :tourist_name, :tourist_email, :tourist_password, :profile_image, :tourist_contact, :tourist_address, :tourist_status, :tourist_date)');

            $stmt->execute(array(
                            ':tourist_username'    => $username,
                            ':tourist_name'        => $name,
                            ':tourist_email'       => $email,
                            ':tourist_password'    => $hash_password,
                            ':profile_image'       => $profile_img,
                            ':tourist_contact'     => $tourist_contact,
                            ':tourist_address'     => $address,
                            ':tourist_status'      => 'approved',
                            ':tourist_date'        => $date
            ));
          
            header('Location: ../includes/login.php');
            return;
        }

        // //contact no validation
        // $tourist_contact = '';
        // if(!empty($contact)){
        //     $pattern = '/^(0|84)+([0-9]{9})$/';
        //     if(!preg_match($pattern, $contact)){
        //         $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
        //         header("Location: registration.php");
        //         return;
        //     }else{
        //         $tourist_contact = $contact;
        //     }
        // }else{
        //     $_SESSION['error'] = 'Error';
        // }

       
    }
}

?>

<br><br><br>
<div class="container mb-5">
    <h2 class="text-secondary text-center p-2 pb-4">Đăng kí khách hàng</h2><br>
    <form action="" method="post" enctype="multipart/form-data" class="col-md-8 mx-auto mb-5">
    
    <?php
        include '../includes/flash_msg.php';
    ?>
        
        <div class="form-group p-2">
            <label for="tourist_username">Username</label>
            <input type="text" class="form-control" id="" name="tourist_username">
        </div>
        <div class="form-group p-2">
            <label for="tourist_name">Họ và tên</label>
            <input type="text" class="form-control" id="" name="tourist_name">
        </div>
        <div class="form-group p-2">
            <label for="tourist_email">Email</label>
            <input type="email" class="form-control" id="" name="tourist_email">
        </div>
        <div class="form-group p-2">
            <label for="tourist_password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="tourist_password">
        </div>
        <div class="form-group p-2">
            <label for="profile_image">Ảnh đại diện</label><br>
            <input type="file" id="" name="profile_image">
        </div>
        <div class="form-group p-2">
            <label for="tourist_contact">Số điện thoại</label>
            <input type="text" class="form-control" id="" name="tourist_contact">
        </div>
        <div class="form-group p-2">
            <label for="tourist_address">Địa chỉ</label>
            <input type="text" class="form-control" id="" name="tourist_address">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Đăng kí" name="tourist_register" class="btn btn-primary">

            <a href="../index.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>

<?php
    include '../layouts/footer.php';
?>