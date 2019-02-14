<script type="text/javascript">
    function attach_record() {
        $("#upload_attach").click();
    }

    transferComplete = function(e) {
        $("#mall_avatar").attr("src", "<?=ROOTPATH?>api/image/mall_m/<?=$memberIdx?>/420/150");
    }

    $("#upload_attach").change(function(event){
        var file = event.target.files[0];       
        var data = new FormData();
        data.append("uploadedFile", file);
        var objXhr = new XMLHttpRequest();
        objXhr.addEventListener("load", transferComplete, false);
        objXhr.open("POST", "<?=ROOTPATH?>api/user_mall_image");
        objXhr.send(data);
    });
</script>