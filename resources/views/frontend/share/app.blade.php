<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0, maximum-scale=1.0" />
    <title>Site Name</title>
    <style>@media screen and (max-device-width:480px){body{-webkit-text-size-adjust:none}}</style>
 
    <!-- implement javascript on web page that first first tries to open the deep link
        1. if user has app installed, then they would be redirected to open the app to specified screen
        2. if user doesn't have app installed, then their browser wouldn't recognize the URL scheme
        and app wouldn't open since it's not installed. In 1 second (1000 milliseconds) user is redirected
        to download app from app store.
     -->
    <script>
    window.onload = function() {
    // <!-- Deep link URL for existing users with app already installed on their device -->
    @if(isset($type) && $type=='home')
        window.location ="install://app.prepareurself/?screen=.authentication.ui.AuthenticationActivity";
    @elseif(isset($type) && $type=='theory')
        window.location ="theory://app.prepareurself/?screen=.resources.ui.activity.ResourcesActivity"+"&id="+{{$id}};
    @elseif(isset($type) && $type=='video')
        window.location ="video://app.prepareurself/?screen=.resources.youtubevideoplayer.YoutubePlayerActivity"+"&id="+{{$id}};
    @elseif(isset($type) && $type=='project')
        window.location ="project://app.prepareurself/?screen=.courses.ui.activity.ProjectsActivity"+"&id="+{{$id}};
    @elseif(isset($type) && $type=='course')
        window.location ="course://app.prepareurself/?screen=.courses.ui.activity.CoursesActivity"+"&id="+{{$id}};
    @endif
    
    // <!-- Download URL (TUNE link) for new users to download the app -->
    setTimeout("window.location = 'https://play.google.com/store/apps/details?id=com.prepare.prepareurself';", 1000);
    }
    </script>
</head>
<body>

</body>
</html>
