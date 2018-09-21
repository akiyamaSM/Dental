<div class="row">
    <div class="col-md-6">
        <!-- FirstName Input -->
        <div class="form-group">
            {!! Form::label('firstName', 'Nom:') !!}
            {!! Form::text('firstName', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <!-- LastName Input -->
        <div class="form-group">
            {!! Form::label('lastName', 'Prénom:') !!}
            {!! Form::text('lastName', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <!-- CIN input -->
        <div class="form-group">
            {!! Form::label('CIN', 'CIN:') !!}
            {!! Form::text('CIN', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <!-- BirthDay Input -->
        <div class="form-group">
            {!! Form::label('birthDay', 'la date de naissance :') !!}
            {!! Form::input('date', 'birthDay' , null, [ 'class' => 'form-control input-sm' ]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <!-- Phone input -->
        <div class="form-group">
            {!! Form::label('phone', 'Num Telephone:') !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-6">
        <!-- Gender input -->
        <div class="form-group">
            {!! Form::label('gender', 'sexe:') !!}
            {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, [ 'class' => 'form-control' ]) !!}
        </div>
    </div>

</div>
<div class="">
    @foreach($illnesses->chunk(3) as $chunk)
        <div class="row">
            @foreach($chunk as $illness)
                <div class="col-md-4">
                    <label class="checkbox">
                        <span class="icons">
                            <span class="first-icon fa fa-square-o"></span>
                            <span class="second-icon fa fa-check-square-o"></span>
                        </span>
                        {!!Form::checkbox('illness_id[]', $illness->id, null, ['class' => 'form-control', 'data-toggle' => 'checkbox'])!!}
                        {{ $illness->name }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<div class="row">
    <!-- Register Form Submit -->
    <div class="col-md-4 col-md-offset-4">
        {!! Form::submit('Créer', ['class' => 'btn btn-fill btn-default form-control']) !!}
    </div>
</div>