<!-- MODAL MSG SUCESSO -->
<div class="modal fade" id="modalSucesso" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div style="background-color: #3498db;" class="modal-header">
                <h3 style="font-size: 19px; color: floralwhite;" class="modal-title"><i class="fas fa-user-check"></i>
                   Mensagem </h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{session('success')}}
            </div>
        </div>
    </div>
</div>
<!-- FIM MODAL MSG SUCESSO -->