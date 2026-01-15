<!doctype html>
<html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Horaires de Prière</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        padding-top: 3rem;
    }
    .navbar {
        background-color: #0d6efd;
    }
    .navbar-brand {
        color: #fff !important;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .prayer-card {
        border-left: 6px solid #0d6efd;
        transition: 0.3s;
    }
    .prayer-card:hover {
        transform: scale(1.02);
    }
    .time, #clock {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0d6efd;
    }

    </style>
    </head>
    <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
    <a class="navbar-brand" href="#">🕌 Horaires de Prière</a>
    </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container mt-5 pt-4">
    <div class="text-center mb-5">
    <h2 id="city" class="fw-bold"></h2>
    <p id="date" class="text-muted"></p>
    <p id="clock" class=""></p>

    </div>

    <div class="row g-4">
    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Fajr</h5>
            <p id="fajr_time" class="time">Loading...</p>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Chourouq</h5>
            <p id="sunrise_time" class="time">Loading...</p>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Dhuhr</h5>
            <p id="dhuhr_time" class="time">Loading...</p>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Asr</h5>
            <p id="asr_time" class="time">Loading...</p>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Maghrib</h5>
            <p id="maghrib_time" class="time">Loading...</p>
        </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card prayer-card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Isha</h5>
            <p id="isha_time" class="time">Loading...</p>
        </div>
        </div>
    </div>
    </div>

    <div class="text-center mt-5">
    <p class="text-muted small">© 2025 PrayerTimes Made With 🤍 By Othmane</p>
    </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    </body>
</html>
