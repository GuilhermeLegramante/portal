<div id="menu-rapido" class="fab">
    <button class="main">

    </button>
    <ul>
        <li>
            <label for="">Listar Tela</label> <br>
            <button onClick="printFormulario();" id="opcao2">
                <i class="fa fa-print" aria-hidden="true"></i>
            </button>
        </li>
        <li>
            <label for="">Todas</label>
            <form action="{{ route('dividas.basicReport', [session('idmunicipe'), 'geral']) }}" class="form" method="get" target="_blank">
                <button type="submit" id="opcao3">
                    <i class="far fa-file-pdf" aria-hidden="true"></i>
                </button>
            </form>
        </li>
        <li>
            <label for="">Parceladas</label>
            <form action="{{ route('dividas.basicReport', [session('idmunicipe'), 'parceladas']) }}" class="form" method="get" target="_blank">
                <button type="submit" id="opcao3">
                    <i class="far fa-file-pdf" aria-hidden="true"></i>
                </button>
            </form>
        </li>
        <li>
            <label for="">Correntes</label>
            <form action="{{ route('dividas.basicReport', [session('idmunicipe'), 'correntes']) }}" class="form" method="get" target="_blank">
                <button type="submit" id="opcao3">
                    <i class="far fa-file-pdf" aria-hidden="true"></i>
                </button>
            </form>
        </li>
    </ul>
</div>
