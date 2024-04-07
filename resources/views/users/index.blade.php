<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    @if (session('error'))
        <div style="color: white; background-color: red;">
            {{ session('error') }}
        </div>
    @endif
    @csrf
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Usuarios</a>
      </div>
    </nav>
    <div class="container align-center offset-md-2 col-md-8 p-5">
    <table class="table table-success table-striped">
        <thead>
            <th scope="col">Email</th>
            <th scope="col">UserName</th>
            @role('Administrador')
            <th scope="col">Acciones</th>
            @endrole
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->email}}</td>
                <td>{{$user->name}}</td>
                @role('Administrador')
                <td>
                    <a href="/users/{{$user->id}}/edit" class="btn btn-info">Editar</a>
                    <form action="/users/{{$user->id}}" method="POST">
                      @csrf
                      @method('DELETE')
                    <button type="submit" class="btn btn-danger">Borrar</button>                    
                    </form>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="users/create" class="btn btn-primary">Crear</a>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>