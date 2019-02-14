<script src="<?=ROOTPATH ?>assets/js/jquery.imagezoom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        /*$('.products').masonry({
            itemSelector: '.item',
            columnWidth: 20
        });*/
        $('.zoom').zoom();

        $(".btn_details").click(function(){
            $("#myModal1 .modal-body img").attr("src",$(this).closest("div").find(".plogo").val());
            $("#myModal1 .modal-body h4").text($(this).closest("div").find(".ptitle").val());
            $("#myModal1 .modal-body p").text($(this).closest("div").find(".pdescription").val());
            $("#myModal1").fadeIn();
        });

        $(".close1").click(function(){
            $("#myModal1").fadeOut();
        });
        $("#change_store_menu").click(function () {
            if(!$("#my_store_content").hasClass("act")) {
                //$("#my_category_content").removeClass("act");
                //$("#my_category_content").fadeOut();
                $("#my_store_content").addClass("act");
                $("#my_store_content").fadeIn();
            }else{
                $("#my_store_content").removeClass("act");
                $("#my_store_content").fadeOut();
            }
        });
        $("#change_category_menu").click(function () {
            if(!$("#my_category_content").hasClass("act")) {
                $("#my_store_content").removeClass("act");
                $("#my_store_content").fadeOut();
                $("#my_category_content").addClass("act");
                $("#my_category_content").fadeIn();
            }else{
                $("#my_category_content").removeClass("act");
                $("#my_category_content").fadeOut();
            }
        });

        $(".cat_menu").click(function () {
            if($("#my_category_content").hasClass("act")) {
                $("#my_category_content").removeClass("act");
                $("#my_category_content").fadeOut();
            }
        });

       $("#change_store").click(function () {
           $("#my_store_content").hide();
            $("#myModal").fadeIn();
       });
        $(".close").click(function () {
            $("#myModal").fadeOut();
        });
        $("#change_view_menu").click(function () {
            location.href="<?=ROOTPATH?>savings/page";
        });
        var zoom=1;
        $(".zoom-p").click(function () {
            zoom=zoom+0.1;
            $(".product_container").attr("style","zoom:"+zoom);
        })
        $(".zoom-m").click(function () {
            zoom=zoom-0.1;
            $(".product_container").attr("style","zoom:"+zoom);
        })
        $(".fa-caret-square-o-up").click(function () {
            $(this).hide();
            $(".market_menu").slideUp();
            $(".fa-caret-square-o-down").show();
        });
        $(".fa-caret-square-o-down").click(function () {
            $(this).hide();
            $(".market_menu").slideDown();
            $(".fa-caret-square-o-up").show();
        });
    });
</script>