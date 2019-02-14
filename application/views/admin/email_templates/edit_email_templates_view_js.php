<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript">
$(function(){
	$(".summernote").summernote({height: 600});
	$('#editor1').summernote("code", $('#editor1').prop("value"));

});
</script>