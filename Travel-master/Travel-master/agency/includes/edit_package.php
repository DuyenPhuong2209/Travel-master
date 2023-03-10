<?php
    if(isset($_SESSION['agency_id'])){
        $agency_id = $_SESSION['agency_id'];
        if(isset($_GET['edit'])){
            $package_id = $_GET['edit'];

            $package = readPackage($package_id);

            $package_status = $package['package_status'];
            $package_date   = $package['package_date'];

            
            if(isset($_POST['update_package'])){
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
                $upload             = $_FILES['place_images']['name'];

                //uploading multiple image to folder
                $place_images = '';
                if(!empty(array_filter($upload))){
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
                }else {
                    $stmt = $pdo->prepare('SELECT place_images FROM packages WHERE package_id = :package_id');
                    $stmt->execute([':package_id' => $package_id]);
                    $place_images = $stmt->fetchColumn();
                }

                //Empty Field Validation
                if($package_name == '' || $location == ''  || $budget_price == '' || $booking_percentage == ''){
                    $_SESSION['error'] = 'H??y ??i???n v??o m???u';
                    header('Location: packages.php?page=edit_package&edit='. $package_id);
                    return;
                }else{
                    $stmt = $pdo->prepare('UPDATE packages SET agency_id = :agency_id, package_name = :package_name, location = :location, place_details = :place_details, place_images = :place_images, num_days = :num_days, 
                    num_nights = :num_nights, budget_price = :budget_price, comfort_price = :comfort_price, lux_price = :lux_price, budget_details = :budget_details, comfort_details = :comfort_details, lux_details = :lux_details,
                     booking_percentage = :booking_percentage, min_people = :min_people, includes = :includes, excludes = :excludes, optional = :optional, itinerary = :itinerary, package_status = :package_status, package_date = :package_date WHERE package_id = :package_id');

                    $stmt->execute([':package_id'           => $package_id,
                                    ':agency_id'            => $agency_id,
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
                                    ':package_status'       => 'C?? s???n',
                                    ':package_date'         => $package_date]);
                    $_SESSION['success'] = 'Th??ng tin tour ???????c c???p nh???t';
                    header('Location: packages.php');
                    return;
                }
            }
        }
    }
?>

<head>
    <script src="js/app.js"></script>
</head>
<br>
<div class="container">
    <h2 class="p-2 pb-5">Ch???nh s???a tour</h2>
    
    <?php
        include '../includes/flash_msg.php';
    ?>

    <form action="" method="post" enctype="multipart/form-data" class="col-md-8">
        <div class="form-group pb-2">
            <label for="package_name">T??n tour</label>
            <input type="text" class="form-control" value="<?php echo $package['package_name']; ?>" id="" name="package_name">
        </div>
        <div class="form-group p-2">
            <label for="location">?????a ch???</label>
            <input type="text" class="form-control" value="<?php echo $package['location']; ?>"  id="" name="location">
        </div>
        <div class="form-group p-2">
            <label for="place_details">Chi ti???t ?????a ??i???m</label>
            <textarea name="place_details" class="form-control" id="body" cols="30" rows="5"><?php echo $package['place_details']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <label for="">?????t h??nh ???nh</label><br>
        <?php
            //getting multiple image from database..
            $stmt = $pdo->prepare('SELECT place_images FROM packages WHERE package_id = :package_id');
            $stmt->execute([':package_id' => $package['package_id']]);
            $img = $stmt->fetchColumn();
            //convert string to array
            $img = explode(',', $img);
            // print_r($img);
            $img_count = count($img);
            //replace the special character to space
            $search = ["(", "'", ")" ];
            for($i=0; $i<$img_count; $i++){
                $place_img = str_replace($search, '', $img[$i]);
                echo '<img src="../images/packages/'. $place_img .'" width="150" height="120" class="mr-2" alt="'. $package['location'] .'">';
        }
        ?>
            <br><br>
            <input type="file" name="place_images[]" multiple >
        </div>
        <div class="form-group p-2">
            <label for="num_days">S??? ng??y</label>
            <input type="number" class="form-control" value="<?php echo $package['num_days']; ?>" id="" name="num_days">
        </div>
        <div class="form-group p-2">
            <label for="num_nights">S??? ????m</label>
            <input type="number" class="form-control" value="<?php echo $package['num_nights']; ?>" id="" name="num_nights">
        </div>
        <div class="form-group p-2">
            <label for="package_details">Phong c??ch du l???ch</label>
            <input type="text" class="form-control" value="<?php echo $package['budget_details']; ?>" id="" name="budget_details" placeholder="Ti???t ki???m"><br>
            <input type="text" class="form-control" value="<?php echo $package['comfort_details']; ?>" id="" name="comfort_details" placeholder="Ti???n nghi"><br>
            <input type="text" class="form-control" value="<?php echo $package['lux_details']; ?>" id="" name="lux_details" placeholder="Sang tr???ng">
        </div>
        <div class="form-group p-2">
            <label for="package_price">Gi??/m???i ng?????i</label>
            <input type="number" class="form-control" value="<?php echo $package['budget_price']; ?>" id="" name="budget_price" placeholder="Ti???t ki???m"><br>
            <input type="number" class="form-control" value="<?php echo $package['comfort_price']; ?>" id="" name="comfort_price" placeholder="Ti???n nghi"><br>
            <input type="number" class="form-control" value="<?php echo $package['lux_price']; ?>" id="" name="lux_price" placeholder="Sang tr???ng">
        </div>
        <div class="form-group p-2">
            <label for="booking_percentage">Ph???n tr??m ?????t tour</label>
            <input type="number" class="form-control" value="<?php echo $package['booking_percentage']; ?>" id="" name="booking_percentage">
        </div>
        <div class="form-group p-2">
            <label for="min_people">S??? ng?????i t???i thi???u c???n thi???t ????? b???t ?????u</label>
            <input type="number" class="form-control" value="<?php echo $package['min_people']; ?>"  id="" name="min_people">
        </div>
        <div class="form-group p-2">
            <label for="includes">Bao g???m</label>
            <textarea name="includes" class="form-control" id="body" cols="30" rows="5"><?php echo $package['includes']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <label for="excludes">Ngo???i tr???</label>
            <textarea name="excludes" class="form-control" id="body" cols="30" rows="5"><?php echo $package['excludes']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <label for="counsel">L???i khuy??n</label>
            <textarea name="counsel" class="form-control" id="body" cols="30" rows="5"><?php echo $package['counsel']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <label for="itinerary">H??nh tr??nh</label>
            <textarea name="itinerary" class="form-control" id="body" cols="30" rows="10"><?php echo $package['itinerary']; ?></textarea>
        </div>
        <div class="form-group p-2">
            <input type="submit" value="C???p nh???t tour" name="update_package" class="btn btn-primary">
            <a href="packages.php" type="button" class="btn btn-secondary float-right">Tho??t</a>
        </div>
    </form>
</div>