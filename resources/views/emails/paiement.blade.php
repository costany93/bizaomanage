<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/app.css">
    <title>Merci pour votre don</title>
    <style>

    </style>
  </head>
  <body>
    <img src="images/logo.png" alt="">
    <h1>{{$details['title']}}</h1>
    <p>Nous vous remercions infiniment {{$details['nom']}} - {{$details['prenom']}} du don que vous venez de faire à l'Association Nationale des Albinos du Sénégal</p>
    <h2>Informations sur le don</h2>
    <p>Nom du donateur : <strong>{{$details['nom']}}</strong></p>
    <p>Prénom du donateur : <strong>{{$details['prenom']}}</strong></p>
    <p>Pays : <strong>{{$details['pays']}}</strong></p>
    <p>Montant : <strong>{{$details['montant']}}</strong></p>
    <p>Date de paiement : <strong>{{$details['date']}}</strong></p>
    <a href="#" class="btn btn-success">Téléchargez le reçu</a>
    <script src="js/app.js"></script>
  </body>
</html>