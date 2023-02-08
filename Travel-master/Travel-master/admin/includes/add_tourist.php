<div class="container">
    <h2 class="p-2 pb-5">Thêm khách hàng</h2>
    <?php
    include '../includes/flash_msg.php';
    ?>
    <form action="" method="post" class="col-md-8">
        <div class="form-group p-2">
            <label for="tourist_username">Username</label>
            <input type="text" class="form-control" id="" name="tourist_username" required>
        </div>
        <div class="form-group p-2">
            <label for="tourist_name">Họ và tên</label>
            <input type="text" class="form-control" id="" name="tourist_name" required>
        </div>
        <div class="form-group p-2">
            <label for="tourist_email">Email</label>
            <input type="email" class="form-control" id="" name="tourist_email" required>
        </div>
        <div class="form-group p-2">
            <label for="tourist_password">Mật khẩu</label>
            <input type="password" class="form-control" id="" name="tourist_password" required>
        </div>
        <div class="form-group p-2">
            <label for="tourist_contact">Số điện thoại</label>
            <input type="text" class="form-control" id="" name="tourist_contact" required>
        </div>
        <div class="form-group p-2">
            <label for="tourist_address">Địa chỉ</label>
            <input type="text" class="form-control" id="" name="tourist_address" required>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Thêm" name="create_tourist" class="btn btn-primary">

            <a href="tourists.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>

    </form>
</div>
<?php
//Tourist Insert Query...Added by Admin
if (isset($_POST['create_tourist'])) {
    $username   = htmlentities($_POST['tourist_username']);
    $name       = htmlentities($_POST['tourist_name']);
    $email      = htmlentities($_POST['tourist_email']);
    $password   = htmlentities($_POST['tourist_password']);
    $contact    = htmlentities($_POST['tourist_contact']);
    $address    = htmlentities($_POST['tourist_address']);
    $date       = date("y.m.d");
    // date("y.m.d")

    //contact no validation
    $tourist_contact = '';
    if (!empty($contact)) {
        $pattern = '/^(0|84)+([0-9]{9})$/';
        if (!preg_match($pattern, $contact)) {
            $_SESSION['error'] = 'Thông tin liên hệ không hợp lệ';
            header("Location: tourists.php?page=add_tourist");
            return;
        } else {
            $contact = $contact;
        }
    }

    //Username Validation
    $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_username = :tourist_username');
    $stmt->execute([':tourist_username' => $username]);
    $tourist_usernames = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tourist_usernames[] = $row;
    }
    if (!empty($tourist_usernames)) {
        $_SESSION['error'] = 'Tên người dùng đã tồn tại. Vui lòng thử cái khác';
        header('Location: tourists.php?page=add_tourist');
    } else {
        $stmt = $pdo->prepare('INSERT INTO tourists( `tourist_username`, `tourist_name`, `tourist_email`, `tourist_password`, `profile_image`, `tourist_contact`, `tourist_address`, `tourist_status`, `date`) 
      VALUES( :tourist_username, :tourist_name, :tourist_email, :tourist_password, :profile_image, :tourist_contact, :tourist_address, :tourist_status, :date)');

        $stmt->execute([
            ':tourist_username'    => $username,
            ':tourist_name'        => $name,
            ':tourist_email'       => $email,
            ':tourist_password'    => $password,
            ':profile_image'       => '',
            ':tourist_contact'     => $contact,
            ':tourist_address'     => $address,
            ':tourist_status'      => 'Chưa phê duyệt',
            ':date'                => $date
        ]);

        $_SESSION['success'] = 'Khách hàng mới được thêm vào';
        header('Location: tourists.php');
        return;
    }
}


?>