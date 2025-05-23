<?php include '../header/header_regis.php'; ?>
        <div class="container">
            <span class="icon-close"><a href="makeup.php"><ion-icon name="close"></ion-icon></a></span>
            <div class="form-login">
                <h2> Register</h2>
                <form action="register_process.php" method="POST" onsubmit="return validateForm()">
                    <div id="notif" style="color:red; margin-bottom: 10px;"></div>
                
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <input type="text" name="username" id="username" required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" name="email" id="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" id="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" id="terms" required> Agree to the terms & conditions</label>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="login-register">
                        <p> Already have an account? <a href="Login.php"> Login</a></p>
                    </div>
                </form>             
            </div>
        </div>
    </div>
    <script src="../js/Regis.js"></script>
<?php include '../footer/footer_regis.php'; ?>