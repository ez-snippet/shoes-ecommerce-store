<?php
$image = isset($_GET['img']) ? basename($_GET['img']) : '';
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Nike Shoes';
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '140';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>

    <link rel="stylesheet" href="/Complete_e-commerce_store/assets/style/image_open.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="main-container">

    <!-- Left Side -->
    <div class="left">
        <img class="product-image"
             src="/Complete_e-commerce_store/uploads/<?php echo $image; ?>"
             alt="<?php echo $name; ?>">
    </div>

    <!-- Right Side -->
    <div class="right">

        <h1><?php echo $name; ?></h1>

        <div class="price">
            $<?php echo $price; ?>.00
        </div>

        <div class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <span>(50 Reviews)</span>
        </div>

        <h3>Select Size</h3>

        <div class="sizes">
             <button>39</button>
            <button>40</button>
            <button>41</button>
            <button>42</button>
            <button>43</button>
            <button>44</button>
        </div>

        <button class="buy-btn">
            <i class="fas fa-bolt"></i> Buy Now
        </button>

    </div>

</div>

</body>
</html>