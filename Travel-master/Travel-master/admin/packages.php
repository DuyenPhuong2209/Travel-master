<?php

    include '../includes/db.php';
    include 'layouts/admin_header.php';
    include 'layouts/admin_navbar.php';

    if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] == ''){
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->query('SELECT * FROM packages ORDER BY agency_id');
    $stmt->execute();

    $packages = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $packages[] = $row;
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
                    <li class="breadcrumb-item active">Thông tin tour</li>
                </ol>

                <?php
                    if(empty($packages)){
                        echo '<h1 class="text-center pt-4">Không tìm thấy tour</h1>';
                    }else{
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên tour</th>
                                    <th>Tên đại lý</th>
                                    <th>Địa điểm</th>
                                    <th>Trạng thái</th>
                                    <th>Bình luận</th>
                                    <th>Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                foreach($packages as $package){
                                    if($package['package_status'] == 'Không có sẵn'){
                                        echo '<tr class="table-warning">';
                                    }else {
                                        echo '<tr>';
                                    }
                                        echo '<td>'. $i++ .'</td>';
                                        echo '<td><a href="../package.php?package_id='. $package['package_id'] .'">'. $package['package_name'] .'</a></td>';

                                        $agency_id = $package['agency_id'];
                                        $stmt = $pdo->prepare('SELECT * FROM agencies WHERE agency_id = :agency_id');
                                        $stmt->execute([':agency_id' => $agency_id]);
                                        $agency = $stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<td><a href="../agency.php?agency_id='. $package['agency_id'] .'">'. $agency['agency_name'] .'</a></td>';
                                        echo '<td>'. $package['location'] .'</td>';
                                        echo '<td>'. ucwords($package['package_status']) .'</td>';

                                        //Counting Package Comment
                                        $stmt = $pdo->prepare('SELECT count(*) FROM comments WHERE package_id = :package_id AND comment_status = :comment_status');
                                        $stmt->execute([':package_id'       => $package['package_id'],
                                                        ':comment_status'   => 'Đã phê duyệt']);
                                        $comment_count = $stmt->fetchColumn();
                                        echo '<td>'. $comment_count .'</td>';

                                    if($package['package_status'] == 'Không có sẵn'){
                                        echo '<td><a href="packages.php?delete='. $package['package_id'] .'" class="btn btn-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
                                    }else{
                                        echo '<td><a href="packages.php?delete='. $package['package_id'] .'" class="btn btn-outline-danger mt-1"><i class="fas fa-trash-alt"></i></a></td>';
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
