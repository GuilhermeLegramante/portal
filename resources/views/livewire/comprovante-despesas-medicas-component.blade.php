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
                            <option>{{ $exc }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label>Gerar PDF</label><br>
                        <button wire:click="pdf()" title="Gerar PDF" style="width: 100%;" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></button>
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

</script>
@endpush
