@extends('base.base')
@section('title', 'Sorteo de Juego')
    
@section('content')
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 text-center mb-4">App<strong>Sorteos</strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-0 col-md-4"></div>
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

                    </div>
                </div>
            </div>
            <input id="btn-start" class="btn btn-success mt-5 mb-5" type="button" value="Comenzar">
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-body">
                    <select name="form-select" id="select-raffle" aria-label="Default select example">
                        <option value="">---Seleccionar---</option>
                        <option value="0">Descartar Participante</option>
                        <option value="1">Elegir Ganador</option>
                    </select>
                    
                    <input id="btn-stop" class="btn btn-primary mt-3" type="button" value="Parar">
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
    .card{
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
        
    }
    .card-per{
        background: rgb(19,129,48);
        background: linear-gradient(90deg, rgba(19,129,48,1) 0%, rgba(43,214,89,1) 76%, rgba(0,255,69,1) 100%);
    }
    .title-cd {
        font-size: 1.5rem;
        font-weight: bold;
        color: #fff;
    }
    .title-participants{
        font-size: 1.2rem;
        font-weight: bold;
        color: #fff;
    }
    .text-total{
        font-size: 0.8rem;
        color: #fff;
    }
    #btn-start{
        font-size: 1.5rem;
        font-weight: bold;
        width: 100%;
        border: none;
        background-color: #0AF275;
    }
    #btn-start:hover{
        background-color: #0adb6c;
    }
    #card-game .card-body{
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .roulette{
        width: 100%;
        height: 50px;
        background-color: #fff;
        border-radius: 10px;
        border: 1px solid #838383;
        overflow: hidden;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #btn-stop{
        font-weight: bold;
        width: 100%;
        border: none;
    }
    #select-raffle{
        width: 100%;
        margin-bottom: 10px;
        padding: 5px;
        border-radius: 5px;
    }
</style>
@endsection
@section('js')
<script src="{{asset('confetti/confetti.js')}}"></script>
<script>
    $(document).ready(function() {
    var raffleId = 1; // Reemplaza esto con el ID de tu sorteo
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
                if (intervalId) {
                    clearInterval(intervalId);
                    index = 0;
                }
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
</script>

@endsection