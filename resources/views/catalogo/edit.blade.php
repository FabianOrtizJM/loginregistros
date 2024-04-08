<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container align-center offset-md-2 col-md-8 p-5">
    <form action="/update/{{$catalogo->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="" class="form-label">Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control" tabindex="1" value="{{$catalogo->nombre}}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Categoria</label>
        <input id="categoria" name="categoria" type="text" class="form-control" tabindex="1" value="{{$catalogo->categoria}}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Pais/Region</label>
        <input id="region" name="region" type="text" class="form-control" tabindex="1" value="{{$catalogo->pais_origen}}">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Millones de copias vendidas</label>
        <input id="copias" name="copias" type="text" class="form-control" tabindex="1" value="{{$catalogo->m_copias}}">
    </div>
    <a href="/signed" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>