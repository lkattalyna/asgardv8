<?php

namespace App\Http\Traits;

use App\RegImprovement;
use Illuminate\Support\Facades\Auth;
/**
 *
 */
trait ImprovementProgressTrait
{
    private function getProgress(RegImprovement $improvement)
    {
        // Item 1 aprobación
        $progress['registerTot'] = 5;
        if($improvement->approval_status != 0){
            $progress['register'] = 100;
            $progress['registerGen'] = $this->getProgressQuantity($progress['registerTot'],100);
        }else{
            $progress['register'] = 50;
            $progress['registerGen'] = $this->getProgressQuantity($progress['registerTot'],50);
        }
        // Item 2 Documentación
        $progress['documentationTot'] = 25;
        if($improvement->documentation){
            $progress['documentation'] = 50;
            $progress['documentationGen'] = $this->getProgressQuantity($progress['documentationTot'],$progress['documentation']);
            // Tiene documento adjunto
            if($improvement->documentation->tech_manual != 0){
                if($improvement->documentation->tech_manual_link != 'N/A'){
                    $progress['documentation'] += 10;
                    $progress['documentationGen'] += $this->getProgressQuantity($progress['documentationTot'],10);
                }
            }else{
                $progress['documentation'] += 10;
                $progress['documentationGen'] += $this->getProgressQuantity($progress['documentationTot'],10);
            }
            //La documentación esta aprobada
            if($improvement->documentation->approval_status != 0){
                $progress['documentation'] += 40;
                $progress['documentationGen'] += $this->getProgressQuantity($progress['documentationTot'],40);
            }
        }else{
            $progress['documentation'] = 0;
            $progress['documentationGen'] = $this->getProgressQuantity($progress['documentationTot'],$progress['documentation']);
        }
        // Item 3 Vistas en Asgard
        if($improvement->asgard_view){
            $progress['asgardTot'] = 20;
            // Existe la vista en asgard
            if($improvement->asgView){
                if($improvement->asgView->state_id == 5){
                    $progress['asgard'] = 80;
                    $progress['asgardGen'] = $this->getProgressQuantity($progress['asgardTot'],$progress['asgard']);
                }elseif($improvement->asgView->state_id >= 6){
                    $progress['asgard'] = 100;
                    $progress['asgardGen'] = $this->getProgressQuantity($progress['asgardTot'],$progress['asgard']);
                }else{
                    $progress['asgard'] = 50;
                    $progress['asgardGen'] = $this->getProgressQuantity($progress['asgardTot'],$progress['asgard']);
                }
            }else{
                $progress['asgard'] = 0;
                $progress['asgardGen'] = $this->getProgressQuantity($progress['asgardTot'],$progress['asgard']);
            }
            // peso del seguimiento
            $progress['tracingTot'] = 50;
        }else{
            $progress['asgardTot'] = 0;
            $progress['asgard'] = 0;
            $progress['asgardGen'] = 0;
            // peso del seguimiento
            $progress['tracingTot'] = 70;
        }
        // item 4 actividades de seguimiento

        // cantidad de CI's
        $progress['ciTot'] = 20;
        if($improvement->ci_goal == 0){
            $progress['ci'] = 100;
            $progress['ciGen'] = 20;
            $progress['tracingGen'] = $this->getProgressQuantity($progress['tracingTot'],$progress['ciTot']);
        }else{
            $progress['ci'] = $this->getProgressPercent($improvement->ci_goal,$improvement->ci_progress);
            $progress['ciGen'] = $this->getProgressQuantity($progress['ciTot'],$progress['ci']);
            $progress['tracingGen'] = $this->getProgressQuantity($progress['tracingTot'],$progress['ciGen']);
        }
        // Desarrollo o programación (script, playbook, etc)
        $progress['devTot'] = 50;
        $progress['dev'] = $improvement->dev_progress;
        $progress['devGen'] = $this->getProgressQuantity($progress['devTot'],$progress['dev']);
        $progress['tracingGen'] += $this->getProgressQuantity($progress['tracingTot'],$progress['devGen']);

        // Integración con otros servicios
        $progress['intTot'] = 20;
        $progress['int'] = $improvement->int_progress;
        $progress['intGen'] = $this->getProgressQuantity($progress['intTot'],$progress['int']);
        $progress['tracingGen'] += $this->getProgressQuantity($progress['tracingTot'],$progress['intGen']);

        // Pruebas
        $progress['testTot'] = 10;
        $progress['test'] = $improvement->test_progress;
        $progress['testGen'] = $this->getProgressQuantity($progress['testTot'],$progress['test']);
        $progress['tracingGen'] += $this->getProgressQuantity($progress['tracingTot'],$progress['testGen']);

        // Conclusión
        $progress['tracing'] = $progress['ciGen'] + $progress['devGen'] + $progress['intGen'] + $progress['testGen'];
        $progress['total'] = $progress['asgardGen'] + $progress['documentationGen'] + $progress['registerGen'] + $progress['tracingGen'];
        $progress['pending'] = number_format((100 - $progress['total']),1,'.','');
        // Actualizo valores en la BD
        $improvement->update([
            'doc_progress' => $progress['documentation'],
            'view_progress' => $progress['asgard'],
            'total_progress' => $progress['total'],
        ]);
        if($progress['total'] == 100 && is_null($improvement->close_date)){
            $improvement->update([
                'close_date' => date('Y-m-d'),
            ]);
        }

        return $progress;
    }
    private function getProgressQuantity($total, $percentProgress)
    {
        $advance = ($total * $percentProgress) / 100;
        if(is_float($advance)){
            $advance = number_format($advance, 1,'.','');
        }
        return $advance;
    }
    private function getProgressPercent($total, $quantityProgress)
    {
        $advance = (100 * $quantityProgress) / $total;
        if(is_float($advance)){
            $advance = number_format($advance, 1,'.','');
        }
        return $advance;
    }
}
