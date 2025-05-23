
<?php include '../header/header_forgot.php'?>
    <div class="container">
      <span class="icon-close"><a href="Login.php"><ion-icon name="close"></ion-icon></a></span>
      <div class="form-login">
        <h2>Forgot Password</h2>
        <form action="send_reset_link.php" method="POST">
          <div class="input-box">
            <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
            <input type="email" name="email" required>
            <label>Email</label>
          </div>
          <button type="submit" class="btn">Send Reset Link</button>
        </form>
      </div>
    </div>
  </div>

<?php include '../footer/footer.php'?>