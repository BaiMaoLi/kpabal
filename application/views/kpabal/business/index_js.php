<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1_cca3KUssaymD-nx0yRKQyHcFFAfxp0"></script>
<script type="text/javascript">
	var nav_tab = "home-tab";
	var geolocation = false;

	function search_data(page_number) {
		$.post("<?=ROOTPATH?>business/search", {keyword: $("#search_keyword").prop("value"), state: $("#stateIdx").prop("value"), category: $("#categoryIdx").prop("value"), sort: nav_tab, page: page_number}, function(data){
			$("#content_table").html(data);

			$(".page-link").unbind("click").click(function(){
				if($(this).parent().hasClass("disabled")) return false;
				search_data($(this).attr("value"));
			});
		});
	}

	var geocoder;

	function initialize() {
	  geocoder = new google.maps.Geocoder();
	}

	function codeLatLng(lat, lng) {
	  var latlng = new google.maps.LatLng(lat, lng);
	  if(typeof geocoder == "undefined") geocoder = new google.maps.Geocoder();
	  geocoder.geocode({
	    'latLng': latlng
	  }, function (results, status) {
	    if (status === google.maps.GeocoderStatus.OK) {
	      if (results[1]) {
	        address_components = results[1].address_components;
	        for(let i =0; i<address_components.length; i++){
	        	if(address_components[i].types[0] == "administrative_area_level_1") {
	        		long_name = address_components[i].long_name;
	        		short_name = address_components[i].short_name;
	        		state_value = $("#stateIdx option[short_name='"+short_name+"']").prop("value");
	        		if(typeof state_value == "undefined") state_value = "";
	        		$("#stateIdx").prop("value", state_value);
	        		$("#cur_states").text($("#stateIdx option:selected").text());
			        $.cookie('region_state', state_value, { path: '/' });
					search_data(0);

	        		return true;
	        	}
	        }
	      } else {
	        $.cookie('region_state', "", { path: '/' });
			search_data(0);
			return false;
	      }
	    } else {
	      $.cookie('region_state', "", { path: '/' });
		  search_data(0);
		  return false;
	    }
	  });
	}

	google.maps.event.addDomListener(window, 'load', initialize);
    function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }
	$(function(){		
search_data(0);
		$(".category_items li").click(function(){
			$(".category_items li").removeClass("on");
			//alert(pad($(this).attr("value"),3));
			$("#categoryIdx").prop("value", pad($(this).attr("value"),3));
			$("#search_keyword").prop("value", "");
			$(this).addClass("on");
			search_data(0);
		});

		$("#stateIdx").change(function(){
			$.cookie('region_state', $(this).prop("value"), { path: '/' });
			$("#cur_states").text($("#stateIdx option:selected").text());
			search_data(0);
		});

		$("#categoryIdx").change(function(){
			$(".category_items li").removeClass("on");
			$("#search_keyword").prop("value", "");
			$(".category_items li[value='"+$(this).prop("value")+"']").addClass("on");
			search_data(0);
		});

		$("#category_search").keyup(function(e){
			$(".category_items li").each(function(){
				if($(this).text().toLowerCase().indexOf($("#category_search").val().toLowerCase()) != -1) $(this).show();
				else $(this).hide();
			});
		});

		$("#search_button").click(function(){
			search_data(0);
		});

		$("#myTab .nav-link").click(function(){
			if(nav_tab == $(this).attr("id")) return false;
			nav_tab = $(this).attr("id");
			search_data(0);
		});


		<?php if($categoryIdx):?>
			$("#categoryIdx").prop("value", "<?=$categoryIdx?>");
			$(".category_items li[value='<?=$categoryIdx?>']").addClass("on");
		<?php endif?>

		if(typeof $.cookie('region_state') != "undefined") {
			$("#stateIdx").prop("value", $.cookie('region_state'));
			$("#cur_states").text($("#stateIdx option:selected").text());
			search_data(0);
		} else {
			if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    codeLatLng(geolocation.lat, geolocation.lng);
                });
            } else {
            	$.cookie('region_state', "", { path: '/' });
				search_data(0);
            }
		}
	});
</script>
