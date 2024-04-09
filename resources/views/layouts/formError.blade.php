@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Hay algunos problemas con los datos del formulario.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
