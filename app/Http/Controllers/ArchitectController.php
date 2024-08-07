<?php

namespace App\Http\Controllers;

use App\Models\Architest;
use Illuminate\Http\Request;

use Exception;
class ArchitectController extends Controller
{
    public function index()
    {
        $architest = Architest::paginate(10);
        if ($architest) {
            return response()->json($architest, 200);
        } else    return response()->json('no architest');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required',
            'image' => 'required|image',
        ]);

        try {
            $architest = new Architest();
            $architest->name = $validatedData['name'];
            $architest->position = $validatedData['position'];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads/category'), $filename);
                $architest->image = $filename;
            }

            $architest->save();
            return response()->json('architest added successfully', 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while adding the architest'], 500);
        }
    }
    public function show(Architest $architest, $id)
    {
        $architest = Architest::find($id);
        if ($architest) {
            return response()->json($architest, 200);
        } else  return response()->json('no architest found');
    }


}
