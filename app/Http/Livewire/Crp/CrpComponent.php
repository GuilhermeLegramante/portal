<?php

namespace App\Http\Livewire\Crp;

use Livewire\Component;
use PDF;
use App\Services\CrpTxtFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Repositories\MunicipeRepository;

class CrpComponent extends Component
{

    //  public $contract;
    public $exc;

    public function render()
    {
        $municipe = new MunicipeRepository();

        $contracts = $municipe->getContracts();

        return view('livewire.crp.crp-component', compact('contracts'));
    }

    public function mount()
    {
        //    $municipe = new MunicipeRepository();
        //     $contracts = $municipe->getContracts();

        $this->exc = date('Y') - 1;

        // if ($contracts != null) {
        //     $this->contract = $contracts->first()->id;
        // }
    }

    public function getCrp()
    {
        try {
            $municipe = new MunicipeRepository();

            $configContent = $municipe->getCrpConfig($this->exc);

            // DESCOMENTAR O TRECHO ABAIXO CASO FOR USAR AS CONFIGURAÇÕES DEFINIDAS NO BANCO
            // if ($configContent == false) {
            //     session()->flash(
            //         'error',
            //         'Não há dados disponíveis para o exercício selecionado.'
            //     );
            //     return redirect(route('consulta.crp'));
            // }
            $configFile = env('PARTITION_DIRF_FILE') . '\config-crp.ini';
            file_put_contents($configFile, $configContent);

            // Storage::disk('local')->put('public/config/crp/config.ini', $configContent);
            // $config = parse_ini_file(asset('storage/config/crp/config.ini'), true);
            $config = parse_ini_file($configFile, true);

            $data = $municipe->getCrpData(Session::get('fol2'), $config, $this->exc);

            // $complementarData = $municipe->getComplementarDataCrp($this->exc);

            // Dados externos do arquivo .txt da DIRF
            $service = new CrpTxtFile();
            $externalData = $service->getCrpDataFromExternalFile($this->exc);

            // dd($externalData);

            // if ($complementarData == false) {
            //     $complementarData = "";
            // }

            $isento = $data->isento;
            $decimo = $data->decimo;
            $rendimento = $data->rendimento;

            if ($rendimento < 0) {
                if ($decimo < 0) {
                    $isento = $isento + $rendimento + $decimo;
                    $decimo = 0;
                } else {
                    $isento = $isento + $rendimento;
                }
                $rendimento = 0;
            }

            $view = 'reports.dividas.crp';

            // O array $data tem os dados do banco
            // O array $externalData tem os dados do arquivo externo da dirf

            // $params = [
            //     'title' => 'Comprovante de Rendimentos Pagos',
            //     // 'idcontrato' => $data->idcontrato,
            //     'rendimento' => $rendimento,
            //     'previdencia' => $data->previdencia,
            //     'complementar' => $data->complementar,
            //     'pensao' => $data->pensao,
            //     'irrf' => $data->irrf,
            //     'isento' => $isento,
            //     'diaria' => $data->diaria,
            //     'molestia' => $data->molestia,
            //     'dividendo' => $data->dividendo,
            //     'pagamento' => $data->pagamento,
            //     'indenizacao' => $data->indenizacao,
            //     'abono' => $data->abono,
            //     'decimo' => $decimo,
            //     'irrfdecimo' => $data->irrfdecimo,
            //     'outro' => $data->outro,
            //     'saude' => $data->saude,
            //     'rra_rendimento' => $data->rra_rendimento,
            //     'rra_judicial' => $data->rra_judicial,
            //     'rra_previdencia' => $data->rra_previdencia,
            //     'rra_pensao' => $data->rra_pensao,
            //     'rra_irrf' => $data->rra_irrf,
            //     'rra_isento' => $data->rra_isento,
            //     'rra_meses' => $data->rra_meses,
            //     'complementarData' => $complementarData,

            // ];

            $params = [
                'year' => $this->exc,
                'title' => 'Comprovante de Rendimentos Pagos',
                'rendimento' => $externalData['rendimento'],
                'previdencia' => $externalData['previdencia'],
                'complementar' => $externalData['complementar'],
                'pensao' => $externalData['pensao'],
                'irrf' => $externalData['irrf'],
                'isento' => $externalData['isento'],
                'isento2' => $externalData['isento2'],
                'diaria' => $externalData['diaria'],
                'molestia' => $externalData['molestia'],
                'dividendo' => $externalData['dividendo'],
                'pagamento' => $externalData['pagamento'],
                'indenizacao' => $externalData['indenizacao'],
                'juros' => $externalData['juros'],
                'abono' => $externalData['abono'],
                'decimo' => $externalData['decimo'],
                'irrfdecimo' => $externalData['irrfdecimo'],
                'outro' => $externalData['outro'],
                'rra_rendimento' => $externalData['rra_rendimento'],
                'rra_judicial' => $externalData['rra_judicial'],
                'rra_previdencia' => $externalData['rra_previdencia'],
                'rra_pensao' => $externalData['rra_pensao'],
                'rra_irrf' => $externalData['rra_irrf'],
                'rra_isento' => $externalData['rra_isento'],
                'rra_meses' => $externalData['rra_meses'],
                // 'complementarData' => $complementarData,
                'complementares' => $externalData['complementares'],
            ];

            $fileName = 'CRP_' . $this->exc . '.pdf';

            $pdfContent = PDF::loadView($view, $params)->output();

            return response()->streamDownload(
                fn () => print($pdfContent),
                $fileName,
            );
        } catch (\Exception $error) {
            session()->flash('error', $error->getMessage());
        }
    }
}
