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
                        <h3 class="text-white">Thank you for the gesture</h3>
                        <p class="text-white">A SMALL GESTURE, A BIG IMPACT</p>
                        {!! Form::open(['method' => 'POST', 'action' => 'BizaoController@getApiUrl']) !!}
                                <div class="form-group">
                                    {!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Please enter your name']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::text('prenom', null, ['class' => 'form-control', 'placeholder' => 'Please enter your first name']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter your e-mail address']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::text('numero', null, ['class' => 'form-control', 'placeholder' => 'Please enter your phone number']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::number('montant', null, ['class' => 'form-control', 'placeholder' => 'Enter the amount of your donation']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::select('pays',$pays, null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-6">
                                        {!! Form::submit('Faire le don', ['class' => 'btn btn-outline-light btn-block my-2']) !!}
                                    </div>
                                </div>

                            {!! Form::close() !!}
                      </div>
                    </div>
                    <div class="alert alert-success mt-2">
                        <p class="text-center ">After entering your donation information, you will be automatically redirected to a secure payment platform where you can make your payment</p>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-4">
                            <a href="https://fasafoundation.org/" class="btn btn-primary btn-block">Back to the site</a>
                        </div>
                    </div>
                  </div>
            </div>
        </div>

    <script src="js/app.js"></script>
  </body>
</html>