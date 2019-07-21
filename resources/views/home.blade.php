@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Artigos</h1>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Título</th>
                <th>Link</th>
                <th>Usuário</th>
                <th>Ações</th>
            </tr>
            </thead>

            <tbody>
            @forelse($artigos as $artigo)
                <tr>
                    <td>{{ $artigo->titulo }}</td>
                    <td><a href="{{ $artigo->link }}">{{ $artigo->link }}</a></td>
                    <td>{{ $artigo->user->usuario }}</td>
                    <th><a href="#" class="btn btn-danger btn-xs btn-del" data-id="{{ $artigo->id }}">&times;</a></th>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Não há artigos registrados!</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('.btn-del').on('click', function (e) {
            e.preventDefault();
            const csrf = $('meta[name=csrf-token]').attr('content');
            const id = $(this).data('id');

            $.ajax({
                contentType: 'application/x-www-form-urlencoded',

                method: 'DELETE',
                url: `http://${location.host}/home/delete/${id}`,

                data: {
                    _token: csrf
                },

                success: function (response) {
                    location.reload();
                }
            });
        });
    </script>
@stop
