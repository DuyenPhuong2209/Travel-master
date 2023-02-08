<?php
    $page = 'contact';
    include 'layouts/header.php';
    include 'layouts/navbar.php';

?>
<head>
    <style>
        .about{
            background-image: url("images/view/contact.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-color: orange;
            height: 86vh;
        }
    </style>
</head>

<br><br><br>
<div class="container-fluid about">
    <br><br>
    <h1 class="text-white text-center my-5">Liên hệ</h1>
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title"><i class="far fa-envelope"></i></h5>
                        <p class="card-text"> duyenntp.21it@vku.udn.vn<br> minhtt.21it@vku.udn.vn</p>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border-success">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-phone"></i></h5>
                        <p class="card-text">0396042643 <br> 0338426431</p>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i></h5>
                        <p class="card-text pt-4">Trường Đại học Việt - Hàn</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'layouts/footer.php';
?>