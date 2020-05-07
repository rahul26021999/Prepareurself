
@extends('backend.layouts.app')

@section('headContent')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

@endsection

@section('javascriptsContent')

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>

<!-- jquery-validation -->
<script src="{{ asset('AdminLTE/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script type="text/javascript">


  $(function () {
    // Summernote
    $('.textarea').summernote({
        height: 150,   //set editable area's height
        codemirror: { // codemirror options
          theme: 'monokai'
        }
      });
  });

  $(document).ready(function () {

    bsCustomFileInput.init();
    $.validator.setDefaults({
      submitHandler: function (form) {
        if(confirm("Please Check The content below from the attached Link"))
          form.submit();  
      }
    });
    $('#editProject').validate({
       rules: {
        name: {
          required: true
        },
        link:{
          required:true
        },
        type:{
          required:true
        },
        level:{
          required:true
        }
      },
      messages: {
        name: {
          required: "Please enter a name"
        },
        link: {
          required: "Please enter a link to project"
        },
        level: {
          required: "Please enter a level of project"
        }

      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>

<script>
  var type='video';
  $('input[type=radio][name=type]').change(function() {
    if (this.value == 'video') {
      type='video';
    }
    else if (this.value == 'theory') {
      type='theory';
    }
    readURL($("input[name='link'"));
  });
function readURL(input) {
    if(type=='video')
    {
      var url=$(input).val();
      url=url.replace("watch?v=", "embed/");
      $('#showURL').attr('src',url);
    }
    else{
      $('#showURL').attr('src',$(input).val());
    }
  }
  function readImageURL(input)
  {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#showImage')
        .attr('src', e.target.result)
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

$("input[type='radio'][name='type']").on('change',function() {
    if($(this).val()=='video') 
    {
     $('#ifVideo').show();
    }
    else{
      $("input[name='videoLink'][value='hasNoPlaylist']").prop('checked',true);
      $('#ifVideo').hide();
      $('#playlist').hide();
      $('#relatedBox').hide();
    }
  });

$("input[type='radio'][name='videoLink']").on('change',function() {
    if($(this).val()=='hasPlaylist') {
     $('#playlist').show();
     $('#relatedBox').hide();
  }else if($(this).val()=='hasRelatedLinks'){
    $('#playlist').hide();
    $('#relatedBox').show();
  }
  else{
    $('#playlist').hide();
    $('#relatedBox').hide();
    
  }

  });



var counter =2 ;
function addInput(divName){
     var newdiv = document.createElement('div');
          newdiv.innerHTML="<label>Related Link "+ (counter) +"</label>" + "<input type='text'  class='form-control' placeholder='Enter  url' name='related[]'>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
}

</script>
<style>
  
  #playlist, #relatedBox{
    display: none;
  }

</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit  project</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <form method="post" action="/admin/project/edit/{{$Project['id']}}" id="editProject" enctype="multipart/form-data">
      @csrf
      <div class="card card-primary">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Name of project</label>
                <input type="text" name="name" value="{{$Project['name']}}" class="form-control" >
              </div>
              <div class="form-group">
                <label>Course</label>
                <select name="course_id" class="form-control">
                  @foreach($courses as $course)
                  @if($course['id']==$Project['course_id'])
                  <option value="{{$course['id']}}" selected="selected">{{$course['name']}}</option>
                  @else
                  <option value="{{$course['id']}}">{{$course['name']}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <label>Type</label>
              <div class="form-group">
                <div class="icheck-primary d-inline">
                  @if($Project['type']=='video')
                  <input type="radio" id="radioPrimary1" value="video" name="type" checked="checked">
                  @else
                  <input type="radio" id="radioPrimary1"  value="video" name="type">
                  @endif
                  <label for="radioPrimary1">
                    Video
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  @if($Project['type']=='theory')
                  <input type="radio" id="radioPrimary2" value="theory" name="type" checked="checked">
                  @else
                  <input type="radio" id="radioPrimary2" value="theory" name="type">
                  @endif
                  <label for="radioPrimary2">
                    Theory
                  </label>
                </div>
              </div>

               <!-- If video is checked -->
              <div class="form-group" id="ifVideo">
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary7" value="hasRelatedLinks" name="videoLink">
                  <label for="radioPrimary7">
                    Has Related Links
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary8" value="hasPlaylist" name="videoLink">
                  <label for="radioPrimary8">
                    Has Playlist 
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary9" checked  value="hasNoPlaylist" name="videoLink">
                  <label for="radioPrimary9">
                    Has No Playlist 
                  </label>
                </div>
              </div>

              <label>Level</label>
              <div class="form-group">
                <div class="icheck-primary d-inline">
                  @if($Project['level']=='easy')
                  <input type="radio" id="radioPrimary3" value="easy" name="level" checked="checked">
                  @else
                  <input type="radio" id="radioPrimary3" value="easy" name="level">
                  @endif
                  <label for="radioPrimary3">
                    Easy
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  @if($Project['level']=='medium')
                  <input type="radio" id="radioPrimary4" value="medium" name="level" checked="checked">
                  @else
                  <input type="radio" id="radioPrimary4" value="medium" name="level">
                  @endif
                  <label for="radioPrimary4">
                    Medium
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  @if($Project['level']=='hard')
                  <input type="radio" id="radioPrimary5" value="hard" name="level" checked="checked">
                  @else
                  <input type="radio" id="radioPrimary5" value="hard" name="level">
                  @endif
                  <label for="radioPrimary5">
                    Hard
                  </label>
                </div>
          
              </div>
              

              <div class="form-group">
                <label>Link Url</label>
                <input type="text" value="{{$Project['link']}}" name="link" onchange="readURL(this)" class="form-control" placeholder="Enter ...">
              </div>


             <div class="form-group" id="playlist">
                <label>If it is a playlist then only</label>
                <input type="text" name="playlist" class="form-control" value="{{$Project['playlist']}}" placeholder="Enter playlist url">
                <div class="col-xs-4 float-left">
                  <label for="startCount">Initial count of playlist</label>
                  <input class="form-control" id="startCount"  type="number">
                </div>
                <div class="col-xs-4 float-right">
                  <label for="totalCount">Count of videos</label>
                  <input class="form-control" id="totalCount" type="number">
                </div>
              
              </div>

              <div id="relatedBox">
                <div class="form-group" id="relatedLinks">
                <label>Related Link 1</label>
                <input type="text" name="related[]" class="form-control" placeholder="Enter  url">
                </div>
                <input type="button" id="relatedLinksButton" class="btn btn-primary" value="Add" onClick="addInput('relatedLinks');">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Description</label>
                <textarea class="textarea" name="description" placeholder="Place some text here"
                          style="width: 100%; height: 500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$Project['description']}}</textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Background Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="backImage" onchange="readImageURL(this)"
                    id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                @if($Project['image_url']!='')
                <img src="{{url('/')}}/uploads/projects/{{$Project['image_url'] }}" id="showImage" alt="" width="auto" height="200">
                @else
                <img src="/defaults/defaultImage.png" id="showImage" alt="" width="auto" height="200">
                @endif
              </div>
            </div>

          </div> <!-- //end of row -->
        </div>    
        <div class="card-footer">
          <a id="cancel" href="/admin/project/all" class="btn btn-danger">Cancel</a>
          <button type="submit" class="btn btn-primary float-right">Submit</button>
        </div>
      </div>
    </form>
    

    <br>

    <h3 style="text-align: center;">Content in Link</h3> 
    <iframe id="showURL" width="100%" height="400" src="https://cdn.dribbble.com/users/727458/screenshots/4153279/dribbble-icons.jpg">
    </iframe>
  </section>

</div>
@endsection


