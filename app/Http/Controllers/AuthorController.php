<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return Inertia::render('Authors/Index', ['authors' => $authors]);
    }

    public function create()
    {
        return Inertia::render('Authors/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'middle_name' => 'required|max:100',
        ]);

        $author = new Author($request->input());
        $author->save();
        //Author::create($request->only(['name', 'last_name', 'middle_name']));

        return redirect('authors');
    }


    public function show(Author $author)
    {
        //
    }

    public function edit(Author $author)
    {
        return Inertia::render('Authors/Edit', ['author' => $author]);
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'middle_name' => 'required|max:100',
        ]);

        $author->update($request->all());
        return redirect('authors');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect('authors');
    }
}
