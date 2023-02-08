<?php

    if(isset($_SESSION['tourist_id'])){
        if(isset($_GET['edit'])){
            $tourist_id = $_GET['edit'];

            $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
            $stmt->execute([':tourist_id' => $tourist_id]);
            $tourist = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $username           = $tourist['tourist_username'];
            $tourist_email      = $tourist['tourist_email'];
            $tourist_status     = $tourist['tourist_status'];
            $tourist_date       = $tourist['date'];

            if(isset($_POST['update_profile'])){
                $name       = htmlentities($_POST['tourist_name']);
                $contact    = htmlentities($_POST['tourist_contact']);
                $address    = htmlentities($_POST['tourist_address']);
                $password   = htmlentities($_POST['tourist_password']);

              

                //uploading image in images folder
                $profile_img = $_FILES['profile_image']['name'];
                $profile_img_temp = $_FILES['profile_image']['tmp_name'];
                move_uploaded_file($profile_img_temp, "images/$profile_img");
                if(empty($profile_img)){
                    $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
                    $stmt->execute(array(':tourist_id' => $tourist_id));
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $profile_img = $row['profile_image'];
                    }
                }

                //contact no validation
                $tourist_contact = '';
                if(!empty($contact)){
                    $pattern = '/^(0|84)+([0-9]{9})$/';
                    if(!preg_match($pattern, $contact)){
                        $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
                        header("Location: profile.php?page=edit_profile&edit=". $tourist_id);
                        return;
                    }else{
                        $tourist_contact = $contact;
                    }
                }

                //Empty Field Validation
                if( $name == '' || $password == ''){
                    $_SESSION['error'] = 'Hãy điền vào mẫu';
                    header('Location: profile.php?page=edit_profile&edit='. $tourist_id);
                    return;
                }else{
                    $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                    $stmt = $pdo->prepare('UPDATE tourists SET tourist_username = :tourist_username, tourist_name = :tourist_name, 
                    tourist_email = :tourist_email, tourist_password = :tourist_password, profile_image = :profile_image, 
                     tourist_contact = :tourist_contact, tourist_address = :tourist_address, tourist_status = :tourist_status, 
                     date = :date WHERE tourist_id = :tourist_id');

                    $stmt->execute([':tourist_id'          => $tourist_id,
                                    ':tourist_username'    => $username,
                                    ':tourist_name'        => $name,
                                    ':tourist_email'       => $tourist_email,
                                    ':tourist_password'    => $hash_password,
                                    ':profile_image'       => $profile_img,
                                    ':tourist_contact'     => $tourist_contact,
                                    ':tourist_address'     => $address,
                                    ':tourist_status'      => $tourist_status,
                                    ':date'                => $tourist_date]);

                    $_SESSION['success'] = 'Thông tin của bạn đã được cập nhật';
                    header('Location: profile.php');
                    return;
                }
            }
        }
            
    }
?>

<div class="container-fluid">

    <?php
        include 'includes/flash_msg.php';
    ?>
    <!-- <h2 class="p-2 pb-5">Update Info</h2> -->
    <form action="" method="post" enctype="multipart/form-data" class="col-md-8 pt-5">
        <!-- <div class="form-group pb-2 pl-2">
            <label for="user_name">Username</label>
            <input type="text" class="form-control" value="Last Minute Vacation" id="" name="user_name">
        </div> -->
        <div class="form-group p-2">
            <label for="tourist_name">Họ và tên</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_name']; ?>" id="" name="tourist_name">
        </div>
        <!-- <div class="form-group p-2">
            <label for="user_email">Email</label>
            <input type="email" class="form-control" value="" id="" name="user_email">
        </div> -->
        <div class="form-group p-2">
            <label for="tourist_password">Mật khẩu</label>
            <input type="password" class="form-control" value="" id="" name="tourist_password">
        </div>
        <div class="form-group p-2">
            <label for="profile_image">Ảnh đại diện</label><br>
            <img src="images/<?php echo $tourist['profile_image']; ?>" width="150" height='120' alt="<?php echo $tourist['tourist_username']; ?>" ><br><br>
            <input type="file" id="" name="profile_image">
        </div>
        <div class="form-group p-2">
            <label for="tourist_contact">Số điện thoại</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_contact']; ?>" id="" name="tourist_contact">
        </div>
        <div class="form-group p-2">
            <label for="tourist_address">Địa chỉ</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_address']; ?>" id="" name="tourist_address">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Cập nhật" name="update_profile" class="btn btn-primary">

            <a href="profile.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>