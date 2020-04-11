 <script type="text/javascript">
    
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      heightAuto:true,
      timer: 3000
    });

    @if(Session::has('success'))
    Toast.fire({
      type: 'success',
      title: '{{ Session::get("success")}}'
    });
    @elseif(Session::has('error'))
    Toast.fire({
      type: 'error',
      title: '{{ Session::get("error")}}'
    });
    @elseif(Session::has('info'))
    Toast.fire({
      type: 'info',
      title: '{{ Session::get("info")}}'
    });
    @elseif(Session::has('warning'))
    Toast.fire({
      type: 'warning',
      title: '{{ Session::get("warning")}}'
    });
    @elseif(Session::has('question'))
    Toast.fire({
      type: 'question',
      title: '{{ Session::get("question")}}'
    });
    @endif
  });
</script>