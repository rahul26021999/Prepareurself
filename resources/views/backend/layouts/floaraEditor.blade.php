 <!-- Include all Editor plugins JS files. -->
  <script type="text/javascript" src="{{ asset('FroalaEditor/js/froala_editor.pkgd.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('FroalaEditor/js/plugins/image.min.js')}}"></script>
  <!-- Include Code Mirror JS. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <!-- Include PDF export JS lib. -->
  <script type="text/javascript" src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

  <script>
    var froala=new FroalaEditor('textarea#froala-editor',{
      height: $('textarea#froala-editor').data('height'),
    
      useClasses:false,
      emoticonsUseImage: false,

      // Set the image upload parameter.
      imageUploadParam: 'file',

      // Set the image upload URL.
      imageUploadURL: '{{url("/")}}/admin/froala/upload-image',

      // Additional upload params.
      imageUploadParams: {_token: '{{csrf_token()}}'},

      // Set request type.
      imageUploadMethod: 'POST',

      // Allow to upload PNG and JPG.
      imageAllowedTypes: ['jpeg', 'jpg', 'png'],
  });
</script>


<!-- Include all Editor plugins CSS style. -->
<link rel="stylesheet" href="{{ asset('FroalaEditor/css/froala_editor.pkgd.min.css') }}">
<!-- Include Code Mirror CSS. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">