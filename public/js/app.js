$(function() {

	var showLoading = function(){
		var $overlay = $(".box .overlay");
		var $loading = $(".box .loading-img");

		$loading.removeClass("hidden");
		$overlay.removeClass("hidden");
	};

	var hideLoading = function(){
		var $overlay = $(".box .overlay");
		var $loading = $(".box .loading-img");

		$loading.addClass("hidden");
		$overlay.addClass("hidden");
	};
	
	$("#deleteModal").on("show.bs.modal", function(e) {
		var botao = $(e.relatedTarget);
	    $(this).find(".btn-danger")
	    	.data("href", botao.attr("href"))
	    	.click(function(event) {
		    	var url = $(this).data("href");

		    	showLoading();
		    	$("#deleteModal").modal("hide");

		    	$.ajax({
		    		url: url,
		    		type: "DELETE",
		    		dataType: "json"
		    	})
		    	.done(function(data) {
		    		if( data.sucesso ){
		    			botao.parents("tr").addClass("bg-danger").delay(1000).fadeOut("slow");
		    			hideLoading();
		    		}
		    	})
		    	.fail(function() {
		    		console.log("AJAX ERROR");
		    	})
		    	.always(function() {
		    		console.log("AJAX COMPLETE");
		    	});
		    	

		    });
	});
});