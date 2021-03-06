@extends('layouts.app')

@section('content')
<main class="container">
    <h1 class="mb-4">{{__("Create task")}}</h1>
    <form method="POST" action="{{ route('tasks.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf
        
        <div class="form-group">
            <label for="name">{{ __("Name") }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="name">
            @error('name')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ __($message, ['entity' => 'задача']) }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">{{ __("Description") }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" value="{{ old('name') }}" name="description" cols="50" rows="10" id="description"></textarea>
            @error('description')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ __($message, ['entity' => 'задача']) }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status_id">{{ __("Status") }}</label>
            <select class="form-control @error('description') is-invalid @enderror" id="status_id" name="status_id">
                @foreach (App\Models\TaskStatus::all() as $status)
                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
                @endforeach
            </select>
            @error('status_id')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ __($message, ['entity' => 'задача']) }}</strong>
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="assigned_to_id">{{ __("Executor") }}</label>
            <select class="form-control" id="assigned_to_id" name="assigned_to_id">
                @foreach (App\Models\User::all() as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="labels">{{ __("Tags") }}</label>
            <select class="form-control" multiple name="labels[]">
                @foreach (App\Models\Label::all() as $label)
                <option value="{{ $label->id }} ">{{ $label->name }}</option>
                @endforeach
            </select>
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __("Create") }}" />
    </form>
</main>
@endsection