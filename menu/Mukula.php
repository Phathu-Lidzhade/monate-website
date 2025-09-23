<?php
session_start();
require_once "../API/db.php";

// Force branch
$branchLocation = "Mukula";

// Fetch menu items for this branch
$stmt = $conn->prepare("SELECT id, name, price, description, category, image 
                        FROM MenuItems 
                        WHERE branch_location = ?");
$stmt->bind_param("s", $branchLocation);
$stmt->execute();
$result = $stmt->get_result();

// Group by category
$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[$row["category"]][] = $row;
}

// Cart count for this user & branch
$cartCount = 0;
if (isset($_SESSION["user_id"])) {   
    $userId = $_SESSION["user_id"];
    $cartStmt = $conn->prepare("SELECT SUM(quantity) as total 
                                FROM Cart 
                                WHERE user_id = ? AND branch_location = ?");
    $cartStmt->bind_param("is", $userId, $branchLocation);
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();
    $cartCount = $cartResult->fetch_assoc()["total"] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Monate Menu - Mukula</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Cart badge style */
    .cart { position: relative; display: inline-block; }
    .cart-badge {
      position: absolute; top: -5px; right: -5px;
      background: red; color: white; font-size: 12px; font-weight: bold;
      padding: 2px 6px; border-radius: 50%;
    }

    /* Popup detail modal */
    .item-detail { position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center;
      z-index: 999; }
    .item-detail.hidden { display: none; }
    .detail-content { background: #fff; border-radius: 12px; max-width: 1000px; width: 90%;
      display: flex; gap: 30px; padding: 30px; position: relative; }
    #close-detail { position: absolute; top: 10px; right: 10px; border: none; background: none;
      font-size: 20px; cursor: pointer; }
    .detail-left img { max-width: 300px; border-radius: 10px; }
    .detail-right { flex: 1; }
    .detail-right h2 { font-size: 28px; margin-bottom: 10px; }
    .detail-right .food-price { font-size: 24px; color:rgb(167, 40, 40); margin-bottom: 15px; }
    .detail-right p { font-size: 16px; color: #555; margin-bottom: 20px; }
    .quantity { display: flex; align-items: center; gap: 10px; margin: 10px 0; }
    .qty-btn { padding: 5px 10px; background: #eee; border: none; cursor: pointer; font-size: 18px; }
    .add-cart { display: inline-block; padding: 12px 24px; background:rgb(168, 49, 49); color: #fff;
      border: none; border-radius: 6px; cursor: pointer; margin-top: 10px; font-size: 16px; }

    .sauce-selection { margin: 10px 0; }
    .sauce-options { display: flex; gap: 10px; }
    .sauce-btn { padding: 5px 10px; border: 1px solid #ccc; border-radius: 20px; background: #f9f9f9;
      cursor: pointer; font-size: 16px; transition: background-color 0.3s, color 0.3s; }
    .sauce-btn.active { background-color: #168131; color: #fff; border-color: #168131; }
    .sauce-btn:hover { background-color: #ddd; }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="top-header">
    <div class="logo">
      <img src="img/logo 2.png" alt="Monate Logo">
    </div>
    <nav class="nav-links">
      <a href="../HOME/index.php">HOME</a>
      <a href="../About Us/index.php">ABOUT US</a>
    </nav>
    <div class="account-cart">
      <a href="../Sign in/index.php" class="account">
        <img src="img/profile.png" alt="Account">
        <span>
          <?php if (isset($_SESSION["username"])): ?>
            Hi, <?= htmlspecialchars($_SESSION["username"]); ?>
          <?php else: ?>
            ACCOUNT
          <?php endif; ?>
        </span>
      </a>
      <div class="divider"></div>
      <!-- Cart links to cart.php with branch param -->
      <a href="<?php echo isset($_SESSION["user_id"]) 
            ? "Mukula_cart.php?branch=" . urlencode($branchLocation) 
            : '../Sign in/index.php'; ?>" class="cart">
        <img src="img/shopping cart.png" alt="Cart">
        <?php if ($cartCount > 0): ?>
          <span class="cart-badge"><?= $cartCount ?></span>
        <?php endif; ?>
      </a>
    </div>
  </header>

  <!-- LOCATION BAR -->
  <div class="location-bar">
    <a href="Mukula.php" class="location-item active">
      <img src="img/location.png" alt="Location">
      <span>MUKULA</span>
    </a>
  </div>

  <!-- MAIN MENU -->
  <main class="content">
    <aside class="side-menu">
      <h2>MENU</h2>
      <ul>
        <?php foreach ($menuItems as $category => $items): ?>
          <li data-category="<?= strtolower($category) ?>"><?= strtoupper($category) ?></li>
        <?php endforeach; ?>
      </ul>
    </aside>

    <section class="menu-section" id="menu-section">
      <?php foreach ($menuItems as $category => $items): ?>
        <h3><?= strtoupper($category) ?></h3>
        <div class="menu-grid">
          <?php foreach ($items as $item): ?>
            <div class="menu-card"
                 data-id="<?= $item['id'] ?>"
                 data-name="<?= htmlspecialchars($item['name']) ?>"
                 data-price="<?= number_format($item['price'], 2) ?>"
                 data-description="<?= htmlspecialchars($item['description']) ?>"
                 data-image="../admin/menu_item/<?= $item['image'] ?>">
              <img src="../admin/menu_item/<?= $item['image'] ?>" 
                   alt="<?= htmlspecialchars($item['name']) ?>">
              <p class="item-name"><?= htmlspecialchars($item['name']) ?></p>
              <p class="item-price">R<?= number_format($item['price'], 2) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </section>
  </main>

  <!-- ITEM DETAIL POPUP -->
  <div id="item-detail" class="item-detail hidden">
    <div class="detail-content">
      <button id="close-detail">✖</button>
      <div class="detail-left">
        <img id="detail-img" src="" alt="">
      </div>
      <div class="detail-right">
        <h2 id="detail-name"></h2>
        <p class="food-price">R<span id="detail-price"></span></p>
        <p id="detail-description"></p>

        <!-- Sauce Selection -->
        <div class="sauce-selection">
          <label>Choose Sauce:</label>
          <div class="sauce-options">
            <button type="button" class="sauce-btn" data-sauce="HOT">HOT</button>
            <button type="button" class="sauce-btn" data-sauce="MILD">MILD</button>
            <button type="button" class="sauce-btn" data-sauce="BBQ">BBQ</button>
            <button type="button" class="sauce-btn" data-sauce="NO SAUCE">NO SAUCE</button>
          </div>
        </div>

        <!-- Quantity -->
        <div class="quantity">
          <button class="qty-btn" id="minus">-</button>
          <span id="qty">1</span>
          <button class="qty-btn" id="plus">+</button>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="Mukula_add_to_cart.php" onsubmit="return validateSauceSelection()">
          <input type="hidden" name="id" id="detail-id">
          <input type="hidden" name="name" id="detail-name-input">
          <input type="hidden" name="price" id="detail-price-input">
          <input type="hidden" name="img" id="detail-img-input">
          <input type="hidden" name="qty" id="qtyInput" value="1">
          <input type="hidden" name="sauce" id="sauce-input">
          <button type="submit" class="add-cart">ADD TO CART</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const sideMenuItems = document.querySelectorAll(".side-menu li");
      const sections = document.querySelectorAll(".menu-section h3, .menu-grid");

      // Category filter
      sideMenuItems.forEach(item => {
        item.addEventListener("click", () => {
          const category = item.getAttribute("data-category").toUpperCase();
          sections.forEach(section => {
            if (section.tagName === "H3") {
              section.style.display = (section.textContent === category) ? "block" : "none";
            } else {
              section.style.display = (section.previousElementSibling.textContent === category) ? "grid" : "none";
            }
          });
          sideMenuItems.forEach(i => i.classList.remove("active"));
          item.classList.add("active");
        });
      });
      if (sideMenuItems.length > 0) sideMenuItems[0].click();

      // Popup logic
      const detail = document.getElementById("item-detail");
      const closeBtn = document.getElementById("close-detail");

      const detailId = document.getElementById("detail-id");
      const detailName = document.getElementById("detail-name");
      const detailPrice = document.getElementById("detail-price");
      const detailDesc = document.getElementById("detail-description");
      const detailImg = document.getElementById("detail-img");

      const inputName = document.getElementById("detail-name-input");
      const inputPrice = document.getElementById("detail-price-input");
      const inputImg = document.getElementById("detail-img-input");

      let qty = 1;
      const qtySpan = document.getElementById("qty");
      const qtyInput = document.getElementById("qtyInput");

      document.getElementById("plus").addEventListener("click", () => {
        if (qty < 10) qty++;
        qtySpan.textContent = qty;
        qtyInput.value = qty;
      });
      document.getElementById("minus").addEventListener("click", () => {
        if (qty > 1) qty--;
        qtySpan.textContent = qty;
        qtyInput.value = qty;
      });

      // Open detail popup
      document.querySelectorAll(".menu-card").forEach(card => {
        card.addEventListener("click", () => {
          qty = 1;
          qtySpan.textContent = qty;
          qtyInput.value = qty;

          detailId.value = card.dataset.id;
          detailName.textContent = card.dataset.name;
          detailPrice.textContent = card.dataset.price;
          detailDesc.textContent = card.dataset.description;
          detailImg.src = card.dataset.image;

          inputName.value = card.dataset.name;
          inputPrice.value = card.dataset.price;
          inputImg.value = card.dataset.image;

          detail.classList.remove("hidden");
        });
      });
      closeBtn.addEventListener("click", () => detail.classList.add("hidden"));

      // Sauce buttons
      const sauceButtons = document.querySelectorAll(".sauce-btn");
      const sauceInput = document.getElementById("sauce-input");
      sauceButtons.forEach(button => {
        button.addEventListener("click", () => {
          sauceButtons.forEach(btn => btn.classList.remove("active"));
          button.classList.add("active");
          sauceInput.value = button.dataset.sauce;
        });
      });
      window.validateSauceSelection = () => {
        if (!sauceInput.value) {
          alert("Please select a sauce before adding to cart.");
          return false;
        }
        return true;
      };
    });
  </script>
</body>
</html>
