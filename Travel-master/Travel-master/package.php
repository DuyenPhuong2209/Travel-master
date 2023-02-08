<?php
    include 'includes/db.php';
    include 'includes/functions.php';
    $page = 'packages';
    include 'layouts/header.php';
    include 'layouts/navbar.php';

    if(isset($_GET['package_id'])){
        $package_id = $_GET['package_id'];

        // $stmt = $pdo->prepare('SELECT * FROM packages WHERE package_id = :package_id');
        // $stmt->execute([':package_id'  => $package_id]);
        $package = readPackage($package_id);
    }
?>

<br><br>
<head>
    <link rel="stylesheet" href="css/package.css">
    <script src="js/script.js"></script>

    <style>
        .effect:hover {
            box-shadow: 4px 4px 15px 0px rgba(0, 0, 0, 0.44);
            -webkit-box-shadow: 4px 4px 15px 0px rgba(0, 0, 0, 0.44);
            -moz-box-shadow: 4px 4px 15px 0px rgba(0, 0, 0, 0.44);
            transition: box-shadow 0.2s ease-in-out;
        }
    </style>
</head>

<br>
<div class="jumbotron jumbotron-fluid package-details">
  <div class="container">
    <h1 class="display-4 font-weight-bold">Chi tiết Tour</h1>
    
  </div>
</div>

<div class="container">
    <div class="ml-auto p-2 mb-5">
        <h3 class="font-weight-bold pt-4"><?php echo $package['package_name']; ?></h3>
        <h5 class="font-italic text-info" style="font-size: 1rem;"><i class="fas fa-map-marker-alt"></i><?php echo $package['location']; ?>, </h5>
        <div class="lead mt-5" style="font-size: 1.2rem;">
            <div class="mb-2">

            <?php
                $agency_id = $package['agency_id'];

                $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_id = :agency_id');
                $stmt->execute([':agency_id' => $agency_id]);
                $agency = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
               Đại lý: <a href="agency.php?agency_id=<?php echo $package['agency_id']; ?>" class="mr-3"> <?php echo $agency['agency_name']; ?> </a>
            </div>
            <div style="font-size: 1rem;">
                <p><span class="mr-2"><i class="fas fa-envelope"></i></span> Email: <?php echo $agency['agency_email']; ?></p>
                <p><span class="mr-2"><i class="fas fa-phone-alt"></i></span> <?php echo $agency['agency_contact']; ?> </p>
            </div>
        </div>
    </div>

    <!-- subnav -->
    <ul class="nav nav-tabs">
        <li class="nav-item subnav">
            <a class="nav-link active tour-details" href="#">Chi tiết chuyến tham quan</a>
        </li>
        <li class="nav-item subnav">
            <a class="nav-link itinerary" href="#">Hành trình</a>
        </li>
        <li class="nav-item subnav">
            <a class="nav-link gallery" href="#">Thư viện ảnh</a>
        </li>
        <li class="nav-item subnav">
            <a class="nav-link review" href="#">Bình luận</a>
        </li>
    </ul>
</div>

