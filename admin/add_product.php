<?php
include __DIR__ . "/../config/db.php";
$current_page = basename($_SERVER['PHP_SELF']);

$error = "";
$added = isset($_GET['added']);

if (isset($_POST['submit'])) {
    $name  = trim($_POST['name']);
    $price = $_POST['price'];
    $star  = $_POST['star'];

    $image = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 && $_FILES['image']['name'] != "") {

        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/Complete_e-commerce_store/uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $originalName = basename($_FILES['image']['name']);
        $safeName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName);
        $image = time() . '_' . $safeName;

        $tmp = $_FILES['image']['tmp_name'];
        $targetPath = $targetDir . $image;

        if (!move_uploaded_file($tmp, $targetPath)) {
            $error = "Image upload fail ho gayi.";
            $image = "";
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, image, stars) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $price, $image, $star);
    $stmt->execute();

    if ($error === "") {
        header("Location: add_product.php?added=1");
        exit;
    }
}

$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/dashboard.css">
    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/add_product.css">
    <link rel="icon" href="/Complete_e-commerce_store/uploads/logo.jpg">
</head>

<body>

    <!-- SVG icon set -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="i-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9" rx="2" />
                <rect x="14" y="3" width="7" height="5" rx="2" />
                <rect x="14" y="12" width="7" height="9" rx="2" />
                <rect x="3" y="16" width="7" height="5" rx="2" />
            </symbol>
            <symbol id="i-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 8v8M8 12h8" />
            </symbol>
            <symbol id="i-bag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2h12l2 5v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7z" />
                <path d="M4 7h16M9 11a3 3 0 0 0 6 0" />
            </symbol>
            <symbol id="i-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12a8 8 0 0 1-11.5 7.2L3 21l1.8-5.5A8 8 0 1 1 21 12z" />
            </symbol>
            <symbol id="i-star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.2 6.5 20.2l1-6.2L3 9.6l6.2-.9z" />
            </symbol>
            <symbol id="i-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 11v2a1 1 0 0 0 1 1h3l8 5V5L7 10H4a1 1 0 0 0-1 1z" />
                <path d="M19 9a4 4 0 0 1 0 6" />
            </symbol>
            <symbol id="i-logout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
            </symbol>
            <symbol id="i-edit" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z" />
            </symbol>
            <symbol id="i-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6M10 11v6M14 11v6" />
            </symbol>
            <symbol id="i-upload" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12" />
            </symbol>
        </defs>
    </svg>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <img src="/Complete_e-commerce_store/uploads/logo.jpg" alt="Logo" class="logo" style="width: 50px; height: 50px; border-radius: 50%;">
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <div class="admin-chip">
                            <div class="admin-avatar">A</div>
                            <span>Welcome, Admin</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar p-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                        <svg>
                            <use href="#i-home" />
                        </svg>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'add_product.php' ? 'active' : '' ?>" href="add_product.php">
                        <svg>
                            <use href="#i-plus" />
                        </svg>Add Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'orders.php' ? 'active' : '' ?>" href="orders.php">
                        <svg>
                            <use href="#i-bag" />
                        </svg>Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'user_message_show.php' ? 'active' : '' ?>" href="user_message_show.php">
                        <svg>
                            <use href="#i-chat" />
                        </svg>Customer Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'reviews_show.php' ? 'active' : '' ?>" href="reviews_show.php">
                        <svg>
                            <use href="#i-star" />
                        </svg>Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'acnounch.php' ? 'active' : '' ?>" href="acnounch.php">
                        <svg>
                            <use href="#i-megaphone" />
                        </svg>Announcements
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="../admin/logout.php">
                        <svg>
                            <use href="#i-logout" />
                        </svg>Logout
                    </a>
                </li>
            </ul>
        </div>
        <!-- /Sidebar -->

        <!-- Main content -->
        <div class="flex-grow-1 p-4">

            <div class="page-head">
                <h1>Add Products</h1>
                
            </div>

            <?php if ($added): ?>
                <div class="alert-soft ok-soft">Product kamyabi se add ho gaya.</div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert-soft err-soft"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Add product form -->
            <div class="card-table p-4 mb-4">
                <h6 class="section-title">New product</h6>

                <form method="post" id="form" enctype="multipart/form-data">
                    <div class="form-grid">

                        <label class="dropzone" for="image">
                            <img class="preview" id="preview" alt="">
                            <svg>
                                <use href="#i-upload" />
                            </svg>
                            <strong>Upload image</strong>
                            <span id="fileName">PNG ya JPG choose karein</span>
                            <input type="file" name="image" id="image" accept="image/*">
                        </label>

                        <div class="fields">
                            <div class="field full">
                                <label for="name">Product name</label>
                                <input type="text" name="name" id="name" placeholder="e.g. Classic Running Shoe" required>
                            </div>
                            <div class="field">
                                <label for="price">Price (PKR)</label>
                                <input type="number" name="price" id="price" placeholder="e.g. 4500" required>
                            </div>
                            <div class="field">
                                <label for="star">Rating</label>
                                <input type="text" name="star" id="star" placeholder="e.g. ⭐⭐⭐⭐⭐">
                            </div>
                            <div class="full">
                                <button type="submit" name="submit" id="btn" class="btn-grad">Add Product</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Products table -->
            <div class="card-table p-4">
                <h6 class="section-title">Products management</h6>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Rating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td>
                                        <?php
                                        $imagePath  = "/Complete_e-commerce_store/uploads/" . $row['image'];
                                        $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                                        if (!empty($row['image']) && file_exists($serverPath)) {
                                            $imageSrc = $imagePath;
                                        } else {
                                            $imageSrc = "/Complete_e-commerce_store/uploads/no-image.png";
                                        }
                                        ?>
                                        <img src="<?= htmlspecialchars($imageSrc) ?>" class="product-img" alt="">
                                    </td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                                    <td>PKR <?= htmlspecialchars($row['price']) ?></td>
                                    <td><?= htmlspecialchars($row['stars']) ?></td>
                                    <td>
                                        <a class="icon-btn" title="Edit" href="update.php?id=<?= (int) $row['id'] ?>">
                                            <svg>
                                                <use href="#i-edit" />
                                            </svg>
                                        </a>
                                        <a class="icon-btn danger ms-2" title="Delete" href="delete.php?id=<?= (int) $row['id'] ?>"
                                            onclick="return confirm('Is product ko delete karna hai?')">
                                            <svg>
                                                <use href="#i-trash" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /Main content -->

    </div>

    <script>
        document.getElementById('image').addEventListener('change', function() {
            var file = this.files[0];
            var preview = document.getElementById('preview');
            if (!file) return;
            document.getElementById('fileName').textContent = file.name;
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>