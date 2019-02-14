<script type="text/javascript">
    var nav_tab = "order-tab";

    function search_data(page_number) {
        $.post("<?=ROOTPATH?>favorites/search_my_orders", {where: nav_tab, page: page_number}, function(data){
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