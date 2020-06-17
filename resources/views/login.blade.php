@extends('app.main')
@section('content')

<body class="text-center vsc-initialized d-flex justify-content-center">
<div class="col-md-5">


@isset($errors)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>    
      @endforeach
    </ul> 
  </div>  
@endif


  <form class="form-signin" action="/login" method="post">
  <h1 class="h3 mb-3 font-weight-normal">Get yor token</h1>
 
  <label for="email" class="sr-only">Email address</label>
  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="" autofocus=""><br>

  <label for="password" class="sr-only">Password</label>
  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required=""><br>
 
  <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
 
</form>
</div>

</body>

@endsection