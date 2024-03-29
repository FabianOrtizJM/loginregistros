<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>Registro</title>
</head>
<body>
    <br>
    <div class="container align-center offset-md-3 col-md-6 p-5 bg-info">
        <h1 class="text-center">Registro</h1>
        <form method="POST" action="{{route('validar-registro')}}">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
            <label for="confirmacontraseña" class="form-label">Confirma Contraseña</label>
            <input type="password" class="form-control" name="password_confirmation" id="confirmacontraseña">
        </div>
        <div class="mb-3">
            <div id="recaptcha_form"></div>
            {!! GoogleReCaptchaV2::render('recaptcha_form') !!}
        </div>
        <button type="submit" class="btn btn-primary">Registro</button>
        </form>
        
        <p class="text-center">¿Ya tienes cuenta? <a href="{{route('login')}}">Inicia Sesion</a></p>
    </div>   
</body>
</html>