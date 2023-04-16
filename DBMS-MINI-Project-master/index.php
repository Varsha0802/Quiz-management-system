<?php session_start(); ?>
<html>

<head>
    <title>Online Quiz System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php
if (isset($_POST['login'])) {
    if (isset($_POST['usertype']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass'])) {
        require_once 'sql.php';
        $conn = mysqli_connect($host, $user, $ps, $project);
        if (!$conn) {
            echo "<script>alert(\"Database error retry after some time !\")</script>";
        }
        $type = mysqli_real_escape_string($conn, $_POST['usertype']);
        $ma = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        // $password = crypt($password, 'rakeshmariyaplarrakesh');
        $sql = "select * from " . $type . " where mail='{$ma}'";
        $res = mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbpw = $row['pw'];
                $dbmail = $row['mail'];
                $_SESSION["name"] = $row['name'];
                $_SESSION["type"] = $type;
                $_SESSION["ma"] = $dbmail;
            }
            if ($dbpw === $password) {
                if ($type === 'student') {
                    header("location:homestud.php");
                } elseif ($type === 'staff') {
                    header("Location: homestaff.php");
                }
            } elseif ($dbpw !== $password && $dbmail === $ma) {
                echo "<script>alert('password is wrong');</script>";
            } elseif ($dbpw !== $password && $dbmail !== $ma) {
                echo "<script>alert('username name not found please sign up');</script>";
            }
        }
    }
}
?>
<style>
    @media screen and (max-width: 620px) {
        input {
            height: 6vw !important;
        }

        .seluser {
            display: grid;
        }

        .sub {
            width: 20vw !important;
        }
    }

    .inp {
        box-sizing: content-box !important;
        width: 30vw;
        height: 3vw;
        border-radius: 10px;
        border: 2px solid black;
        padding-left: 2vw;
        font-weight: bolder;
        outline: none;
    }

    ::placeholder {
        font-weight: bold;
        font-family: 'Courier New', Courier, monospace;
    }

    label {
        font-weight: bolder;
        font-size: 1.5vw;
    }

    form {
        font-size: 1.5vw;
        margin: 0;
    }

    button:hover {
        background-color: #fff !important;
    }

    .bg {
        background-size: 100%;
    }

    a {
        color: #042A38;
    }

    .login {
        max-height: 70vh;
    }
</style>

<body style="margin:0;height: 100%;ouline:none;color: #042A38f !important;padding-botton:5vw;">
    <div class="bg" style="font-weight: bolder;background-image: url(./images/background.jpg);background-repeat: no-repeat;padding: 0;margin: 0;background-size: cover;font-family: opacity: 0.9; height: 130%;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style ="text-align: center;">
            <a class="navbar-brand" href="index.php" style="text-decoration: none; text-align: center;">
                <h1 class="w3-container" style=" color:#042A38;text-transform: uppercase;width: auto;background:#fff;padding: 1vw; text-decoration: none;"> ONLINE QUIZ SYSTEM</h1>
            </a>
        </nav>

            <div class="w3-card" class="login"
                style="color: #042A38;width: 40vw;background-color: #ffffffab;border: 2px solid black;padding: 2vw;font-weight: bolder;margin-top: 3vh; margin-bottom: 20%; border-radius: 10px; float: right; margin-right:50px">
                <form method="POST">
                    <div class="seluser" style ="text-align: center" >
                        <input type="radio" name="usertype" value="student" required>STUDENT &nbsp; &nbsp; &nbsp;
                        <input type="radio" name="usertype" value="staff" required>STAFF
                    </div><br><br>
                    <div class="signin">
                        <label for="email" style="text-transform: uppercase;">Email</label><br><br>
                        <input type="text" name="email" placeholder="" class="inp" required>
                        <br><br>
                        <label for="username" style="text-transform: uppercase;">ID</label><br><br>
                        <input type="text" name="username" placeholder="" class="inp" required>
                        <br><br>
                        <label for="password" style="text-transform: uppercase;">Password</label><br><br>
                        <input type="password" name="pass" placeholder="******" class="inp" required>
                        <br><br>
                        <input name="login" class="sub" type="submit" value="Login"
                            style="height: 3vw;width: 10vw;font-family: 'Courier New', Courier, monospace;font-weight: bolder;border-radius: 10px;border: 2px solid black;background-color:lightblue"><br>
                </form><br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="signup.php" style= " text-decoration: none"> New user! SIGN UP</a>
            </div>
        
    </div>
</div>
<?php require("footer.php"); ?>
</body>

</html>