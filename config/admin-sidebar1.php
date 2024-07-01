<div class="sidebar-wrapper">
    <div class="upper">
        <div class="logo-container">
            <img class="logo" src="../assets/logo-2.svg" alt="ThirTeaAnn">
        </div>

        <ol>
            <li>
                <a class="dashboard" href="dashboard.php">
                    <img class="link-img" src="../assets/sidebar_assets/dashboard-vector.svg" alt="menu">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="hrm.php">
                    <img class="link-img" src="../assets/sidebar_assets/hrm-vector.svg" alt="staff">
                    HRM
                </a>
            </li>
            <li>
                <a href="inventory.php">
                    <img class="link-img" src="../assets/sidebar_assets/inventory-vector.svg" alt="inventory">
                    Inventory
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <img class="link-img" src="../assets/sidebar_assets/orders-vector.svg" alt="orders">
                    Orders
                </a>
            </li>
            <li>
                <a href="order-records.php">
                    <img class="link-img" src="../assets/sidebar_assets/records-vector.svg" alt="history">
                    Records
                </a>
            </li>
            <li>
                <a href="report.php">
                    <img class="link-img" src="../assets/sidebar_assets/report-vector.svg" alt="report">
                    Report
                </a>
            </li>
        </ol>
    </div>

    <a href="../config/logout.php">
        <img class="link-img" src="../assets/sidebar_assets/logout-vector.svg"> 
        Logout
    </a>
</div>

<script>
    // Get the current page URL
    var currentPage = window.location.href;

    // Add the 'active-link' class to the corresponding link
    document.addEventListener('DOMContentLoaded', function () {
        var links = document.querySelectorAll('.sidebar-wrapper a');
        links.forEach(function (link) {
            if (link.href === currentPage) {
                link.classList.add('active-link');
            }
        });
    });
</script>