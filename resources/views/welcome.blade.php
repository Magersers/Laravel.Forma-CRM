<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mini-CRM | IT-Аутсорсинг</title>
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
    }

    .navbar-brand,
    .btn-outline-light {
      color: var(--light-text) !important;
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

    .hero-section {
      padding: 6rem 1rem;
      background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
      text-align: center;
    }

    .contact-card {
      background: #1e1e1e;
      border-left: 4px solid var(--primary-red);
      border-radius: 8px;
      padding: 1.5rem;
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

    footer {
      background-color: #0a0a0a;
      padding: 1.5rem 0;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

  <!-- Навбар -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Mini-CRM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      @if(session('user_id') == '')
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
          Вход
        </a>
      </div>
      @endif
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1 class="display-4 fw-bold">IT-Аутсорсинг с контролем качества</h1>
      <p class="lead mt-3">Оставьте заявку — мы свяжемся с вами в течение часа</p>
    </div>
  </section>

  <!-- Contact Form -->
  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="contact-card">
            <h2 class="mb-4">Оставить заявку</h2>
            <form id="contactForm" action="{{route('forma_valid')}}" method="POST">
                @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text " value="{{ old('name') }}" class="form-control" id="name" name='name' required>
                 @error('name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                 @enderror
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ old('email') }}"  name = 'email'required>
                @error('email')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
                <div class="invalid-feedback">Пожалуйста, введите корректный email</div>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input type="tel" class="form-control" id="phone" name='phone'  value="{{ old('phone') }}"  required pattern="[\+]?[0-9\s\-\(\)]{10,}"
                  title="Например: +7 (999) 123-45-67">
                @error('phone')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
                <div class="invalid-feedback">Пожалуйста, введите корректный номер телефона</div>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Сообщение</label>
                <textarea class="form-control" name='opisanie' id="message" rows="4" required>{{ old('opisanie') }} </textarea>
                @error('message')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-red w-100">Отправить заявку</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center text-light">
    <div class="container">
      <p class="mb-0">© 2025 Mini-CRM для IT-аутсорсинга. Все права защищены.</p>
      <p class="mt-2">
        <a href="mailto:support@itcrm.example" class="text-light text-decoration-none">support@itcrm.example</a> |
        <a href="tel:+74951234567" class="text-light text-decoration-none">+7 (495) 123-45-67</a>
      </p>
    </div>
  </footer>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Авторизация</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('login')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="loginEmail" class="form-label">Email</label>
              <input type="email" name='email' class="form-control bg-secondary text-light" id="loginEmail" required>
            </div>
            <div class="mb-3">
              <label for="loginPassword" class="form-label">Пароль</label>
              <input type="password" name='password' class="form-control bg-secondary text-light" id="loginPassword" required>
            </div>
            <button type="submit" class="btn btn-red w-100">Войти</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Валидация формы -->
  <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      const email = document.getElementById('email');
      const phone = document.getElementById('phone');

      // Сброс стилей
      email.classList.remove('is-invalid');
      phone.classList.remove('is-invalid');

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.value)) {
        email.classList.add('is-invalid');
        e.preventDefault();
        return;
      }

      if (!phone.validity.valid) {
        phone.classList.add('is-invalid');
        e.preventDefault();
        return;
      }

      // Если всё ок — можно отправить (в реальности — AJAX)
      alert('Заявка отправлена! Мы скоро свяжемся с вами.');

    });
  </script>

</body>
</html>