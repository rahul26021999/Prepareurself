<?php 
namespace App\Traits;

use App\Models\Project;
use App\Models\Resource;
use App\Models\Course;

trait OneSingleNotification{

    public function sendToOne($data){
        $content = array("en" => $title);
        $heading= array('en' => $message);
        $big_picture=$image;
        $include_player_ids=[$id];
        $url=$app_url;

        $fields = array(
            'app_id' => 'cfac8b6e-f2a6-405d-8d84-f9b16cc013db',
            'include_player_ids' => $include_player_ids,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'big_picture' =>$big_picture,
            'app_url'=>$url,
        );

        return $this->sendPushNotification($fields);
    }
    public function sendToMany($title,$message,$image,$ids,$app_url){

        $content = array("en" => $message);
        $heading= array('en' => $title);
        $big_picture=$image;
        $include_player_ids=$ids;
        $url=$app_url;

        $fields = array(
            'app_id' => 'cfac8b6e-f2a6-405d-8d84-f9b16cc013db',
            'include_player_ids' => $include_player_ids,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $heading,
            'big_picture' =>$big_picture,
            'app_url'=>$url,
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

    public function generateAndroidClickLink($request)
    {
        if($request['screen']=='app'){
            
            return "install://app.prepareurself/?screen=.authentication.ui.AuthenticationActivity";

        }elseif($request['screen']=='theory'){
            
            $resource=Resource::find($request['id']);
            return "theory://app.prepareurself/?screen=.resources.ui.activity.ResourcesActivity&id=".$resource['id']."&link=".$resource['link'];

        }elseif($request['screen']=='video'){

            $resource=Resource::find($request['id']);
            return "video://app.prepareurself/?screen=.youtubeplayer.youtubeplaylistapi.ui.VideoActivity&id=".$resource['id'];

        }elseif($request['screen']=='project'){
            
            $project=Project::find($request['id']);
            return "project://app.prepareurself/?screen=.courses.ui.activity.ProjectsActivity&id=".$project['id']."&courseName=".$project->Course->name;

        }elseif($request['screen']=='feedback'){

            return "install://app.prepareurself/?screen=.authentication.ui.AuthenticationActivity&type=feedback";
            
        }
        elseif ($request['screen']=='profile') {
            return "install://app.prepareurself/?screen=.authentication.ui.AuthenticationActivity&type=profile";
        }
        elseif($request['screen']=='allCourses'){

        }
        elseif($request['screen']=='allProjects'){

        }
        elseif($request['screen']=='allTopics'){
            
            $course=Course::find($request['id']);
            return "course://app.prepareurself/?screen=.courses.ui.activity.CoursesActivity&id=".$course['id'];
        }
        elseif($request['screen']=='allVideos'){

        }
        elseif($request['screen']=='allTheory'){

        }
        elseif($request['screen']=='course'){
        }
    }
}
?>