@extends('layouts.layout')

@section('title', 'Книги')

@section('content')

<form action="{{route('books.index')}}" method="get">

<label for="inputState">Автор</label>
<select name="author" id="author" class="mb-3 form-control">
    @foreach($authors as $author)
    <option value="{{$author->id}}" >{{$author->FIO}}</option>
    @endforeach
  </select>
  <input type="submit" value="Сортировать" class="btn btn-primary mb-3">
  <a href="{{route('books.index')}}" class="btn btn-primary mb-3">Сбросить</a>
</form>
@if(!$books->count())
  <h3 class="mb-3">Книг автора "{{$selectedAuth->FIO}}" не найдено</h3>
 @else
<h3 class="mb-3"> {{isset($selectedAuth) ? 'Книги автора "'.$selectedAuth->FIO.'"' : null}}</h3>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Название</th>
      <th scope="col">Автор</th>
      <th scope="col">Год издания</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($books as $book)
    <tr>
      <th scope="row">{{$book->id}}</th>
      <td>{{$book->title}}</td>
     
      <td>{{$book->authors()->pluck('FIO')->implode(", ")}}</td>
      <td>{{$book->publication_year}}</td>
     
      <td><a  class="btn btn-warning" href="{{route('books.edit', $book)}}">Изменить</a>
      <a  class="btn btn-danger" href="{{route('delete_book', $book->id)}}">Удалить</a></td>
    
    </tr>
    @endforeach
  </tbody>
</table>
@endif
<a  class="btn btn-primary mb-3"  href="{{route('books.create')}}">Добавить книгу</a>

@endsection

