<?php
include __DIR__ . "/../config/db.php";

// Get product ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If no ID is provided, show error instead of redirecting
if ($id == 0) {
  $error = "No product selected. Please go back and select a product.";
  $product = null;
} else {
  // Fetch product details
  $sql = "SELECT * FROM products WHERE id='$id'";
  $result = mysqli_query($conn, $sql);
  $product = mysqli_fetch_assoc($result);

  // If product not found, show error instead of redirecting
  if (!$product) {
    $error = "Product not found. Please go back and select a valid product.";
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
  // Get form data
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $size = mysqli_real_escape_string($conn, $_POST['size']);
  $color = mysqli_real_escape_string($conn, $_POST['color']);
  $quantity = (int)$_POST['quantity'];
  $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
  $notes = mysqli_real_escape_string($conn, $_POST['notes']);
  $product_id = $product['id'];
  $total_price = $product['price'] * $quantity;

  // Insert into orders table
  $insert_sql = "INSERT INTO orders (
        product_id, 
        full_name, 
        phone, 
        email, 
        address, 
        city, 
        size, 
        color, 
        quantity, 
        payment_method, 
        notes, 
        total_price
    ) VALUES (
        '$product_id',
        '$full_name',
        '$phone',
        '$email',
        '$address',
        '$city',
        '$size',
        '$color',
        '$quantity',
        '$payment_method',
        '$notes',
        '$total_price'
    )";

  if (mysqli_query($conn, $insert_sql)) {
    $order_id = mysqli_insert_id($conn);
    // Redirect to success page with order ID
    header("Location: order_success.php?order_id=" . $order_id);
    exit();
  } else {
    $error = "Error placing order: " . mysqli_error($conn);
  }
}

// Set default values
$default_size = '40';
$default_color = 'Black';
$default_quantity = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complete Your Order <?php echo $product ? '· ' . htmlspecialchars($product['name']) : ''; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style/order_form.css">
</head>

