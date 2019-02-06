<?php $db = new UsersDB(__TABLE_NAME__);
$db->connect();
$res = $db->get_record_by_id($_SESSION["user_id"]);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Data</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="views/admin/css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="views/admin/css/style.css">
    <link rel="stylesheet" href="views/admin/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="vendors/linericon/style.css"> -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css">
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="vendors/animate-css/animate.css">
    <link rel="stylesheet" href="vendors/popup/magnific-popup.css">
    <link rel="stylesheet" href="vendors/flaticon/flaticon.css"> -->
    <!-- main css -->
    <link rel="stylesheet" href="views/admin/css/style1.css">
    <link rel="stylesheet" href="views/admin/css/responsive.css">


</head>

<body>

    <!--================Home Banner Area =================-->
    <section class="home_banner_area">
        <div class="container box_1620">
            <div class="banner_inner d-flex align-items-center">
                <div class="banner_content">
                    <div class="media">
                        <div class="d-flex">
                            <img src="Files/Photos/<?php echo $res[0]["username"] ?>.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="personal_text">
                                <h6>Hello Everybody, i am</h6>
                                <h3><?php echo $res[0]["fullname"] ?></h3>
                                <h4><?php echo $res[0]["job"] ?></h4>
                                <ul class="list basic_info">
                                    <li><a href="#"><i class="lnr lnr-envelope"></i><?php echo $res[0]["email"] ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <embed class=" ml-3" src="Files/CVs/<?php echo $res[0]["username"] ?>" width="600" height="800" />
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->



</body>

</html>