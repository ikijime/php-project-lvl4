@extends('layouts.app')

@section('content')
<div style="max-width: 600px" class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-5">{{__('Привет от Хекслета!')}}</h1>
        <p class="col-md-8 fs-4">
            Практические курсы по программированию
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