<?php
include __DIR__ . "/../config/db.php";
$query = mysqli_query($conn, "SELECT * FROM announcements ORDER BY id DESC");
$sql = mysqli_query($conn, "SELECT * FROM products");

$announcements = [];
while ($row = mysqli_fetch_assoc($query)) {
    $announcements[] = $row['message'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fair shoes.pk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="icon" href="/Complete_e-commerce_store/uploads/logo.jpg">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/home.css">
</head>

<body>

    <!-- SVG icon set -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="i-bolt" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></symbol>
            <symbol id="i-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
            <symbol id="i-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></symbol>
            <symbol id="i-pin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></symbol>
            <symbol id="i-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
            <symbol id="i-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><polyline points="22 6 12 13 2 6"/></symbol>
            <symbol id="i-facebook" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></symbol>
            <symbol id="i-instagram" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></symbol>
        </defs>
    </svg>

    <?php if (count($announcements) > 0): ?>
        <div class="announcement-bar">
            <div class="ticker">
                <?php for ($copy = 0; $copy < 2; $copy++): ?>
                    <div class="ticker-group">
                        <?php foreach ($announcements as $msg): ?>
                            <span class="ticker-item"><?= htmlspecialchars($msg) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg sticky-top custom-navbar">
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
                    <li class="nav-item">
                        <a class="admin-link" href="../admin/admin_form.php" title="Admin" aria-label="Admin login">
                            <svg><use href="#i-user"/></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="bannerSlider" class="carousel slide carousel-fade container mt-4" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

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

        <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev" aria-label="Previous">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next" aria-label="Next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

    <img src="/Complete_e-commerce_store/uploads/banner4.jpg" alt="" class="aliiii">

    <section id="products">
        <div class="section-head">
            <h2 class="leteast">Latest <span class="product">Products</span></h2>
            <p>Naye aur premium shoes, behtareen qeemat par.</p>
        </div>

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
                    <a class="shoe-wrap" href="image_open.php?img=<?= urlencode($p['image']) ?>&name=<?= urlencode($p['name']) ?>&price=<?= urlencode($p['price']) ?>">
                        <img class="shoe" loading="lazy" src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    </a>
                    <h3 class="p-name"><?= htmlspecialchars($p['name']) ?></h3>
                    <div class="price">Rs. <?= htmlspecialchars($p['price']) ?></div>
                    <div class="star">
                        <span class="star-text"><?= htmlspecialchars($p['stars']) ?></span>
                        <span class="rating-count">(50)</span>
                    </div>
                    <a href="../includes/order_form.php?id=<?= (int) $p['id'] ?>" class="buy-btn">
                        <svg><use href="#i-bolt"/></svg> Buy Now
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>

    <a href="https://wa.me/923001234567" class="whatsapp-float" target="_blank" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
        <svg><use href="#i-chat"/></svg>
    </a>

    <!-- Footer Start -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="foot-brand">
                        <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo">
                        <span>Fair Shoes Store</span>
                    </div>
                    <p class="foot-text">
                        Premium quality shoes with the best prices and fast delivery.
                        Shop the latest collections for men, women, and kids.
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="foot-title">Quick Links</h5>
                    <ul class="foot-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="home.php">Products</a></li>
                        <li><a href="feed_back_form.php">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="foot-title">Contact</h5>
                    <p class="foot-contact"><svg><use href="#i-pin"/></svg>Hyderabad, Pakistan</p>
                    <p class="foot-contact"><svg><use href="#i-phone"/></svg>+92 300 1234567</p>
                    <p class="foot-contact"><svg><use href="#i-mail"/></svg>fairshoes76@gmail.com</p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="foot-title">Follow Us</h5>
                    <div class="social">
                        <a href="#" class="s-fb" aria-label="Facebook"><svg><use href="#i-facebook"/></svg></a>
                        <a href="#" class="s-ig" aria-label="Instagram"><svg><use href="#i-instagram"/></svg></a>
                        <a href="#" class="s-wa" aria-label="WhatsApp"><svg><use href="#i-chat"/></svg></a>
                    </div>
                </div>

            </div>

            <div class="foot-bottom">
                © 2026 Fair Shoes Store. All Rights Reserved.
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <script src="/assets/js/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>