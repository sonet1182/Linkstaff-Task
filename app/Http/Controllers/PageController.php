<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:pages,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $page = new Page();
            $page->name = $request->input('name');
            $page->user_id = Auth::user()->id;
            $page->save();

            return response()->json([
                'status' => 200,
                'message' => 'Page has Been Created Successfully',
            ]);
        }
    }
}
