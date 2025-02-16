<html>
    <head>
        <title>CSC 325 Community Service App</title>
        <link rel="stylesheet" href="inc/Styles.css">
        <script>
            function validate(form) {
                fail  = validateEmail(form.email.value)
                fail += validateUsername(form.username.value)
                fail += validatePassword(form.password.value)
                fail += validateMatch(form.password.value, form.confirm_password.value)
                if   (fail == "")   return true
                else { alert(fail); return false }
            }
            function validateUsername(field) {
                if (field == "") return "No Username was entered.\n"
                else if (field.length < 5)
                    return "Usernames must be at least 5 characters.\n"
                else if (/[^a-zA-Z0-9_-]/.test(field))
                    return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
                return ""
            }
            function validateEmail(field) {
                if (field == "") return "No Email was entered.\n"
                else if (!((field.indexOf(".") > 0) &&
                     (field.indexOf("@") > 0)) ||
                     /[^a-zA-Z0-9.@_-]/.test(field))
                return "The Email address is invalid.\n"
                return ""
            }
            function validatePassword(field) {
                if (field == "") return "No Password was entered.\n"
                else if (field.length < 6)
                    return "Passwords must be at least 6 characters.\n"
                else if (! /[a-z]/.test(field) ||
                         ! /[A-Z]/.test(field) ||
                         ! /[0-9]/.test(field))
                    return "Passwords require one each of a-z, A-Z and 0-9.\n"
                return ""
            }
            function validateMatch(field1, field2) {
                if (field1 != field2) return "Password and confirm password do not match.\n"
                return ""
            }
        </script>
    </head>
    <body>
        <?php include "inc/nav.php"; ?>
        <main>
            <section>
            <?php
                require_once 'inc/sql.php';

                if (isset($_POST['register'])) {
                    $email = htmlspecialchars($_POST['email']);
                    $username = htmlspecialchars($_POST['username']);
                    $password = $_POST['password'];
                    $confirm_password = $_POST['confirm_password'];

                    function validateEmail($field) {
                        if ($field == "") return "No Email was entered<br>";
                        else if (!((strpos($field, ".") > 0) &&
                                (strpos($field, "@") > 0)) ||
                                preg_match("/[^a-zA-Z0-9.@_-]/", $field))
                        return "The Email address is invalid<br>";
                        return "";
                    }
                    function validateUsername($field) {
                        if ($field == "") return "No Username was entered<br>";
                        else if (strlen($field) < 5)
                            return "Usernames must be at least 5 characters<br>";
                        else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
                            return "Only letters, numbers, - and _ in usernames<br>";
                        return "";		
                    }
                    function validatePassword($field) {
                        if ($field == "") return "No Password was entered<br>";
                        else if (strlen($field) < 6)
                            return "Passwords must be at least 6 characters<br>";
                        else if (!preg_match("/[a-z]/", $field) ||
                                !preg_match("/[A-Z]/", $field) ||
                                !preg_match("/[0-9]/", $field))
                            return "Passwords require 1 each of a-z, A-Z and 0-9<br>";
                        return "";
                    }
                    function validateMatch($field1, $field2) {
                        if ($field1 != $field2) return "Password and confirm password do not match.<br>";
                        return "";
                    }

                    $fail  = validateEmail($email);
                    $fail .= validateUsername($username);
                    $fail .= validatePassword($password);
                    $fail .= validateMatch($password, $confirm_password);

                    if ($fail == "") {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        try {
                            $pdo = new PDO($attr, $user, $pass, $opts);

                            $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
                            $stmt->execute([$username]);
                            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($userExists) {
                                echo "<b>Unsuccessful registration</b>: username is already taken!<br>";
                                echo "<a href='index.php'>Please try again</a>";
                            } else {
                                $stmt = $pdo->prepare("INSERT INTO users (email, username, password_hash) VALUES (:email, :username, :pass)");
                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':username', $username);
                                $stmt->bindParam(':pass', $hashed_password);
                                $stmt->execute();
                                echo "Registration successful!";
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else {
                        echo $fail;
                    }
                } else { ?>
                    <form method="post" onsubmit="return validate(this)">
                        <fieldset style="display:inline;">
                            <legend>Registration</legend>
                            <div>
                                <label for="email">Email Address:</label>
                                <input type="text" id="email" name="email" required>
                            </div>
                            <div>
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div>
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <div>
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                            <div>
                                <input type="submit" value="Register!" name="register">
                            </div>
                        </fieldset>
                    </form>
                <?php } ?>
            </section>
        </main>
        <?php include "inc/foot.php"; ?>
    </body>
</html>