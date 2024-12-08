<style>
    #alert {
        position: fixed;
        top: 40px;
        left: 58%;
        transform: translateX(-50%);
        z-index: 1050;
        width: 80%; /* Ajusta el ancho según tus necesidades */
        max-width: 600px; /* Ajusta el ancho máximo según tus necesidades */
        text-align: center;
    }
</style>
<div class="row justify-content-center">
    <div class="">
        @if (session('success'))
            <div class="alert alert-success" role="alert" id="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div role="alert" id="alert" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @elseif(session('warning'))
            <div role="alert" id="alert" class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @elseif(session('info'))
            <div role="alert" id="alert" class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
    </div>
</div>
