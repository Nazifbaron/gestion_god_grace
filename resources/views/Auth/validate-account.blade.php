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



<form method="post" action="{{route('submit',$email)}}">

    @csrf
    @method('POST')

    <div class="box">
        <h1>Definissez vos accès</h1>

        
        @if (Session::get('error_msg') )
            <b style="font-size:10px;color:red">{{Session::get('error_msg')}}</b>
        @endif
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="email" value="{{$email}}" readonly/>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" name="code" class="email" value="{{old('code')}}" />
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="password" class="password" />
        </div>
        @error('password')
            <span class="text text-danger">{{$message}}</span>
        @enderror
        <div class="form-group">
            <label for="confirmpassword">Confirmler le mot de passe</label>
            <input type="confirmpassword" name="confirmpassword" class="confirmpassword" />
        </div>
        @error('confirmpassword')
            <span class="text text-danger">{{$message}}</span>
        @enderror

        <div class="btn-container">
            <button type="submit"> Validate</button>
        </div>

        <!-- End Btn -->
        <!-- End Btn2 -->
    </div>
    <!-- End Box -->
</form>

</body>
</html>
<style>

.form-group{
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction: column;
}
.text-danger{
    color:rgb(185,81,81)!important
}

</style>