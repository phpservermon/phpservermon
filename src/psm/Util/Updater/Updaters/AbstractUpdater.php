<?php

namespace psm\Util\Updater\Types;
use psm\Service\Database;



abstract class AbstractUpdater
{
    private $run_time;
    private $run_start = 0;

    private $error = '';


    public function GetIcon(){
        return 'icon-cog';
    }

    protected function StartRun(){
        $this->run_start = microtime(true);

    }

    protected function StopRun(){
        $this->run_time = (microtime(true) - $this->run_start);
    }

    public function GetRunTime(){
        return $this->run_time;
    }


    public function GetError(){
        return $this->error;
    }

    protected function SetError($error){
        $this->error = $error;
    }



    public function PrepareIP($ip) {
        return $ip;
    }
    public function ValidateIP($ip){

    }

    abstract public function Update($server);



}





