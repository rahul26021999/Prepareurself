<!-- summernote stylesheet -->
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.css')}}">

<style type="text/css">
  .code_view{
    background: #f3f3f3;
    border-radius: 10px;
  }
</style>
<!-- summernote  javascript-->
<script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  $(function () {
      $('.textareaLimited').summernote({
          height:{{$height}},
           toolbar: [
               ['para', ['style','ul', 'ol']],
               ['font', ['strikethrough', 'superscript', 'subscript']],
               ['style', ['bold', 'italic', 'underline']],
               ['insert', ['picture']],
               ['view', ['fullscreen', 'codeview', 'help']],
          ],
          styleTags: ['p', { title: 'code', tag: 'pre', className: 'code_view', value: 'pre' }],
        
    });

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
