<?php 
namespace App\Traits;

trait OneSingleNotification{

    public function sendToOne($data){
        $content = array("en" => $title);
        $heading= array('en' => $message);
        $big_picture=$image;
        $include_player_ids=[$id];

        // $buttons= array(array("id"=> "id1", "text"=> "button1", "icon"=> "ic_menu_share"), array("id"=> "id2", "text"=>"button2", "icon"=> "ic_menu_send"), array("id"=> "id2", "text"=>"button2", "icon"=> "ic_menu_send"));


        $fields = array(
            'app_id' => 'cfac8b6e-f2a6-405d-8d84-f9b16cc013db',
            'include_player_ids' => $include_player_ids,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'big_picture' =>$big_picture,
            // 'buttons' => 
        );

        return $this->sendPushNotification($fields);
    }
    public function sendToMany($title,$message,$image,$ids){

        $content = array("en" => $title);
        $heading= array('en' => $message);
        $big_picture=$image;
        $include_player_ids=$ids;

        // $buttons= array(array("id"=> "id1", "text"=> "button1", "icon"=> "ic_menu_share"), array("id"=> "id2", "text"=>"button2", "icon"=> "ic_menu_send"), array("id"=> "id2", "text"=>"button2", "icon"=> "ic_menu_send"));


        $fields = array(
            'app_id' => 'cfac8b6e-f2a6-405d-8d84-f9b16cc013db',
            'include_player_ids' => $include_player_ids,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'big_picture' =>$big_picture,
        );

        return $this->sendPushNotification($fields);
        
       
    }
    private function sendPushNotification($fields)
    {
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
?>