
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm p-3 fixed-top">
    <div class="container">
        <a class="navbar-brand mb-0 h1" href="index.php">Travel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if($page == "index") echo 'active'; ?>">
                    <a class="nav-link home" href="index.php">TRANG CHỦ </a>
                </li>
                <li class="nav-item <?php if($page == "agencies") echo 'active'; ?>">
                    <a class="nav-link" href="agencies.php">ĐẠI LÝ</a>
                </li>
                <li class="nav-item <?php if($page == "packages") echo 'active'; ?>">
                    <a class="nav-link" href="packages.php">TOUR</a>
                </li>
                <li class="nav-item <?php if($page == "about") echo 'active'; ?>">
                    <a class="nav-link" href="about.php">CHÚNG TÔI</a>
                </li>
                <li class="nav-item <?php if($page == "contact") echo 'active'; ?>">
                    <a class="nav-link" href="contact.php">LIÊN HỆ</a>
                </li>
            </ul>

            <?php
                if(isset($_SESSION['tourist_email']) && ($_SESSION['tourist_status'] == 'Đã phê duyệt')){
                        
            ?>
            <ul class="navbar-nav ml-auto float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['tourist_username']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profile.php" >Hồ sơ</a>
                        <a class="dropdown-item" href="mybookings.php" >Tour của tôi</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="includes/logout.php" >Đăng xuất</a>
                    </div>
                </li>
            </ul>

            <?php
                }elseif(isset($_SESSION['agency_login'])){
                    
                ?>

                <ul class="navbar-nav ml-auto float-right">
                    <li class="nav-item">
                        <a class="nav-link" href="agency/index.php"><?php echo $_SESSION['agency_name']; ?></a>
                    </li>
                </ul>

                <?php
                    }elseif(isset($_SESSION['admin_email']) && ($_SESSION['admin_status'] == 'Đã phê duyệt')) {
                        
                ?>
                
                <ul class="navbar-nav ml-auto float-right">
                    <li class="nav-item">
                        <a class="nav-link" href="admin/dashboard.php"><?php echo $_SESSION['username']; ?></a>
                    </li>
                </ul>

                <?php

                    }else{
            ?>
            <!-- Registration & Log In -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="includes/login.php">ĐĂNG NHẬP</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ĐĂNG KÍ
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="tourist/registration.php" >KHÁCH HÀNG</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="agency/register.php">ĐẠI LÝ</a>
                    </div>
                </li>
            </ul>

            <?php
                }
            ?>
        </div>
    </div>
</nav>
