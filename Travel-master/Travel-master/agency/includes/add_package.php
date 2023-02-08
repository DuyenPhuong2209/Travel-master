<?php
    //Package Insert Query
    if(isset($_SESSION['agency_id'])){
        if(isset($_POST['create_package'])){
            $agency_id          = $_SESSION['agency_id'];
            $package_name       = htmlentities($_POST['package_name']);
            $location           = htmlentities($_POST['location']);
            $place_details      = $_POST['place_details'];
            $num_days           = htmlentities($_POST['num_days']);
            $num_nights         = htmlentities($_POST['num_nights']);
            $budget_price       = htmlentities($_POST['budget_price']);
            $comfort_price      = htmlentities($_POST['comfort_price']);
            $lux_price          = htmlentities($_POST['lux_price']);
            $budget_details     = htmlentities($_POST['budget_details']);
            $comfort_details    = htmlentities($_POST['comfort_details']);
            $lux_details        = htmlentities($_POST['lux_details']);
            $booking_percentage = htmlentities($_POST['booking_percentage']);
            $min_people         = htmlentities($_POST['min_people']);
            $includes           = $_POST['includes'];
            $excludes           = $_POST['excludes'];
            $counsel            = $_POST['counsel'];
            $itinerary          = $_POST['itinerary'];
            $created_at         = date("y.m.d");

            //uploading multiple image to folder
            $place_images = '';
            if(!empty(array_filter($_FILES['place_images']['name']))){
                foreach($_FILES['place_images']['name'] as $key => $value){
                    $place_img = $_FILES['place_images']['name'][$key];
                    $place_img_temp = $_FILES['place_images']['tmp_name'][$key];
                    
                    if(move_uploaded_file($place_img_temp, "../images/packages/$place_img")){
                        $images[] = "('".$place_img."')";
                    }
                }
                if(!empty($images)){
                    $place_images = implode(",",$images);
                }
            }

            //Empty Field Validation
            if($package_name == '' || $location == '' || $budget_price == '' || $booking_percentage == ''){
                $_SESSION['error'] = 'Hãy điền vào mẫu';
                header('Location: packages.php?page=add_package');
                return;
            }else{
                $stmt = $pdo->prepare('INSERT INTO packages(agency_id, package_name, location,  place_details, place_images, num_days, num_nights, budget_price, comfort_price, lux_price, budget_details, comfort_details, lux_details, 
                booking_percentage, min_people, includes, excludes, counsel, itinerary, package_status, package_date) VALUES(:agency_id, :package_name, :location, :place_details, :place_images, :num_days, :num_nights,  :budget_price,
                 :comfort_price, :lux_price, :budget_details, :comfort_details, :lux_details, :booking_percentage, :min_people, :includes, :excludes, :counsel, :itinerary, :package_status, :package_date)');

                $stmt->execute([':agency_id'            => $agency_id,
                                ':package_name'         => $package_name,
                                ':location'             => $location,
                                ':place_details'        => $place_details,
                                ':place_images'         => $place_images,
                                ':num_days'             => $num_days,
                                ':num_nights'           => $num_nights,
                                ':budget_price'         => $budget_price,
                                ':comfort_price'        => $comfort_price,
                                ':lux_price'            => $lux_price,
                                ':budget_details'       => $budget_details,
                                ':comfort_details'      => $comfort_details,
                                ':lux_details'          => $lux_details,
                                ':booking_percentage'   => $booking_percentage,
                                ':min_people'           => $min_people,
                                ':includes'             => $includes,
                                ':excludes'             => $excludes,
                                ':counsel'              => $counsel,
                                ':itinerary'            => $itinerary,
                                ':package_status'       => 'Có sẵn',
                                ':package_date'         => $created_at]);
                $_SESSION['success'] = 'Tour mới được thêm vào';
                header('Location: packages.php');
                return;
            }
        }
    }
?>

<head>
    <script src="js/app.js"></script>
</head>
<br>
<div class="container">
    <h2 class="p-2 pb-5">Thêm tour</h2>

    <?php
        include '../includes/flash_msg.php';
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group p-2">
            <label for="package_name">Tên tour</label>
            <input type="text" class="form-control" id="" name="package_name">
        </div>
        <div class="form-group p-2">
            <label for="location">Địa chỉ</label>
            <input type="text" class="form-control" id="" name="location">
        </div>
        <div class="form-group p-2">
            <label for="place_details">Chi tiết địa điểm</label>
            <textarea name="place_details" class="form-control" id="body" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group p-2">
            <label for="">Đặt hình ảnh</label><br>
            <input type="file" name="place_images[]" multiple >
        </div>
        <div class="form-group p-2">
            <label for="num_days">Số ngày</label>
            <input type="number" class="form-control" id="" name="num_days">
        </div>
        <div class="form-group p-2">
            <label for="num_nights">Số đêm</label>
            <input type="number" class="form-control" id="" name="num_nights">
        </div>
        <div class="form-group p-2">
            <label for="package_details">Phong cách du lịch</label>
            <input type="text" class="form-control" id="" name="budget_details" placeholder="Tiết kiệm"><br>
            <input type="text" class="form-control" id="" name="comfort_details" placeholder="Tiện nghi"><br>
            <input type="text" class="form-control" id="" name="lux_details" placeholder="Sang trọng">
        </div>
        <div class="form-group p-2">
            <label for="package_price">Giá/mỗi người</label>
            <input type="number" class="form-control" id="" name="budget_price" placeholder="Tiết kiệm"><br>
            <input type="number" class="form-control" id="" name="comfort_price" placeholder="Tiện nghi"><br>
            <input type="number" class="form-control" id="" name="lux_price" placeholder="Sang trọng">
        </div>
        <div class="form-group p-2">
            <label for="booking_percentage">Phần trăm đặt tour</label>
            <input type="number" class="form-control" id="" name="booking_percentage">
        </div>
        <div class="form-group p-2">
            <label for="min_people">Số người tối thiểu cần thiết để bắt đầu</label>
            <input type="number" class="form-control" id="" name="min_people">
        </div>
        <div class="form-group p-2">
            <label for="includes">Bao gồm</label>
            <textarea name="includes" class="form-control" id="body" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group p-2">
            <label for="excludes">Ngoại trừ</label>
            <textarea name="excludes" class="form-control" id="body" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group p-2">
            <label for="counsel">Lời khuyên</label>
            <textarea name="counsel" class="form-control" id="body" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group p-2">
            <label for="itinerary">Hành trình</label>
            <textarea name="itinerary" class="form-control" id="body" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="Thêm tour" name="create_package" class="btn btn-primary">
            <a href="packages.php" type="button" class="btn btn-secondary float-right">Thoát</a>
        </div>
    </form>
</div>