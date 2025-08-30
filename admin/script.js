// ---------- Static pages ----------
const pages = {
    dashboard: `<h2>Dashboard Overview</h2><p>This is your dashboard.</p>`,
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
                        <th>Sauce</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="menuTableBody">
                    <tr>
                        <td><img src="img/sample.jpg" style="width:50px; height:50px; object-fit:cover; border-radius:4px;"></td>
                        <td>Burger</td>
                        <td>R 50.00</td>
                        <td>Juicy beef burger</td>
                        <td>BBQ</td>
                        <td>
                            <button class="btn-warning">Edit</button>
                            <button class="btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    `,
    addMenu: `
        <h2>Add New Menu Item</h2>
        <div class="card">
            <form id="menuForm">
                <label>Dish Name:</label>
                <input type="text" name="name" required>

                <label>Price (R):</label>
                <input type="number" name="price" step="0.01" required>

                <label>Description:</label>
                <textarea name="description" rows="3"></textarea>

                <label>Choose Sauce:</label>
                <select name="sauce">
                    <option value="Hot">Hot</option>
                    <option value="Mild">Mild</option>
                    <option value="BBQ">BBQ</option>
                    <option value="Garlic">Garlic</option>
                </select>

                <label>Upload Image:</label>
                <input type="file" name="image" accept="image/*">

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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="ordersBody">
                    ${[
                        {id:'#001', customer:'John Doe', items:'BBQ Burger x1', total:'75.00', status:'Pending'},
                        {id:'#002', customer:'Mary Smith', items:'Hot Wings x2', total:'120.00', status:'Ready'},
                        {id:'#003', customer:'Lerato M.', items:'Chicken Wrap x1, Fries x1', total:'95.00', status:'Delivered'}
                    ].map(o => `
                        <tr class="order-row">
                            <td>${o.id}</td>
                            <td>${o.customer}</td>
                            <td>${o.items}</td>
                            <td>${o.total}</td>
                            <td>
                                <div class="status-cell">
                                    <span class="badge ${statusClass(o.status)} js-status">${o.status}</span>
                                    <select class="status-select" aria-label="Change status">
                                        <option value="Pending" ${o.status==='Pending' ? 'selected':''}>Pending</option>
                                        <option value="Ready" ${o.status==='Ready' ? 'selected':''}>Ready</option>
                                        <option value="Delivered" ${o.status==='Delivered' ? 'selected':''}>Delivered</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
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
            const cell = this.closest('.status-cell');
            const badge = cell.querySelector('.js-status');
            const newVal = this.value;
            badge.textContent = newVal;
            badge.classList.remove('status-pending','status-ready','status-delivered');
            badge.classList.add(statusClass(newVal));
        });
    });
}

// ---------- Customers page ----------
function renderCustomers() {
    const customersData = [
        { name: "John Doe", email: "john@example.com", phone: "072-123-4567", orders: 5 },
        { name: "Mary Smith", email: "mary@example.com", phone: "082-987-6543", orders: 2 },
        { name: "Lerato M.", email: "lerato@example.com", phone: "079-555-1234", orders: 8 }
    ];

    return `
        <h2>Customers</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Total Orders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${customersData.map(c => `
                        <tr>
                            <td>${c.name}</td>
                            <td>${c.email}</td>
                            <td>${c.phone}</td>
                            <td>${c.orders}</td>
                            <td>
                                <button class="btn-warning">View</button>
                                <button class="btn-danger">Delete</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
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
                initOrdersPage();
            } 
            else if (page === 'customers') {
                mainContent.innerHTML = renderCustomers();
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
        });
    });
});

// Hide loader after initial page load
window.addEventListener("load", function () {
    loader.style.opacity = "0";
    setTimeout(() => loader.style.display = "none", 300);
});
