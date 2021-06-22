<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/app.css">
    <title>Faire un don à l'ANAS</title>
    <style>
        .body{
            height: 700px;
        }
        .anas-bg{
            background-color: #f44716;
        }
        body{
            background-image: url('images/benevole.jpg');
            background-size: 100%;
        }
    </style>
  </head>
  <body class="body">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">

                <div class="col-lg-6 mt-5">
                    <div class="card anas-bg card-form text-center">
                      <div class="card-body">
                          @include('include.form_error')
                        <p class="text-white">Entrez le code pour faire un don</p>
                        {!! Form::open(['method' => 'POST', 'action' => 'BizaoController@checkAccess']) !!}
                                <div class="form-group">
                                    {!! Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Entrez le code pour faire un don']) !!}
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-6">
                                        {!! Form::submit('Vérifier', ['class' => 'btn btn-outline-light btn-block my-2']) !!}
                                    </div>
                                </div>

                            {!! Form::close() !!}
                      </div>
                    </div>

                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-lg-4">
                            <a href="https://anasngo.org/" class="btn btn-primary btn-block">Revenir au site</a>
                        </div>
                    </div>
                  </div>
            </div>
        </div>

    <script src="js/app.js"></script>
  </body>
</html>