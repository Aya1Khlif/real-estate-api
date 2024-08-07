<?php

namespace App\Http\Controllers;


use App\Models\Services;
use Exception;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    public function index()
    {
        $services = Services::paginate(10);
        if ($services) {
            return response()->json($services, 200);
        } else    return response()->json('no Services');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'required|',
            'description' => 'required|',

        ]);

        try {
            $services = new Services();
            $services->title = $validatedData['title'];
            $services->sub_title = $validatedData['sub_title'];
            $services->description = $validatedData['description'];

            $services->save();
            return response()->json('Product added successfully', 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while adding the product'], 500);
        }
    }
    public function show(Services $services, $id)
    {
        $services = Services::find($id);
        if ($services) {
            return response()->json($services, 200);
        } else  return response()->json('no Services found');
    }
}
