<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('role_as', '0')->get();
        return response()->json([
            'status' => 200,
            'users' => $user
        ]);
    }
    public function viewuser()
    {
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $user = User::where('id', $user_id)->where('role_as', '0')->get();
            return response()->json([
                'status' => 200,
                'users' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Login to View User Data',
            ]);
        }
    }
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'users' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Users Found',
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
            $user = User::find($id);
            if ($user) {
                $user->status = $request->input('status');
                $user->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'User Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'User Not Found',
                ]);
            }
        }
    }
}
