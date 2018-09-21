@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="header">
            <h4 class="title">Créer nouveau patient</h4>
        </div>
        <div class="content">
            {!! Form::open(['route' => 'admin.patient.store']) !!}
                @include('Patients.partials.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('js')
    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="/js/bootstrap-checkbox-radio-switch.js"></script>
    <script src="/js/bootstrap-notify.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if(isset($errors) && $errors->any())
                @foreach($errors->all() as $error)
                    $.notify({
                        icon: 'pe-7s-attention',
                        message: "{{ $error }}"
                    },{
                        type: 'danger',
                        timer: 1000,
                        delay: 3000,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });
                @endforeach
            @endif
        } );
    </script>
@stop