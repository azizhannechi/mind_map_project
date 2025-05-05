<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      height: 100vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    header {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 1rem 2rem;
      text-align: center;
      animation: slideDown 1s ease-out;
    }

    header h1 {
      font-size: 1.8rem;
      color: #007bff;
    }

    @keyframes slideDown {
      from { transform: translateY(-50px); opacity: 0; }
      to   { transform: translateY(0); opacity: 1; }
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.97); }
      to   { opacity: 1; transform: scale(1); }
    }

    .login-box {
      background: #fff;
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 380px;
      text-align: center;
    }

    .avatar {
      background: #007bff;
      width: 80px;
      height: 80px;
      margin: 0 auto 1.2rem;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 2rem;
      transition: transform 0.3s;
    }

    .avatar:hover {
      transform: scale(1.05) rotate(5deg);
    }

    h2 {
      margin-bottom: 1.5rem;
      color: #333;
      font-weight: 600;
    }

    .input-group {
      position: relative;
      margin-bottom: 1.3rem;
    }

    .input-group input {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 2.5rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .input-group input:focus {
      border-color: #007bff;
      box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
      outline: none;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 0.9rem;
      transform: translateY(-50%);
      color: #aaa;
      pointer-events: none;
    }

    button {
      width: 100%;
      padding: 0.8rem;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    .error {
      color: red;
      font-size: 0.9rem;
      margin-top: 0.75rem;
      min-height: 1.2em;
      animation: shake 0.3s;
    }

    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
      75% { transform: translateX(-5px); }
      100% { transform: translateX(0); }
    }

    @media (max-width: 450px) {
      header h1 {
        font-size: 1.4rem;
      }
      .login-box {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Carte interactive des objectifs personnels</h1>
    <h1>(login)</h1>
  </header>

  <main>
    <div class="login-box">
      <div class="avatar"><i class="fas fa-user"></i></div>
      <h2>Connexion</h2>

      <?php if(session('error')): ?>
        <div class="error" id="errorMsg"><?php echo e(session('error')); ?></div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('login.perform')); ?>">
        <?php echo csrf_field(); ?>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        </div>

        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Mot de passe" required>
        </div>

        <button type="submit">Se connecter</button>
      </form>
    </div>
  </main>
</body>
</html><?php /**PATH E:\mind_map_project\mind_map_project\resources\views/login.blade.php ENDPATH**/ ?>