@extends('layouts.layout')

@section('title', 'Авторы')

@section('content')
<a  class="btn btn-primary mb-3"  href="{{route('authors.create')}}">Добавить автора</a>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">ФИО</th>
      <th scope="col">Количество книг</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
    @foreach($authors as $author)
    <tr>
      <th scope="row">{{$author->id }}</th>
      <td>{{$author->FIO}}</td>
      <td>{{$author->quantity}}</td>
      <td><a  class="btn btn-warning" href="{{route('authors.edit', $author->id)}}">Изменить</a>
      <a  class="btn btn-danger" href="{{route('delete_author', $author->id)}}">Удалить</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

<table class="table">
@endsection
