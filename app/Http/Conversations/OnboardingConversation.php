<?php

namespace App\Http\Conversations;
use App\VirtualHost;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnboardingConversation extends Conversation
{
    /**
     * Place your BotMan logic here.
     */
    public function askMenu()
    {
        $question = Question::create('¿Que tipo de tarea desea realizar?')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Listar Servicios disponibles')->value('List'),
                Button::create('Escribir nombre del servicio manualmente')->value('Text'),
            ]);
        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() == 'List'){
                    $this->listService($this);
                }elseif($answer->getValue() == 'Text'){
                    $this->textService($this);
                }
            }
        });
    }
    public function listService()
    {
        $question = Question::create('Seleccione la capa de servicio')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Virtualización')->value('vrt'),
                Button::create('Volver')->value('back'),
            ]);
        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() == 'vrt'){
                    $this->vrtList();
                }elseif($answer->getValue() == 'back'){
                    $this->askMenu($this);
                }
            }
        });
    }
    public function textService()
    {
        $this->ask('Escriba el servicio que desea ejecutar:', function(Answer $answer) {
            $vrt = array('DIAGNOSTICO M.V.', 'DIAGNOSTICO MV', 'DIAGNOSTICO M.V', 'DIAGNOSTICOM.V.','DIAGNOSTICOMV');
            if(in_array(strtoupper($answer->getText()),$vrt)){
                $this->say('Procesando..');
            }else{
                $this->say('No existen servicios con el texto indicado');
                $this->askMenu();
            }

        });
    }

    public function vrtList()
    {
        $question = Question::create('Seleccione el servicio')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('Diagnostico M.V.')->value('A'),
                Button::create('Volver')->value('back'),
            ]);
        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() == 'A'){
                    $this->getServiceCodeDiagMV();
                }elseif($answer->getValue() == 'back'){
                    $this->listService();
                }
            }
        });
    }
    public function getServiceCodeDiagMV()
    {
        $this->ask('Escriba el código de servicio:', function(Answer $answer) {
            $server = $answer->getText();
            $hosts = VirtualHost::where('name','like',"%$server%")->count();
            if($hosts == 0){
                $this->say('No se encontraron datos para la búsqueda');
                $this->getServiceCodeDiagMV();
            }elseif($hosts > 5){
                $this->say('Se encontraron '.$hosts.'para la búsqueda, por favor sea mas especifico');
                $this->getServiceCodeDiagMV();
            }else{
                $hosts = VirtualHost::where('name','like',"%$server%")->get();
                $this->getInfoDiagMV($hosts);
            }

        });
    }
    public function getInfoDiagMV($hosts)
    {
        $question = Question::create('Seleccione la maquina virtual')->callbackId('select_vm');
        foreach($hosts as $host){
            $question->addButton(Button::create("$host->name - $host->vcenter")->value("$host->power_state*$host->vm_id;$host->vcenter"));
        }
        $question->addButton(Button::create('Volver')->value('back'));
        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $vm = $answer->getValue();
                $this->validateVM($vm);
            }
        });
    }
    public function validateVM($vm)
    {
        $vm = explode("*",$vm);
        if($vm[0] == 0){
            $this->say('La maquina seleccionada se encuentra apagada por favor intente con otra');
            $this->vrtList();
        }else{
            $this->say('Se iniciará el diagnostico por favor espere...');
            //$this->bot->typesAndWaits(1);
            $this->runDiagVM($vm[1]);
            //$this->test($vm[1]);
        }
    }
    public function test($vm){
        $this->say('otro mensaje...');
        $this->runDiagVM($vm);
    }
    public function runDiagVM($vm)
    {
        $results = exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\CHATBOT\C001-ChatBot-ExecutionScriptsWinRM.ps1 -op 1 -params '$vm'");
        //dd($results);
        $results = json_decode($results,true);
        //dd($results);
        if(is_null($results) || $results == "" || count($results) == 0){
            $this->say('No se logro realizar el proceso, por favor intente de nuevo');
            //dd("Resultado:*".$results."*");
            $this->vrtList();
        }else{
            $message = '-------------------------------------- <br>';
            $message .= '<table>';
            foreach($results as $key => $value){
                $message .= "<tr><th>$key</th><td>$value</td></tr>";
            }
            $message .= '</table><br>';
            $message .= '-------------------------------------- ';
            $this->say('Proceso finalizado, los datos del diagnostico son los siguientes: <br>'.$message);
            $question = Question::create('¿Que desea hacer?')
                ->callbackId('return')
                ->addButtons([
                    Button::create('Volver')->value('back'),
                ]);
            $this->ask($question, function(Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    if($answer->getValue() == 'back'){
                        $this->listService();
                    }
                }
            });
        }
    }
    public function run()
    {
        $this->askMenu();
    }
}
