<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    public function index()
    {
        $size = Size::all();
        return response()->json([
            'status' => 200,
            'size' => $size,
        ]);
    }

    public function allsize()
    {
        $size = Size::where('status', '0')->get();
        return response()->json([
            'status' => 200,
            'size' => $size,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $size = new Size;
            $size->name = $request->input('name');
            $size->status = $request->input('status') == true ? '1' : '0';
            $size->save();
            return response()->json([
                'status' => 200,
                'message' => 'Size Added Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $size = Size::find($id);
        if ($size) {
            return response()->json([
                'status' => 200,
                'size' => $size
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Size Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $size = Size::find($id);
            if ($size) {
                $size->name = $request->input('name');
                $size->status = $request->input('status') == true ? '1' : '0';
                $size->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Size Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Size ID Found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $size = Size::find($id);
        if ($size) {
            $size->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Size Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Size ID Found',
            ]);
        }
    }
}
