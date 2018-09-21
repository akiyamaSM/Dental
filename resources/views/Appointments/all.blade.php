@extends('layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/css/bootstrap-select.min.css">

    <style>
        .modal-backdrop{
            z-index: 0;
        }
        .newButton{
            margin-bottom: 25px;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <div class="row newButton">
            <a href="#" class="btn btn-default btn-fill col-md-offset-5 col-xs-offset-3" role="button" @click="showModal()">Nouveau Rendez-vous</a>
        </div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="header">
                <h4 class="title"> La liste des rendez-vous</h4>
            </div>
            <div class="content">
                <table id="example" class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">Patient</th>
                        <th class="text-center">CIN</th>
                        <th class="text-center">Date rendez-vous</th>
                        <th class="text-center">etat</th>
                        <th class="text-center">Consulter</th>
                        <th class="text-center">Opérations</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr id="rowWithID{{ $appointment->id }}">
                            <td class="text-center">{{ $appointment->concern->fullName }}</td>
                            <td class="text-center">{{ $appointment->concern->CIN }}</td>
                            <td class="text-center">{{ $appointment->appointment_at }}</td>
                            <td class="text-center">
                                @if($appointment->state == -1)
                                    <span id="spanWithID{{ $appointment->id }}"  class="label label-danger">Canceled</span>
                                @elseif($appointment->state == 0)
                                    <span id="spanWithID{{ $appointment->id }}"  class="label label-info">En Cours</span>
                                @else
                                    <span id="spanWithID{{ $appointment->id }}"  class="label label-success">Done</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" title="Consulter" class="btn btn-primary btn-fill btn-xs" role="button">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-center">

                                @if($appointment->state == -1 && $appointment->appointment_at > Carbon\Carbon::now() )
                                    <button title="activate" class="btn btn-info btn-fill btn-xs" data-title="Activate" @click.prevent="activateAppointment({{ $appointment->id }})">
                                        <i class="fa fa-recycle"></i>
                                    </button>
                                @endif
                                @if($appointment->state == 0)
                                    <button title="confirm" class="btn btn-success btn-fill btn-xs" data-title="Confirm" @click.prevent="validateAppointment({{ $appointment->id }})">
                                        <i class="fa fa-check-circle"></i>
                                    </button>
                                    <button title="cancel" class="btn btn-warning btn-fill btn-xs" data-title="Cancel" @click.prevent="cancelAppointment({{ $appointment->id }})">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                @endif
                                <button title="Supprimer" class="btn btn-danger btn-fill btn-xs" data-title="Delete" @click.prevent="showDeleteModal({{ $appointment->id }})">
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
                            <span>Ajoutez un Rendez-vous</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('patient', 'Patient:') !!}
                            {{ Form::select('patient', $list, null, ['class' => 'selectpicker', 'data-live-search' => true, 'v-model' => 'appointment.patient_id']) }}
                        </div>
                        <div class="form-group">
                            {!! Form::label('date', 'Date:') !!}
                            <input class="form-control" type="text" id="datepicker" v-model="appointment.appointment_at">
                        </div>
                        <!-- Notice Input -->
                        <div class="form-group">
                            {!! Form::label('notice', 'Notice:') !!}
                            {!! Form::text('notice', null, ['class' => 'form-control', 'v-model' => 'appointment.notice']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger btn-fill" @click.prevent="addNewAppointment()">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.css">
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
                appointment: {
                    id : '',
                    patient_id : '',
                    appointment_at : '',
                    notice : ''
                }
            },
            methods: {
                showModal: function(){
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                addNewAppointment : function(){
                    var appointment = this.appointment
                    this.appointment = {
                        id : '',
                        patient_id : '' ,
                        appointment_at : '',
                        notice : ''
                    }
                    this.$http.post('/admin/appointments', appointment).then(function (data) {
                        if(data.status === 200) {
                            data = data.data
                            $('#myModal').modal('toggle')
                            $.notify({
                                icon: 'pe-7s-gift',
                                message: "le rendez-vous avec le Client  <b>" + data.patient_id + " </b> - est bien ajouté."
                            }, {
                                type: 'success',
                                timer: 1000,
                                delay: 2000
                            });

                        }
                    }).catch(function(data){

                        $.each(data.data, function(index, value) {
                            $.notify({
                                icon: 'pe-7s-attention',
                                message: value[0]
                            },{
                                type: 'danger',
                                timer: 1000,
                                delay: 3000,
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                }
                            });
                        });
                    })
                },
                cancelAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id+'/cancel').then(function (data){
                        console.log("Done " + data)
                    }).catch(function(errors) {
                        console.log("Errr " + errors)
                    })
                },
                activateAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id +'/activate').then(function (data){
                        console.log("Done " + data)
                    }).catch(function(errors) {
                        console.log("Errr " + errors)
                    })
                },
                validateAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id +'/validate').then(function (data){
                        console.log("Done " + data)
                    }).catch(function(errors) {
                        console.log("Errr " + errors)
                    })
                }
            }
        });


        $(document).ready(function() {
            $( "#datepicker" ).datetimepicker();
            $('#example').DataTable( {
                "order": [[ 2, "desc" ]]
            });
        } );
    </script>
@stop