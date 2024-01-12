<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with(['author:id,name', 'category:id,name'])
            ->paginate(10);
        $categories = Category::all();
        $authors = Author::all();
        return Inertia::render(
            'Books/Index',
            ['books' => $books, 'categories' => $categories, 'authors' => $authors]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'category_id' => 'required|numeric',
            'author_id' => 'required|numeric'
        ]);
        $book = new book($request->input());
        $book->save();
        return redirect('books');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|max:150',
            'category_id' => 'required|numeric',
            'author_id' => 'required|numeric',
        ]);
        $book->update($request->input());
        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('books');
    }

    public function BookByAuthor()
    {
        $data = Book::select(DB::raw('count(books.id) as count, authors.name '))
            ->join('authors', 'authors.id', '=', 'books.authors.id')
            ->groupBy('authors.first_name')->get();
        return Inertia::render('Books/Graphics', ['data' => $data]);
    }
    public function reports()
    {
        $books = Book::select(
            'books.id',
            'books.name',
            'category.id',
            'categories.name as category',
            'author.id',
            'authors.firs_name as author'
        )
            ->join('categories', 'categories.id', '=', 'books.categories.id')
            ->join('authors', 'authors.id', '=', 'books.authors.id')
            ->get();

        $categories = Category::all();
        $authors = Author::all();

        return Inertia::render(
            'Books/Reports',
            ['books' => $books, 'categories' => $categories, 'authors' => $authors]
        );
    }
}
