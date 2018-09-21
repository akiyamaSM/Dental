@if(isset($errors) && $errors->any())
    <div class="row">
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
    </div>
@endif