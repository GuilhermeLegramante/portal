<div>
    @include('partials.flash-messages')
    <div id="topo" class="card card-primary card-outline">
        <div class="card-body">
            @include('partials.spinner')
            <div class="row">
                <div wire:ignore class="col-sm-3">
                    <div class="form-group">
                        <label>Exercício</label>
                        <select id="exc" class="form-control">
                            <option>{{ date('Y') - 1 }}</option>
                            {{-- <option>{{ date('Y') - 2 }}</option> --}}
                            {{-- <option>{{ date('Y') - 3 }}</option>
                            <option>{{ date('Y') - 4 }}</option>
                            <option>{{ date('Y') - 5 }}</option> --}}
                        </select>
                    </div>
                </div>
                {{-- <div wire:ignore class="col-sm-8">
                    <div class="form-group">
                        <label>Contrato</label>
                        <select class="form-control" id="contract">
                            @foreach ($contracts as $item)
                            <option value="{{ $item->id }}">{{ $item->matricula }} | {{ $item->desc_funcao }}</option>
                @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-sm-1">
            <div class="form-group">
                <label>Gerar CRP</label><br>
                <button wire:click="getCrp()" title="Gerar PDF" style="width: 100%;" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
</div>


@push('scripts')
<script>
    $('#exc').select2({
        language: "pt-BR"
        , placeholder: "Selecione..."
    });

    $('#exc').on('change', function() {
        @this.exc = $(this).val();
    })

    // $('#contract').select2({
    //     language: "pt-BR",
    //     placeholder: "Selecione..."
    // });

    // $('#contract').on('change', function(){
    //     @this.contract = $(this).val();
    // })

</script>
@endpush
