<div class="row">
    <div class="col-md-6">
        <!-- Types input -->
        <div class="form-group">
            {!! Form::label('type_id', 'Type operation:') !!}
            {!! Form::select('type_id', $types , null, [ 'class' => 'form-control input-md' ]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <!-- dents input -->
        <div class="form-group">
            {!! Form::label('tooth_id', 'Les dents:') !!}
            {!! Form::select('tooth_id', $teeth , null, [ 'class' => 'form-control input-md' ]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <!-- Prix input -->
        <div class="form-group">
            {!! Form::label('price', 'Prix:') !!}
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Prix en DH']) !!}
        </div>
    </div>

    <div class="col-md-9">
        <!-- Gender input -->
        <div class="form-group">
            <label>Remarques</label>
            <textarea name='notice' rows="5" class="form-control" placeholder="Si vous avez plus de remarque..."></textarea>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {!! Form::submit('Ajouter', ['class' => 'btn btn-fill btn-info form-control']) !!}
    </div>
</div>