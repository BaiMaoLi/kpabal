<script type="text/javascript">
    function attach_record() {
        $("#upload_attach").click();
    }

    transferComplete = function(e) {
        $("#product_avatar").attr("src", "<?=ROOTPATH?>api/image/mall_product_m/<?=$memberIdx?>/640/400");
    }

    $("#upload_attach").change(function(event){
        var file = event.target.files[0];       
        var data = new FormData();
        data.append("uploadedFile", file);
        var objXhr = new XMLHttpRequest();
        objXhr.addEventListener("load", transferComplete, false);
        objXhr.open("POST", "<?=ROOTPATH?>api/user_mall_product_image");
        objXhr.send(data);
    });

    $("#btn_save").click(function(){
        $("#product_long_desc").prop("value", oEditors[0].getContents());
        $("#frm_content").submit();
    })

    jQuery(document).ready(function() {
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "product_long_desc",
            sSkinURI: "<?=ROOTPATH?>../<?=((strpos(ROOTPATH, 'withyou')!==false)?"":"CI_MANG/")?>wordpress/?mb_ext=seditor&se_skin=SmartEditor2Skin_en_US&se_locale=en_US",
            fCreator: "createSEditor2",
            htParams: {
                bUseToolbar: true,
                bSkipXssFilter: true,
                I18N_LOCALE: "en_US",
                bUsePhotoUpload: true,
                bUseVerticalResizer: true,
                bUseModeChanger: true,
                aAdditionalFontList: [["Noto Sans", "Noto Sans KR"]]
            },
            fOnAppLoad: function() {
            }
        });
    });
</script>