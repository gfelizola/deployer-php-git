var mostrarCloneModal = function( repo, urlClone ){
	var modal = $('#cloneModal');
	modal.find('.modal-body .repositorio').html(repo);
	modal.find('.btn-danger').attr("href", urlClone).unbind('click').click(function(event) {
		event.preventDefault();
		$("#console_frame").attr('src', $(this).attr('href'));
	});
	modal.modal('show');
};

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

$(function() {
	
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

	$("#rollbackModal").on("show.bs.modal", function(e) {
		var botao = $(e.relatedTarget);
	    $(this).find("form").attr("action", botao.attr("href"));
	});

	/* Morris.js Charts */
    if( window.Morris ){
    	var lineDR = new Morris.Line({
	        element    : 'deploys-chart',
	        data       : window.dadosGraficoDR,
	        xkey       : 'y',
	        ykeys      : ['deploys', 'rollbacks'],
	        labels     : ['Deploys', 'Rollbacks'],
	        lineColors : ['#00cc5a', '#ff0000'],
	        hideHover  : 'auto',
	        smooth     : false,
	        resize     : true,
	        parseTime  : false
	    });

	    var barDR = new Morris.Bar({
	        element   : 'projetos-chart',
	        data      : window.dadosGraficoP,
	        xkey      : 'nome',
	        ykeys     : ['deploys', 'rollbacks'],
	        labels    : ['Deploys', 'Rollbacks'],
	        barColors : ['#00cc5a', '#ff0000'],
	        stacked   : true,
	        resize    : true,
	        hideHover : 'auto'
	    });

	    $('ul.nav-tabs a').on('shown.bs.tab', function(e) {
	    	lineDR.redraw();
	        barDR.redraw();

	        $(".nav-tabs-custom").resize();
	    });
    }
});