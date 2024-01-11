@extends('voyager::master')

@section('page_title','Premios Sorteos')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-gift"></i> Premios Sorteos
    </h1>
    <a href="{{ route('voyager.raffles.show',$raffle->id) }}" class="btn btn-warning">
        <i class="voyager-double-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del premio</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prizes as $prize)
                                    <tr>
                                        <td>{{ $prize->name }}</td>
                                        <td>{{ $prize->quantity }}</td>
                                        <td>
                                            {{-- <form action="{{ route('prizes.destroy', ['prize' => $prize->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="voyager-trash"></i> Eliminar
                                                </button>
                                            </form> --}}
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModalPrize" data-prize="{{ $prize->id }}">
                                                <i class="voyager-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-body">
                        <form action="{{ route('prizes.store', ['raffle' => $raffle->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre del premio:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Cantidad:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear premio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="deleteModalPrize" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar este premio?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePrize">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        var prizeId;

        $('#deleteModalPrize').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            prizeId = button.data('prize');
        });

        // $('#confirmDeletePrize').click(function() {
        //     $.ajax({
        //         url: 'raffle/prizes/' + prizeId + '/delete',
        //         method: 'POST',
        //         data: {
        //             _method: 'DELETE',
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function() {
        //             location.reload();
        //         }
        //     });
        // });
        $('#confirmDeletePrize').click(function() {
            $.ajax({
                url: '/admin/raffle/prizes/' + prizeId + '/delete',
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    location.reload();
                }
            });
        });
    });
    </script>
@endsection

@section('javascript')

@endsection