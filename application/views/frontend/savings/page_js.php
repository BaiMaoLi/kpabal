<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#change_view_menu").click(function () {
            location.href="<?=ROOTPATH?>savings";
        });
        $(".btn_details").click(function(){
            $("#myModal .modal-body img").attr("src",$(this).closest("div").find(".plogo").val());
            $("#myModal .modal-body h4").text($(this).closest("div").find(".ptitle").val());
            $("#myModal .modal-body p").text($(this).closest("div").find(".pdescription").val());
            $("#myModal").fadeIn();
        });
        $(".close").click(function(){
            $("#myModal").fadeOut();
        });
    });
</script>