<?php
    include '../includes/db.php';
    include 'layouts/admin_header.php';

    if(isset($_POST['admin_login'])){
        $email      = htmlentities($_POST['admin_email']);
        $password   = htmlentities($_POST['admin_password']);

        if($email == '' || $password == ''){
            $_SESSION['error'] = 'All Fields are Required';
            header('Location: index.php');
            return;
        }

        $stmt = $pdo->prepare('SELECT * FROM admins WHERE admin_email = :admin_email');
        $stmt->execute([':admin_email'    => $email ]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if($email !== $admin['admin_email'] ){
            //when email & password doesnot match with database
            $_SESSION['error'] = 'Info is Wrong';
            header('Location: index.php');
            return;
        }elseif($email === $admin['admin_email'] ){
            if(password_verify($password, $admin['admin_password'])){
                $_SESSION['admin_id']         = $admin['admin_id'];
                $_SESSION['username']         = $admin['username'];
                $_SESSION['admin_email']      = $admin['admin_email'];
                $_SESSION['admin_status']     = $admin['admin_status'];
                
                
                if($_SESSION['admin_status'] == 'unapproved'){
                    $_SESSION['error'] = 'Bạn cần sự chấp thuận của quản trị viên';
                    header('Location: index.php');
                    return;
                    
                }else{
                    $_SESSION['admin_login'] = 'admin';
                    //when admin is in approved state
                    header('Location: dashboard.php');
                    return;
                }
            }else{
                $_SESSION['error'] = 'Sai mật khẩu';
                header('Location: index.php');
                return;
            }
        }
    }
?>

<div class="container-fluid">
    <div class="card mx-auto col-sm-6" style="border: none;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="p-5 font-italic text-center font-weight-bold" style="font-size: 3rem;">Đăng nhập</h2>
                    <h5 class="p-2 font-italic text-center"> 
                    Quay trở lại <span class="font-weight-bold"><a href="../index.php">Trang web người dùng</a></span>
                    </h5>
                </div>
            </div>
        </div>

        <?php
            include '../includes/flash_msg.php';
        ?>

        <form action="" method="post" class="col-md-12 pt-5">
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="" name="admin_email">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="" name="admin_password">
            </div>
            <div class="form-group">
                <input type="submit" value="Đăng nhập" name="admin_login" class="btn btn-primary">

                <a href="../index.php" type="button" class="btn btn-secondary float-right">Thoát</a>
            </div>
        </form>
    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>