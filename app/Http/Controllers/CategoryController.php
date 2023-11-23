<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }


    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $category = new Category($request->input());
        $category->save();
        return redirect('categories');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $category->update($request->all());
        return redirect('categories');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('categories');
    }
}
