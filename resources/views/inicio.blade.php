<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Inicio</title>
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a href="/signed"><button type="button" class="btn btn-success">Catalogo</button></a>
            <a href="/signedusers"><button type="button" class="btn btn-success">Usuarios</button></a>
        </div>
      </nav>
    <div class="container">
        <div class="col-md-3 offset-md-5 p-5">
            <h1 class="text-center">Bienvenido</h1>
            <a href="{{route('logout')}}"><button type="button" class="btn btn-outline-primary me-2">logout</button></a>
        </div>
    </div>
</body>
</html>