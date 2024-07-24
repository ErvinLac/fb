<?php
// Include configuration
require_once '../retailer/config.php';

// Establishing connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch user from database
    $sql = "SELECT * FROM useraccounts WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, now validate the password
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, do something (e.g., redirect)
            header("Location: productview.php");
            exit();
        } else {
            echo "Error: Invalid password.";
        }
    } else {
        echo "Error: User not found.";
    }
}

// Close MySQL connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 850px;
            height: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .body {
            display: flex;
            width: 100%;
            height: 550px;
            border: 1px solid #ddd;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.7); /* Add glow effect */
            transition: box-shadow 0.3s ease-in-out;
        }

        .body:hover {
            box-shadow: 0 0 30px rgba(0, 123, 255, 1); /* Intensify glow effect on hover */
        }

        .box-1 {
            flex: 1;
        }

        .box-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .box-2 {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9); /* White with transparency */
            border-radius: 10px; /* Add border-radius for a smooth look */
        }

        .login-form {
            width: 100%;
            max-width: 350px;
            text-align: center;
            margin-top: -80px;
        }

        .login-form img {
            width: 300px; 
            height: auto; 
            margin-bottom: 20px;
            margin-top: -50px;
            margin-left: -10px;
        }

        .login-form h3 {
            margin-bottom: 30px;
            margin-top: -100px;
            font-weight: 700;
            font-size: 20px;
            color: black;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .login-form .input-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .login-form .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 12px;
        }

        .login-form .input-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .login-form .btn {
            width: 100%;
            padding: 10px;
            background-color: #800080;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .login-form .btn:hover {
            background-color: #663399;
        }

        .login-form .input-group label {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 8px;
            font-weight: 400;
            color: black;
            font-size: 14px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666; 
        }

        .login-form p {
            color: black;
            font-size: 14px;
        }

        .login-form p a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="body">
            <div class="box-1">
                <img src="bg2.jpg">
            </div>
            <div class="box-2">
                <div class="login-form">
                    <img src="logo.png" alt="coNEXTion Technology">
                    <h3>Login your account</h3>
                    <form method="post" action="productview.php">
                        <div class="input-group">
                            <label for="InputEmail1">Email address</label>
                            <input type="email" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                        </div>
                        <div class="input-group">
                            <label for="InputPassword1">Password</label>
                            <div style="position: relative;">
                                <input type="password" id="exampleInputPassword1" name="password" placeholder="Password" required>
                                <span class="toggle-password">
                                    <i class="fas fa-eye-slash" id="eye-icon-confirm"></i>
                                    <i class="fas fa-eye" id="eye-slash-icon-confirm" style="display:none;"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group text-center">
                            <button type="submit" class="btn">Submit</button>
                        </div>
                        <div style="font-size: 15px; margin-top: 60px; text-align: center;">
                            <p>Don't have an account yet? <a href="registration.php">Sign-Up</a></p>
                            <?php
                            //for Google Login button
                                require_once 'config.php';
                                if (isset($_SESSION['user_token'])) {
                                    header("Location: admin_displaydata.php");
                                } else {
                                    echo "<a href='" . $client->createAuthUrl() . "'><button type=\"button\" name=\"btnSearch\" class=\"btn btn-primary px-5\" style=\"background: #1C6CFF; color: #fff;\">Google Login</button></a>";
                                }
                            ?>
                            <!-- Facebook Login button -->
                            <a href="http://localhost/SIA/retailer/login.php"><button type="button" id="btnFacebookLogin" class="btn btn-primary px-5" style="background: #3b5998; color: #fff; margin-top: 10px;">Log in with Facebook</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://odn.jsdelivr.net/npm/bootstrao@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-McrW6ZMFY"></script>
    
    <!-- Include Font Awesome JS if needed for further functionality -->
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('exampleInputPassword1');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.add('fa-eye');
                icon.classList.remove('fa-eye-slash'); // Add slash in the eye icon
            } else {
                passwordInput.type = 'password';
                icon.classList.add('fa-eye-slash');
                icon.classList.remove('fa-eye'); // Remove slash in the eye icon
            }
    });
</script>
</body>
</html>
