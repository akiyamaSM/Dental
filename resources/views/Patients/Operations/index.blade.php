@extends('layouts.master')
@section('css')
    <style>
        .text-center{
            text-align: center;
        }
        .modal-backdrop{
            z-index: 0;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <div class="card">
            <div class="header">
                <h4 class="title">Operations</h4>
                <p class="category">La liste des operations effectueés sur {{ $patient->fullName }} </p>
            </div>
            <div class="content ">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">CODE</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">SUR</th>
                        <th class="text-center">Nombre de seances</th>
                        <th class="text-center">Prix Convenu</th>
                        <th class="text-center">reçu</th>
                        <th class="text-center">Etat</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patient->operations()->withTrashed()->get() as $operation)
                        <tr id="rowWithID{{ $operation->id }}">
                            <td class="text-center">{{$operation->id}}</td>
                            <td class="text-center">{{ $operation->type->name }}</td>
                            <td class="text-center">{{ $operation->about->name }}</td>
                            <td class="text-center">{{ $operation->sessions()->count() }}</td>
                            <td class="text-center">{{ $operation->price }} DH</td>
                            <td class="text-center">{{ $operation->payments()->sum('versed') }} DH</td>
                            <td class="text-center">
                                @if($operation->trashed())
                                    <span id="spanWithID{{ $operation->id }}" class="label label-success">Terminée</span>
                                @else
                                    <span id="spanWithID{{ $operation->id }}"  class="label label-default">En Cours</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!$operation->trashed())
                                    <a href="{{ route("patient.operation.show", [$patient, $operation])  }}" class="btn btn-primary btn-fill btn-xs" title="consulter" for="button">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a id="aWithID{{ $operation->id }}" @click.prevent="showModal({{$operation}})" class="btn btn-danger btn-fill btn-xs" title="Terminer" for="button">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                @else
                                    <a href="{{ route("patient.operation.history", [$patient, $operation])  }}" class="btn btn-primary btn-fill btn-xs" title="consulter" for="button">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <a href="{{ route('patient.operation.create', $patient) }}" class="btn btn-default btn-fill pull-right" role="button">Nouvelle Operation</a>
                <div class="clearfix"></div>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">
                                <span>Términer les seances</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <span> Voulez Vous vraiment supprimer Operation Num @{{ operation.id }}</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger btn-fill" @click.prevent="delete(operation.id)">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="/js/bootstrap-notify.js"></script>
    <script src="/js/vue.js"></script>
    <script src="/js/vue-resource.js"></script>
    <script type="text/javascript">
        new Vue({
            http: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
                }
            },
            el: '#app',
            data: {
                operation: {
                    id : '',
                }
            },
            methods: {
                showModal: function(operation){
                    this.operation.id = operation.id
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                delete: function(id){
                    this.$http.delete('/admin/patient/operation/'+ id + '/terminate').success(function() {
                        $('#spanWithID'+id).removeClass("label-default")
                                           .addClass("label-success")
                                           .text("Terminée")
                        $('#aWithID'+id).remove()
                        $('#myModal').modal('toggle')
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "L operation <b>Some Name should be Here</b> - a éte bien Terminée."
                        },{
                            type: 'info',
                            timer: 1000,
                            delay: 2000
                        });
                    })
                }
            }
        });


        $(document).ready(function() {
            @if(session()->has('message'))
            $.notify({
                icon: 'pe-7s-gift',
                message: "{!! session()->get('message') !!}"
            },{
                type: 'success',
                timer: 1000,
                delay: 2000
            });
            @endif
        } );
    </script>
@stop