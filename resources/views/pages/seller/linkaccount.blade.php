@extends('includes.seller.sellerView')
@section('title')
    Link Bank Account
@endsection
@section('content')
@if(Session::has('success'))
         <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
               <div id="charge-message" class="alert alert-success">
                  {{  Session::get('success') }}
               </div>
            </div>
         </div>
         @endif
         @if(Session::has('error'))
         <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
               <div id="charge-message" class="alert alert-danger">
                  {{  Session::get('error') }}
               </div>
            </div>
         </div>
         @endif
<style>
strong{
    /* margin-top: 65px;
    margin-bottom: 40%;
    width: 20%;
    margin-left: 28px; */
    font-size: 24px;
}
.connect-button span {
        padding: 8px 12px;
        background: #1275ff;
        background-image: -webkit-gradient(linear,left top,left bottom,from(#7dc5ee),color-stop(85%,#008cdd),to(#30a2e4));
        background-image: linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
        font-size: 15px;
        line-height: 30px;
        color: #fff;
        font-weight: 700;
		border-radius: 3px; 
		margin-left: 35px;
}
.disconnect-button span {
        padding: 8px 12px;
        background: #ff6767;
      
        font-size: 15px;
        line-height: 30px;
        color: #fff;
        font-weight: 700;
        border-radius: 3px;
}
/* footer.sticky-footer {
    padding: 1.5rem 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    position: absolute;
    bottom: 0;
    width: calc(100% - 15em);
} */
p { padding: 50px 15px; }
label { display: block; margin-bottom: 20px; }
a .button-disconnect{ margin-left: 35px; }
.nav-pills .nav-link.active{
	margin-left: 0px;
	background-color: #ff6767; !important
}
.mheight{
	min-height: 80vh;
}
</style>

<div class ="container">
<div class="row">
            <div class="col-12 text-center">
               <div class="shortDesc">
               <p>             
               <strong> Payment Processing.</strong></p>
               
               </div>
            </div>
         </div>
<div class="mheight">
@if(Auth::user()->stripe_connect_id == "")
 <p>
    <label><strong>Connect your stripe account</strong></label>
    <a href="https://connect.stripe.com/express/oauth/authorize?response_type=code&amp;client_id=ca_HVAsXZ8joZi8r8pZY6dJQtQAm7xHqTW6&amp;scope=read_write&amp;redirect_uri=http://{{$host}}/seller/store-stripe-account-details&amp;" class="connect-button"><span>Connect with Stripe</span></a>
    <!-- <a href="https://connect.stripe.com/express/oauth/authorize?response_type=code&amp;client_id=ca_GGo92VymJkmNgfULKL1p1UQ0e3TdmXpR&amp;scope=read_write&amp;redirect_uri=https://{{$host}}/owner/store-stripe-account-details&amp;" class="connect-button"><span>Connect with Stripe</span></a> -->
</p>
@else
<p>
<label>
	<strong>
		Hi {{Auth::user()->name}}, Your account is now connected with stripe
	</strong>
</label>
	<a href="{{url('/seller/delete-stripe-account')}}"class="disconnect-button">
		<span class="button-disconnect">
			Delete account
		</span>
	</a>

  <a href="{{$final_stripe_link_url}}" target="_blank" class="disconnect-button">
    <span class="button-disconnect">
      Go to Stripe Dashboard
    </span>
  </a>
  
</p>
@endif

@if($acc_is_verified == 1 && $account_detail->external_accounts == '')
<article class="card">
<div class="card-body p-5">

<ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
   <li class="nav-item">
	   <a class="nav-link active bank" data-toggle="pill" href="#nav-tab-card">
	   <i class="fa fa-credit-card"></i> Bank Details</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade show active" id="nav-tab-card">
   <div class="row">
	   <div class="col-sm-6">
		   <div class="form-group">
			   <label for="username">Full name (on the card)</label>
			   <input type="text" class="form-control" name="username" placeholder="Eg. John Doe" value="{{$account_detail->external_accounts->data[0]['account_holder_name']}}" disabled>
		   </div> 
	   </div>
	   <div class="col-sm-6">
		   <div class="form-group">
			   <label for="cardNumber">Account Type</label>
			   <div class="input-group">
			   <input type="text" class="form-control" name="accoount_type" placeholder="Eg. John Doe" value="{{$account_detail->external_accounts->data[0]['account_holder_type']}}" disabled >
			   </div>
		   </div> 
	   </div>
   </div> 

   <div class="row">
	   <div class="col-sm-6">
		   <div class="form-group">
		   <label for="cardNumber">Routing number</label>
			   <div class="input-group">
				   <input type="number" class="form-control" name="cardNumber" placeholder="Eg. 000123456789" value="{{$account_detail->external_accounts->data[0]['routing_number']}}" disabled>
			   </div>
		   </div>
	   </div>
	   <div class="col-sm-6">
		   <div class="form-group">
			   <label for="cardNumber">Bank Name</label>
			   <div class="input-group">
				   <input type="text" class="form-control" name="cardNumber" placeholder="Eg. 110000000" value="{{$account_detail->external_accounts->data[0]['bank_name']}}" disabled>
			   </div>
		   </div> 
	   </div>
   </div>
   <div class="row">
	   <div class="col-sm-6">
		   <div class="form-group">
		   <label for="cardNumber">Country</label>
			   <div class="input-group">
				   <input type="text" class="form-control" name="cardNumber" placeholder="Eg. 000123456789" value="{{$account_detail->external_accounts->data[0]['country']}}" disabled>
			   </div>
		   </div>
	   </div>
	   <div class="col-sm-6">
		   <div class="form-group">
			   <label for="cardNumber">Currency</label>
			   <div class="input-group">
				   <input type="text" class="form-control" name="cardNumber" placeholder="Eg. 110000000" value="{{$account_detail->external_accounts->data[0]['currency']}}" disabled>
			   </div>
		   </div> 
	   </div>
   </div>
</div> 
</div> 
</div> 
</article>  
</div>


@endif
</div>
@endsection
