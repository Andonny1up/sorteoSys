@extends('base.base')
@section('title', 'AppSorteo')

@section('header')
<header>
    <figure>
        <img src="{{asset('img/logo_gad_beni.png')}}" alt="Logo" height="80px">
    </figure>
    <nav class="navbar">
        <i class="fa fa-ticket"></i>
        <span>{{$raffle->name}}</span>
    </nav>
</header>
@endsection

@section('content')
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 text-center mb-4 heading"><i class="fa fa-ticket"></i>App<strong>Sorteos</strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-0 col-md-4">
            <div class="card mb-4">
                <div class="card-per card-header pb-0">
                    <p class="title-cd text-center"><i class="fa fa-trophy"></i> Premios</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card mb-4">
                <div class="card-per card-header pb-0">
                    <p class="title-cd text-center">¡Presiona comenzar!</p>
                </div>
            </div>
            <div id="card-game" class="card">
                <div class="card-header card-per ps-4">
                    <p class="title-participants">Participantes</p>
                    <span class="text-total">TOTAL: {{$total_participants}}</span>
                </div>
                <div class="card-body">
                    <div id="roulette" class="roulette">
                        ¡SUERTE!
                    </div>
                </div>
            </div>
            <input id="btn-start" class="btn btn-success mt-5 mb-5" type="button" value="¡Comenzar!">
            <input id="btn-stop" class="btn btn-success mt-5 mb-5" type="button" value="¡Detener!">
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-body">
                    <select name="form-select" id="select-raffle" aria-label="Default select example">
                        <option value="">---Seleccionar---</option>
                        <option value="0">Descartar Participante</option>
                        <option value="1">Elegir Ganador</option>
                    </select>
                    
                    
                    <table id="part-result"class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participantsSelected as $participant)
                                @if ($participant->pivot->status == 'Ganador')
                                    <tr class="table-success">
                                @else
                                    <tr class="table-danger">
                                @endif
                                        <td>{{$participant->name}}</td>
                                        <td>{{$participant->pivot->status}}</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- MOdal --}}
    <div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="winnerModalLabel">Ganador</h5>
            </div>
            <div class="modal-body" id="winnerModalBody">
              <!-- El nombre del ganador se insertará aquí -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
@section('css')
<style>
   
</style>
@endsection
@section('js')
<script src="{{asset('confetti/confetti.js')}}"></script>
<script>
    $(document).ready(function() {
    var raffleId = {{$raffle->id}};
    var participants = [];
    var index = 0;
    var intervalId;

    $('#btn-start').click(function() {
        if (intervalId) {
            clearInterval(intervalId);
            index = 0;
        }
        $.getJSON('/raffle/' + raffleId + '/participants', function(data) {
            participants = data;
            if (participants.length == 0) {
                $('#roulette').text('No hay participantes.');
                return;
            }
            intervalId = setInterval(function() {
                $('#roulette').text(participants[index].name);
                index = (index + 1) % participants.length;
            }, 100);
        });
    });

    $('#btn-stop').click(function() {
        
        var selectValue = $('#select-raffle').val();
        $.getJSON('/raffle/' + raffleId + '/selectRandomParticipant?selectValue=' + selectValue, function(data) {
            console.log(data);
            if (data.name) {
                $('#roulette').text(data.name);
                var resultText = selectValue == 1 ? ' HA GANADO!' : ' HA SIDO DESCARTADO';
                let resultTextTitle = selectValue == 1 ? 'Ganador' : 'Descartado';
                if (intervalId) {
                    clearInterval(intervalId);
                    index = 0;
                }
                $('#winnerModalLabel').text(resultTextTitle);
                $('#winnerModalBody').text(data.name + resultText);
                $('#winnerModal').modal('show');
                $.getJSON('/raffle/' + raffleId + '/participants/selected', function(data) {
                    var tableBody = $('#part-result tbody');
                    tableBody.empty();
                    $.each(data, function(index, participant) {
                        var status = participant.pivot.status;
                        console.log(status);
                        if (status == 'Ganador') {
                            var row = $('<tr class="table-success">').append($('<td>').text(participant.name), $('<td>').text(status));
                        } else {
                            var row = $('<tr class="table-danger">').append($('<td>').text(participant.name), $('<td>').text(status));
                        }
                        
                        tableBody.append(row);
                    });
                });
            } else {
                if (intervalId) {
                    clearInterval(intervalId);
                    index = 0;
                }
                $('#roulette').text('No hay más participantes.');
            }
            
        });
        
        if (selectValue == 1) {
            setTimeout(startConfetti, 1000);
            setTimeout(stopConfetti, 3000); // detener la animación después de 3 segundos
        }
    });
});

// toggle ocultar botones comenzar y parada
$(document).ready(function() {
    $('#btn-start').click(function() {
        $(this).hide();
        $('#btn-stop').show();
    });

    $('#btn-stop').click(function() {
        $(this).hide();
        $('#btn-start').show();
    });
});

</script>

@endsection