<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Exception;
use Symfony\Component\Process\Process;

class BotController extends Controller
{
    public function getBotResponse()
    {
		try
		{
	        $process = new Process('cd public/scripts/bot/ && python3 main.py -q "'.$request['query'].'"');
	        $process->run();
	        // executes after the command finishes
	        if (!$process->isSuccessful()) {
	            throw new ProcessFailedException($process);    
	        }
	        echo $process->getOutput();
	    }
	    catch(ProcessFailedException $e){
	    	Log::error('ProcessFailedException Encountered'.$e);
	    	echo "ProcessFailedException";
	    }
	    catch(Exception $e){
	        Log::error('Exception Encountered'.$e);
	        echo "Exception";
	    }
    }
}
