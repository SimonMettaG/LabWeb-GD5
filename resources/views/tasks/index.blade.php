@extends('layouts.main')

@section('content')
<div style="text-align: center; margin-top: 10px">
    <h1>Dashboard</h1>
</div>
<br>
<div style="text-align: center">
    <button class="btn btn-success" onclick="createTask()">Agregar nuevo</button>
</div>
<br><br>
<div class="container-fluid" style="text-align: center">
    <div class="row">
        <div class="col">
            <div style="border: 3px black solid; border-radius: 5px" id="start" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>Salida de planta</h5>
                <hr>
                @foreach ($tasks as $task)
                        @if ($task->status == 1)
                        <div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
                <br>
            </div>
        </div>
        <div class="col">
            <div style="border: 3px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>LDC</h5>
                <hr>
                @foreach ($tasks as $task)
                    @if ($task->status == 2)
                        <div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            <div style="border: 3px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>Proceso de entrega</h5>
                <hr>
                @foreach ($tasks as $task)
                        @if ($task->status == 3)
                        <div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            <div style="border: 3px black solid; border-radius: 5px">
                <div style="border: 2px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <h5>Entregado</h5>
                    <hr>
                    @foreach ($tasks as $task)
                        @if ($task->status == 4)
                            <div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                                Task #{{$task->id}}
                            </div>
                            <br>
                        @endif
                    @endforeach
                </div>
                <br>
                <div style="border: 2px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <h5>Fallido</h5>
                    <hr>
                    @foreach ($tasks as $task)
                        @if ($task->status == 5)
                            <div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                                Task #{{$task->id}}
                            </div>
                            <br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('layout_end_body')
<script>
    function createTask() {
        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {}
        })
        .done(function(response) {
            $('#start').append('<div class="container" style="border: 1px black solid; border-radius: 5px" draggable="true">Task #'+response.id+'</div><br>');
            console.log(response.id, response.status);
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }

    /*
    function updateTask(taskId) {
        let theURL='{{ route('tasks.update', 0)}}'+taskId;
        //console.log(taskId);
        $.ajax({
            url: theURL,
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: taskId
            }
        })
        .done(function(response) {
            if(response.is_done == 1) {
                $('#status' + taskId).html('No');
            }
            else {
                $('#status' + taskId).html('Sí');
            }
            //console.log(response.description);
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }
    */

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        aaaaa = ev.target
        ev.dataTransfer.setData("text", ev.target);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        console.log(data);
        ev.target.appendChild(aaaaa);
    }
</script>
