<?php
	$userid = $loggedinuser['memberIdx'];
?>
<script type="text/javascript">
	var rating_value = [0, 0, 0, 0];
	$(function(){
		$(".rating .rate_label").click(function(){
			rating_value[$(".rating").index($(this).parent())] = 0;
			$(this).parent().find(".fa-star").removeClass("checked");
		});
		$(".rating .fa-star").click(function(){
			$(this).parent().find(".fa-star").removeClass("checked");
			var index_star = $(this).parent().find(".fa-star").index($(this));
			rating_value[$(".rating").index($(this).parent())] = index_star + 1;
			for(let i=0; i <= index_star; i++) 
				$(this).parent().find(".fa-star").eq(i).addClass("checked");
		}).mouseover(function(){
			$(this).parent().find(".fa-star").removeClass("checked");
			var index_star = $(this).parent().find(".fa-star").index($(this));
			for(let i=0; i <= index_star; i++) 
				$(this).parent().find(".fa-star").eq(i).addClass("checked");
		}).mouseout(function(){
			$(this).parent().find(".fa-star").removeClass("checked");
			var index_star = rating_value[$(".rating").index($(this).parent())];
			for(let i=0; i < index_star; i++) 
				$(this).parent().find(".fa-star").eq(i).addClass("checked");
		});

		$("#btn_favorite").click(function(){
<?php if(is_null($userid)):?>
			alert("You have to log in first");
			$("#uid").focus();
			return false;
<?php else:?>
			$.post("<?=ROOTPATH?>api/business_favorite/<?=$business->id?>", {on_off: ($(this).find(".fa-heart").hasClass("far"))?1:0}, function(data){
			});
			if($(this).find(".fa-heart").hasClass("far"))
				$(this).find(".fa-heart").removeClass("far").addClass("fas");
			else
				$(this).find(".fa-heart").removeClass("fas").addClass("far");
<?php endif?>
		});
		$("#btn_edit").click(function(){
<?php if(is_null($userid)):?>
			alert("You have to log in first");
			$("#uid").focus();
			return false;
<?php elseif($userid != $business->memberIdx):?>
			alert("Only owner can edit business info");
			return false;
<?php else:?>
			window.location.href = "<?=ROOTPATH?>favorites/business/<?=$business->id?>";
<?php endif?>
		});
		$("#btn_maps").click(function(){

		});
		$("#btn_review").click(function(){
<?php if(is_null($userid)):?>
			alert("You have to log in first");
			$("#uid").focus();
			return false;
<?php else:?>
			review_content = $("#txt_review").prop("value");
			if(review_content.trim() == "") {
				$("#txt_review").focus();
				return false;
			}

			$.post("<?=ROOTPATH?>api/business_review/<?=$business->id?>", {content: review_content, rating_1: rating_value[0], rating_2: rating_value[1], rating_3: rating_value[2], rating_4: rating_value[3]}, function(data){
				window.location.reload(true);
			});
<?php endif?>
		});
	});


$(document).ready(function() {
  var map = null;
  var myMarker;
  var myLatlng;

  function initializeGMap(lat, lng) {
    myLatlng = new google.maps.LatLng(lat, lng);

    var myOptions = {
      zoom: 12,
      zoomControl: true,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    myMarker = new google.maps.Marker({
      position: myLatlng
    });
    myMarker.setMap(map);
  }

  // Re-init map before show modal
  $('#myMapModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    initializeGMap(button.data('lat'), button.data('lng'));
    $("#location-map").css("width", "100%");
    $("#map_canvas").css("width", "100%");
  });

  // Trigger map resize event after modal shown
  $('#myMapModal').on('shown.bs.modal', function() {
    google.maps.event.trigger(map, "resize");
    map.setCenter(myLatlng);
  });
});
</script>