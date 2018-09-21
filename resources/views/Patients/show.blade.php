@extends('layouts.master')
@section('css')
    <style>
        .modal-backdrop{
            z-index: 0;
        }
        .img-center {
            height: 200px;
            width: 200px;
            margin:0 auto;
        }

        .hero-widget {
            text-align: center;
        }
        .hero-widget .icon {
            display: block;
            font-size: 33px;
            line-height: 27px;
            margin-bottom: 3px;
            text-align: center;
        }
        .hero-widget var {
            display: block;
            font-size: 20px;
            line-height: 64px;
            font-style: normal;
        }
        .hero-widget label {
            font-size: 17px;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Profile</h4>
                    </div>
                    <div class="content">
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Code Patient</label>
                                        <input type="text" class="form-control" disabled="" value="{{ $patient->id }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" placeholder="Phone" value="{{ $patient->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code Identité National</label>
                                        <input type="text" class="form-control" disabled="" value="{{ $patient->CIN }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" placeholder="Nom" value="{{ $patient->firstName }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input type="text" class="form-control" placeholder="Prénom" value="{{ $patient->lastName }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" placeholder="Address" value="{{ $patient->address }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default btn-fill pull-right">Modifier</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image">
                        <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&amp;fm=jpg&amp;h=300&amp;q=75&amp;w=400" alt="...">
                    </div>
                    <div class="content">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="/img/{{ $patient->gender }}.png" alt="...">
                                <h4 class="title">{{$patient->fullName}}
                                </h4>
                            </a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="hero-widget">
                                    <div class="icon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="text">
                                        <var>{{$patient->payments()->sum('versed')}} DH</var>
                                        <label class="text-muted">Versé</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="hero-widget">
                                    <div class="icon">
                                        <i class="fa fa-wrench"></i>
                                    </div>
                                    <div class="text">
                                        <var>{{ $patient->operations()->count() }}</var>
                                        <label class="text-muted">Operations</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <center>
                            <h3>Dossier Medicale</h3>
                        </center>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <img src="/img/icons/medical-report-icon.png" class="img-circle img-center" alt="image" />
                            </div>
                        </div>
                        <hr>
                        <p>Vestibulum odio risus, interdum fringilla vulputate ac, placerat in mi. Vivamus pharetra, mauris vitae cursus ultricies.</p>
                        <a href="{{ route('patient.payment.index', $patient) }}" class="btn btn-default btn-fill btn-block" role="button">Dossier Medicale</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <center>
                            <h3>Operations</h3>
                        </center>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <img src="/img/icons/doctor.png" class="img-circle img-center" alt="image" />

                            </div>
                        </div>
                        <hr>
                        <p>Vestibulum odio risus, interdum fringilla vulputate ac, placerat in mi. Vivamus pharetra, mauris vitae cursus ultricies.</p>
                        <a href="{{ route('patient.operation.index', $patient) }}" class="btn btn-default btn-fill btn-block" role="button">Operations</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <center>
                            <h3>Paiement</h3>
                        </center>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <img src="/img/icons/money.png" class="img-circle img-center" alt="image" />
                            </div>
                        </div>
                        <hr>
                        <p>Vestibulum odio risus, interdum fringilla vulputate ac, placerat in mi. Vivamus pharetra, mauris vitae cursus ultricies.</p>
                        <a href="{{ route('patient.payment.index', $patient) }}" class="btn btn-default btn-fill btn-block" role="button">Paiment</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <center>
                            <h3>Rendez-vous</h3>
                        </center>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <img src="/img/icons/money.png" class="img-circle img-center" alt="image" />
                            </div>
                        </div>
                        <hr>
                        <p>Vestibulum odio risus, interdum fringilla vulputate ac, placerat in mi. Vivamus pharetra, mauris vitae cursus ultricies.</p>
                        <a href="{{ route('appointments.patient.all', $patient) }}" class="btn btn-default btn-fill btn-block" role="button">Renez-vous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
/*    new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
            }
        },
        el: '#app',
        data: {
            appointment: {
                patient_id : '',
                appointment_at : '',
                notice : ''
            }
        },
        methods: {
            showModal: function(patient_id){
                this.appointment.patient_id = patient_id
                $('#myModal').modal('toggle')
                $(".modal-backdrop").removeClass("in")
            },
            addNewAppointment : function(){
                var appointment = this.appointment
                this.appointment = {
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
            }
        }
    });*/

/*    $(document).ready(function() {
        $( "#datepicker" ).datetimepicker();
    } );*/
</script>
@stop