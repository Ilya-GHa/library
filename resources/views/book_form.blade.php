@extends('layouts.layout')

@section('title', isset($id) ? 'Обновление книги: '.$book->title: 'Добавление книги')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<form method="POST" action="{{isset($id) ? route('update_book', $id) : route('books.store')}}">
  @csrf
  <div class="form-group">
    <label for="title ">Название</label>
    <input type="text" class="form-control" name="title" id="title" placeholder="Название книги" value="{{isset($id)? $book->title:old('title')}}">
  </div>
  <div class="form-group">
    <label for="publication_year ">Год издания</label>
    <input type="text" class="form-control" name="publication_year" id="publication_year " placeholder="Год издания" value="{{isset($id)?$book->publication_year:old('publication_year')}}">
    <div class="form-group mt-2">
      <label for="">Авторы:</label>
      @foreach($authors as $author)
      <p><label for="author">{{$author->FIO}}</label>

        @if(isset($id))
        <input type="checkbox" name="authors[]" id="author" value="{{$author->id}}" @if($book->authors()->where('author_id', $author->id)->count())
        checked="checked"
        @endif>

        @else
        <input type="checkbox" name="authors[]" id="author" value="{{$author->id}}">
        @endif

      </p>
      @endforeach
    </div>
    <button type="submit" class="btn btn-primary">{{isset($id)? 'Изменить' : 'Добавить' }}</button>
</form>
@endsection