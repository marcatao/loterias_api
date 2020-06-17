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


  <form class="form-signin" action="/account" method="post">
  <h1 class="h3 mb-3 font-weight-normal">Register</h1>

  <label for="name" class="sr-only">Name</label>   
  <input type="text" id="name" name="name" class="form-control" placeholder="Name" required="" autofocus=""><br>

  <label for="email" class="sr-only">Email address</label>
  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="" autofocus=""><br>

  <label for="password" class="sr-only">Password</label>
  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">

  <label for="password_confirmation" class="sr-only">Password confirm</label>
  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required=""><br>

  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
 
</form>
</div>

</body>

@endsection