@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <todo-component route="{{ url('/api/') }}"></todo-component>
        </div><!--col-->
    </div><!--row-->
@endsection
