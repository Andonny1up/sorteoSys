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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prizes as $prize)
                                    <tr>
                                        <td>{{ $prize->name }}</td>
                                        <td>{{ $prize->quantity }}</td>
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
@endsection