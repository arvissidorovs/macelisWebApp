<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="img/maceklis_logo.ico" type="image/jpg" rel="shortcut icon" />
</head>

<body>
    <form action="login2.php" method="post">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <span class="login100-form-title p-b-26">
                        <img src="../img/maceklis_logo.png" />
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="username" required>
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password"
                        style="margin-bottom: 25px !important">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <?php
          session_start();
          if (isset($_SESSION['error'])): ?>
                    <div class="txt3">
                        <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']); // Clear the error message
              ?>
                    </div>
                    <?php endif; ?>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Neesi reģistrējies?
                        </span>

                        <a class="txt2" href="../sign-in/sign-in.html">
                            Reģistrējies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="dropDownSelect1"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.input100');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value !== '') {
                    this.classList.add('has-val');
                } else {
                    this.classList.remove('has-val');
                }
            });
        });
    });

    function onGoogleSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        var id_token = googleUser.getAuthResponse().id_token;
        // Send id_token to server for verification and user creation/sign-in
    }
    </script>
</body>

</html>