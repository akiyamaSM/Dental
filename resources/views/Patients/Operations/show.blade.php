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
                <h4 class="title">les sessions</h4>
                <p class="category">La liste des operations effectueés sur {{ $patient->fullName }} </p>
            </div>
            <div class="content ">
                @include('Patients.Operations.partials.table')
                <button @click.prevent="showModal({{ $operation }})" type="submit" class="btn btn-default btn-fill pull-right">Nouvelle Session</button>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['id' => 'session-form']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <span>Nouvelle Seance</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <textarea v-model="newSession.notice" name='notice' rows="5" class="form-control" placeholder="Ajoutez vos remarques Ici ..." ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary btn-fill" @click.prevent="addSession(operation.id)">Ajouter</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="/js/vue.js"></script>
    <script src="/js/vue-resource.js"></script>
    <script src="/js/bootstrap-notify.js"></script>
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
                    id : ''
                },
                newSession: {
                    notice : ''
                }
            },
            methods: {
                showModal: function(operation){
                    this.operation.id = operation.id
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                addSession: function(id){
                    var session = this.newSession
                    this.newSession = { notice : ''}
                    this.$http.post('/admin/patient/operation/'+ id + '/session/create', session).success(function(data) {
                         $('#myTable > tbody:last-child').append("<tr>" +
                                                                     "<td class='text-center'>" + data.id + "</td>" +
                                                                     "<td class='text-center'>" + data.notice + "</td>"+
                                                                     "<td class='text-center'>" + data.created_at + "</td>"+
                                                                 "</tr>")
                        $('#myModal').modal('toggle')
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "La nouvelle <b>seance</b> - a éte bien Ajouter."
                        },{
                            type: 'success',
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