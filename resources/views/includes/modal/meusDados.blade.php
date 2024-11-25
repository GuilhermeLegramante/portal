<!-- MODAL EDIÇÃO DADOS USUÁRIO -->
<div class="modal fade" id="modalMeusDados" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div style="background-color: dodgerblue;" class="modal-header">
                <h3 style="font-size: 19px; color: floralwhite;" class="modal-title"><i class="fas fa-user"></i>
                    Meus Dados </h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('edicaoDadosUsuario')}}" class="form" method="post">
                    @csrf
                    <div class="card-body p-0">
                        <div class="form-group">
                            <label class="labelCustom">Nome</label>
                            <input type="text" name="nome" value="{{old('nome') ? old('nome') : $usuario->NOMEUSUARIO}}"
                                class="form-control {{$errors->has('nome') ? 'erro' : ''}}">
                            @if ($errors->has('nome'))
                            <h3 class="msgErro">{{$errors->first('nome')}}</h3>
                            @endif

                            <label class="labelCustom">Login</label>
                            <input type="text" name="login" value="{{old('login') ? old('login') : $usuario->LOGIN}}"
                                class="form-control {{$errors->has('login') ? 'erro' : ''}}">
                            @if ($errors->has('login'))
                            <h3 class="msgErro">{{$errors->first('login')}}</h3>
                            @endif

                            <label class="labelCustom">E-mail</label>
                            <input type="email" name="email" value="{{old('email') ? old('email') : $usuario->EMAIL}}"
                                class="form-control {{$errors->has('email') ? 'erro' : ''}}">
                            @if ($errors->has('email'))
                            <h3 class="msgErro">{{$errors->first('email')}}</h3>
                            @endif

                            <label class="labelCustom">Senha</label>
                            <input type="password" name="senha" id=""
                                class="form-control {{$errors->has('senha') ? 'erro' : ''}}">
                            @if ($errors->has('senha'))
                            <h3 class="msgErro">{{$errors->first('senha')}}</h3>
                            @endif

                            <label class="labelCustom">Confirmação da Senha</label>
                            <input type="password" name="senha_confirmation" id="" class="form-control">
                        </div>
                    </div>
            </div>

            <div class="modal-footer justify-content">
                <a href="" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><strong>CANCELAR</strong></a>
                <button type="submit" class="btn btn-outline-success btn-sm"><strong>SALVAR</strong> <i
                        class="fas fa-save" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- FIM MODAL EDIÇÃO DADOS DO USUÁRIO -->