<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h3 class="my-0 mr-md-auto font-weight-normal">@yield('title')</h3>
        <nav class="my-2 my-md-2 mr-md-3 p-2">
            <a class="p-2 text-dark" href="{{route('books.index')}}">Список книг</a>
            <a class="p-2 text-dark" href="{{route('authors.index')}}">Список авторов</a>
        </nav>
    </div>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>