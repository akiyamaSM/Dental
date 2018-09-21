@extends('layouts.master')
@section('css')
    <style>
        .text-center{
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="header">
            <h4 class="title">les sessions</h4>
            <p class="category">La liste des operations effectueés sur {{ $patient->fullName }} </p>
        </div>
        <div class="content ">
            @include('Patients.Operations.partials.table')
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/js/bootstrap-notify.js"></script>
    <script type="text/javascript">
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