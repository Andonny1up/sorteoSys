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
                <div class="card-body">
                    {{-- <select name="" id="">
                        @foreach ($prizes_remaining as $prize)
                            <option value="{{$prize->id}}">{{$prize->name}}</option>
                        @endforeach
                    </select> --}}
                    <table id="table-prizes" class="table">
                        <thead>
                            <tr>
                                <th>PREMIOS</th>
                                <th>Cantidad Restante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prizes_remaining as $prize)
                                <tr>
                                    <td>{{$prize->name}}</td>
                                    <td style="text-align: end">{{$prize->remaining}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card mb-4">
                <div class="card-per card-header pb-0">
                    <p class="title-cd text-center">¡Buena Suerte!</p>
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
                    {{-- <select name="form-select" id="select-raffle" aria-label="Default select example">
                        <option value="">---Seleccionar---</option>
                        <option value="0">Descartar Participante</option>
                        <option value="1">Elegir Ganador</option>
                    </select> --}}
                    
                    
                    <table id="part-result"class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Premio</th>
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
                                        @if ( $participant->prize )
                                            <td>{{$participant->prize->name }}</td>
                                        @else
                                            <td></td>
                                        @endif
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
            <div id="header-modal-winner" class="modal-header card-per">
              <h5 class="modal-title" id="winnerModalLabel" style="color: white">Ganador</h5>
            </div>
            <div class="container-icon">
                <i id="icon-1" class="fa fa-ticket"></i>
                <i id="icon-2" class="fa fa-trophy" style="color: gold; display: none;"></i>
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
    {{-- Modal confi sorteo --}}
    <div class="modal fade" id="prizeModal" tabindex="-1" aria-labelledby="prizeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div id="header-modal-confi" class="modal-header select-red">
              <h5 class="modal-title" id="prizeModalLabel"> <i class="fa fa-trophy"></i> Iniciar Sorteo <i class="fa fa-trophy"></i></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="prize" style="display: block">¿Elegir Premio?</label>
                <select name="prize" id="prize-select">
                    <!-- llenar el select con los premios disponibles -->
                    @foreach ($prizes_remaining as $prize)
                        <option value="{{$prize->id}}">{{$prize->name}}</option>
                    @endforeach
                </select>
              <label for="status" style="display: block">¿Descartar o Elegir Ganador?</label>
              <select name="status" id="select-raffle" class="select-red">
                <option value="0" style="background-color: #ff3838">Descartar Participante</option>
                <option value="1" style="background-color: rgba(0,255,69,1)">Elegir Ganador</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="confirm-selection">OK</button>
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


    // $('#btn-start').click(function() {
    //     if (intervalId) {
    //         clearInterval(intervalId);
    //         index = 0;
    //     }
    //     $.getJSON('/raffle/' + raffleId + '/participants', function(data) {
    //         participants = data;
    //         if (participants.length == 0) {
    //             $('#roulette').text('No hay participantes.');
    //             return;
    //         }
    //         intervalId = setInterval(function() {
    //             $('#roulette').text(participants[index].name);
    //             index = (index + 1) % participants.length;
    //         }, 100);
    //     });
    // });

    // $('#btn-start').click(function() {
    //     // Muestra el modal en lugar de comenzar el sorteo inmediatamente
    //     $('#prizeModal').modal('show');
    // });
    $('#btn-start').click(function() {
        // Realiza una consulta AJAX para verificar si aún hay participantes no seleccionados
        $.getJSON('/raffle/' + raffleId + '/participants/notSelected', function(data) {
            if (data.length > 0) {
                $('#prizeModal').modal('show');
            } else {
                $('#roulette').text('No hay participantes.');
            }
        });
    });

    $('#confirm-selection').click(function() {
        // Obtiene los valores seleccionados
        var selectPrize = $('#prize-select').val();
        var selectValue = $('#select-raffle').val();

        // Cierra el modal
        $('#prizeModal').modal('hide');

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
        
        // Obtiene los valores seleccionados
        var selectPrize = $('#prize-select').val();
        var selectValue = $('#select-raffle').val();
        
        $.getJSON('/raffle/' + raffleId + '/selectRandomParticipant?selectValue=' + selectValue + '&selectPrize=' + selectPrize, function(data) {
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
                        if (participant.prize) {
                            var namePrize = participant.prize.name;
                        } else {
                            var namePrize = '';
                        }
                        console.log(status);
                        if (status == 'Ganador') {
                            var row = $('<tr class="table-success">').append($('<td>').text(participant.name), $('<td>').text(status), $('<td>').text(namePrize));
                        } else {
                            var row = $('<tr class="table-danger">').append($('<td>').text(participant.name), $('<td>').text(status), $('<td>').text(namePrize));
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

            $.getJSON('/raffle/' + raffleId + '/prizes', function(data) {
            // Actualiza el select
            var select = $('#prize-select');
            select.empty();
            $.each(data, function(index, prize) {
                select.append($('<option></option>').attr('value', prize.id).text(prize.name));
            });

            // Actualiza la tabla de premios
            var tableBody = $('#table-prizes tbody');
            tableBody.empty();
            $.each(data, function(index, prize) {
                var row = $('<tr>').append($('<td>').text(prize.name), $('<td style="text-align: end">').text(prize.remaining));
                tableBody.append(row);
            });
            // ...
        });
        }
    });
});

// toggle ocultar botones comenzar y parada
$(document).ready(function() {
    $('#confirm-selection').click(function() {
        $('#btn-start').hide();
        $('#btn-stop').show();
    });

    $('#btn-stop').click(function() {
        $(this).hide();
        $('#btn-start').show();
    });
});

// Cambiar el color red or green
$('#select-raffle').change(function() {
    if ($(this).val() == '0') {
        $(this).removeClass('select-default').addClass('select-red');
        $('#header-modal-confi').removeClass('select-default').addClass('select-red');
        $('#icon-2').hide();
        $('#icon-1').show();

    } else {
        $(this).removeClass('select-red').addClass('select-default');
        $('#header-modal-confi').removeClass('select-red').addClass('select-default');
        
        $('#icon-1').hide();
        $('#icon-2').show();
    }
});

</script>

@endsection