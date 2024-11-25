<form wire:submit.prevent="submit">
    {{-- {{ csrf_field() }} --}}
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
            placeholder="CPF do servidor">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('cpfcnpj') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="input-group mb-3">
        <input type="password" wire:model.debounce.500ms="password"
            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Sua senha">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="input-group mb-3">
        <input type="password" wire:model.debounce.500ms="password_confirmation" class="form-control"
            placeholder="Confirme sua nova senha" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="text" wire:model.debounce.500ms="pin" class="form-control" maxlength="5" placeholder="Seu PIN">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('pin') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{ route('getPin') }}">
                Não sei o meu PIN
            </a>
        </div>
    </div>
    <br>

    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <button style="border-radius: 4px;" type="submit" class="btn btn-primary btn-block btn-flat">
                Salvar
            </button>
        </div>
    </div>

    @include('partials.spinner-login')

</form>