
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=ROOTPATH?>assets/js/magicsuggest.js"></script>
<script>
    $(document).ready(function(){

        var txt=$.parseJSON($("#tags_name").html());
        var data=[];
        $.each(txt, function( key, value ){
            data.push(value['title']);
        });
        var ms1 = $('#ms1').magicSuggest({
            name:"tags",
            data: data
        });

//        $("#careers_occupation1").change(function(){
//            if($(this).val()>0){
//                $.ajax({
//                    url: "<?//=ROOTPATH?><!----><?//=ADMIN_PUBLIC_DIR?>///talky/ajax_cat",
//                    type: "post",
//                    data:{"id":$("#careers_occupation1").val()},
//                    success: function(result){
//                        $("#careers_occupation2").html('<option value="0">전체</option>'+result);
//                    }
//                });
//            }else{
//                $("#careers_occupation2").html('<option value="0">전체</option>');
//            }
//        });
    });
</script>