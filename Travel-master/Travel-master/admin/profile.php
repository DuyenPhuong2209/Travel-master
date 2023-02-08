<?php
    include '../includes/db.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
        header('Location: index.php');
        return;
    }

    if(isset($_SESSION['admin_id'])){
        $admin_id = $_SESSION['admin_id'];

        $stmt = $pdo->prepare('SELECT * FROM admins WHERE admin_id = :admin_id');
        $stmt->execute([':admin_id' => $admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        $username       = $admin['username'];
        $admin_email    = $admin['admin_email'];
        $admin_status   = $admin['admin_status'];
        $admin_date     = $admin['date'];

        if(isset($_POST['update_profile'])){
            $admin_name         = htmlentities($_POST['admin_name']);
            $admin_password     = htmlentities($_POST['admin_password']);

            if($admin_name == '' || $admin_password == ''){
                $_SESSION['error'] = 'All Fields Are Required';
                header('Location: profile.php');
                return;
            }else{
                $hash_password = password_hash($admin_password, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare('UPDATE admins SET username = :username, admin_name = :admin_name, admin_email = :admin_email, admin_password = :admin_password, admin_status = :admin_status, date = :date WHERE admin_id = :admin_id');

                $stmt->execute([':admin_id'         => $admin_id,
                                ':username'         => $username,
                                ':admin_name'       => $admin_name,
                                ':admin_email'      => $admin_email,
                                ':admin_password'   => $hash_password,
                                ':admin_status'     => $admin_status,
                                ':date'             => $admin_date]);
                $_SESSION['success'] = 'Profile Updated';
                header('Location: profile.php');
                return;
            }

        }
    }
?>

<div id="layoutSidenav">
    <?php
        include 'layouts/admin_sidenav.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Welcome</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Hồ sơ</li>
                </ol>
                <?php
                    include '../includes/flash_msg.php';
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
                            <!-- <div class="form-group p-2">
                                <label for="username">username</label>
                                <input type="text" class="form-control" value="<?php echo $admin['username']; ?>" id="" name="username">
                            </div> -->
                        
                            <div class="form-group p-2">
                                <label for="admin_name">Họ và tên</label>
                                <input type="text" class="form-control" value="<?php echo $admin['admin_name']; ?>" id="" name="admin_name">
                            </div>
                            <div class="form-group p-2">
                                <label for="admin_password">Mật khẩu</label>
                                <input type="password" class="form-control" value="" id="" name="admin_password">
                            </div>
                            <div class="form-group p-2">
                                <input type="submit" value="Cập nhật" name="update_profile" class="btn btn-primary">

                                <a href="dashboard.php" type="button" class="btn btn-secondary float-right">Thoát</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
