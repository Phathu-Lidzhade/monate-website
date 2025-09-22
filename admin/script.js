// ---------- Static pages ----------
const pages = {
    dashboard: `
    <h2>Welcome, Admin!</h2>
    <p>Email: ${adminData.email}</p>
    <p>Branch: ${adminData.branch}</p>
    <p>Select a menu item to view its content here.</p>
`,
    reports: `<h2>Reports</h2><p>Charts and reports will be shown here.</p>`,
    settings: `<h2>Settings</h2><p>Adjust your preferences here.</p>`
};

// ---------- Menu Management sub-pages ----------
const subPages = {
    currentMenu: `
    <h2>Current Menu Items</h2>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Dish Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="menuTableBody"></tbody>
        </table>
    </div>
`,
    addMenu: `
    <h2>Add New Menu Item</h2>
    <div class="card">
        <form id="menuForm" action="add_menu_item.php" method="POST" enctype="multipart/form-data">
            <label>Dish Name:</label>
            <input type="text" name="name" required>

            <label>Price (R):</label>
            <input type="number" name="price" step="0.01" required>

            <label>Description:</label>
            <textarea name="description" rows="3"></textarea>

            <label>Category:</label>
            <select name="category" required>
                <option value="CHICKEN">CHICKEN</option>
                <option value="KOTA">KOTA</option>
                <option value="SHARING">SHARING</option>
                <option value="WINGS">WINGS</option>
                <option value="DRINKS">DRINKS</option>
            </select>

            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit" class="btn-accent">Add Menu Item</button>
        </form>
    </div>
`
};

// ---------- Orders page ----------
function renderOrders() {
    return `
        <h2>Orders</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Item(s)</th>
                        <th>Total (R)</th>
                        <th>Address & Instructions</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody id="ordersBody"></tbody>
            </table>
        </div>
    `;
}

function loadOrders() {
    fetch("fetch_orders.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("ordersBody");
            tbody.innerHTML = "";
            data.forEach(o => {
                tbody.innerHTML += `
                    <tr>
                        <td>${o.id}</td>
                        <td>${o.customer}</td>
                        <td>${o.items}</td>
                        <td>${o.total}</td>
                        <td>
                            ${o.address ? `<div><strong>Address:</strong> ${o.address}</div>` : ""}
                            ${o.instructions ? `<div><strong>Note:</strong> ${o.instructions}</div>` : ""}
                        </td>
                        <td>
                            <div class="status-cell">
                                <span class="badge ${statusClass(o.status)} js-status">${o.status}</span>
                                <select class="status-select" data-id="${o.id}">
                                    <option value="Pending" ${o.status==='Pending' ? 'selected':''}>Pending</option>
                                    <option value="Ready" ${o.status==='Ready' ? 'selected':''}>Ready</option>
                                    <option value="Delivered" ${o.status==='Delivered' ? 'selected':''}>Delivered</option>
                                </select>
                            </div>
                        </td>
                        <td>${o.created_at}</td>
                    </tr>
                `;
            });
            initOrdersPage();
        })
        .catch(err => console.error("Error loading orders:", err));
}

function statusClass(value) {
    const map = {
        'Pending': 'status-pending',
        'Ready': 'status-ready',
        'Delivered': 'status-delivered'
    };
    return map[value] || 'status-pending';
}

function initOrdersPage() {
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.addEventListener('change', function () {
            const newVal = this.value;
            const cell = this.closest('.status-cell');
            const badge = cell.querySelector('.js-status');
            const orderId = this.dataset.id;

            // Optimistic UI update
            badge.textContent = newVal;
            badge.className = `badge ${statusClass(newVal)} js-status`;

            // Send to backend
            fetch("update_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${orderId}&status=${encodeURIComponent(newVal)}`
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert("Failed to update order status: " + (data.error || "Unknown error"));
                }
            })
            .catch(err => {
                console.error("Error updating status:", err);
                alert("Error updating order status.");
            });
        });
    });
}

// ---------- Customers page ----------
function renderCustomers() {
    return `
        <h2>Customers</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Orders Made</th>
                        <th>Total Spent (R)</th>
                    </tr>
                </thead>
                <tbody id="customersBody"></tbody>
            </table>
        </div>
    `;
}

