@extends('layouts.master')

@section('content-header')
    <h1>Gerar tag</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
        	<form action="#" method="get">

        		<div class="box box-primary">
        			<div class="box-body">
        				<div class="row">
        					<div class="col-md-12">
        						<div class="form-group">
			        				{{ Form::label("jira_id", "ID do Jira") }}
			        				{{ Form::text("jira_id", null, array( "class" => "form-control", "placeholder" => "ex.: ESTADAO-1700" )) }}
			        			</div>
        					</div>

        					<div class="col-md-6">
			        			<div class="form-group">
			        				{{ Form::label("destino", "Destino para tag") }}
			        				{{ Form::select("destino", ["qa"=>"dev/qa","prod"=>"producao"], false, array( "class" => "form-control" )) }}
			        			</div>
        					</div>
		        			<div class="col-md-6">
		        				<div class="form-group">
		        					{{ Form::label("branch", "Branch usado no destino") }}
		        					{{ Form::text("branch", "master", array( "class" => "form-control" )) }}
		        					<p>
		        						<em><small>trocar para o branch que será feito o merge</small></em>
		        					</p>
		        				</div>
		        			</div>

	        				<div class="form-group hidden">
	        					{{ Form::label("versao", "Versão") }}
	        					{{ Form::number("versao", "1", array( "class" => "form-control", "placeholder" => "ex.: ESTADAO-1700" )) }}
	        				</div>
        				</div>
        			</div>
        			<div class="box-footer">
        				<h4>Comandos para o git</h4>
        				<div class="row">
        					<div class="col-md-8">
        						<pre class="tag">git add -A
git commit -m "descrição da minha alteração"
git checkout <span class="branch">master</span>
git pull origin <span class="branch">master</span>
git merge MEU_BRANCH

#verificar se não houveram conflitos

git tag "<b></b>"
git push origin <span class="branch">master</span> --tags</pre>
        					</div>
        					<div class="col-md-4">
        						<button type="button" id="copy" class="btn btn-warning btn-lg" disabled>
	                                <i class="fa fa-clipboard"></i> Copiar para o clipboard
	                            </button>
        					</div>
        				</div>
        			</div>
        		</div>
        	</form>
        </div><!-- ./col -->
    </div><!-- /.row -->
@stop

@section('footer-extra')
	{{ HTML::script("js/plugins/zeroclipboard/ZeroClipboard.js") }}
    <script>
    $(function() {

    	var criarTag = function(){
    		var jira    = $("#jira_id").val();
    		var versao  = $("#versao").val();
    		var destino = $("#destino").val();

    		if( jira.length < 2 ) return false;

    		var agora  = new Date();
    		var tagAno = agora.getFullYear().toString();
    		var tagMes = (agora.getMonth() + 1).toString();
    		var tagDia = agora.getDate().toString();
    		var tagHor = agora.getHours().toString();
    		var tagMin = agora.getMinutes().toString();

    		while( tagMes.length < 2 ) tagMes = "0" + tagMes;
    		while( tagDia.length < 2 ) tagDia = "0" + tagDia;
    		while( tagHor.length < 2 ) tagHor = "0" + tagHor;
    		while( tagMin.length < 2 ) tagMin = "0" + tagMin;

    		var tag = destino + "-" + tagAno + tagMes + tagDia + "-" + tagHor + tagMin + "-" + encodeURIComponent(jira);// + "-v" + versao;
    		$(".tag b").text(tag);
    		// var tagData =  + (agora.getMonth()
    	}

    	var trocaBranch = function(){
    		var branch  = $("#branch").val();
    		$(".tag .branch").text( $("#branch").val() != "" ? $("#branch").val() : "master" )
    	}

    	criarTag();

    	$("#jira_id").change(criarTag);
    	$("#jira_id").keyup(criarTag);
    	$("#destino").change(criarTag);
    	$("#branch").keyup(criarTag);
    	$("#branch").keyup(trocaBranch);

    	//Copiar para clipboard
    	ZeroClipboard.config({ 
    		swfPath        : "{{ URL::to("js/plugins/zeroclipboard/ZeroClipboard.swf") }}",
    		trustedDomains : ["*"]
    	});

    	ZeroClipboard.on({
			"ready": function(e) { $("#copy").removeAttr("disabled") },
			"error": function(e) { $("#copy").remove() }
		});

    	var client = new ZeroClipboard($("#copy"));
    	client.on( "copy", function (event) {
			var clipboard = event.clipboardData;
			var tag = $(".tag").get(0);
			var texto = tag.textContent || tag.innerText || "navegador não suporta copy clipboard";
			// console.log( texto );

			clipboard.setData( "text/plain", texto.replace(/\n/g, '\r\n') );
			// clipboard.setData( "text/html", texto );
		});
    });
    </script>
@stop