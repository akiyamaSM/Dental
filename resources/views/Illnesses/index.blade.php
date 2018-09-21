@extends('layouts.master')
@section('css')
    <style>
        .modal-backdrop{
            z-index: 0;
        }
        .newButton{
            margin-bottom: 25px;
        }
    </style>
@endsection
@section('title')
    - Gestion des Maladies
@endsection
@section('content')
    <!-- Modal -->

    <div id="app">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">

                {!! Form::open(['id' => 'maladies-form']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button @click="noEdit" type="button" class="close" data-dismiss="modal" aria-label="Close"  ><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            <span v-if="!edit">Ajouter une nouvelle Maladie</span>
                            <span v-else>Modfier le nom du Maladie</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::label('name','Nom :') !!}<span style="color:red" v-show="!isValid">*</span>
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'Illness-name', 'v-model' => 'newIllness.name']) !!}
                    </div>
                    <div class="modal-footer">
                        <button @click="noEdit" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="Illness-save-btn" v-if="edit" @click.prevent="editIllness(newIllness.id)">Save changes</button>
                        <button type="button" class="btn btn-primary" id="Illness-create-btn" v-if="!edit" @click.prevent="addNewIllness">Save changes</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row newButton">
            <a class="btn btn-default btn-fill col-md-offset-5 col-xs-offset-3" role="button" @click="noEdit">Nouvelle Maladie</a>
        </div>
        <div class="clearfix"></div>
        <div class="card">
            <h1 class="header">
                <h4 class="title">Liste des Maladies</h4>
            </h1>
            <div class="box-body">
                <div class="content">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Nom</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                            </thead>
                                <tbody style="text-align: center;">
                                    <tr v-for="illness in Illnesses ">
                                        <td>@{{ illness.name }}</td>
                                        <td>
                                            <a href="" @click.prevent='showIllness(illness)' class="btn btn-success  btn-fill btn-xs" >
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/vue.js"></script>
    <script src="/js/vue-resource.js"></script>
    <script>
        new Vue({
            http: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
                }
            },
            el: '#app',
            data: {
                newIllness: {
                    name : '',
                    id : ''
                },
                edit : false,
                error : ''
            },
            methods: {
                fetchIllness: function (){
                    this.$http.get('/api/Illness', function(data){
                        this.$set('Illnesses', data)
                    });
                },
                addNewIllness: function(){
                    var Illness = this.newIllness
                    this.newIllness = {id :'', name: ''}
                    this.$http.post('/api/Illness', Illness).error(function(data){
                        this.error = data.name
                    }).success(function (data) {
                        $('#myModal').modal('toggle')
                        this.Illnesses.push(data)
                    })
                },

                showIllness : function(illness){
                    this.edit = true
                    this.newIllness.id = illness.id
                    this.newIllness.name= illness.name
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")

                },
                editIllness: function (id) {
                    var Illness = this.newIllness
                    this.newIllness = { name :'', id: ''}
                    this.$http.patch('/api/Illness/'+ id, Illness)
                    this.fetchIllness()
                    $('#myModal').modal('toggle')
                    this.edit = false
                },
                noEdit: function () {
                    this.edit = false
                    this.newIllness = { name :'', id: ''}
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")

                }
            },
            ready:function(){
               this.fetchIllness()
            },
            computed: {
                isValid: function(){
                    return !!this.newIllness.name.trim();
                }
            }
        });
    </script>
@endsection