function loadCustomers() {
    fetch("fetch_customers.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("customersBody");
            tbody.innerHTML = "";
            data.forEach(c => {
                tbody.innerHTML += `
                    <tr>
                        <td>${c.id}</td>
                        <td>${c.username}</td>
                        <td>${c.email}</td>
                        <td>${c.mobile}</td>
                        <td>${c.orders_made}</td>
                        <td>R${c.total_spent}</td>
                    </tr>
                `;
            });
        })
        .catch(err => console.error("Error loading customers:", err));
}

// ---------- NEW: Menu Items ----------
function loadMenuItems() {
    fetch("fetch_menu_items.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("menuTableBody");
            tbody.innerHTML = "";
            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td><img src="menu_item/${item.image}" alt="${item.name}" style="width:60px; height:60px; object-fit:cover;"></td>
                        <td>${item.name}</td>
                        <td>R${parseFloat(item.price).toFixed(2)}</td>
                        <td>${item.description || ""}</td>
                        <td>${item.category || ""}</td>
                        <td><button onclick="deleteMenuItem(${item.id})">Delete</button></td>
                    </tr>
                `;
            });
        })
        .catch(err => console.error("Error loading menu items:", err));
}

function deleteMenuItem(id) {
    if (!confirm("Are you sure you want to delete this item?")) return;
    fetch(`delete_menu_item.php?id=${id}`)
        .then(res => res.text())
        .then(msg => {
            alert(msg);
            loadMenuItems();
        })
        .catch(err => console.error("Error deleting item:", err));
}

// ---------- Navigation + loader ----------
const navLinks = document.querySelectorAll(".nav > a[data-page]");
const submenuLinks = document.querySelectorAll(".submenu a");
const menuBtn = document.getElementById("menuManagementBtn");
const submenu = document.getElementById("menuSubmenu");
const mainContent = document.getElementById("main-content");
const loader = document.getElementById("loader");

function showLoaderThen(renderFn) {
    loader.style.display = "flex";
    loader.style.opacity = "1";
    setTimeout(() => {
        renderFn();
        loader.style.opacity = "0";
        setTimeout(() => loader.style.display = "none", 300);
    }, 350);
}

navLinks.forEach(link => {
    link.addEventListener("click", e => {
        e.preventDefault();
        navLinks.forEach(l => l.classList.remove("active"));
        link.classList.add("active");
        submenuLinks.forEach(s => s.classList.remove("active"));

        const page = link.getAttribute("data-page");

        showLoaderThen(() => {
            if (page === 'orders') {
                mainContent.innerHTML = renderOrders();
                loadOrders();
            } 
            else if (page === 'customers') {
                mainContent.innerHTML = renderCustomers();
                loadCustomers();
            }
            else {
                mainContent.innerHTML = pages[page] || "<p>Page not found.</p>";
            }
        });
    });
});

menuBtn.addEventListener("click", e => {
    e.preventDefault();
    submenu.classList.toggle("show");
    submenuLinks.forEach(s => s.classList.remove("active"));
    submenuLinks[0].classList.add("active");
    showLoaderThen(() => {
        mainContent.innerHTML = subPages["currentMenu"];
        loadMenuItems();
    });
});

submenuLinks.forEach(link => {
    link.addEventListener("click", e => {
        e.preventDefault();
        submenuLinks.forEach(s => s.classList.remove("active"));
        link.classList.add("active");
        const sub = link.getAttribute("data-subpage");
        showLoaderThen(() => {
            mainContent.innerHTML = subPages[sub];
            if (sub === "currentMenu") loadMenuItems();
        });
    });
});

// Hide loader after initial page load
window.addEventListener("load", function () {
    loader.style.opacity = "0";
    setTimeout(() => loader.style.display = "none", 300);
});

// ---------- Account Dropdown ----------
const accountBtn = document.getElementById("accountBtn");
const accountDropdown = document.getElementById("accountDropdown");

accountBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    accountDropdown.classList.toggle("show");
});

window.addEventListener("click", () => {
    accountDropdown.classList.remove("show");
});
