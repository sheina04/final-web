<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest Assured</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      display: flex;
      height: 100vh;
      background-color: #f7f2eb;
    }

    /* Left section with candles */
    .left {
      flex: 1;
      background: url('candles.jpeg') no-repeat center center;
      background-size: cover;
    }

    /* Right section with login form */
    .right {
      flex: 1;
      background-color: #f7f2eb;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-container {
      max-width: 400px;
      width: 100%;
      text-align: center;
      color: #5c3b28;
    }

    .login-container img {
      width: 40px;
      margin-bottom: 10px;
    }

    .login-container h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }

    .login-container p {
      margin: 0.2rem 0 1.5rem;
      font-size: 0.9rem;
      color: #6f4f37;
    }

    .input-group {
      text-align: left;
      margin-bottom: 1rem;
    }

    .input-group label {
      font-size: 0.85rem;
      font-weight: 500;
      display: block;
      margin-bottom: 0.3rem;
    }

    .input-group input {
      width: 100%;
      padding: 12px;
      border-radius: 15px;
      border: 1px solid #b9a897;
      font-size: 0.9rem;
      outline: none;
    }

    .forgot {
      text-align: right;
      font-size: 0.8rem;
      margin-top: -0.8rem;
      margin-bottom: 1rem;
      color: #6f4f37;
      cursor: pointer;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #6f4f37;
      color: white;
      border: none;
      border-radius: 20px;
      font-size: 1rem;
      cursor: pointer;
      font-weight: 600;
    }

    .btn:hover {
      background-color: #5c3b28;
    }

    .footer {
      font-size: 0.75rem;
      margin-top: 2rem;
      color: #8a7765;
    }

    .footer a {
      color: #6f4f37;
      margin: 0 5px;
      text-decoration: none;
    }

    /* ✅ Responsive adjustments */
    @media (max-width: 900px) {
      body {
        flex-direction: column;
      }

      .left {
        display: none; /* hide candles on small screens */
      }

      .right {
        flex: none;
        width: 100%;
        height: 100vh;
      }
    }
  </style>
</head>
<body>
  <!-- Left Section (candles image) -->
  <div class="left"></div>

  <!-- Right Section (Login Form) -->
  <div class="right">
    <div class="login-container">
      <img src="dove.png" alt="logo">
      <h1>Hi, Welcome to Rest Assured!</h1>
      <p>text here</p>

      <div class="input-group">
        <label for="userid">User ID* (required)</label>
        <input type="text" id="userid" placeholder="Enter your user ID">
      </div>

      <div class="input-group">
        <label for="password">Password* (required)</label>
        <input type="password" id="password" placeholder="Enter your password">
      </div>

      <div class="forgot">Forgot password?</div>

      <button class="btn">SIGN IN</button>

      <div class="footer">
        <a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a>
        <p>This site is protected by reCAPTCHA Enterprise. Google's 
        <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply.</p>
      </div>
    </div>
  </div>
</body>
</html>
