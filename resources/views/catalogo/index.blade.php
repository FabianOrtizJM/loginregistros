<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    @csrf
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Catalogo de videojuegos</a>
      </div>
    </nav>
    <div class="container align-center offset-md-2 col-md-8 p-5">
    <table class="table table-success table-striped">
        <thead>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Categoria</th>
            <th scope="col">Pais/Region de origen</th>
            <th scope="col">Millones de copias vendidas</th>
            @role('Administrador|Coordinador')
            <th scope="col">Acciones</th>
            @endrole
        </thead>
        <tbody>
            @foreach ($catalogos as $catalogo)
            <tr>
                <td>{{$catalogo->id}}</td>
                <td>{{$catalogo->nombre}}</td>
                <td>{{$catalogo->categoria}}</td>
                <td>{{$catalogo->pais_origen}}</td>
                <td>{{$catalogo->m_copias}}</td>
                @role('Administrador|Coordinador')
                <td>
                    <a href="/edit/{{$catalogo->id}}" class="btn btn-info">Editar</a>
                    <form action="/delete/{{$catalogo->id}}" method="POST">
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
    <a href="catalogo/create" class="btn btn-primary">Crear</a>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>