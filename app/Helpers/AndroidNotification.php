<?php 

namespace App\Helpers;

use GuzzleHttp\Client;

class AndroidNotification {

   /**
    * Sending push message to single user by Firebase Registration ID
    * @param $to
    * @param $message
    *
    * @return bool|string
    */
   public function send( $to, $notification) {

      $fields = array(
         'to'   => $to,
         'notification' => $notification
         // 'data' => $message,
      );

      return $this->sendPushNotification( $fields );
   }


   /**
    * Sending message to a topic by topic name
    * @param $to
    * @param $message
    *
    * @return bool|string
    */
   public function sendToTopic( $to, $notification, $message=[] ) {
      $fields = array(
         'to'   => '/topics/' . $to,
         'notification' => $notification,
         'data' => $message,
      );

      return $this->sendPushNotification( $fields );
   }


   /**
    * Sending push message to multiple users by firebase registration ids
    * @param $registration_ids
    * @param $message
    *
    * @return bool|string
    */
   public function sendMultiple( $registration_ids, $notification, $message ) {
      $fields = array(
         'to'   => $registration_ids,
         'notification' => $notification,
         'data' => $message,
      );

      return $this->sendPushNotification( $fields );
   }

   /**
    * CURL request to firebase servers
    * @param $fields
    *
    * @return bool|string
    */
   private function sendPushNotification( $fields ) {     
       // Set POST variables
       $url = 'https://fcm.googleapis.com/fcm/send';

       // $client = new Client();

       // $result = $client->post( $url, [
       //    'json'    =>
       //       $fields
       //    ,
       //    'headers' => [
       //       'Authorization' => 'key='.env('FCM_LEGACY_KEY'),
       //       'Content-Type'  => 'application/json',
       //    ],
       // ] );
         $headers = [
          'Authorization: key=AAAABFVd6go:APA91bGU2xtxYkVXWf7J9yoQB1RcKapTcj9-i9s5kGL6LksOtOFpPg53j9WEDyGu64N_QbKzE1hioqydJIjthxOztLV2VQQ1mViWeiULwnR8WjI18XDGW5n9wbWhog_ueLq61Z4v2QM9',
          'Content-Type: application/json'
      ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);


        dd($result);


       return json_decode( $result->getBody(), true );
   }
 }