<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Carte interactive des objectifs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Créez un compte pour accéder à la carte interactive de vos objectifs personnels">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #28a745;
      --primary-hover: #218838;
      --secondary-color: #007bff;
      --text-color: #333;
      --light-gray: #f8f9fa;
      --border-color: #ced4da;
      --error-color: #dc3545;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      line-height: 1.6;
      color: var(--text-color);
    }

    header {
      background: rgba(255, 255, 255, 0.98);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 1rem 2rem;
      text-align: center;
      animation: slideDown 0.5s ease-out;
    }

    header h1 {
      font-size: clamp(1.4rem, 3vw, 1.8rem);
      color: var(--secondary-color);
      margin-bottom: 0.5rem;
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
      padding: 1rem;
      animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.98); }
      to   { opacity: 1; transform: scale(1); }
    }

    .auth-box {
      background: #fff;
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    .avatar {
      background: var(--primary-color);
      width: 80px;
      height: 80px;
      margin: 0 auto 1.5rem;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 2rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .avatar:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    h2 {
      margin-bottom: 1.8rem;
      color: var(--text-color);
      font-weight: 600;
      font-size: 1.5rem;
    }

    .input-group {
      position: relative;
      margin-bottom: 1.4rem;
      text-align: left;
    }

    .input-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .input-group input {
      width: 100%;
      padding: 0.85rem 1rem 0.85rem 2.8rem;
      border: 2px solid var(--border-color);
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background-color: var(--light-gray);
    }

    .input-group input:focus {
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
      outline: none;
      background-color: #fff;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 1rem;
      transform: translateY(-50%);
      color: #6c757d;
      font-size: 1.1rem;
    }

    .error {
      color: var(--error-color);
      font-size: 0.85rem;
      margin-top: 0.4rem;
      display: block;
    }

    button {
      width: 100%;
      padding: 1rem;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1.05rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 0.5rem;
    }

    button:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .auth-links {
      margin-top: 1.5rem;
      font-size: 0.95rem;
    }

    .auth-links a {
      color: var(--secondary-color);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .auth-links a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .password-strength {
      margin-top: 0.5rem;
      height: 4px;
      background: #e9ecef;
      border-radius: 2px;
      overflow: hidden;
    }

    .strength-meter {
      height: 100%;
      width: 0;
      transition: width 0.3s ease, background 0.3s;
    }

    @media (max-width: 480px) {
      .auth-box { padding: 2rem 1.5rem; }
      header { padding: 1rem; }
    }
  </style>
</head>
<body>
  <header>
    <h1>Carte interactive des objectifs personnels</h1>
    <p>Créez votre compte pour commencer</p>
  </header>

  <main>
    <div class="auth-box">
      <div class="avatar"><i class="fas fa-user-plus"></i></div>
      <h2>Créer un compte</h2>

      <?php if(session('error')): ?>
        <div class="error" role="alert"><?php echo e(session('error')); ?></div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('register.perform')); ?>" novalidate>
        <?php echo csrf_field(); ?>

        <div class="input-group">
          <label for="username">Nom d'utilisateur</label>
          <i class="fas fa-user"></i>
          <input type="text" id="username" name="username" value="<?php echo e(old('username')); ?>"
                 placeholder="Votre nom d'utilisateur" required autocomplete="username" autofocus>
          <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="error"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-group">
          <label for="email">Adresse e-mail</label>
          <i class="fas fa-envelope"></i>
          <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                 placeholder="votre@email.com" required autocomplete="email">
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="error"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-group">
          <label for="password">Mot de passe</label>
          <i class="fas fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="••••••••"
                 required autocomplete="new-password" minlength="8">
          <div class="password-strength">
            <div class="strength-meter" id="password-strength"></div>
          </div>
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="error"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="input-group">
          <label for="password_confirmation">Confirmer le mot de passe</label>
          <i class="fas fa-lock"></i>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 placeholder="••••••••" required autocomplete="new-password">
        </div>

        <button type="submit">S'inscrire</button>

        <div class="auth-links">
          Déjà un compte ? <a href="<?php echo e(route('login')); ?>">Connectez-vous</a>
        </div>
      </form>
    </div>
  </main>

  <script>
    document.getElementById('password').addEventListener('input', function(e) {
      const password = e.target.value;
      const strengthMeter = document.getElementById('password-strength');
      let strength = 0;

      if (password.length >= 8) strength += 1;
      if (password.length >= 12) strength += 1;
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
      if (password.match(/[0-9]/)) strength += 1;
      if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

      const width = strength * 25;
      let color = '#dc3545'; // Rouge
      if (strength >= 3) color = '#ffc107'; // Jaune
      if (strength >= 5) color = '#28a745'; // Vert

      strengthMeter.style.width = width + '%';
      strengthMeter.style.background = color;
    });
  </script>
</body>
</html>
<?php /**PATH E:\mind_map_project\mind_map_project\resources\views/register.blade.php ENDPATH**/ ?>