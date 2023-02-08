<?php
    include '../includes/db.php';
    include 'layouts/agency_header.php';
    include 'layouts/agency_navbar.php';

    if(empty($_SESSION['agency_login']) || $_SESSION['agency_login'] == 'Chủ'){
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
                    <li class="breadcrumb-item active">Thông tin nhân viên</li>
                </ol>
                <?php
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = '';
                    }
                    switch($page){
                        case 'add_employee':
                            include 'includes/add_employee.php';
                        break;
                        case 'edit_employee':
                            include 'includes/edit_employee.php';
                        break;
                        default:
                            include 'includes/view_all_employees.php';
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