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
            <div style="border: 3px black solid; border-radius: 5px" id="cont1" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>Salida de planta</h5>
                <hr>
                @foreach ($tasks as $task)
                        @if ($task->status == 1)
                        <div id={{$task->id}} name="{{$task->id}}" class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            <div id="cont2" style="border: 3px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>LDC</h5>
                <hr>
                @foreach ($tasks as $task)
                    @if ($task->status == 2)
                        <div id={{$task->id}} name="{{$task->id}}" class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            <div id="cont3" style="border: 3px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                <h5>Proceso de entrega</h5>
                <hr>
                @foreach ($tasks as $task)
                        @if ($task->status == 3)
                        <div id={{$task->id}} name="{{$task->id}}" class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                            Task #{{$task->id}}
                        </div>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            <div style="border: 3px black solid; border-radius: 5px">
                <div id="cont4" style="border: 2px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <h5>Entregado</h5>
                    <hr>
                    @foreach ($tasks as $task)
                        @if ($task->status == 4)
                            <div id={{$task->id}} name="{{$task->id}}" class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
                                Task #{{$task->id}}
                            </div>
                            <br>
                        @endif
                    @endforeach
                </div>
                <br>
                <div id="cont5" style="border: 2px black solid; border-radius: 5px" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <h5>Fallido</h5>
                    <hr>
                    @foreach ($tasks as $task)
                        @if ($task->status == 5)
                            <div id={{$task->id}} name="{{$task->id}}" class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">
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
<br>
<div id="textarea" class="container" style="border: 2px black solid; border-radius: 5px">
    
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
            $('#cont1').append('<div id='+response.id+' name='+response.id+'class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">Task #'+response.id+'</div><br>');

            console.log(response.id, response.status);
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }

    
    function updateTask(taskId, new_status) {
        let theURL='{{ route('tasks.update', 0)}}' + taskId;
        $.ajax({
            url: theURL,
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: taskId,
                status: new_status
            }
        })
        .done(function(response) {
          
            console.log(response.status);
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    }
    

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        aaaaa = ev.target
        idvalue = ev.target.attributes.id.nodeValue;
        var target = ev.target;
        var parent = target.parentElement;
        if (parent.id == "cont4") {
            alert("Producto ya fue entregado");
        }
        /*else if(parent.id == "5"){
            alert("Producto fallido al entregar");
        }*/ 
        else{
            ev.dataTransfer.setData("text", ev.target);
        }
    }

    function drop(ev) {
        ev.preventDefault();
        statusvalue = ev.target.attributes.id.nodeValue;
        if (ev.target.id == "cont1") {
            alert("No puede regresar a Planta");
        }
        else
        {
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(aaaaa);
        }

        if(statusvalue=="cont1"){
            statusvalue=1;
        }
        else if(statusvalue=="cont2"){
            statusvalue=2;
        }
        else if(statusvalue=="cont3"){
            statusvalue=3;
        }
        else if(statusvalue=="cont4"){
            statusvalue=4;
        }
        else{
            statusvalue=5;
        }

        updateTask(idvalue, statusvalue);
    }

    Echo.channel("test")
        .listen('TestEvent', function(data) {
            console.log(data);
        });
    
    Echo.channel("changeStatus")
        .listen('ChangeStatus', function(data) {
            console.log(data);
            $("#"+data.task.id).remove();
            $('#cont'+data.task.status).append('<div id='+data.task.id+' name='+data.task.id+'class="container" style="border: 1px black solid; border-radius: 5px" draggable="true" ondragstart="drag(event)">Task #'+data.task.id+'</div><br>');
            $('#textarea').append('<p>Task '+data.task.id+' moved to container '+data.task.status+'</p>');
        });
</script>

@endpush