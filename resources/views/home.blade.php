@extends('layouts.app')

@section('content')
<div style="max-width: 600px" class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-4">{{__('Task manager')}}</h1>
        <p class="lead">Завершающий проект по профессии PHP-Программист на <a href="http://hexlet.io/">Hexlet.io</a> </p>
        <hr class="my-4">
        <p>
            Небольшое приложение для создания задач. Позволяет назначать исполнителей и устанавливать метки. Подключена стандартная авторизация Laravel. В проекте закрепляются знания базовых CRUD операций Laravel, Eloquent отношений между таблицами(Один к одному, Множество к множеству и тд).
            Используется фильтрация данных запроса при помощи spatie/laravel-query-builder.
            Сайт в процессе разработки.
        </p>
        <p class="lead">
            <a class="btn btn-primary" href="#" role="button">{{__("Learn more")}}</a>
        </p>
    </div>
</div>
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('home') }}
@endsection