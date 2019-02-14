<script type="text/javascript">
    $(document).ready(function(){
        $("#register-form-submit").click(function(){
            var url = '<?php echo  ROOTPATH.API_DIR;?>/user_register';
            var data =  "user_id=" + $("#user_id").val() +
                        "&user_password=" + $("#user_password").val() +
                        "&user_email=" + $("#user_email").val() + 
                        "&confirm_password=" + $("#confirm_password").val();
            ajax_proc(url,data, function(){
                $(".msgContent").text('');
                $(".alert-success").addClass('display-none').addClass('fade');
                $(".alert-danger").addClass('display-none').addClass('fade');
            },function(data){
                var status = data.status;
                var msg = data.result;
                $(".msgContent").html(msg);
                if(status) {
                    $(".alert-success").removeClass('display-none').removeClass('fade');
                }
                else{
                    $(".alert-danger").removeClass('display-none').removeClass('fade');
                }
                
            },function(data){
                console.log(data);
            });
        });
    });
</script>