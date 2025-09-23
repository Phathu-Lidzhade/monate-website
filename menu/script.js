document.addEventListener("DOMContentLoaded", () => {
    const sideMenuItems = document.querySelectorAll(".side-menu li");
    const menuSection = document.getElementById("menu-section");
  
    const menuData = {
      chicken: [
        { name: "HOT FRIED CHICKEN", price: "R30", img: "img/38b39197551d5de6ffa145c8759d35e9 1.png" },
        { name: "SPICY GRILLED CHICKEN", price: "R45", img: "img/38b39197551d5de6ffa145c8759d35e9 1.png" },
        { name: "BBQ CHICKEN", price: "R40", img: "img/38b39197551d5de6ffa145c8759d35e9 1.png" }
      ],
      kota: [
        { name: "FULL KOTA", price: "R40", img: "img/kota.png" },
        { name: "HALF KOTA", price: "R25", img: "img/kota.png" }
      ],
      sharing: [{ name: "FAMILY MEAL", price: "R120", img: "img/sharing.png" }],
      wings: [
        { name: "SPICY WINGS (6pc)", price: "R35", img: "img/wings.png" },
        { name: "BBQ WINGS (6pc)", price: "R35", img: "img/wings.png" }
      ],
      drinks: [
        { name: "COKE 500ml", price: "R15", img: "img/drink.png" },
        { name: "SPRITE 500ml", price: "R15", img: "img/drink.png" }
      ]
    };
  
    // Handle side menu clicks
    sideMenuItems.forEach(item => {
      item.addEventListener("click", () => {
        sideMenuItems.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
  
        const category = item.getAttribute("data-category");
        const items = menuData[category];
  
        menuSection.innerHTML = `<h3>${category.toUpperCase()}</h3><div class="menu-grid"></div>`;
        const grid = menuSection.querySelector(".menu-grid");
  
        items.forEach(food => {
          const card = document.createElement("div");
          card.classList.add("menu-card");
          card.setAttribute("data-name", food.name);
          card.setAttribute("data-price", food.price);
          card.setAttribute("data-img", food.img);
  
          card.innerHTML = `
            <img src="${food.img}" alt="${food.name}">
            <p class="item-name">${food.name}</p>
            <p class="item-price">${food.price}</p>
          `;
  
          // Make cards clickable
          card.addEventListener("click", () => {
            localStorage.setItem("foodItem", JSON.stringify(food));
            window.location.href = "food.html";
          });
  
          grid.appendChild(card);
        });
      });
    });
  
    // Make initial menu item clickable too
    document.querySelectorAll(".menu-card").forEach(card => {
      card.addEventListener("click", () => {
        const food = {
          name: card.getAttribute("data-name"),
          price: card.getAttribute("data-price"),
          img: card.getAttribute("data-img")
        };
        localStorage.setItem("foodItem", JSON.stringify(food));
        window.location.href = "food.html";
      });
    });
  });
  