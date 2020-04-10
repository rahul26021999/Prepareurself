warning: LF will be replaced by CRLF in app/Models/Course.php.
The file will have its original line endings in your working directory.
[1mdiff --git a/app/Http/Controllers/TopicController.php b/app/Http/Controllers/TopicController.php[m
[1mindex c37ac37..e8c76d9 100644[m
[1m--- a/app/Http/Controllers/TopicController.php[m
[1m+++ b/app/Http/Controllers/TopicController.php[m
[36m@@ -82,6 +82,7 @@[m [mclass TopicController extends Controller[m
       if($courseName=='')[m
       {[m
         $CourseTopic=CourseTopic::with('Course')->get();[m
[32m+[m[32m        // return json_encode($CourseTopic);[m
         return view('backend.topic.all',['courseTopic'=>$CourseTopic]);[m
       }[m
       else[m
[36m@@ -89,7 +90,8 @@[m [mclass TopicController extends Controller[m
         $course=Course::where('name',$courseName)->first();[m
         if($course!=null)[m
         {[m
[31m-          $CourseTopic=CourseTopic::where('course_id',$course['id'])->get();[m
[32m+[m[32m          $CourseTopic=Course::with('CourseTopic.Resource')->where('id',$course['id'])->get();[m
[32m+[m[32m          return json_encode($CourseTopic);[m
           return view('backend.topic.show',['courseTopic'=>$CourseTopic,'course'=>$course]);[m
         }[m
         else{[m
[1mdiff --git a/app/Models/Course.php b/app/Models/Course.php[m
[1mindex e01feff..30713a8 100644[m
[1m--- a/app/Models/Course.php[m
[1m+++ b/app/Models/Course.php[m
[36m@@ -12,5 +12,9 @@[m [mclass Course extends Model[m
     {[m
         return $this->hasMany('App\Models\CourseTopic');[m
     }[m
[32m+[m[32m    public function Resource()[m
[32m+[m[32m    {[m
[32m+[m[41m    [m	[32mreturn $this->hasManyThrough('App\Models\Resource', 'App\Models\CourseTopic');[m
[32m+[m[32m    }[m
 [m
 }[m
[1mdiff --git a/resources/views/backend/topic/all.blade.php b/resources/views/backend/topic/all.blade.php[m
[1mindex 8c8b8af..6f52397 100644[m
[1m--- a/resources/views/backend/topic/all.blade.php[m
[1m+++ b/resources/views/backend/topic/all.blade.php[m
[36m@@ -87,6 +87,7 @@[m
                 <tbody>[m
                   @foreach($courseTopic as $topic)[m
                      <tr>[m
[32m+[m[32m                      <td></td>[m
                       <td><a href ="" >#{{$topic['id']}}</a></td>[m
                       <td>{{$topic['name']}}</td>[m
                       <td><a href ="/admin/topic/all/{{$topic['course']['name']}}" data-toggle="tooltip" title="Show all Topics in {{$topic['course']['name']}}" >{{$topic['course']['name']}}</a></td>[m
