(function ($) {
  "use strict";

  $(".like-post i").on("click", function (e) {
  	e.preventDefault();
    var post_id = $(this).data("post_id");
    var element = $(this);
    if($(this).hasClass("text-muted")){
    	$.ajax({
	        url: BASE_URL + "Blog_Controller/like_post",
	        type: "POST",
	        data: {post_id: post_id },
	        success: function (result) {
	        	result = JSON.parse(result);
	        	if (result.success == 'successfull') {
		            element.removeClass("text-muted");
		            element.addClass("text-success");
		        } 
		        else if (result.status == "redirect") {
		            window.location.href = BASE_URL + "login";
		        } 
		        else if (result.error == "unsuccessfull") {
		            alert("Something happen wrong");
		        }
	        },
	        error: function (e) {
	        	console.log(e);
	        },
        });
    }
    else
    {
    	$.ajax({
	        url: BASE_URL + "Blog_Controller/delete_post", 
	        type: "POST",
	        data: {post_id: post_id},
	        success: function (result) {
	          result = JSON.parse(result);
	          if (result.success == 'successfull') {
	            element.removeClass("text-success");
	            element.addClass("text-muted");
	          } 
	          else if (result.status == "redirect") {
	            window.location.href = BASE_URL + "login";
	          } 
	          else if (result.error == "unsuccessfull") {
	            alert("Something happen wrong");
	          }
	        },
	        error: function (e) {
	          console.log(e);
	        },
      	});
    }
  });
})(jQuery);  