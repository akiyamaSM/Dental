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
            <a href="#" class="btn btn-default btn-fill col-md-offset-5 col-xs-offset-3" role="button" @click="showModal({{ $patient->id }})">Nouveau Rendez-vous</a>
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
                        <tr id="rowWithID@{{ appointment.id }}" v-for="appointment in appointments">
                            <td class="text-center">{{ $patient->fullName }}</td>
                            <td class="text-center">{{ $patient->CIN }}</td>
                            <td class="text-center">@{{ appointment.appointment_at }}</td>
                            <td class="text-center">
                                    <span v-show="isCanceled(appointment)" id="spanWithID@{{ appointment.id }}"  class="label label-danger">Canceled</span>
                                    <span v-show="isCurrent(appointment)" id="spanWithID@{{ appointment.id }}"  class="label label-info">En Cours</span>
                                    <span v-show="isConfirmed(appointment)" id="spanWithID@{{ appointment.id }}"  class="label label-success">Done</span>
                            </td>
                            <td class="text-center">
                                <a href="#" title="Consulter" class="btn btn-primary btn-fill btn-xs" role="button">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-center">

                                    <button v-show="canBeReactivated(appointment)" title="reactivate" class="btn btn-info btn-fill btn-xs" data-title="Reactivate" @click.prevent="showReactivateModal(appointment, $index)">
                                        <i class="fa fa-recycle"></i>
                                    </button>
                                    <span v-show="isCurrent(appointment)">
                                        <button title="confirm" class="btn btn-success btn-fill btn-xs" data-title="Confirm" @click.prevent="showConfirmModal(appointment, $index)">
                                            <i class="fa fa-check-circle"></i>
                                        </button>
                                        <button title="edit" class="btn btn-primary btn-fill btn-xs" data-title="Edit" @click.prevent="showEditModal(appointment, $index)">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                        <button title="cancel" class="btn btn-warning btn-fill btn-xs" data-title="Cancel" @click.prevent="showCancelModal(appointment, $index)">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </span>
                                <button title="Supprimer" class="btn btn-danger btn-fill btn-xs" data-title="Delete" @click.prevent="showDeleteModal(appointment, $index)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
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
                        <button type="button" class="btn btn-success btn-fill" v-if="!modeEdit" @click.prevent="addNewAppointment()">Ajouter</button>
                        <button type="button" class="btn btn-success btn-fill" v-if="modeEdit"  @click.prevent="editAppointment()">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
        @include('Appointments.Patient.Modals.state')
    </div>

