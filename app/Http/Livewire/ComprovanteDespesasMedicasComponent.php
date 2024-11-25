<?php

namespace App\Http\Livewire;

use App\Repositories\ComprovanteDespesasMedicasRepository;
use App\Services\Mask;
use PDF;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ComprovanteDespesasMedicasComponent extends Component
{
    public $exc;

    public function mount()
    {
        $this->exc = date('Y') - 1;
    }

    public function render()
    {
        return view('livewire.comprovante-despesas-medicas-component');
    }

    public function pdf()
    {
        try {
            $repository = new ComprovanteDespesasMedicasRepository();
            $resumeData = $repository->resumeData($this->exc);

            $debts = collect($repository->debts($this->exc));

            // dd($debts->groupBy('mes'));

            if (is_array($resumeData)) {
                $resumeData = $resumeData[0];

                $view = 'reports.comprovante-despesas-medicas';

                $params = [
                    'year' => $this->exc,
                    'title' => 'Comprovante Despesas Médicas',
                    'data' => $resumeData,
                    'valorContribuicao' => Mask::money($resumeData->valorContribuicao),
                    'valorPago' => Mask::money($resumeData->valorPago),
                    'valorReembolso' => Mask::money($resumeData->valorReembolso),
                    'debts' => $debts->groupBy('mes'),

                ];

                $fileName = 'Comprovante Despesas Médicas - ' . $this->exc . '.pdf';

                $pdfContent = PDF::loadView($view, $params)->output();

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    $fileName,
                );

                $view = 'reports.comprovante-despesas-medicas';
            } else {
                session()->flash('error', 'Dados não disponíveis para o munícipe.');
            }
        } catch (\Exception $error) {
            session()->flash('error', $error->getMessage());
        }
    }
}
