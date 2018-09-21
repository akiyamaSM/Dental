@extends('layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
    <style>
        .modal-backdrop{
            z-index: 0;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <div class="card">
            <div class="header">
                <h4 class="title"> La liste des patients</h4>
            </div>
            <div class="content">

                <table id="example" class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">CIN</th>
                        <th class="text-center">PHONE</th>
                        <th class="text-center">BirthDay</th>
                        <th class="text-center">Reactiver</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patients as $patient)
                        <tr id="rowWithID{{ $patient->id }}">
                            <td class="text-center">{{ $patient->fullName }}</td>
                            <td class="text-center">{{ $patient->CIN }}</td>
                            <td class="text-center">{{ $patient->phone }}</td>
                            <td class="text-center">{{ $patient->birthDay }}</td>
                            <td class="text-center">
                                <button @click.prevent="reactive({{ $patient }})" title="Reactiver" class="btn btn-success btn-fill btn-xs" role="button">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button title="Supprimer" class="btn btn-danger btn-fill btn-xs" data-title="Delete" @click.prevent="showModal({{ $patient }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <span>Suppression Patient</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <span> Voulez Vous vraiment supprimer @{{ patient.fullName }} Definitivement?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger btn-fill" @click.prevent="delete(patient.id)">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js">
    </script>
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
                patient: {
                    id : '',
                    fullName : '',
                }
            },
            methods: {
                showModal: function(patient){
                    this.patient.id = patient.id
                    this.patient.fullName = patient.fullName
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                delete: function(id){

                    this.$http.delete('/admin/patient/'+ id+'/forcedestroy').success(function(data) {
                        $('#rowWithID'+id).remove()
                        $('#myModal').modal('toggle')
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "Le patient <b> " + data.firstName +" "+ data.lastName+ " </b> - a éte bien supprimer Definitivement."
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 2000
                        });
                    })

                },
                reactive: function(patient) {
                    console.log(patient.id)

                     this.$http.get('/admin/patient/'+ patient.id+'/revive').success(function(data) {
                     $('#rowWithID'+patient.id).remove()
                     $.notify({
                     icon: 'pe-7s-gift',
                     message: "Le patient <b> " + data.firstName +" "+ data.lastName+ " </b> - a éte bien supprimer Definitivement."
                     },{
                     type: 'success',
                     timer: 1000,
                     delay: 2000
                     });
                     })
                }
            }
        });
    </script>
@stop