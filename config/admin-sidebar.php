<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--========== BOX ICONS ==========-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!--========== CSS ==========-->
        
        <link rel="stylesheet" href="../styles/staff-sidebar.css">
        

        <title>Responsive sidebar submenus</title>
    </head>
    <body>
        <!--========== HEADER ==========-->
        <header class="header">
            <div class="main-header d-flex justify-content-between w-100 p-3">
                <i class='bx bx-wine nav__icon' class="header__img"></i>
                <a href="#" class="header__logo">Thir Tea Ann</a>
                <div class="header__toggle">
                    <i class='bx bx-menu' id="header-toggle"></i>
                </div>
            </div>
        </header>

        <!--========== NAV ==========-->
        <div class="nav" id="navbar">
            <nav class="nav__container">
                <div>
                    <a href="#" class="nav__link nav__logo">
                    <i class='bx bx-wine nav__icon'></i>
                        <span class="nav__logo-name">Thir Tea Ann</span>
                    </a>
    
                    <div class="nav__list">
                        <div class="nav__items">
                            <!-- <h3 class="nav__subtitle">Profile</h3> -->
    
                            <a href="dashboard.php" class="nav__link active">
                                <i class='bx bxs-dashboard nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>

                            <a href="hrm.php" class="nav__link">
                            <i class='bx bx-edit-alt nav__icon'></i>
                                <span class="nav__name">HRM</span>
                            </a>

                            <a href="inventory.php" class="nav__link">
                            <i class='bx bx-box nav__icon'></i>
                                <span class="nav__name">Inventory</span>
                            </a>
                            
                            <div class="nav__dropdown">
                                <a href="orders.php" class="nav__link">
                                    <i class='bx bx-user nav__icon' ></i>
                                    <span class="nav__name">Orders</span>
                                    <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                                </a>    

                                <div class="nav__dropdown-collapse">
                                    <div class="nav__dropdown-content">
                                        <a href="orders.php" class="nav__dropdown-item">Orders</a>
                                        <a href="order-records.php" class="nav__dropdown-item">Orders Record</a>
                                    </div>
                                </div>
                            </div>

                            <a href="report.php" class="nav__link">
                            <i class='bx bxs-report nav__icon'></i>
                                <span class="nav__name">Report</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="../config/logout.php" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>
        <!--========== MAIN JS ==========-->
        <script src="../assets/js/sidebar.js"></script>
    </body>
</html>