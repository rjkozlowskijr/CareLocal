<header>
    <h1>CSC 325 Community Service App</h1>
    <nav>        
        <a href="index.php">Home</a>
        <a href="news.php">News Bulletin</a>
        <a href="reports.php">Engagement Reports</a>
        <?php
            session_start();
            if (!isset($_SESSION['username'])) {
                echo "<a href='login.php'>Login</a>";
            } else {
                echo "<a href='logout.php'>Logout : " . $_SESSION['username'] . "</a>";
            }
        ?>
    </nav>
</header>
