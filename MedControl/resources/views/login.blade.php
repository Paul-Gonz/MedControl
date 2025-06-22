<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="login-box">
        <div class="login-logo">
            <h1 style="font-size: 55px; margin-right: -15px; text-decoration: underline 4px"><b>Med</b>Control<img src="{{ asset('images/logo-sin-fondo.png') }}" alt="Logo MedControl" style="height: 200px; margin-left: -15px; margin-top: -35px; margin-bottom: -15px"></h1>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Iniciar Sesión</p>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/4e9c8e4e0a.js" crossorigin="anonymous"></script>
</body>
</html>