@endsection
@section('js')
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
                modeEdit : false,
                appointments : {!! $appointments !!},
                appointment : {
                    id : '',
                    patient_id : '',
                    appointment_at : '',
                    notice : '',
                    state : ''
                },
                state : {
                   title : 'My Title',
                   message : 'My Message',
                   action : 'My Action',
                   verb : 'My verb',
                   color : ''
                },
                idDelete : '',
                idEdit : '',
                idConfirm : '',
                idReactivate : '',
                idCancel : '',
                indexToEdit : ''
            },
            methods: {
                initData: function(){
                    this.$set('appointments', {!!$appointments !!})
                },
                showModal: function(patient_id){
                    this.appointment = {
                        id : '',
                        appointment_at : '',
                        notice : '',
                        state : '',
                        patient_id : ''
                    }
                    this.modeEdit = false
                    this.appointment.patient_id = patient_id
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showEditModal: function(appointment, index){
                    this.modeEdit = true
                    this.idEdit = appointment.id
                    this.indexToEdit = index
                    this.setAppointment(appointment)
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                setAppointment: function(appointment){
                    this.appointment.id = appointment.id
                    this.appointment.patient_id = appointment.patient_id
                    this.appointment.notice = appointment.notice
                    this.appointment.appointment_at = appointment.appointment_at
                    this.appointment.state = appointment.state
                },
                showDeleteModal: function(patient, index){
                    this.idDelete = patient.id
                    this.indexToEdit = index
                    this.setModal('Delete', 'Are you sure wanna get rid of it!', 'Delete it', 'delete', 'danger')
                    $('#myStateModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showCancelModal: function(appointment, indexCancel){
                    this.idCancel = appointment.id
                    this.indexToEdit = indexCancel
                    this.setModal('Cancel', 'Are you sure wanna Cancel it!', 'Cancel it', 'cancel', 'warning')
                    $('#myStateModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showConfirmModal: function(appointment, indexConfirm){
                    this.idConfirm = appointment.id
                    this.indexToEdit = indexConfirm
                    this.setModal('Confirm', 'Great!! the patient make it in the Time', 'Confirm', 'confirm', 'success')
                    $('#myStateModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showReactivateModal: function(appointment, indexReactivate){
                    this.idReactivate = appointment.id
                    this.indexToEdit = indexReactivate
                    this.setModal('Reactivate', 'So He still wants to make it!', 'reactivate it', 'reactivate', 'info')
                    $('#myStateModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                setModal: function(title, message, action, verb, color){
                    this.state.title = title
                    this.state.message = message
                    this.state.action = action
                    this.state.verb = verb
                    this.state.color = color
                },
                dispatchAction: function(){
                    if(this.state.verb == 'delete'){
                        this.deleteAppointment(this.idDelete)
                    }else if(this.state.verb == 'confirm'){
                        this.confirmAppointment(this.idConfirm)
                    }else if(this.state.verb == 'cancel'){
                        this.cancelAppointment(this.idCancel)
                    }else if(this.state.verb == 'reactivate'){
                        this.reactivateAppointment(this.idReactivate)
                    }else{
                        console.log("something went Wrong")
                    }

                    $('#myStateModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                editAppointment: function(){
                    this.$http.patch('/admin/appointments/'+ this.idEdit + '/update', this.appointment).then(function (data) {
                        if(data.status === 200) {
                            this.appointments.$set(this.indexToEdit, this.appointment)
                            data = data.data
                            $('#myModal').modal('toggle')
                            $.notify({
                                icon: 'pe-7s-gift',
                                message: "le rendez-vous avec le Client  <b>" + data.patient_id + " </b> - est bien modifié."
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
                addNewAppointment : function(){
                    var appointment = this.appointment
                    this.appointment = {
                        id : '',
                        appointment_at : '',
                        notice : '',
                        state : '',
                        patient_id : ''
                    }
                    console.log(appointment.patient_id)
                    this.$http.post('/admin/appointments', appointment).then(function (data) {
                        if(data.status === 200) {
                            appointment.id = data.data.id
                            appointment.state = data.data.state
                            appointment.appointment_at = data.data.appointment_at
                            this.appointments.push(appointment)
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
                isCanceled: function(appointment){
                  return   appointment.state == -1
                },
                isCurrent: function(appointment){
                  return   appointment.state == 0
                },
                isConfirmed: function(appointment){
                  return   appointment.state == 1
                },
                canBeReactivated: function(appointment){
                    var appointmentDate = new Date(appointment.appointment_at)
                    var now = new Date()
                    return appointment.state == -1 && appointmentDate > now
                },
                cancelAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id+'/cancel').then(function (data){
                        var appointment = {
                            id : data.data.id,
                            appointment_at : data.data.appointment_at,
                            state : data.data.state,
                            notice : data.data.notice
                        }
                        this.appointments.$set(this.indexToEdit, appointment)
                        this.indexToEdit = ''
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "The Appointment has been Cancled perfectly"
                        },{
                            type: 'warning',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    }).catch(function(errors) {
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "Ups! Something went wrong"
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    })
                },
                reactivateAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id +'/activate').then(function (data){
                        var appointment = {
                            id : data.data.id,
                            appointment_at : data.data.appointment_at,
                            state : data.data.state,
                            notice : data.data.notice
                        }
                        this.appointments.$set(this.indexToEdit, appointment)
                        this.indexToEdit = ''
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "The Appointment has been reactivated again!!"
                        },{
                            type: 'info',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    }).catch(function(errors) {
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "Ups! Something went wrong"
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    })
                },
                confirmAppointment: function (id) {
                    this.$http.patch('/admin/appointments/'+ id +'/confirm').then(function (data){
                        var appointment = {
                            id : data.data.id,
                            appointment_at : data.data.appointment_at,
                            state : data.data.state,
                            notice : data.data.notice
                        }
                        this.appointments.$set(this.indexToEdit, appointment)
                        this.indexToEdit = ''
                        $.notify({
                            icon: 'pe-7s-gift',
                            message: "The Appointment has been set as confirmed!!!"
                        },{
                            type: 'success',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    }).catch(function(errors) {
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "Ups! Something went wrong"
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    })
                },
                deleteAppointment: function(id){

                    this.$http.delete('/admin/appointments/'+ id ).then(function (data){
                        this.appointments.$remove(this.appointments[this.indexToEdit])
                        this.indexToEdit = ''
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "The Appointment has been removed successfully!!!"
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    }).catch(function(errors) {
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "Ups! Something went wrong"
                        },{
                            type: 'danger',
                            timer: 1000,
                            delay: 3000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                    })
                }
            }
        });
        $(document).ready(function() {
            $( "#datepicker" ).datetimepicker();
            $('#example').DataTable( {
                "order": [[ 2, "desc" ]],
                "bInfo" : false
            });
        } );
    </script>
@stop