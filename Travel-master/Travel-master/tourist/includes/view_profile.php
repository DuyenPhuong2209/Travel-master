<?php
    if(isset($_SESSION['tourist_id'])){
        $tourist_id = $_SESSION['tourist_id'];

        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
        $stmt->execute([':tourist_id' => $tourist_id]);
        $tourist = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<div class="my-5">
    <?php
        $profile_img = '';
        if(!empty($tourist['profile_image'])){
            $profile_img = $tourist['profile_image'];
        }else{
            $profile_img = 'default_user.png';
        }
    ?>
    <img src="images/<?php echo $profile_img; ?>" width="200" class="rounded float-right" alt="<?php echo $tourist['tourist_username']; ?>">
</div>
<div class="lead py-5 col-sm-8">

<?php
    include 'includes/flash_msg.php';
?>

    <div class="font-italic">
        <div class="p-2">
            <span class="font-weight-bold mr-3">Username:</span><?php echo $tourist['tourist_username']; ?>
        </div>
        <hr>
        <div class="p-2">
            <span class="font-weight-bold mr-3">Họ và tên:</span><?php echo $tourist['tourist_name']; ?>
        </div>
        <hr>
        <div class="p-2">
            <span class="font-weight-bold mr-3">Email:</span><?php echo $tourist['tourist_email']; ?>
        </div>
        <hr>
        <div class="p-2">
            <span class="font-weight-bold mr-3">Số điện thoại:</span><?php echo $tourist['tourist_contact']; ?>
        </div>
        <hr>
        <div class="p-2">
            <span class="font-weight-bold mr-3">Địa chỉ:</span><?php echo $tourist['tourist_address']; ?>
        </div>
        <hr>
        <div class="p-2">
            <a href="profile.php?page=edit_profile&edit=<?php echo $tourist['tourist_id']; ?>" class="btn btn-primary">Chỉnh sửa hồ sơ</a>
        </div>
    </div>
</div>