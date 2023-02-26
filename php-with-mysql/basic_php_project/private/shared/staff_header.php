<header>
    <h1>GBI - Staff Area</h1>
</header>

<body>

    <nav>
        <ul>
            <li>User:
                <?php echo $_SESSION['username'] ?? '' ?>
            </li>
            <li>
                <?php echo $_SESSION['status'] ?? '';
                unset($_SESSION['status']); ?>
            </li>
            <li> <a href="<?php echo url_for('/staff/index.php') ?>" class="ref">Menu</a></li>
            <li> <a href="<?php echo url_for('/staff/logout.php') ?>" class="ref">Logout</a></li>
        </ul>
    </nav>