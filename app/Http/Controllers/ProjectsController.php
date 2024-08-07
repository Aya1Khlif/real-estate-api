<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

use Exception;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Projects::paginate(10);
        if ($projects) {
            return response()->json($projects, 200);
        } else    return response()->json('no projects');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        try {
            $projects = new Projects();
            $projects->title = $validatedData['title'];
            $projects->description = $validatedData['description'];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads/category'), $filename);
                $projects->image = $filename;
            }

            $projects->save();
            return response()->json('projects added successfully', 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while adding the projects'], 500);
        }
    }
    public function show(Projects $projects, $id)
    {
        $projects = Projects::find($id);
        if ($projects) {
            return response()->json($projects, 200);
        } else  return response()->json('no projects found');
    }
}
