<script type="text/javascript">

    jQuery(document).ready(function() {
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "article_content",
            sSkinURI: "<?=ROOTPATH?>../CI_MANG/wordpress/?mb_ext=seditor&se_skin=SmartEditor2Skin_en_US&se_locale=en_US",
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

	$("#mb_test_i_file1").change(function(event){
	    var file = event.target.files[0];       
	    var data = new FormData();
	    data.append("uploadedFile", file);
	    var objXhr = new XMLHttpRequest();
	    objXhr.onreadystatechange = function() {
		    if (objXhr.readyState == XMLHttpRequest.DONE) {
		        jQuery("#upload_id_1").prop("value", objXhr.responseText);
		    }
		}
	    objXhr.open("POST", "<?=ROOTPATH?>blogs/upload_attach");
	    objXhr.send(data);
	});

	$("#mb_test_i_file2").change(function(event){
	    var file = event.target.files[0];       
	    var data = new FormData();
	    data.append("uploadedFile", file);
	    var objXhr = new XMLHttpRequest();
	    objXhr.onreadystatechange = function() {
		    if (objXhr.readyState == XMLHttpRequest.DONE) {
		        jQuery("#upload_id_2").prop("value", objXhr.responseText);
		    }
		}
	    objXhr.open("POST", "<?=ROOTPATH?>blogs/upload_attach");
	    objXhr.send(data);
	});

    jQuery(".btn-send-write").click(function(){
    	if(jQuery("#article_title").prop("value") == "") {
    		jQuery("#article_title").focus();
    		return false;
    	}	
    	jQuery.post("<?=ROOTPATH?>article_register/<?=$categoryIdx?>", {"article_title": jQuery("#article_title").prop("value"), "article_content": oEditors[0].getContents(), "upload_id_1": jQuery("#upload_id_1").prop("value"), "upload_id_2": jQuery("#upload_id_2").prop("value")}, function(data){
    		top.location.href = '<?=ROOTPATH?>blogs/category/<?=$categoryIdx?>';
    	});
    })

</script>