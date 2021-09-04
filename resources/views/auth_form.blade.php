@extends('layouts.layout')

@section('title', isset($id) ?' Форма обновления автора ': 'Форма добавления автора')

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
<form method="POST" action="{{isset($id) ? route('authors.update', $author->id) : route('authors.store')}}">
    @csrf
    @isset($id)
        @method('PUT')
    @endisset
    <div class="form-group">
        <label for="FIO ">ФИО автора</label>
        <input type="text" class="form-control" name="FIO" id="FIO" placeholder="Введите ФИО автора" value="{{isset($id)? $author->FIO : old('FIO')}}">

    </div>
    <button type="submit" class="btn btn-primary">{{isset($id)? 'Изменить' : 'Добавить' }}</button>
</form>
@endsection