<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Get all resources
     *
     * @return void
     */
    public function index()
    {
        return response()->json(['categories' =>  Category::all()], 200);
    }

    /**
     * Display specified resource
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'response' => $category
        ], 200);
    }

    /**
     * Store new resource
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'status' => 'required',
        ]);

        try {
            $category = new Category;
            $category->name = $request->input('name');
            $category->status = $request->input('status');

            $category->save();
            
            //return success message
            return response()->json(
                [
                    'response' => [
                        'created' => true,
                        'categoryId' => $category->id
                    ]
                ], 201
            );
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'An error occured while saving.'], 409);
        }
    }

    /**
     * Update a resource by ID
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        try {
            $category = Category::find($id);
            $category->name = $request->name;
            $category->status = $request->status;
            
            $category->save();

            return response()->json(['response' => $category], 200);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'An error occured while saving.'], 409);
        }
    }
}