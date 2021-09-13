<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     * 
     */



    public function index(Request $request)
    {

        $author = Author::find($request->author);


        function getAuthor()
        {
            if (request()->filled('author')) {
               return $author_id = request()->author;
            }
        };

        if ($request->filled('author')) {
            
            $bookQuery = Book::whereHas('authors', function ($q) {

                $q->where('author_id', getAuthor()); //this refers id field from categories table

            })
                ->get();

        } else {
            $bookQuery = Book::get();
        };

        return view('books', [
            'books' => $bookQuery,
            'authors' => Author::get(),
            'selectedAuth' => $author
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            'book_form',
            [
                'book' => [],
                'authors' => Author::get()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * 
     *

     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->all());

        if ($request->input('authors')) {
            // dd($request);
            $book->authors()->attach($request->input('authors'));

            $length = count($request->authors);
            for ($i = 0; $i < $length; $i++) {

                $author = Author::find($request->authors[$i]);

                $author->quantity += 1;
                $author->save();
            }
        }

        return redirect()->route('books.index', $book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**  
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('book_form', [
            'id' => $id,
            'book' => Book::findOrFail($id),
            'authors' => Author::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {


        $book = Book::findOrFail($id);

        $authors = Author::get();

        foreach ($authors as $author) {
            $array[] = $author->id;
        }

        // dd($request->authors);

        $book->update($request->all());

        // $book->authors()->detach();

        if ($request->input('authors')) {

            $length_all_authors = count($array);
            $length_selected_authors = count($request->authors);

            // dd($length_all_authors, $length_selected_authors);
            for ($i = 0; $i < $length_all_authors; $i++) {

                for ($y = 0; $y < $length_selected_authors; $y++) {

                    // dd($array[$i] == $request->authors[$y] && $book->authors()->where('author_id', $array[$i])->count() != 1?true:false);
                    if ($book->authors()->where('author_id', $array[$i])->count() != 1 && $array[$i] == $request->authors[$y]) {


                        $author = Author::find($array[$i]);

                        $author->quantity += 1;
                        $author->save();


                        $book->authors()->attach($request->authors[$y]);
                    }
                }
            }
            $related_authors = $book->authors()->get();
            foreach ($related_authors as $related_author) {
                $count = 0;
                for ($y = 0; $y < $length_selected_authors; $y++) {
                    if ($request->authors[$y] == $related_author->id) {
                        // $book->authors()->detach($related_author->id);
                        $count++;
                    }
                    $res = $request->authors[$y] != $related_author->id ? 'true' : 'false';
                    // echo " Автор из реквеста: " . $request->authors[$y] . " Автор привязанный: " . $related_author->id . " Результат -> ".$res.'<br>';



                }
                // echo "ITOG: ".$count."<br>";
                if ($count == 0) {
                    // dd($related_author->quantity);
                    $related_author->quantity -= 1;
                    $related_author->save();
                    $book->authors()->detach($related_author->id);
                }

                //  dd($related_author->quantity);
            }
            // dd($res);

        } else {
            $related_authors = $book->authors()->get();
            foreach ($related_authors as $related_author) {
                $related_author->quantity -= 1;
                $related_author->save();
            }
            $book->authors()->detach();
        }
        return redirect()->route('books.index', $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $authors = Author::get();

        $book = Book::findOrFail($id);

        foreach ($authors as $author) {

            if ($book->authors()->where('author_id', $author->id)->count()) {

                $author->quantity -= 1;

                $author->save();
            }
        }
        $book->authors()->detach();

        $book->delete();

        return redirect()->route('books.index');
    }
}
