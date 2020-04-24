<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Traits\OneSingleNotification;

class NotificationController extends Controller
{
	use OneSingleNotification;

    public function ray(Request $request){
    	$response=$this->send();

	    $return["allresponses"] = $response;
	    $return = json_encode( $return);
	    
	    array("114ea7ce-b753-437a-9d35-d673010ceacd","5866c59f-106d-4806-8386-6b3c8af59c85","b0fa55bd-b61e-41fd-b382-69ada116de5d"),
	    print("\n\nJSON received:\n");
	    print($return);
	    print("\n");
    	// $user=User::where('email',$request['email'])->first();
    	// $user->sendAndroidNotification();
    }
}