<!-- tour details -->
<div class="lead container tour-details-content">
    <div class="mt-5 p-2">
        <h4 class="pb-2">Chi tiết địa điểm</h4>
        <p>
            <?php echo $package['place_details']; ?>
        </p>
    </div>
    <div class="alert alert-warning mt-5 text-dark" role="alert">
        <p><span class="mr-1"><i class="far fa-clock"></i></span>
            
        Khoảng thời gian:  <span class="mx-1" style="font-weight: 600;"><?php echo $package['num_days']; ?></span> ngày <span class="mx-1" style="font-weight: 600;"><?php echo $package['num_nights']; ?></span> đêm
        </p>
    </div>
    <div class="alert alert-secondary mt-5 text-dark" role="alert">
        <p><span class="mr-1"><i class="fas fa-users"></i></span>
            
        Tối thiểu  <span class="mx-1" style="font-weight: 600;"><?php echo $package['min_people']; ?></span> Những người được yêu cầu.

            <?php
                $package_id = $package['package_id'];
                $stmt = $pdo->prepare('SELECT * FROM bookings WHERE package_id = :package_id AND booking_status = :booking_status');
                $stmt->execute([':package_id'       => $package_id,
                                ':booking_status'   => 'Xác nhận']);

                $books = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $books[] = $row['persons'];
                }
                $size = sizeof($books);

                $book_person = 0;
                for($i=0; $i<$size; $i++){
                    $book_person += $books[$i];
                }
            ?>

            
        Đã được đặt bởi <span class="mx-1" style="font-weight: 600;"><?php echo $book_person; ?></span> người.
        </p>
    </div>
    
    <?php
        $stmt = $pdo->prepare('SELECT * FROM package_dates WHERE package_id = :package_id');
        $stmt->execute([':package_id'   => $package['package_id']]);
        $date = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="mt-5">
        <p>Giá từ:
            <h5> <?php echo number_format($package['budget_price'], 0 , $c = "," , $d = "." )."VND" ?><span class="ml-3">/ mỗi người</span></h5>
        </p>
        <?php
            if(!isset($_SESSION['tourist_email']) || (!empty($date) && $date['status'] == 'Kết thúc')){
                echo '<a href="booking.php?package_id='. $package['package_id'] .'" class="btn btn-primary mt-3 disabled">Đặt tour này</a>';
            }else{
                echo '<a href="booking.php?package_id='. $package['package_id'] .'" class="btn btn-primary mt-3"> Đặt tour này</a>';
            }
        ?>
    </div>

    <?php
        if(!empty($date)){
    ?>
    <div class="alert alert-info mt-5 text-dark" role="alert">
        <p><span class="mr-1"><i class="far fa-calendar-alt"></i></span>
            
            Ngày đặt cuối cùng: <span class="mx-1" style="font-weight: 600;"><?php echo $date['last_date']; ?></span>.
            Ngày du lịch:  <span class="mx-1" style="font-weight: 600;"><?php echo $date['travel_date']; ?></span>
        </p>
    </div>
    <?php
        }
    ?>
    
    <div class="row mt-5 lead">
        <div class="col-sm-4 border-right">
            <h5 class="p-4 "><span class="border-bottom border-success">Bao gồm</span></h5>
            <ul class="list-unstyled p-2">
                <?php 
                    echo $package['includes'];
                ?>
                <!-- <li class=""><span class="text-success mr-2"><i class="fas fa-check"></i></span> Lorem ipsum dolor sit amet.</li>-->
            </ul>
        </div>
        <div class="col-sm-4 ">
            <h5 class="p-4"><span class="border-bottom border-danger">Ngoại trừ</span></h5>
            <ul class="list-unstyled p-2">
                <?php 
                    echo $package['excludes'];
                ?>
                <!-- <li class=""><span class="text-danger mr-2"><i class="fas fa-times"></i></span> Lorem ipsum dolor.</li>-->
            </ul>
        </div>
        <div class="col-sm-4 border-left">
            <h5 class="p-4"><span class="border-bottom border-primary">Lời khuyên</span></h5>
            <ul class="list-unstyled p-2">
            <?php 
                echo $package['counsel'];
            ?>
                <!-- <li class=""><span class="text-primary mr-2"><i class="fas fa-plus"></i></span> Lorem ipsum dolor sit amet.</li>-->
            </ul>
        </div>
    </div>
</div>

<!-- Itinerary -->
<div class="container itinerary-content">
    <div class="lead mt-5 p-2 border-bottom">
        <?php echo $package['itinerary']; ?>
        <!-- <h5 class="font-weight-bold">Day 1</h5>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laudantium nisi deserunt veniam, quaerat eos veritatis.</p> -->
    </div>
    <!-- <div class="lead mt-3 p-2 border-bottom">
        <h5 class="font-weight-bold">Day 2</h5>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laudantium nisi deserunt veniam, quaerat eos veritatis.</p>
    </div> -->
</div>

<!-- gallery -->
<div class="container gallery-content">
    <h5 class="mt-5">Thư viện ảnh</h5>
    <div class="row" id="gallery" data-toggle="modal" data-target="#exampleModal">

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
                echo '<div class="col-12 col-sm-6 col-lg-3">';
                    echo '<img class="w-100" src="images/packages/'. $place_img .'" alt="'. $package['package_id'] .'" data-target="#carouselExample" data-slide-to="'. $i .'">';
                echo '</div>';
        }
    ?>
        <!-- <div class="col-12 col-sm-6 col-lg-3">
            <img class="w-100" src="images/packages/astronomy-beautiful-clouds-constellation-355465.jpg" alt="First slide" data-target="#carouselExample" data-slide-to="1">
        </div> -->
    </div>

    <!-- Modal -->
    <div class="modal fade modal-fullscreen exmple-modal-fullscreen show" id="exampleModal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content h-100 border-0 shadow-0">
                <div class="modal-body p-0">
                    <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                    <?php
                        for($i=0; $i<$img_count; $i++){
                            echo '<li data-target="#carouselExample" data-slide-to="'. $i .'"></li>';
                        }
                    ?>
                        <!-- <li data-target="#carouselExample" data-slide-to="0" class="active"></li> -->
                        
                    </ol>
                    <div class="carousel-inner">
                    <?php
                        for($i=0; $i<$img_count; $i++){
                            $place_img = str_replace($search, '', $img[$i]);
                            
                            if($i > 0){
                                echo '<div class="carousel-item">
                                        <img class="d-block w-100" src="images/packages/'. $place_img .'" alt="First slide">
                                    </div>';
                            }else {
                                echo '<div class="carousel-item active" >';
                                    echo '<img class="d-block w-100" src="images/packages/'. $place_img .'" alt="..">';
                                echo '</div>';
                            }
                            
                        }
                    ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Trước</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Tiếp theo</span>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review -->
