<?php
    include '../includes/db.php';
    include '../includes/functions.php';
    include 'layouts/agency_header.php';
    include 'layouts/agency_navbar.php';

    if(empty($_SESSION['agency_login']) || $_SESSION['agency_login'] == ''){
        header('Location: ../includes/login.php');
        return;
    }

    if(isset($_SESSION['agency_id'])){
        $agency_id = $_SESSION['agency_id'];

        $stmt = $pdo->prepare('SELECT * FROM reviews WHERE agency_id = :agency_id AND review_status = :review_status ORDER BY review_id DESC');
        $stmt->execute([':agency_id'        => $agency_id,
                        ':review_status'    => 'Đã phê duyệt']);
        $reviews = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $reviews[] = $row;
        }
    }

?>

<head>
    <link rel="stylesheet" href="../css/agency.php">
</head>

<div id="layoutSidenav">
    <?php
        include 'layouts/agency_sidenav.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Welcome to 
                <?php
                    if(isset($_SESSION['employee_id'])){
                        echo ucwords($_SESSION['agency_name']) ." (". ucwords($_SESSION['role']) .")";
                    }elseif($_SESSION['agency_id']){
                        echo ucwords($_SESSION['agency_name']) ." ";
                    }
                ?>
                </h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Danh sách xếp hạng</li>
                </ol>
                <div class="container-fluid mt-3">

                <?php
                    if(empty($reviews)){
                        echo '<h1 class="text-center pt-4"> Không tìm thấy đánh giá nào</h1>';
                    }else{
                ?>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Người đánh giá </th>
                                <th>Email</th>
                                <th>Xếp hạng</th>
                                <th>Bình luận</th>
                                <th>Ngày tháng năm</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $i = 1;
                            foreach($reviews as $review){
                                echo '<tr>';
                                    echo '<td>'. $i++ .'</td>';

                                    $tourist = readTourist($review['tourist_id']);
                                    echo '<td>'. ucwords($tourist['tourist_name']) .'</td>';
                                    echo '<td>'. $tourist['tourist_email'] .'</td>';

                                    echo '<td>'. $review['rating'] .'</td>';
                                    echo '<td>'. $review['comment'] .'</td>';
                                    echo '<td>'. $review['review_date'] .'</td>';
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
        </main>
  
    </div>
</div>

<?php
    include 'layouts/agency_footer.php';
?>