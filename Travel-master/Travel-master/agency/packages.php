<?php
    include '../includes/db.php';
    include '../includes/functions.php';
    include 'layouts/agency_header.php';
    include 'layouts/agency_navbar.php';

    if(empty($_SESSION['agency_login']) || $_SESSION['agency_login'] == ''){
        header('Location: ../includes/login.php');
        return;
    }
?>

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
                    <li class="breadcrumb-item active">Chi tiết tour & Ngày </li>
                </ol>
                <?php
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = '';
                    }
                    switch($page){
                        case 'add_package':
                            include 'includes/add_package.php';
                        break;
                        case 'edit_package':
                            include 'includes/edit_package.php';
                        break;
                        case 'package_date':
                            include 'includes/package_date.php';
                        break;
                        case 'add_date':
                            include 'includes/add_date.php';
                        break;
                        case 'update_date':
                            include 'includes/update_date.php';
                        break;
                        default:
                            include 'includes/view_all_packages.php';
                    break;
                    }
                ?>
            </div>
        </main>
    </div>
</div>

<?php
    include 'layouts/agency_footer.php';
?>