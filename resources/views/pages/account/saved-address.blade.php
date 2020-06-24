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
                    <div class="cart_table">
                        @if(!empty($data['addresses']))
                            <table>
                                <tr>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                                <tbody>
                                @foreach($data['addresses'] as $address)
                                    <tr>
                                        <td>
                                            {{ $address['first_name'] . " " . $address['last_name'] }}<br>
                                            {{ $address['city'] }}, {{ $address['state'] }}, {{ $address['zip'] }}<br>
                                            {{ $address['address'] }}<br>
                                            {{ $address['email'] }}<br>
                                            {{ $address['mobile'] }}
                                        </td>
                                        <td>
                                            <a href="{{ route('delete.address', $address['id']) }}" title="Delete Address"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center no-address-container">
                                <h3>No Saved Address</h3>
                            </div>
                        @endif
                    </div>
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

        .no-address-container {
            padding: 70px;
        }
    </style>
@endsection
