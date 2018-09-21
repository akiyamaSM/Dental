@extends('layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
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
            <a href="#" class="btn btn-default btn-fill col-md-offset-5 col-xs-offset-3" role="button" @click="showModal()">new Unit</a>
        </div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="header">
                <h4 class="title"> La liste des unites</h4>
            </div>
            <div class="content">
                <table id="example" class="table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">name</th>
                            <th class="text-center">description</th>
                            <th class="text-center">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="rowWithID@{{ unit.id }}" v-for="unit in units">
                            <td class="text-center">@{{ unit.id }}</td>
                            <td class="text-center">@{{ unit.name }}</td>
                            <td class="text-center">@{{ unit.description }}</td>
                            <td class="text-center">
                                <button title="edit" class="btn btn-primary btn-fill btn-xs" data-title="Edit" @click.prevent="showEditModal(unit, $index)">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                                <button title="Supprimer" class="btn btn-danger btn-fill btn-xs" data-title="Delete" @click.prevent="showDeleteModal(unit, $index)">
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
        <div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <span>Delete</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <span>Are you sure do you want to delete it, Really!?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger btn-fill"  @click.prevent="deleteUnit(idEdit)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <span>Ajoutez une unité</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'v-model' => 'unit.name']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::text('description', null, ['class' => 'form-control', 'v-model' => 'unit.description']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success btn-fill" v-if="!modeEdit" @click.prevent="addUnit()">Ajouter</button>
                        <button type="button" class="btn btn-success btn-fill" v-if="modeEdit"  @click.prevent="editUnit()">Modifier</button>
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
            el : '#app',
            data :{
                units : {!! $units !!},
                modeEdit : false,
                unit: {
                  id :'',
                  name : '',
                  description : ''
                },
                indexToEdit : '',
                idEdit : ''
            },
            methods: {
                showModal : function(){
                    this.setUnit('', '', '')
                    this.modeEdit = false
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showDeleteModal : function(unit, index){
                    this.indexToEdit = index
                    this.idEdit = unit.id
                    $('#myDeleteModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                showEditModal : function(unit, index){
                    this.modeEdit = true
                    this.indexToEdit = index
                    this.idEdit = unit.id
                    this.setUnit(unit.id, unit.name, unit.description)
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                setUnit : function(id, name, description){
                    this.unit.id = id
                    this.unit.name = name
                    this.unit.description = description
                },
                addUnit : function(){
                    var newunit = this.unit
                    this.unit = {
                        id : '',
                        name : '',
                        description : ''
                    }
                    this.$http.post('/admin/pharmacy/units', newunit).then(function (data) {
                        if(data.status === 200) {
                            newunit.id = data.data.id
                            this.units.push(newunit)
                            data = data.data
                            $('#myModal').modal('toggle')
                            $.notify({
                                icon: 'pe-7s-gift',
                                message: "l'unite   <b>" + data.name + " </b> - est bien ajouté."
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
                deleteUnit : function(id){
                    this.$http.delete('/admin/pharmacy/units/'+ id ).then(function (data){
                        this.units.$remove(this.units[this.indexToEdit])
                        this.indexToEdit = ''
                        $('#myDeleteModal').modal('toggle')
                        $.notify({
                            icon: 'pe-7s-attention',
                            message: "The Unit has been removed successfully!!!"
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
                },
                editUnit : function(){
                    this.$http.patch('/admin/pharmacy/units/'+ this.idEdit + '/update', this.unit).then(function (data) {
                        if(data.status === 200) {
                            this.units.$set(this.indexToEdit, this.unit)
                            data = data.data
                            $('#myModal').modal('toggle')
                            $.notify({
                                icon: 'pe-7s-gift',
                                message: "l'unite   <b>" + data.name + " </b> - est bien Modifiée."
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
        } );
    </script>
@endsection