<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\OrderAddress;

class OrderController extends Controller
{
    //
    public function getOrders()
    {
        $orders = Order::orderBy('created_at','desc')->paginate(15);
        return view('pages.admin.order.index',compact('orders'));
    }

    public function orderDetail($id)
    {
        $get_order_detail = Order::where('id',$id)->first();
        $get_order_address = OrderAddress::where('order_id',$id)->first();
        return view('pages.admin.order.view_detail',compact('get_order_detail','get_order_address'));
    }
}
