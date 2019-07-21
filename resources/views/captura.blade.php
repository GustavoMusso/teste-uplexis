@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Buscar Artigos</h1>
        @if(count($msg) > 0)
            <div class="alert alert-{{ $msg['type'] }} alert-dismissible fade show" role="alert">
                {{ $msg['msg'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form method="post" action="{{ route('home.store') }}">
            <div class="row">
                {{ csrf_field() }}
                <div class="col-sm-11">
                    <div class="form-group">
                        <label for="pesquisa" class="sr-only">Pesquisa</label>
                        <input type="text" id="pesquisa" name="pesquisa" class="form-control" placeholder="Pesquisa">
                    </div>
                </div>

                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
