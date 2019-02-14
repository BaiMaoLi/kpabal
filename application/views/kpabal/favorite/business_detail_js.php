<script type="text/javascript">
    function attach_record() {
        $("#upload_attach").click();
    }

    transferComplete = function(e) {
        $("#business_avatar").attr("src", "<?=ROOTPATH?>api/image/business_m/<?=$memberIdx?>/552/400");
    }

    $("#upload_attach").change(function(event){
        var file = event.target.files[0];       
        var data = new FormData();
        data.append("uploadedFile", file);
        var objXhr = new XMLHttpRequest();
        objXhr.addEventListener("load", transferComplete, false);
        objXhr.open("POST", "<?=ROOTPATH?>api/user_business_image");
        objXhr.send(data);
    });
</script>