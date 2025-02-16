<html>
    <head>
        <title>CSC 325 Community Service App</title>
        <link rel="stylesheet" href="inc/Styles.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include "inc/nav.php"; ?>
        <main>
            <section>
            <?php
                session_start();
                require_once 'inc/sql.php';

                if (isset($_POST['login'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = $_POST['password'];

                    try {
                        $pdo = new PDO($attr, $user, $pass, $opts);
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                        $stmt->execute([$username]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($user && password_verify($password, $user['password_hash'])) {
                            $_SESSION['user_id'] = $user['username'];
                            $_SESSION['username'] = $user['username'];
                            echo "<b>Login success</b><br>";
                            echo "Redirecting to <a href='index.php'>home</a>...";
                            header("refresh:3;url=index.php" );
                        } else {
                            echo "<b>Authentication failed!</b><br>";
                            echo "<a href='login.php'>Please try again</a>";
                            header("refresh:3;url=login.php" );
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                } else { ?>
                    <form method="post">
                        <fieldset style="display:inline;">
                            <legend>Login</legend>
                            <div>
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div>
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div>
                                <input type="submit" value="Login!" name="login">
                                <input type="submit" value="Create New Account" onclick="window.location.href = 'https://csc325.42web.io/registration.php';">
                            </div>
                        </fieldset>
                    </form>
                <?php } ?>
            </section>
        </main>
        <?php include "inc/foot.php"; ?>
    </body>
</html>