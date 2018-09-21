<form action="/" method="POST">
    {{ Form::autoComplete("firstName", null, ["class" => "form-control"], ['myId' => $languages]) }}
    <input type="submit" />
</form>