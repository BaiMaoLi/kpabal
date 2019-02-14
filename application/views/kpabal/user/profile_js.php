
<script type="text/javascript">
    $(document).ready(function(){
        $('#datatable_message').dataTable();
        $('#datatable_points').dataTable();
        $('#datatable_lotto_order').dataTable();
        $('#datatable_lotto_payment').dataTable();
        $("#order-tab1").click(function(){
            $("#div_lotto_payment").hide();
            $("#div_lotto_order").show();
        });
        $("#payment-tab1").click(function(){
            $("#div_lotto_order").hide();
            $("#div_lotto_payment").show();
        });
        $('#tab-info .default').datepicker({
            autoclose: true,
            startDate: "today",
        });
        
        $("#member_form").validate({
            // define validation rules
            rules: {
                
            },
            
            //display error alert on form submit  
            invalidHandler: function(event, validator) {     
                
            },

            submitHandler: function (form) {
                if($("#user_password").prop("value")) {
                    if($("#user_password").prop("value") != $("#user_password2").prop("value")) {
                        toastr.error("Please enter New Passwords correctly.");
                        return false;
                    }

                    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
                    if(!(strongRegex.test($("#user_password").prop("value")))) {
                        toastr.error("Password strength is weak. Password must be eight characters or longer, and contain at least one lowercase & uppercase alphabetical character, numeric, special character.");
                        $("#user_password").focus();
                        return false;
                    }
                }
                $.post("<?php echo ROOTPATH.API_DIR;?>/members_update", $("#member_form").serialize(), function(data){
                    if(data == 0) window.location.href = "<?=FRONTEND_USER_PROFILE_DIR?>";
                    else if(data == -1) toastr.error("Someone already used that User ID");
                    else if(data == -2) toastr.error("Someone already used that email address");
                });
            }
        });  

        $(".edDesc").click(function(){
            var content = $("#descField").text();
            $("#descField").hide();
            $(".edDesc").hide();
            $("#descEtField").show();
        });

        $("#aboutCancel").click(function(){
            $("#descField").show();
            $(".edDesc").show();
            $("#descEtField").hide();
        });

        $("#aboutSubmit").click(function(){
            var memberIdx = $("#memberIdx").val();
            var member_about = $("#descEtField textarea").val().trim();
            var url = '<?php echo ROOTPATH.API_DIR;?>/user_about_update';
            var data =  "memberIdx=" + memberIdx + "&memberabout=" + member_about;
            ajax_proc(url,data, function(){
                
            },function(data){
                var result = data.status
                if(result){
                    window.location.href = "<?=FRONTEND_USER_PROFILE_DIR?>";
                }
            },function(data){
                console.log(data);
            });
        });

        $("#avatarimg").click(function(){
            $("#upload_avatar").click();
        });

        transferComplete = function(e) {
            var memberIdx = $("#memberIdx").val();
            $("#avatarimg").attr("src", "<?=ROOTPATH.PROJECT_AVATAR_DIR;?>/user_" + memberIdx + "_1.jpg");
        }

        $("#upload_avatar").change(function(event){
            var memberIdx = $("#memberIdx").val();
            var file = event.target.files[0];    	
            var data = new FormData();
            data.append("uploadedFile", file);
            var objXhr = new XMLHttpRequest();
            objXhr.addEventListener("load", transferComplete, false);
            objXhr.open("POST", "<?php echo ROOTPATH.API_DIR;?>/upload_avatar/" + memberIdx);
            objXhr.send(data);
        });
    });
    
    var nav_tab = "order-tab";

    function search_data(page_number) {
        $.post("https://mall.kpabal.com/favorites/search_my_orders", {where: nav_tab, page: page_number,memberIdx:8}, function(data){
            $("#content_table").html(data);

            $(".page-link").unbind("click").click(function(){
                if($(this).parent().hasClass("disabled")) return false;
                search_data($(this).attr("value"));
            });
        });
    }

    $(function(){

        $("#myTab .nav-link").click(function(){
            if(nav_tab == $(this).attr("id")) return false;
            nav_tab = $(this).attr("id");
            search_data(0);
        });

        search_data(0);
    });
</script>
