<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Вход | Mini-CRM</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-red: #d32f2f;
      --dark-bg: #121212;
      --light-text: #f5f5f5;
    }

    body {
      background-color: var(--dark-bg);
      color: var(--light-text);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .login-card {
      background: #1e1e1e;
      border: 1px solid #333;
      border-radius: 12px;
      padding: 2.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
    }

    .login-card h2 {
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: var(--light-text);
    }

    .form-control {
      background-color: #2a2a2a;
      border: 1px solid #444;
      color: var(--light-text);
    }

    .form-control:focus {
      background-color: #2a2a2a;
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.25);
      color: var(--light-text);
    }

    .form-label {
      color: #ccc;
    }

    .btn-red {
      background-color: var(--primary-red);
      border-color: var(--primary-red);
      color: white;
    }

    .btn-red:hover {
      background-color: #b71c1c;
      border-color: #b71c1c;
    }

    .back-link {
      display: inline-block;
      margin-top: 1rem;
      color: #aaa;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .back-link:hover {
      color: var(--primary-red);
      text-decoration: underline;
    }

    .alert-error {
      color: #ff8a80;
      background-color: rgba(211, 47, 47, 0.15);
      border: 1px solid var(--primary-red);
      border-radius: 6px;
      padding: 0.75rem 1rem;
      margin-bottom: 1.25rem;
      display: none;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h2 class="text-center">Вход в Mini-CRM</h2>

    <!-- Ошибка авторизации -->
    @if($auth)
    <div id="authError" class="alert-error" style='display:block;'>
      Неверный email или пароль
    </div>
    @endif
    <form id="loginForm" action="{{route('login_aut')}}" method="POST">
        @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input value="{{ old('email') }}" type="email" class="form-control" name='email' id="email" required autocomplete="email">
        <div class="invalid-feedback">Пожалуйста, введите корректный email</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name='password' class="form-control" id="password" required minlength="6" autocomplete="current-password">
        <div class="invalid-feedback" >Пароль должен содержать минимум 6 символов</div>
      </div>
      <button type="submit" class="btn btn-red w-100">Войти</button>
    </form>
    <a href="{{route('home')}}" class="back-link d-block text-center mt-3">&larr; Вернуться на главную</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Логика авторизации с имитацией ошибки -->
  <script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
    //   e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      const errorEl = document.getElementById('authError');

      // Сброс стилей ошибок полей
      document.getElementById('email').classList.remove('is-invalid');
      document.getElementById('password').classList.remove('is-invalid');
      errorEl.style.display = 'none';

      // Валидация формата
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('email').classList.add('is-invalid');
        e.preventDefault();
        return;
      }
      if (password.length < 6) {
        document.getElementById('password').classList.add('is-invalid');
        e.preventDefault();
        return;
      }

      // === ИМИТАЦИЯ ПРОВЕРКИ НА СЕРВЕРЕ ===
      // В реальном проекте здесь будет fetch() к /login
      const validEmail = "admin@itcrm.example";
      const validPassword = "secret123";

    });
  </script>

</body>
</html>