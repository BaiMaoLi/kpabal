<!--<script type="text/javascript" src="http://img.koreatimes.com/2015/js/jquery.min.js"></script>
<script type="text/javascript" src="http://img.koreatimes.com/talk/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="http://img.koreatimes.com/talk/js/jquery.selectbox-0.2.min.js"></script>
<script type="text/javascript" src="http://img.koreatimes.com/talk/js/jquery.cookie.js"></script>
<script type="text/javascript" src="http://img.koreatimes.com/talk/js/lightbox.min.js"></script>
<script type="text/javascript" src="http://img.koreatimes.com/talk/js/common.js?ver=10012018"></script>
-->

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.selectbox/1.2.0/jquery.selectBox.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript" src="<?=ROOTPATH?>assets/js/modernizr.custom.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?=ROOTPATH?>assets/js/jquery.lazyload.js"></script>
<script type="text/javascript" src="<?=ROOTPATH?>assets/js/cbpGridGallery.js"></script>
<script type="text/javascript" src="<?=ROOTPATH?>assets/js/magicsuggest.js"></script>
<script>
    jQuery(document).ready(function($) {
        $("a.like").click(function () {
            var url="<?=ROOTPATH?>talky/update_like/"+$(this).attr("name");
            $.ajax({
                type: "POST",
                url: url,
                success: function(data) {
                   $("a.like").html(data);
                }
            });
        });

        var txt=$.parseJSON($("#tags_name").html());
        var data=[];
        $.each(txt, function( key, value ){
            data.push(value['title']);
        });
        var ms1 = $('#ms1').magicSuggest({
            name:"tags",
            data: data
        });

        $('.table').DataTable( {
            "ordering": false
        } );
    } );
    $(".TrendingTags-labelToggle").click(function(){
        if($(".extra_tags").hasClass("active")){
            $(".extra_tags").removeClass("active");
            $(".extra_tags").slideUp();
            $(".TrendingTags-labelToggle").text("MORE TAGS +");
        }else{
            $(".extra_tags").addClass("active");
            $(".extra_tags").slideDown();
            $(".TrendingTags-labelToggle").text("LESS TAGS ×");
        }
    });
    $('.list').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
</script>
<script>
jQuery(document).ready(function($){

    $('.srch_select').bind('change', function(){
        $('#searchform').submit();
    });
    new CBPGridGallery( document.getElementById( "grid-gallery" ) );
    //$('.srch_select').selectbox();
    //$('.pop_bg').empty();
});

$(function() {
});
</script>
