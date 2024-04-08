<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN</title>

  <link href="img/ui.ico" rel="icon">
  <link href="img/ui.ico" rel="ui.ico">

  <!-- Favicons -->
  <link href="img/ui.ico" rel="icon">
  <link href="img/ui.ico" rel="ui.ico">

  <!-- Custom fonts for this template-->
  <link href="/capstone/dashboard/dashboard_admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <!-- Custom styles for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <style>
    html {
      height: 100%;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background:linear-gradient(305deg, rgba(9,32,121,1) 75%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454));
    }

    .login-box {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 400px;
      padding: 40px;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, .5);
      box-sizing: border-box;
      box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
      border-radius: 10px;
    }

    .login-box h2 {
      margin: 0 0 30px;
      padding: 0;
      color: #fff;
      text-align: center;
    }

    .login-box .user-box {
      position: relative;
    }

    .login-box .user-box input {
      width: 100%;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      margin-bottom: 30px;
      border: none;
      border-bottom: 1px solid #fff;
      outline: none;
      background: transparent;
    }

    .login-box .user-box label {
      position: absolute;
      top: 0;
      left: 0;
      padding: 10px 0;
      font-size: 16px;
      color: #fff;
      pointer-events: none;
      transition: .5s;
    }

    .login-box .user-box input:focus~label,
    .login-box .user-box input:valid~label {
      top: -20px;
      left: 0;
      color: white;
      font-size: 12px;
    }

    .login-box form button {
      position: relative;
      display: inline-block;
      padding: 10px 20px;
      color: white;
      font-size: 16px;
      text-decoration: none;
      text-transform: uppercase;
      overflow: hidden;
      transition: .5s;
      margin-top: 40px;
      letter-spacing: 4px;
      border: none;
      background-color: transparent;
      cursor: pointer;
    }

    .login-box button:hover {
      color: green;
    }

    .login-box button span {
      position: absolute;
      display: block;
    }

    .login-box button span:nth-child(1),
    .login-box button span:nth-child(2),
    .login-box button span:nth-child(3),
    .login-box button span:nth-child(4) {
      position: absolute;
      display: block;
      width: 100%;
      height: 2px;
      background-color: yellow;
      animation: btn-anim 1s infinite;
    }

    .login-box button span:nth-child(1) {
      top: 0;
      left: -100%;
      animation-delay: 0s;
    }

    .login-box button span:nth-child(2) {
      top: -100%;
      left: 0;
      animation-delay: 0.25s;
    }

    .login-box button span:nth-child(3) {
      top: 100%;
      left: 0;
      animation-delay: 0.5s;
    }

    .login-box button span:nth-child(4) {
      top: 0;
      left: 100%;
      animation-delay: 0.75s;
    }

    @keyframes btn-anim {
      0% {
        left: -100%;
      }

      25% {
        left: 0;
      }

      50% {
        left: 100%;
      }

      75% {
        left: 0;
      }

      100% {
        left: -100%;
      }
    }
  </style>
</head>

<body>

  <div class="login-box">
    <h2>Library Admin Login</h2>
    <form action="process_admin.php" method="POST">
      <div class="user-box">
        <input type="email" name="log_email" required="">
        <label>Email address</label>
      </div>
      <div class="user-box">
        <input type="password" name="log_password" required="">
        <label>Password</label>
      </div>
      <button type="submit">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Submit
      </button>
    </form>
  </div>

</body>

</html>