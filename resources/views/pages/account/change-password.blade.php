@extends('layouts.default')
@section('content')
    <div class="inner_banner title_banner" style="background-image: url(images/inner_banner.jpg);">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="page-title"><h2>Cart</h2></div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <div class="container cart-items-container">
            <div class="row">
                <div class="col-lg-3 col-sm-12 profile-left-sidebar">
                    @include('pages.account.sidebar')
                </div>
                <div class="col-lg-9 col-sm-12">
                    @include('success-error')
                    <form action="{{ route('update.password.post') }}" method="post">
                        @csrf
                        <div class="cart_table billingdetail">
                            <div class="col-full">
                                <label>Old Password<span>*</span></label>
                                <input type="password" name="old_password" placeholder="Old Password" required>
                            </div>
                            <div class="col-full">
                                <label>New Password<span>*</span></label>
                                <input type="password" name="password" placeholder="New Password" required>
                            </div>
                            <div class="col-full">
                                <label>Confirm Password<span>*</span></label>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                            <div class="col-half">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection
@section('page_style')
    <style>
        .empty-cart-container {
            text-align: center;
        }

        /* Style the tab */
        .profile-left-sidebar .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 30%;
            height: 300px;
        }

        /* Style the buttons inside the tab */
        .profile-left-sidebar .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .profile-left-sidebar .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .profile-left-sidebar .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .profile-left-sidebar .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 70%;
            border-left: none;
            height: 300px;
        }
    </style>
@endsection
