<?php

    if(isset($_GET['edit'])){
        $tourist_id = $_GET['edit'];

        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
        $stmt->execute([':tourist_id' => $tourist_id]);
        $tourist_status = '';
        $tourist_date = '';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $tourist_status = $row['tourist_status'];
            $tourist_date = $row['date'];
        }

        if(isset($_POST['update_tourist'])){
            $username   = htmlentities($_POST['tourist_username']);
            $name       = htmlentities($_POST['tourist_name']);
            $email      = htmlentities($_POST['tourist_email']);
            $contact    = htmlentities($_POST['tourist_contact']);
            $address    = htmlentities($_POST['tourist_address']);

            $password   = htmlentities($_POST['tourist_password']);

            $tourist_stripe = $stripe->customers->update(
                $tourist_stripe_id,
                ['name'  => $firstname." ".$lastname,
                'email'  => $email]
            );
            
             //uploading image in images folder
            $profile_img = $_FILES['profile_image']['name'];
            $profile_img_temp = $_FILES['profile_image']['tmp_name'];
            move_uploaded_file($profile_img_temp, "../images/$profile_img");
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
                    header("Location: tourists.php?page=edit_tourist&edit=". $tourist_id);
                    return;
                }else{
                    $tourist_contact = $contact;
                }
            }

            //Empty Field Validation
            if($username == '' ||$name == '' || $email == '' || $password == ''|| $contact == ''){
                $_SESSION['error'] = 'Hãy điền vào mẫu';
                header('Location: tourists.php?page=edit_tourist&edit='. $tourist_id);
                return;
            }else{
                $stmt = $pdo->prepare('UPDATE tourists SET  tourist_username = :tourist_username, tourist_name = :tourist_name, tourist_email = :tourist_email, tourist_password = :tourist_password, profile_image = :profile_image,  
                tourist_contact = :tourist_contact, tourist_address = :tourist_address, tourist_status = :tourist_status, date = :date WHERE tourist_id = :tourist_id');

                $stmt->execute([
                                ':tourist_id'           => $tourist_id,
                                ':tourist_username'     => $username,
                                ':tourist_name'         => $name,
                                ':tourist_email'        => $email,
                                ':tourist_password'     => $password,
                                ':profile_image'        => $profile_img,
                                ':tourist_contact'      => $user_contact,
                                ':tourist_address'      => $address,
                                ':tourist_status'       => $tourist_status,
                                ':date'                 => $date]);

                $_SESSION['success'] = 'Cập nhật thông tin khách hàng';
                header('Location: tourists.php');
                return;
            }

        }
    }
?>

<br><br>
<div class="container" >
    <h2 class="p-2 pb-5">Cập nhật khách hàng</h2>
    
    <?php
        include '../includes/flash_msg.php';

        //Tourist Read Query for specific id
        if(isset($_GET['edit'])){
            $tourist_id = $_GET['edit'];

            $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
            $stmt->execute([':tourist_id' => $tourist_id]);
            $tourist = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group pb-2">
            <label for="tourist_username">Username</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_username']; ?>" id="" name="tourist_username">
        </div>
        <div class="form-group p-2">
            <label for="tourist_name">Họ và tên</label>
            <input type="text" class="form-control" id="" value="<?php echo $tourist['tourist_name']; ?>" name="tourist_name">
        </div>
        <div class="form-group p-2">
            <label for="tourist_email">Email</label>
            <input type="email" class="form-control" value="<?php echo $tourist['tourist_email']; ?>" id="" name="tourist_email">
        </div>
        <div class="form-group p-2">
            <label for="tourist_password">Mật khẩu</label>
            <input type="password" class="form-control" value="" id="" name="tourist_password">
        </div>
        <div class="form-group p-2">
            <label for="profile_image">Ảnh đại diện</label><br>
            <img src="../images/<?php echo $tourist['profile_image']; ?>" width="150" height='120' alt="<?php echo $tourist['tourist_username']; ?>" ><br><br>
            <input type="file" id="" name="profile_image">
        </div>
        <div class="form-group p-2">
            <label for="tourist_contact">Số điện thoại</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_contact']; ?>" id="" name="user_contact">
        </div>
        <div class="form-group p-2">
            <label for="user_address">Địa chỉ</label>
            <input type="text" class="form-control" value="<?php echo $tourist['tourist_address']; ?>" id="" name="tourist_address">
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Cập nhật" name="update_tourist" class="btn btn-primary">

            <a href="tourists.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>