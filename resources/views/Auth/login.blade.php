<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700,600" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>Application de gestion de salaire</title>
</head>
<body>



<form method="post" action="{{route('handlelogin')}}">

    @csrf
    @method('POST')

    <div class="box">
        <h1>Connexion</h1>

        
        @if (Session::get('error_msg') )
            <b style="font-size:10px;color:red">{{Session::get('error_msg')}}</b>
        @endif
        
        <input type="email" name="email" class="email" />
        <input type="password" name="password" class="email"/>

        <div class="btn-container">
            <button type="submit"> Connectez-vous</button>
        </div>

        <!-- End Btn -->
        <!-- End Btn2 -->
    </div>
    <!-- End Box -->
</form>

</body>
</html>