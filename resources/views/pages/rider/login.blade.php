@extends('includes.rider.riderLogin')

@section('content')
<style>
.login-box .inner-login .btnLogin{
    width:100%;
}
.form-check-label {
    margin-left: 15px;
}
input[type=radio], input[type=checkbox] {
    margin: 1px 0 0;
}
.mb-5 a{
    padding-left: 3px;
}
</style>
        @if(Session::has('success'))
            <div class="row mt-5">
                <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-success">
                    {{  Session::get('success') }}
                </div>
                </div>
            </div>
         @endif
         @if(Session::has('error'))
            <div class="row mt-5">
                <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-danger">
                    {{  Session::get('error') }}
                </div>
                </div>
            </div>
         @endif
<form method="POST" action="{{ route('rider.login.submit') }}" id= "loginForm">
    @csrf
    <div class="login-box">
        <div class="inner-login">
            <h3>Log in</h3>
            <p class="mb-5"><span>New Rider?</span> Create your account<a class="btn btn-link btn-link-theme" href="{{url('/rider/register') }}">here</a></p>
            <div class="form-group">
                <label>Email</label>
                <input id="email" type="email" class="form-control input-box" name="email" value="{{ old('email') }}"  autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input id="password" type="password" class="form-control input-box" name="password" >
            </div>
           
            <div class="form-group">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label ml-3" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <button type="submit" class="btnLogin">
                {{ __('Login') }}
            </button>
            
        </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
  $(document).ready(function () {
    $('#loginForm').validate({ // initialize the plugin
        rules: {
           
            email: {
                required: true,
                email: true
            },
            password: {
                required: true  
            }
            
        },
        
     messages: {
       
        email:  {
            required: "Enter an email"
        },
        password:  {
            required: "Enter the password"
           
        }
        
             }
         
    });
    
});
</script>
@endsection
