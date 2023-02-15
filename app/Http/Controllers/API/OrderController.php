<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitems;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 200,
            'orders' => $orders,
        ]);
    }
    public function vieworder($id)
    {
        $orderitem = Orderitems::where('order_id', $id)->get();
        if ($orderitem) {
            return response()->json([
                'status' => 200,
                'orderitems' => $orderitem,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Order Found',
            ]);
        }
    }
    public function order()
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $orders = Order::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                'orders' => $orders,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to View Order Data',
            ]);
        }
    }
    public function orderdetail($id)
    {
        $orderitem = Orderitems::where('order_id', $id)->get();
        if ($orderitem) {
            return response()->json([
                'status' => 200,
                'orderitems' => $orderitem,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Order Found',
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $orders = Order::find($id);
            if ($orders) {
                $orders->status = $request->input('status');
                $orders->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Order Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Order Not Found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $orders = Order::find($id);
        if ($orders) {
            $orders->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Order Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Order ID Found',
            ]);
        }
    }
    public function deleteorder($id)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $orders = Order::where('id', $id)->where('user_id', $user_id)->first();
            if ($orders) {
                $orders->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Order Item Removed Successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Order Item not Found',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ]);
        }
    }
    public function received(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $orders = Order::find($id);
            if ($orders) {
                $orders->status = $request->input('status');
                $orders->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Order Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Order Not Found',
                ]);
            }
        }
    }
    public function updatestatus($order_id, $status)
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $orders = Order::where('id', $order_id)->where('user_id', $user_id)->first();
            if ($status) {
                $orders->status = $status;
            }
            $orders->update();
            return response()->json([
                'status' => 200,
                'message' => 'Order up  Updated',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to continue',
            ]);
        }
    }
}
