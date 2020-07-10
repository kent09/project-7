(function($) {

	$('.widget_wp_oz_widget input[type=checkbox]').each(function() {
		$(this).on('click', function() {

			var arr = $('.widget_wp_oz_widget .woof_checkbox_term:checked').map(function(){
		        return this.value;
		    }).get();

			$.ajax({
				type : "POST",
				dataType : "json",
				url : product_cat_filter.ajax_url,
				data : { action: "product_cat_filter", term : arr },
				success: function(response) {
					let $url, $result;

					$url = removeParam("product_cat", window.location.href);

					if(response.type == "success" ) {
						$result = response.result;

						if(checkParam("swoof",window.location.href)) {
							window.location.href = $url + "&product_cat=" + $result.product_cat;
						} else {
							window.location.href = $url + "?swoof=1&product_cat=" + $result.product_cat;
						}
					} else {
						window.location.href = $url;
					}
				}
			});
		});
	});

	function removeParam(key, sourceURL) {
	    var rtn = sourceURL.split("?")[0],
	        param,
	        params_arr = [],
	        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
	    	console.log(queryString);
	    if (queryString !== "") {
	        params_arr = queryString.split("&");
	        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
	            param = params_arr[i].split("=")[0];
	            if (param === key) {
	                params_arr.splice(i, 1);
	            }
	        }
	        rtn = rtn + "?" + params_arr.join("&");
	    }
	    return rtn;
	}
	function checkParam(key, sourceURL) {
		if(sourceURL.indexOf('?' + key + '=') != -1)
		    return true;
		else if(sourceURL.indexOf('&' + key + '=') != -1)
		    return true;
		return false;
	}

}(jQuery));