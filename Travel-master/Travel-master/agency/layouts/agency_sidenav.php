<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #04234D;">
        <div class="sb-sidenav-menu">
            <div class="nav pt-5 mt-5">
                <a class="nav-link" href="index.php">
                    Bảng điều khiển
                </a>
                <?php
            

                if ($_SESSION['agency_login'] == 'Chủ đại lý') {
                ?>
                    <a class="nav-link py-3" href="bookings.php">
                        Danh sách đặt tour
                    </a>
                    <a class="nav-link py-3" href="payments.php">
                        Danh sách thanh toán
                    </a>
                    <a class="nav-link py-3" href="reviews.php">
                        Đánh giá đại lý
                    </a>
                    <a class="nav-link py-3" href="comments.php">
                        Bình luận tour
                    </a>
                <?php
                } elseif($_SESSION['agency_login'] == 'Nhân viên đại lý' || $_SESSION['agency_login'] == 'Nhân viên đại lý')  {
                ?>

                    <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapsePackages" aria-expanded="false" aria-controls="collapseLayouts">
                        Tour
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePackages" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="packages.php">Xem tất cả tour</a>
                            <a class="nav-link" href="packages.php?page=add_package">Thêm tour</a>
                            <a href="packages.php?page=package_date" class="nav-link">Ngày tour</a>
                        </nav>
                    </div>
                    <a class="nav-link py-3" href="payments.php">
                        Danh sách thanh toán
                    </a>
                    <a class="nav-link py-3" href="reviews.php">
                        Đánh giá đại lý
                    </a>
                    <a class="nav-link py-3" href="comments.php">
                        Bình luận tour
                    </a>
                <?php
                }
                ?>


                <?php
                if ($_SESSION['agency_login'] == 'Chủ đại lý') {
                ?>

                    <a class="nav-link collapsed py-3" href="#" data-toggle="collapse" data-target="#collapseEmployees" aria-expanded="false" aria-controls="collapseLayouts">
                        Nhân viên
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseEmployees" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="employees.php">Xem tất cả nhân viên</a>
                            <a class="nav-link" href="employees.php?page=add_employee">Thêm nhân viên</a>
                        </nav>
                    </div>

                <?php
                } else {
                ?>
                    <a class="nav-link py-3" href="employees.php">
                        Nhân viên
                    </a>

                <?php
                }
                ?>

            </div>
        </div>

    </nav>
</div>