<?php
    include '../includes/db.php';
    include '../includes/functions.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->query('SELECT * FROM reviews ORDER BY review_status DESC');
    $stmt->execute();

    $reviews = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $reviews[] = $row;
    }

    if(isset($_GET['publish'])){
        $review_id = $_GET['publish'];

        $stmt = $pdo->prepare('UPDATE reviews SET review_status = :review_status WHERE review_id = :review_id');
        $stmt->execute([':review_id'     => $review_id,
                        ':review_status' => 'Đã phê duyệt']);

        $_SESSION['success'] = 'Trạng thái đánh giá được đặt thành Đã phê duyệt';
        header('Location: reviews.php');
        return;
    }

    if(isset($_GET['unpublish'])){
        $review_id = $_GET['unpublish'];

        $stmt = $pdo->prepare('UPDATE reviews SET review_status = :review_status WHERE review_id = :review_id');
        $stmt->execute([':review_id'     => $review_id,
                        ':review_status' => 'Chưa phê duyệt']);

        $_SESSION['success'] = 'Trạng thái đánh giá được đặt thành Chưa phê duyệt ';
        header('Location: reviews.php');
        return;
    }

    if(isset($_GET['delete'])){
        $review_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM reviews WHERE review_id = :review_id');
        $stmt->execute([':review_id' => $review_id]);

        $_SESSION['success'] = 'Xóa đánh giá';
        header('Location: reviews.php');
        return;
    }

?>

<div id="layoutSidenav">
    <?php
        include 'layouts/admin_sidenav.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Welcome </h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Xem bình luận và xếp hạng</li>
                </ol>

                <?php
                    include '../includes/flash_msg.php';
                    
                    if(empty($reviews)){
                        echo '<h1 class="text-center pt-4">Không thấy bình luận nào</h1>';
                    }else{
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người đánh giá</th>
                                    <th>Xếp hạng</th>
                                    <th>Bình luận</th>
                                    <th>Đại lý</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tháng năm</th>
                                    <th>Đã phê duyệt</th>
                                    <th>Chưa phê duyệt</th>
                                    <th>Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach($reviews as $review){
                                if($review['review_status'] == 'Chưa phê duyệt'){
                                    echo '<tr class="table table-warning">';
                                }else{
                                    echo '<tr>';
                                }
                                    echo '<td>'. $i++ .'</td>';
                                    
                                    //read tourist name
                                    $tourist = readTourist($review['tourist_id']);
                                    echo '<td>'. ucwords($tourist['tourist_name']) .'</td>';

                                    echo '<td>'. $review['rating'] .'</td>';
                                    echo '<td>'. $review['comment'] .'</td>';

                                    //read agency name
                                    $agency = readAgency($review['agency_id']);
                                    echo '<td><a href="../agency.php?agency_id='. $review['agency_id'] .'">'. $agency['agency_name'] .'</a></td>';

                                    echo '<td>'. ucwords($review['review_status']) .'</td>';
                                    echo '<td>'. $review['review_date'] .'</td>';

                                if($review['review_status'] == 'Chưa phê duyệt'){
                                    echo '<td><a href="reviews.php?publish='. $review['review_id'] .'" class="btn btn-success mt-1">Đã phê duyệt</a></td>';
                                    echo '<td><a href="reviews.php?unpublish='. $review['review_id'] .'" class="btn btn-secondary mt-1">Chưa phê duyệt</a></td>';
                                    echo '<td><a href="reviews.php?delete='. $review['review_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                                }else{
                                    echo '<td><a href="reviews.php?publish='. $review['review_id'] .'" class="btn btn-outline-success mt-1">Đã phê duyệt</a></td>';
                                    echo '<td><a href="reviews.php?unpublish='. $review['review_id'] .'" class="btn btn-outline-secondary mt-1">Chưa phê duyệt</a></td>';
                                    echo '<td><a href="reviews.php?delete='. $review['review_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                                }
                                echo '</tr>';
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                    }
                ?>
            </div>
        </main>

    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
