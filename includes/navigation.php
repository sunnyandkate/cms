<div class="nav-container">
   
   <nav>
       <h2><a class="logo" href="index.php">My Blog</a></h2>
        <div class="toggle-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
      
        <div class="desktop-menu">
            <ul>               
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <li><a href="admin/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="admin/login.php">Login</a></li>
                    <li><a href="admin/register.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    
</div>
<div class="mobile-menu">
        <ul>         
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <li><a href="admin/dashboard.php">Dashboard</a></li>
                <li><a href="admin/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="admin/login.php">Login</a></li>
                <li><a href="admin/register.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
</div>