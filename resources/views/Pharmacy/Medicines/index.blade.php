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
            <a href="#" class="btn btn-default btn-fill col-md-offset-5 col-xs-offset-3" role="button" @click="showModal()">new Button</a>
        </div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="header">
                <h4 class="title">liste medicines</h4>
            </div>
            <div class="content">
                <table id="example" class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">DESCRIPTION</th>
                        <th class="text-center">OPERATION</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr id="rowWithID@{{ medicine.id }}" v-for="medicine in medicines">
                            <td class="text-center">@{{ medicine.id }}</td>
                            <td class="text-center">@{{ medicine.name }}</td>
                            <td class="text-center">@{{ medicine.unit.name }}</td>
                            <td class="text-center">@{{ medicine.description }}</td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['id' => 'maladies-form']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <span >Test</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('unit', 'Unit:') !!}
                            {{ Form::select('unit', $units, null, ['class' => 'selectpicker', 'data-live-search' => true, 'v-model' => 'medicine.unit_id']) }}
                        </div>
                        <!-- Name Input -->
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {{ Form::text('name', null, ['class' => 'form-control', 'v-model' => 'medicine.name']) }}
                        </div>
                        <!-- Description Input -->
                        <div class="form-group">
                            {!! Form::label('description', 'Description:') !!}
                            {{ Form::text('description', null, ['class' => 'form-control', 'v-model' => 'medicine.description']) }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger btn-fill" @click.prevent="addMedicine()">Ajouter</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"></script>
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
            el : '#app',
            data : {
                medicines : {!! $medicines !!},
                medicine : {
                    unit :{
                      id : '',
                      name :''
                    },
                    unit_id : '',
                    id : '',
                    name : '',
                    description : ''
                },
                modeEdit : false
            },
            methods :{
                showModal: function(){
                    this.modeEdit = false
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                addMedicine : function(){
                    var medicine = this.medicine
                    this.medicine = {
                        unit :{
                            id : '',
                            name :''
                        },
                        unit_id : '',
                        id : '',
                        name : '',
                        description : ''
                    }
                    this.$http.post('/admin/pharmacy/medicines', medicine).then(function (data) {
                        medicine.id = data.data.id
                        medicine.unit.name = data.data.unit.name
                        this.medicines.push(medicine)
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
        })

        $(document).ready(function() {
            $('#example').DataTable({
                "bInfo" : false
            });
        });
    </script>
@endsection