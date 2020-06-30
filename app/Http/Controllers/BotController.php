<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Exception;
use Log;
use Symfony\Component\Process\Process;

class BotController extends Controller
{
    public function getBotResponse(Request $request)
    {
		try
		{
		$req=json_decode($request->getContent());
		$query=$req->queryResult->queryText;
		Log::error($query);
		$process = new Process("python3 scripts/main.py \"{$query}\"");
	        $process->run();
	        // executes after the command finishes
	        if (!$process->isSuccessful()) {
	            throw new ProcessFailedException($process);    
		}
		$res=$process->getOutput();
		$arr=json_decode($res);
		Log::error($res);
		return response()->json($arr,200);
	    }
	    catch(ProcessFailedException $e){
	    	Log::error('ProcessFailedException Encountered'.$e);
	    	echo "ProcessFailedException".$e;
	    }
	    catch(Exception $e){
	        Log::error('Exception Encountered'.$e);
	        echo "Exception";
	    }
    }
}
