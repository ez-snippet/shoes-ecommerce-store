<?php
include __DIR__ . "/../config/db.php";
$query = mysqli_query($conn, "SELECT * FROM announcements");
$sql = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fair shoes.pk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="icon" href="/uploads/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/home.css">

</head>

<body>
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <marquee direction="left" style="background:green; cursor: pointer;  color:white; padding:10px; font-size:18px; font-weight:bold;">
            <?= htmlspecialchars($row['message']) ?>
        </marquee>

    <?php } ?>

    <nav class="navbar navbar-expand-lg bg-white text-black border-3 shadow-sm h-75 sticky-top custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-black" href="#" aria-current="page">
                            <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/review.php">Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/feed_back_form.php">Contact</a>
                    </li>
                    <span title="Admin">
                        <a href="../admin/admin_form.php">
                            <lord-icon
                                src="https://cdn.lordicon.com/kdduutaw.json"
                                trigger="loop"
                                delay="100"
                                style="width:40px;height:40px">
                            </lord-icon>
                        </a>
                    </span>
            </div>
    </nav>
    <div id="bannerSlider" class="carousel slide carousel-fade container mt-4" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="/Complete_e-commerce_store/uploads/banner1.jpg" class="d-block w-100 slider-img" alt="">
            </div>

            <div class="carousel-item">
                <img src="/Complete_e-commerce_store/uploads/banner2.jpg" class="d-block w-100 slider-img" alt="">
            </div>

            <div class="carousel-item">
                <img src="/Complete_e-commerce_store/uploads/banner3.jpg" class="d-block w-100 slider-img" alt="">
            </div>

        </div>

        <!-- Previous -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <!-- Next -->
        <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

    <img src="/Complete_e-commerce_store/uploads/banner4.jpg" alt="" class="aliiii">
    <section id="products">
    <h2 class="leteast">Latest <span class="product">Products</span></h2>
    <div class="mian_div">

        <?php

        while ($p = mysqli_fetch_assoc($sql)) {

            $imagePath  = "/Complete_e-commerce_store/uploads/" . $p['image'];
            $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

            if (!empty($p['image']) && file_exists($serverPath)) {
                $imageSrc = $imagePath;
            } else {
                $imageSrc = "/Complete_e-commerce_store/uploads/no-image.png";
            }
        ?>
            <div class="card_box">
                <a href="image_open.php?img=<?= urlencode($p['image']) ?>&name=<?= urlencode($p['name']) ?>&price=<?= urlencode($p['price']) ?>">
                    <img class="shoe" loading="lazy" src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                </a>
                <h2  style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><?= htmlspecialchars($p['name']) ?></h2>
                <div class="price" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Rs. <?= htmlspecialchars($p['price']) ?></div>
                <div class="star">
                    <?= htmlspecialchars($p['stars']) ?>
                    <span class="rating-count">(50)</span>
                </div>
                <a href="../includes/order_form.php?id=<?= (int) $p['id'] ?>" class="btn">
                    <i class="fas fa-bolt"></i> Buy Now
                </a>
            </div>
        <?php } ?>
</section>

        <a href="https://wa.me/923001234567" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>

    </div>
    <!-- Footer Start -->
    <footer class="bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">

                <!-- Store Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 class="fw-bold mb-3">
                        <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo"> Fair shoes Stor
                    </h4>
                    <p class="text-secondary">
                        Premium quality shoes with the best prices and fast delivery.
                        Shop the latest collections for men, women, and kids.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-decoration-none text-secondary">Home</a></li>
                        <li><a href="home.php" class="text-decoration-none text-secondary">Products</a></li>
                        <li><a href="feed_back_form.php" class="text-decoration-none text-secondary">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Contact</h5>

                    <p class="text-secondary mb-2">
                        <i class="fa-solid fa-location-dot me-2 text-success"></i>
                        Hyderabad, Pakistan
                    </p>

                    <p class="text-secondary mb-2">
                        <i class="fa-solid fa-phone me-2 text-success"></i>
                        +92 300 1234567
                    </p>

                    <p class="text-secondary">
                        <i class="fa-solid fa-envelope me-2 text-success"></i>
                        fairshoes76@gmail.com
                </div>

                <!-- Social -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Follow Us</h5>

                    <div class="d-flex gap-2">

                        <a href="#" class="btn btn-primary rounded-circle d-flex bg-primary justify-content-center align-items-center"
                            style="width:45px;height:45px;">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="#"
                            class="btn rounded-circle d-flex justify-content-center align-items-center text-white"
                            style="width:45px;height:45px;background: radial-gradient(circle at 30% 107%,
            #fdf497 0%,
            #fdf497 5%,
            #fd5949 45%,
            #d6249f 60%,
            #285AEB 90%);">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="#" class="btn btn-success rounded-circle d-flex bg-success justify-content-center align-items-center"
                            style="width:45px;height:45px;">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>
                </div>

            </div>

            <hr class="border-secondary">

            <div class="text-center text-secondary">
                © 2026 Fair Shoes Store. All Rights Reserved.
            </div>
        </div>
    </footer>
    <!-- Footer End -->
    <script src="/assets/js/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>