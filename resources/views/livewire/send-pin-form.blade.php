<form wire:submit.prevent="submit">
    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('error') }}
    </div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
    @endif

    <div class="input-group mb-3">
        <input type="text" id="cpfcnpj" wire:model.debounce.1000ms="cpfcnpj"
            class="form-control {{ $errors->has('cpfcnpj') ? 'is-invalid' : '' }}"
            placeholder="CPF do servidor" autofocus>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('cpfcnpj') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="input-group mb-3">
        <input type="email" wire:model.debounce.500ms="email"
            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Seu E-mail">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <br>

    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <button style="border-radius: 4px;" type="submit" class="btn btn-primary btn-block btn-flat">
                Enviar
            </button>
        </div>
    </div>

    @include('partials.spinner-login')
</form>