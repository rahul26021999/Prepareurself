<!-- summernote stylesheet -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.css')}}">

<!-- summernote  javascript-->
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  $(function () {
    $('.textarea').summernote({
       height:{{$height}},
       toolbar:[
          ['custom',['textmanipulator']], // The dropdown
          ['style',['style']],
          ['font',['bold','italic','underline','strikethrough','clear']],
          ['fontname',['fontname']],
          ['fontsize', ['fontsize']],
          ['color',['color']],
          ['para',['ul','ol','paragraph']],
          ['height',['height']],
          ['table',['table']],
          ['insert',['media','link','hr']],
          ['view',['fullscreen','codeview','undo','redo']],
          ['help',['help']]
        ],
        textManipulator:{
          lang: 'en-US' // Change to your chosen language
        },
        popover: {
          table: [
            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
            ['custom', ['tableStyles']]
          ],
        },

    });
  })
</script>
