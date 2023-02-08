<?php
    include '../includes/db.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->query('SELECT * FROM comments ORDER BY comment_status DESC');
    $stmt->execute();
    $comments = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $comments[] = $row;
    }
    
    if(isset($_GET['publish'])){
        $comment_id = $_GET['publish'];

        $stmt = $pdo->prepare('UPDATE comments SET comment_status = :comment_status WHERE comment_id = :comment_id');
        $stmt->execute([':comment_id'     => $comment_id,
                        ':comment_status' => 'Đã phê duyệt']);

        $_SESSION['success'] = 'Trạng thái được đặt thành Đã phê duyệt';
        header('Location: comments.php');
        return;
    }

    if(isset($_GET['unpublish'])){
        $comment_id = $_GET['unpublish'];

        $stmt = $pdo->prepare('UPDATE comments SET comment_status = :comment_status WHERE comment_id = :comment_id');
        $stmt->execute([':comment_id'     => $comment_id,
                        ':comment_status' => 'Chưa phê duyệt']);

        $_SESSION['success'] = 'Trạng thái được đặt thành Chưa phê duyệt';
        header('Location: comments.php');
        return;
    }

    if(isset($_GET['delete'])){
        $comment_id = $_GET['delete'];

        $stmt = $pdo->prepare('DELETE FROM comments WHERE comment_id = :comment_id');
        $stmt->execute([':comment_id' => $comment_id]);

        $_SESSION['success'] = 'Bình luận đã bị xóa';
        header('Location: comments.php');
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
                <h1 class="mt-4">Welcome</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Xem bình luận tour</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">

                    <?php
                        include '../includes/flash_msg.php';
                        
                        if(empty($comments)){
                            echo '<h1 class="text-center pt-4">Không tìm thấy bình luận nào</h1>';
                        }else{
                    ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người bình luận</th>
                                    <th>Email</th>
                                    <th>Bình luận</th>
                                    <th>Tour</th>
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
                                foreach($comments as $comment){
                                    if($comment['comment_status'] == 'Chưa phê duyệt'){
                                        echo '<tr class="table-warning">';
                                    }else{
                                        echo '<tr>';
                                    }
                                        echo '<td>'. $i++ .'</td>';

                                        $stmt = $pdo->prepare('SELECT * FROM tourists WHERE tourist_id = :tourist_id');
                                        $stmt->execute([':tourist_id' => $comment['tourist_id']]);
                                        $tourist = $stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<td>'. $tourist['tourist_name'] .'</td>';
                                        echo '<td>'. $tourist['tourist_email'] .'</td>';
                                        echo '<td>'. substr($comment['content'], 0, 40) .' .....</td>';

                                        $stmt = $pdo->prepare('SELECT * FROM packages WHERE package_id = :package_id');
                                        $stmt->execute([':package_id' => $comment['package_id']]);
                                        $package = $stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<td><a href="../package.php?package_id='. $comment['package_id'] .'">'. $package['package_name'] .'</a></td>';

                                        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_id = :agency_id');
                                        $stmt->execute([':agency_id' => $comment['agency_id']]);
                                        $agency = $stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<td><a href="../agency.php?agency_id='. $comment['agency_id'] .'">'. $agency['agency_name'] .'</a></td>';
                                        echo '<td>'. ucwords($comment['comment_status']) .'</td>';
                                        echo '<td>'. $comment['comment_date'] .'</td>';

                                    if($comment['comment_status'] == 'Chưa phê duyệt'){
                                        echo '<td><a href="comments.php?publish='. $comment['comment_id'] .'" class="btn btn-success mt-1">Đã phê duyệt</a></td>';
                                        echo '<td><a href="comments.php?unpublish='. $comment['comment_id'] .'" class="btn btn-secondary mt-1">Chưa phê duyệt</a></td>';
                                        echo '<td><a href="comments.php?delete='. $comment['comment_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                                    }else{
                                        echo '<td><a href="comments.php?publish='. $comment['comment_id'] .'" class="btn btn-outline-success mt-1">Đã phê duyệt</a></td>';
                                        echo '<td><a href="comments.php?unpublish='. $comment['comment_id'] .'" class="btn btn-outline-secondary mt-1">Chưa phê duyệt</a></td>';
                                        echo '<td><a href="comments.php?delete='. $comment['comment_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

<?php
    include 'layouts/admin_footer.php';
?>
