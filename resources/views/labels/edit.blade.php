@extends('layouts.app')

@section('content')
<main class="container">

    <h1 class="mb-3">{{ __("Change tag") }}</h1>

    <form method="POST" action="{{ route('labels.update', $label) }}" accept-charset="UTF-8" class="w-50">
        @method('PATCH')
        @csrf

        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input class="form-control  @error('name') is-invalid @enderror" value="{{ $label->name }}" name="name" type="text" id="name">
            @error('name')
            <div class="invalid-feedback d-block" role="alert" >
                <strong>{{ __($message, ['entity' => 'метка']) }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ $label->description }}</textarea>
            @error('description')
            <div class="invalid-feedback d-block" role="alert" >
                <strong>{{ __($message, ['entity' => 'метка']) }}</strong>
            </div>
            @enderror
        </div>

        <input class="btn btn-primary mt-2" type="submit" value="{{ __("Update") }}">

    </form>

</main>
@endsection