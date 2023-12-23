@extends('base.base')
@section('title', 'Sorteo de Juego')
    
@section('content')
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 text-center mb-4">GAD<strong>Sorteos</strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col">
            <div class="card mb-4">
                <div class="card-per card-header pb-0">
                    <p class="title-cd text-center">Sorteo de Juego</p>
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
                    {{-- @foreach($participants as $participant)
                        <div class="participant" style="display:none;">{{$participant->name}}</div>
                    @endforeach --}}
                </div>
            </div>
            <input id="btn-start" class="btn btn-success mt-5" type="button" value="Comenzar">
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <select name="form-select" id="" aria-label="Default select example">
                        <option value="">---Seleccionar---</option>
                        <option value="0">Descartar Participante</option>
                        <option value="1">Elegir Ganador</option>
                    </select>
                    <input id="btn-stop" class="btn btn-primary mt-5" type="button" value="Parar">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($participants as $participant)
                                <tr>
                                    <td>{{ $participant->name }}</td>
                                    <td>{{ $participant->pivot->selected ? 'Ganador' : 'Descartado' }}</td>
                                </tr>
                            @endforeach --}}
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
</style>
@endsection
@section('js')
{{-- <script>
    var btnStart = document.getElementById('btn-start');
    var btnStop = document.getElementById('btn-stop');
    var intervalId;

    btnStart.addEventListener('click', function(event) {
        event.preventDefault();

        var participants = document.querySelectorAll('.participant');
        var index = 0;

        intervalId = setInterval(function() {
            if (participants.length > 0) {
                participants[(index - 1 + participants.length) % participants.length].style.display = 'none';
                participants[index].style.display = 'block';
            }

            index = (index + 1) % participants.length;
        }, 100); // Cambia cada segundo
    });

    btnStop.addEventListener('click', function(event) {
        event.preventDefault();

        if (intervalId) {
            clearInterval(intervalId);
        }
    });
</script> --}}
<script>
    $(document).ready(function() {
    var raffleId = 1; // Reemplaza esto con el ID de tu sorteo
    var participants = [];
    var index = 0;
    var intervalId;

    $('#btn-start').click(function() {
        if (intervalId) {
            clearInterval(intervalId);
        }
        $.getJSON('/raffle/' + raffleId + '/participants', function(data) {
            participants = data;
            intervalId = setInterval(function() {
                $('#roulette').text(participants[index].name);
                index = (index + 1) % participants.length;
            }, 300);
        });
    });

    $('#btn-stop').click(function() {
        if (intervalId) {
            clearInterval(intervalId);
        }
        $.getJSON('/raffle/' + raffleId + '/selectRandomParticipant', function(data) {
        if (data) {
            $('#roulette').text(data.name);
            $('#winnerModalBody').text(data.name + ' HA GANADO!');
            $('#winnerModal').modal('show');
        } else {
            $('#roulette').text('No hay más participantes.');
        }
    });
    });
});
</script>
@endsection