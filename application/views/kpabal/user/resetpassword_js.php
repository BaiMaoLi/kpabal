<script type="text/javascript">
    $(document).ready(function(){
        $("#reset-form-submit").click(function(){
            var url = '<?php echo ROOTPATH.API_DIR;?>/user_forgotten_reset';
            var data =  "forgot_password_code=" + $("#forgot_password_code").val() +
                        "&user_password=" + $("#user_password").val()
            ajax_proc(url,data, function(){
                $(".msgContent").text('');
                $(".alert-success").addClass('fade').addClass('display-none');
                $(".alert-danger").addClass('fade').addClass('display-none');
            },function(data){
                var status = data.status;
                var msg = data.result;
                $(".msgContent").html(msg);
                if(status) {
                    $(".alert-success").removeClass('fade').removeClass('display-none');
                }
                else{
                    $(".alert-danger").removeClass('fade').removeClass('display-none');
                }
                
            },function(data){
                console.log(data);
            });
        });
    });
</script>