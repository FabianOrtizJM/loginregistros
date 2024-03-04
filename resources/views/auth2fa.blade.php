<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">{{ __('Login 2FA') }}</div>
              <div class="card-body">
                <form method="POST" action="{{ route('login2fa',$user->id) }}" aria-label="{{ __('Login') }}">
                  @csrf
                  <div class="form-group row">
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label for="code_verification" class="col-form-label">
                          {{ __('CÓDIGO DE VERIFICACIÓN') }}
                        </label>
                        <input 
                          id="code_verification" 
                          type="text" 
                          class="form-control{{ $errors->has('code_verification') ? ' is-invalid' : '' }}" 
                          name="code_verification"
                          value="{{ old('code_verification') }}" 
                          required
                          autofocus>
                        @if ($errors->has('code_verification'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('code_verification') }}</strong>
                          </span>
                        @endif
                      </div>
                      <button type="submit" class="btn btn-primary">ENVIAR</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>