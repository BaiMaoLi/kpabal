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
            	oEditors[0].setContents('<?=str_replace("'", "\'", $article->article_content)?>');
            }
        });
    });

    jQuery(".btn-send-write").click(function(){
    	if(jQuery("#article_title").prop("value") == "") {
    		jQuery("#article_title").focus();
    		return false;
    	}
    	jQuery.post("<?=ROOTPATH?>article_save/<?=$article->id?>", {"article_title": jQuery("#article_title").prop("value"), "article_content": oEditors[0].getContents()}, function(data){
    		top.location.href = '<?=ROOTPATH?>blogs/article/<?=$article->id?>';
    	});
    })

</script>