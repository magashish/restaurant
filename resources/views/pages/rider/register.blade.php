@extends('includes.rider.riderLogin')

@section('content')
<style>
.register-box .inner-register label {
    margin-bottom: 4px;
    margin-top: 12px;
}
.register-box .inner-register {
    width: 425px;
}
.register-box .inner-register .btnLogin {
    margin-top: 19px;
}
</style>
<form method="POST" action="{{ route('rider.register.submit') }}" id = "registerForm">
    @csrf
    <div class="register-box">
        <div class="inner-register">
            <h3>Register</h3>

            <div class="row">
                <div class="col-sm-12">
                    <label>Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-sm-12">
                    <label>Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-sm-12">
                    <label>Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label>Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                </div>
            </div>
            <button type="submit" class="btnLogin">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

   <script>
  $(document).ready(function () {
    $('#registerForm').validate({ // initialize the plugin
        rules: {
            name: {
                required: true,
                minlength:5,
                maxlength:20
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: '{{route("checkcheckEmailAddressReq")}}',
                    type: "get",
                    data: {
                        email: function () {
                            return $("#email").val();
                        }
                    },
                },
            },
            password: {
                required: true,
                minlength:8
            },
            password_confirmation: {
            required: true,
            minlength: 8,
            equalTo: "#password"
            }
           
        },
        
     messages: {
        name: {
            required: "Enter a username",
            minlength: "Enter at least 5 characters"
        },
        email:  {
            required: "Enter an email",
            remote: "This email already exists"
        },
        password:  {
            required: "Enter the password",
            minlength: "Enter at least 8 characters"
        }
       
        
        }
         
    });
    
});
</script>
@endsection