<?php
    //Read Comment
    if(isset($_GET['package_id'])){
        $package_id = $_GET['package_id'];

        $stmt = $pdo->prepare('SELECT * FROM comments WHERE package_id = :package_id AND comment_status = :comment_status ORDER BY comment_id DESC');
        $stmt->execute([':package_id'       => $package_id,
                        ':comment_status'   => 'Đã phê duyệt']);
        $comments = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $comments[] = $row;
        }
    }
?>
<div class="container review-content">
    <h5 class="mt-5">Bình luận (<?php echo $count = $stmt->rowCount(); ?>)</h5>
    <div class="container-fluid px-1 pt-5 pb-3 mx-auto">
        <!-- comment -->
        <div class="row">
            <div class="col-sm-8">

            <?php
                //comment delete
                if(isset($_GET['delete_comment'])){
                    $comment_id = $_GET['delete_comment'];
                    $package_id = $_GET['package_id'];

                    $stmt = $pdo->prepare('DELETE FROM comments WHERE comment_id = :comment_id');
                    $stmt->execute([':comment_id' => $comment_id]);

                    header('Location: package.php?package_id='. $package_id);
                    return;
                }

                if(empty($comments)){
                    echo '<h1 class="text-center pt-4">Không có bình luận nào để hiển thị</h1>';
                }else{
                    foreach($comments as $comment){
            ?>
                <div class="card effect">
                    <div class="row d-flex">

                    <?php
                        $tourist_id = $comment['tourist_id'];

                        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
                        $stmt->execute([':tourist_id'  => $tourist_id]);
                        $tourist = $stmt->fetch(PDO::FETCH_ASSOC);

                        $profile_img = '';
                        if(!empty($tourist['profile_image'])){
                            $profile_img = $tourist['profile_image'];
                        }else{
                            $profile_img = 'default_user.png';
                        }
                    ?>

                        <div class=""> <img class="profile-pic" src="images/<?php echo $profile_img; ?>"></div>
                        <div class="d-flex flex-column">
                            <h4 class="my-auto"><?php echo $tourist['tourist_name'] .' '. $tourist['tourist_name']; ?></h4>
                        </div>
                        <div class="ml-auto">
                            <p class="text-muted pt-5 pt-sm-3"><?php echo $comment['comment_date']; ?></p>
                        </div>
                    </div>
                    <div class="row text-left mt-3">
                        <p class="content mt-4"><?php echo $comment['content']; ?></p>
                    </div>
                    <?php
                        if(isset($_SESSION['tourist_id']) && $_SESSION['tourist_id'] == $tourist['tourist_id']){
                            echo '<div class="" >
                                    <a href="package.php?package_id='. $comment['package_id'] .'&delete_comment='. $comment['comment_id'] .'" class="btn btn-danger float-right" ><i class="fas fa-trash-alt"></i></a>
                                </div>';
                        }
                    ?>
                </div>

            <?php
                }
            }
            ?>
            </div>

            <!-- Insert Comment -->
            <?php
                if(isset($_POST['post_comment'])){
                    $tourist_id = $_SESSION['tourist_id'];
                    $package_id = $_GET['package_id'];
                    $content    = $_POST['content'];
                    $date       = date("y.m.d");

                    $package = readPackage($package_id);

                    if(empty($content)){
                        header('Location: package.php?package_id='. $package_id);
                        return;
                    }else{
                        $stmt = $pdo->prepare('INSERT INTO comments(tourist_id, package_id, agency_id, content, comment_status, comment_date) VALUES(:tourist_id, :package_id, :agency_id, :content, :comment_status, :comment_date)');

                        $stmt->execute([':tourist_id'       => $tourist_id,
                                        ':package_id'       => $package_id,
                                        ':agency_id'        => $package['agency_id'],
                                        ':content'          => $content,
                                        ':comment_status'   => 'Đã phê duyệt',
                                        ':comment_date'     => $date]);

                        header('Location: package.php?package_id='. $package_id);
                        return;
                    }
                }

                if(isset($_SESSION['tourist_id'])){
                    $stmt = $pdo->prepare('SELECT * FROM payments WHERE tourist_id = :tourist_id AND package_id = :package_id');
                    $stmt->execute([':tourist_id' => $_SESSION['tourist_id'],
                                ':package_id' => $package_id]);
                    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                
            ?>

            <div class="col-sm-4 mt-4"  style="font-size: .9rem">
                <h5>Để lại bình luận</h5>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="content">Viết bình luận</label><br>
                        <textarea name="content" id="body" cols="50" rows="10"></textarea>
                        <button type="submit">Bình luận</button>
                    </div>
                    <?php
                        if(isset($_SESSION['tourist_id'])  && (!empty($payment) && $payment['tour_status'] == 'published')){
                            echo '<div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="post_comment" value="Gửi">
                                    
                                </div>';
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="js/package.js"></script>

<?php
    include 'layouts/footer.php';
?>