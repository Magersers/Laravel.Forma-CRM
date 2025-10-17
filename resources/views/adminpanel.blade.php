<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Админ-панель | Mini-CRM</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    :root {
      --primary-red: #d32f2f;
      --dark-bg: #121212;
      --light-text: #f5f5f5;
      --card-bg: #1e1e1e;
    }

    body {
      background-color: var(--dark-bg);
      color: var(--light-text);
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      background-color: #1a1a1a;
      min-height: 100vh;
      padding: 1.5rem 0;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      width: 250px;
      z-index: 1040;
      overflow-y: auto;
    }

    .sidebar .nav-link {
      color: #aaa;
      margin-bottom: 0.5rem;
      border-radius: 6px;
      padding: 0.6rem 1.2rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      color: white;
      background-color: var(--primary-red);
    }

    .main-content {
      margin-left: 250px;
      padding: 1.5rem;
    }

    @media (max-width: 991.98px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
      }
      .menu-toggle {
        display: block;
      }
    }
    input.form-control::placeholder
    {
        color: rgba(255, 255, 255, 0.468)
    }
    .menu-toggle {
      display: none;
      position: absolute;
      top: 12px;
      left: 12px;
      z-index: 1050;
      background: var(--primary-red);
      border: none;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 6px;
    }

    .card {
      background-color: var(--card-bg);
      border: 1px solid #333;
      color: var(--light-text);
      margin-bottom: 1.25rem;
    }
    html .text-muted1
    {
        color: white;
    }

    .status-badge {
      font-size: 0.85rem;
      padding: 0.4em 0.8em;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 90px;
      text-align: center;
    }

    .status-new { background-color: #1976d2; color: white; }
    .status-in-progress { background-color: #ffa000; color: black; }
    .status-completed { background-color: #388e3c; color: white; }

    select.form-select,
    .form-control {
      background-color: #2a2a2a;
      border: 1px solid #444;
      color: var(--light-text);
    }

    select.form-select:focus {
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.25);
    }

    .btn-save {
      color: white;
      height: 38px;
      font-size: 0.85rem;
      padding: 0.3rem 0.75rem;
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    @media (max-width: 575.98px) {
      .card-body > .d-flex {
        flex-direction: column;
      }
      .card-body > .d-flex > .text-end {
        margin-left: 0 !important;
        margin-top: 1rem;
        align-self: stretch;
      }
      .action-buttons {
        justify-content: flex-end;
      }
    }

    /* Search bar */
    .search-box {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

  <button class="menu-toggle" id="menuToggle">☰</button>

  <nav class="sidebar" id="sidebar">
    <div class="px-3">
      <h5 class="text-center text-light mb-4">Mini-CRM</h5>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-tab="active">Активные заявки</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-tab="archived">Архив</a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="main-content">
    <header class="d-flex justify-content-between align-items-center mb-3">
      <h2 id="page-title">Активные заявки</h2>
      <a href="{{route('home')}}" class="text-light text-decoration-none">← На главную</a>
    </header>

    <!-- Поле поиска -->
    <div class="search-box">
      <input type="text" id="searchInput" class="form-control" placeholder="Поиск по заявкам...">
    </div>

    <div id="requests-container">
      <!-- Заявки -->
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>

    const initialRequests = [
        @foreach($zad as $row)
        { id: {{$row -> id }}, name: "{{$row->name}}", email: "{{$row->email}}", phone: "{{$row->phone}}", message: "{{$row->opisanie}}", status: "{{$row->status}}", archived: {{$row->arhiv ? 'false':'true'}} },
        @endforeach
    ];

    let requests = JSON.parse(JSON.stringify(initialRequests));
    let currentView = 'active';
    let searchTerm = '';

  
    function sendToServer(requestData) {
      $.ajax({
        url: '{{route('status')}}', 
        method: 'POST',
         headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(response) {
          console.log('Успешно обновлено:', response);
         
        },
        error: function(xhr, status, error) {
          console.error('Ошибка отправки:', error);
          alert('Не удалось сохранить изменения на сервере');
        }
      });
    }

    // === Фильтрация и рендер ===
    function renderRequests() {
      const container = $('#requests-container');
      const filtered = requests.filter(req => {
        const matchesTab = (req.archived === (currentView === 'archived'));
        if (!matchesTab) return false;

        if (!searchTerm) return true;

        const term = searchTerm.toLowerCase();
        return (
          req.name.toLowerCase().includes(term) ||
          req.email.toLowerCase().includes(term) ||
          req.phone.toLowerCase().includes(term) ||
          req.message.toLowerCase().includes(term)
        );
      });

      if (filtered.length === 0) {
        container.html(`<div class="text-center py-5"><p class="text-muted1" '>Заявок не найдено</p></div>`);
        return;
      }

      const html = filtered.map(req => `
        <div class="card" data-id="${req.id}">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="card-title mb-1">${req.name}</h5>
                <p class="mb-1"><strong>Email:</strong> ${req.email}</p>
                <p class="mb-1"><strong>Телефон:</strong> ${req.phone}</p>
                <p class="text-muted1"  >${req.message}</p>
              </div>
              <div class="text-end ms-3" style="min-width: 200px;">
                <div class="mb-2">
                  <select class="form-select form-select-sm status-select">
                    <option value="new" ${req.status === 'new' ? 'selected' : ''}>Новая</option>
                    <option value="in-progress" ${req.status === 'in-progress' ? 'selected' : ''}>В работе</option>
                    <option value="completed" ${req.status === 'completed' ? 'selected' : ''}>Завершена</option>
                  </select>
                </div>
                <div class="action-buttons">
                  <button class="btn btn-red btn-sm btn-save">Сохранить</button>
                  ${currentView === 'archived'
                    ? `<button class="btn btn-outline-light btn-sm btn-unarchive">Вернуть</button>`
                    : `<button class="btn btn-outline-secondary btn-sm btn-archive">В архив</button>`
                  }
                </div>
              </div>
            </div>
            <div class="mt-2">
              <span class="status-badge ${
                req.status === 'new' ? 'status-new' :
                req.status === 'in-progress' ? 'status-in-progress' :
                'status-completed'
              }">
                ${
                  req.status === 'new' ? 'Новая' :
                  req.status === 'in-progress' ? 'В работе' :
                  'Завершена'
                }
              </span>
            </div>
          </div>
        </div>
      `).join('');

      container.html(html);

    
      $('.btn-save').on('click', function() {
        const card = $(this).closest('.card');
        const id = parseInt(card.data('id'));
        const select = card.find('.status-select');
        const newStatus = select.val();

        const request = requests.find(r => r.id === id);
        if (request) {
          request.status = newStatus;

          const badge = card.find('.status-badge');
          badge.removeClass('status-new status-in-progress status-completed')
               .addClass(request.status === 'new' ? 'status-new' :
                         request.status === 'in-progress' ? 'status-in-progress' : 'status-completed');
          badge.text(request.status === 'new' ? 'Новая' :
                     request.status === 'in-progress' ? 'В работе' : 'Завершена');

      
          sendToServer({
            id: request.id,
            status: request.status,
            arhiv: request.archived
          });
        }
      });

      $('.btn-archive').on('click', function() {
        const id = parseInt($(this).closest('.card').data('id'));
        const request = requests.find(r => r.id === id);
        if (request) {
          request.archived = true;
          if (currentView === 'active') renderRequests();
        }
        sendToServer({
            id: request.id,
            status: request.status,
            arhiv: true
          });
      });

      $('.btn-unarchive').on('click', function() {
        const id = parseInt($(this).closest('.card').data('id'));
        const request = requests.find(r => r.id === id);
        if (request) {
          request.archived = false;
          if (currentView === 'archived') renderRequests();
        }
        sendToServer({
            id: request.id,
            status: request.status,
            arhiv: false
          });
      });
    }

    // === Поиск ===
    $('#searchInput').on('input', function() {
      searchTerm = $(this).val().trim();
      renderRequests();
    });

    // === Переключение вкладок ===
    function setTab(tab) {
      currentView = tab;
      $('.nav-link').removeClass('active');
      $(`.nav-link[data-tab="${tab}"]`).addClass('active');
      $('#page-title').text(tab === 'active' ? 'Активные заявки' : 'Архив');
      renderRequests();
    }

    $('.nav-link').on('click', function(e) {
      e.preventDefault();
      const tab = $(this).data('tab');
      setTab(tab);
      $('#sidebar').removeClass('show');
    });

    $('#menuToggle').on('click', () => {
      $('#sidebar').toggleClass('show');
    });

    $(document).on('click', function(e) {
      const sidebar = $('#sidebar');
      const toggle = $('#menuToggle');
      if ($(window).width() <= 991 && !sidebar.is(e.target) && sidebar.has(e.target).length === 0 && !toggle.is(e.target)) {
        sidebar.removeClass('show');
      }
    });

    // Инициализация
    setTab('active');
  </script>

</body>
</html>