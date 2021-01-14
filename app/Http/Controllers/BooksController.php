<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    private $WORKS_API_URL = 'https://openlibrary.org';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $books = auth()->user()->books()->get();
        return view('books')->with(compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'books' => 'required|array'
        ]);

        foreach($validated['books'] as $olid) {
            $url = $this->WORKS_API_URL . '/api/books?bibkeys=OLID:' . $olid . '&format=json&jscmd=data';
            $json = file_get_contents($url);
            $book_data = json_decode($json);
            $book_olid_string = 'OLID:'.$olid;
            $book_data = $book_data->$book_olid_string;

            $book = new Book();
            $book->olid = $olid;
            $book->url = $book_data->url ?? '';
            $book->title = $book_data->title ?? '';
            $book->author = $book_data->authors[0]->name ?? 'Unknown';
            $book->author_url = $book_data->authors[0]->url ?? '#';
            $book->publish_date = $book_data->publish_date ?? '';
            $book->cover_small = $book_data->cover->small ?? '';
            auth()->user()->books()->save($book);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return redirect()->back();
    }
}
