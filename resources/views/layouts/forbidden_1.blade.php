<form method="POST" action="{{ route('logout') }}">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-4 ">
            <div class="login-panel panel panel-default">
                <div class="panel-body alert-danger">
                    <div class="alert alert-warning">
                        Su usuario no cuenta con permisos para ingresar a estos modulos
                    </div>
                    <input type="submit" class="btn btn-danger btn-lg center-block" value="Regresar">
                </div>
            </div>
        </div>
    </div>
</form>
