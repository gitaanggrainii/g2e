<?php
session_start();

include '../header/header_login.php'; ?>

        <div class="container">
            <span class="icon-close"><a href="makeup.php"><ion-icon name="close"></ion-icon></a></span>
            <div class="form-login">
                <h2> Login</h2>
                <form action="login_process.php" method="POST">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember Me</label>
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="login-register">
                        <p> Don't have an account? <a href="Regis.php" class="register-link">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include '../footer/footer_login.php'; ?>