<div class="list-group list-group-profile-sidebar">
    <a href="{{ route('account') }}" class="list-group-item  {{ $data['page'] == 'account' ? 'active' : '' }}">
        <i class="fa fa-user"></i> Profile
    </a>
    <a href="{{ route('my.orders') }}" class="list-group-item {{ $data['page'] == 'my-orders' ? 'active' : '' }}">
        <i class="fa fa-edit"></i> My Orders
    </a>
    <a href="{{ route('change.password') }}" class="list-group-item {{ $data['page'] == 'change-password' ? 'active' : '' }}">
        <i class="fa fa-key"></i> Change Password
    </a>
    <a href="{{ route('saved.address') }}" class="list-group-item {{ $data['page'] == 'saved-address' ? 'active' : '' }}">
        <i class="fa fa-address-card"></i> Saved Address
    </a>
</div>