<body>

  <?php if (isset($error) && !$product): ?>
    <div class="not-found-card">
      <div class="emoji">🔍</div>
      <h2>Product Not Found</h2>
      <p><?php echo htmlspecialchars($error); ?></p>
      <a href="../includes/home.php">Go Back to Shopping</a>
    </div>
    <?php exit(); ?>
  <?php endif; ?>

  <div class="checkout-wrap">

    <!-- Store header -->
    <div class="store-header">
      <div class="store-name">FairShoesCollection</div>
    </div>

    <?php if (isset($error) && $product): ?>
      <div class="error-message">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="" id="orderForm">
    <div class="checkout-columns">

      <!-- LEFT: form -->
      <div class="checkout-left">
      <div class="checkout-body">

        <!-- Contact -->
        <section class="checkout-section">
          <h2>Contact</h2>
          <div class="field">
            <input type="email" id="email" name="email" placeholder="Email address" required>
          </div>
        </section>

        <!-- Delivery -->
        <section class="checkout-section">
          <h2>Delivery</h2>
          <div class="field">
            <select disabled>
              <option>Pakistan</option>
            </select>
          </div>
          <div class="field">
            <input type="text" id="full_name" name="full_name" placeholder="Full name" required>
          </div>
          <div class="field">
            <input type="text" id="address" name="address" placeholder="Address (House No, Street, Area)" required>
          </div>
          <div class="field">
            <input type="text" id="city" name="city" placeholder="City" required>
          </div>
          <div class="field">
            <input type="text" id="phone" name="phone" placeholder="Phone number (03XX-XXXXXXX)" required>
            <div class="field-hint">Format: 03XX-XXXXXXX</div>
          </div>
        </section>

        <!-- Order details / product options -->
        <section class="checkout-section">
          <h2>Order Details</h2>

          <div class="product-row">
            <span class="label">Product</span>
            <span class="value"><?php echo htmlspecialchars($product['name']); ?></span>
          </div>
          <div class="product-row">
            <span class="label">Price</span>
            <span class="value price">Rs. <?php echo number_format($product['price']); ?></span>
          </div>

          <div class="option-label">Size *</div>
          <div class="chip-group" id="sizeGroup">
            <?php
            $sizes = [ 39, 40, 41, 42, 43, 44];
            foreach ($sizes as $size):
            ?>
              <span class="chip <?php echo ($size == $default_size) ? 'active' : ''; ?>" data-value="<?php echo $size; ?>"><?php echo $size; ?></span>
            <?php endforeach; ?>
          </div>
          <input type="hidden" name="size" id="selectedSize" value="<?php echo $default_size; ?>">

          <div class="option-label">Color *</div>
          <div class="chip-group" id="colorGroup">
            <?php
            $colors = [
              ['name' => 'Black', 'bg' => '#111111'],
              ['name' => 'Brown', 'bg' => '#8B4513'],
            ];
            foreach ($colors as $color):
            ?>
              <span class="chip color-chip <?php echo ($color['name'] == $default_color) ? 'active' : ''; ?>" data-value="<?php echo $color['name']; ?>">
                <span class="color-dot" style="background:<?php echo $color['bg']; ?>;"></span>
                <?php echo $color['name']; ?>
              </span>
            <?php endforeach; ?>
          </div>
          <input type="hidden" name="color" id="selectedColor" value="<?php echo $default_color; ?>">

          <div class="option-label">Quantity *</div>
          <div class="quantity-wrapper">
            <button type="button" onclick="decreaseQuantity()">−</button>
            <input type="number" name="quantity" id="quantity" value="<?php echo $default_quantity; ?>" min="1" max="10">
            <button type="button" onclick="increaseQuantity()">+</button>
          </div>
        </section>

        <!-- Shipping method -->
        <section class="checkout-section">
          <h2>Shipping method</h2>
          <div class="method-box">
            <div class="method-box-top">
              <span>Standard Shipping</span>
              <span class="free-tag">FREE</span>
            </div>
          </div>
        </section>

        <!-- Payment -->
        <section class="checkout-section">
          <div class="section-header-row" style="margin-bottom: 0.3rem;">
            <h2>Payment</h2>
          </div>
          <p class="field-hint" style="margin-bottom: 1rem;">All transactions are secure and encrypted.</p>
          <div class="method-box">
            <div class="method-box-title">
              <input type="radio" name="payment_method" id="cod" value="Cash on Delivery" checked>
              <label for="cod">Cash on Delivery (COD)</label>
            </div>
            <div class="method-box-detail">
              COD (Cash on Delivery) means you pay for the product when it arrives at your door.
              <span class="urdu">کیش آن ڈیلیوری کا مطلب ہے کہ آپ پارسل ملنے پر ادائیگی کریں گے۔</span>
            </div>
          </div>
        </section>

        <!-- Billing address -->
        <section class="checkout-section">
          <h2>Billing address</h2>
          <label class="radio-option selected">
            <span class="radio-left">
              <input type="radio" name="billing_same" checked>
              Same as shipping address
            </span>
          </label>
          <label class="radio-option">
            <span class="radio-left">
              <input type="radio" name="billing_same">
              Use a different billing address
            </span>
          </label>
        </section>

        <!-- Order notes -->
        <section class="checkout-section" style="border-bottom: none;">
          <h2>Order Notes (Optional)</h2>
          <div class="field">
            <textarea id="notes" name="notes" placeholder="Write any notes about your order..."></textarea>
          </div>
        </section>

        <button type="submit" class="btn-complete" style="margin: 1rem 0 0.5rem 0;">Complete order</button>
        <div class="secure-note">🔒 Your information is safe and secure</div>
        <a href="#" class="privacy-link">Privacy policy</a>

      </div>
      </div>

      <!-- RIGHT: sticky order summary -->
      <div class="checkout-right">
        <div class="summary-line-item">
          <div class="thumb">
            👟
            <span class="qty-badge" id="thumbQtyBadge"><?php echo $default_quantity; ?></span>
          </div>
          <div class="line-item-info">
            <div class="name"><?php echo htmlspecialchars($product['name']); ?></div>
            <div class="variant">
              Size <span id="summarySizeLine"><?php echo $default_size; ?></span> ·
              <span id="summaryColorLine"><?php echo $default_color; ?></span>
            </div>
          </div>
          <div class="line-item-price" id="lineItemPrice">Rs <?php echo number_format($product['price']); ?></div>
        </div>

        <div class="discount-row">
          <input type="text" placeholder="Discount code">
          <button type="button">Apply</button>
        </div>

        <div class="cost-row">
          <span class="label">Subtotal · <span id="subtotalQtyLabel">1 item</span></span>
          <span id="detailSubtotal">Rs <?php echo number_format($product['price']); ?></span>
        </div>
        <div class="cost-row">
          <span class="label">Shipping</span>
          <span>FREE</span>
        </div>
        <div class="cost-row total-row-final">
          <span class="label">Total</span>
          <span class="total-value">
            <span class="currency">PKR</span><span class="amount" id="summaryTotal">Rs <?php echo number_format($product['price']); ?></span>
          </span>
        </div>
      </div>

    </div>
    </form>
  </div>

  <script>
    // Quantity buttons
    function decreaseQuantity() {
      const input = document.getElementById('quantity');
      let value = parseInt(input.value) || 1;
      if (value > 1) {
        value--;
        input.value = value;
        updateSummary();
      }
    }

    function increaseQuantity() {
      const input = document.getElementById('quantity');
      let value = parseInt(input.value) || 1;
      if (value < 10) {
        value++;
        input.value = value;
        updateSummary();
      }
    }

    // Dynamic update for size selection
    document.querySelectorAll('#sizeGroup .chip').forEach(chip => {
      chip.addEventListener('click', function() {
        document.querySelectorAll('#sizeGroup .chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const value = this.dataset.value;
        document.getElementById('selectedSize').value = value;
        document.getElementById('summarySizeLine').textContent = value;
      });
    });

    // Dynamic update for color selection
    document.querySelectorAll('#colorGroup .chip').forEach(chip => {
      chip.addEventListener('click', function() {
        document.querySelectorAll('#colorGroup .chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const value = this.dataset.value;
        document.getElementById('selectedColor').value = value;
        document.getElementById('summaryColorLine').textContent = value;
      });
    });

    // Billing address radio styling
    document.querySelectorAll('.radio-option').forEach(opt => {
      opt.addEventListener('click', function() {
        document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
      });
    });

    // Update quantity and total
    document.getElementById('quantity').addEventListener('change', updateSummary);

    function updateSummary() {
      const quantity = parseInt(document.getElementById('quantity').value) || 1;
      const price = <?php echo $product['price']; ?>;
      const total = price * quantity;
      const formatted = 'Rs ' + total.toLocaleString();

      document.getElementById('thumbQtyBadge').textContent = quantity;
      document.getElementById('subtotalQtyLabel').textContent = quantity + (quantity > 1 ? ' items' : ' item');
      document.getElementById('lineItemPrice').textContent = formatted;
      document.getElementById('detailSubtotal').textContent = formatted;
      document.getElementById('summaryTotal').textContent = formatted;
    }
  </script>

</body>

</html>