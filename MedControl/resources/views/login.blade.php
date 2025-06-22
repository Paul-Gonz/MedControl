<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Login</h2>
    @if($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="{{ route('login.process') }}">
        @csrf
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>
        <label>Clave:</label>
        <input type="password" name="clave" required><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>