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
                        <th class="text-center">Reçu</th>
                        <th class="text-center">Manquant</th>
                        <th class="text-center">Date dernier versement</th>
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
                            <td class="text-center fixed">{{ $operation->price }} DH</td>
                            <td class="text-center versed">{{ $operation->payments()->sum('versed') }} DH</td>
                            <td class="text-center remained">{{ $operation->price - $operation->payments()->sum('versed') }} DH</td>
                            <td class="text-center">
                                @if($operation->payments()->count() > 0)
                                    <span id="spanWithID{{ $operation->id }}">{{ $operation->payments()->first()->created_at }}</span>
                                @else
                                    <span id="spanWithID{{ $operation->id }}"  class="label label-default">pas encore</span>
                                @endif
                            </td>
                            <td class="text-center action">
                                @if($operation->price - $operation->payments()->sum('versed') > 0 )
                                    <a @click.prevent="showModal({{$operation}})" class="btn btn-success btn-fill btn-xs verserBtn" title="Verser" for="button">
                                        <i class="fa fa-money"></i>
                                    </a>
                                @else
                                    <span class="label label-success">Payé</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">
                                <span>Nouvelle Versement</span>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <span> Veullez tapez le monant à verser de l'operation num @{{ operation.id }}</span>
                                {!! Form::text('versed', null, ['class' => 'form-control', 'v-model' => 'newPayment.versed']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-fill" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success btn-fill" @click.prevent="verse(operation.id)">Verser</button>
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
                    id : ''
                },
                newPayment: {
                    versed: ''
                }
            },
            methods: {
                showModal: function(operation){
                    this.operation.id = operation.id
                    $('#myModal').modal('toggle')
                    $(".modal-backdrop").removeClass("in")
                },
                verse: function(id){
                    var payment = this.newPayment
                    this.newPayment = { versed : ''}
                    this.$http.post('/admin/patient/operation/'+ id + '/payment/create', payment).then(function(data) {
                        if(data.status === 200) {
                            // Selectors
                            var versed = $('#rowWithID'+id +' .versed')
                            var fixed = $('#rowWithID'+id +' .fixed')
                            var remained = $('#rowWithID'+id +' .remained')
                            var action = $('#rowWithID'+id +' .action')

                            // Set The Value Versed
                            var versedPrice = parseInt(versed.text()) + parseInt(payment.versed)
                            var fixedPrice = parseInt(fixed.text())
                            var remainedTemp = fixedPrice - versedPrice
                            versed.text(versedPrice+ " DH")
                            remained.text(remainedTemp+ " DH")
                            $.notify({
                                icon: 'pe-7s-gift',
                                message: "le Mountnant de  <b>"+ payment.versed +" DH</b> - est bien ajouté."
                            },{
                                type: 'success',
                                timer: 1000,
                                delay: 2000
                            });
                            if(remainedTemp<=0){
                                $('#rowWithID'+id +' .verserBtn').remove()
                                action.html('<span class="label label-success">Payé</span>')
                                $.notify({
                                    icon: 'pe-7s-gift',
                                    message: "le Mountnant Totale de  <b>"+ versedPrice +" DH</b> - est bien payé."
                                },{
                                    type: 'info',
                                    timer: 1000,
                                    delay: 2000
                                });
                            }
                            $('#myModal').modal('toggle')

                        }

                    }).catch(function (data){
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
        });
    </script>
@stop