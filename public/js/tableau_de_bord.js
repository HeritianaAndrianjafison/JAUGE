$(document).ready(function (){

	$(".sort").click(function (){

		var ref = $(this).attr("alt");
		$(".indice").attr("style","");
		$(".indice").attr("class","indice glyphicon glyphicon-triangle-bottom");
		$(this).find(".indice").attr("style","color:red");
		var orientation =$(this).attr("orientation");
		if(orientation==1){
			triC(ref);
			$(this).find(".indice").attr("class","indice glyphicon glyphicon-triangle-bottom");
			$(this).attr("orientation",2);
		}else{
			triD(ref);
			$(this).attr("orientation",1);
			$(this).find(".indice").attr("class","indice glyphicon glyphicon-triangle-top");
		}
		
	})
	$(".init").click()
	$(".init").click()
})

function triD(ref){

var ligne = [];
var nl =$("#ligne_number").val();

		for(var i=0;i<nl;i++){
			var current = $(".l"+i);
			var cv = parseFloat($(".l"+i).find(".s"+ref).attr("value"));
			for(var j=i+1;j<nl;j++){
				

				var sort= $(".l"+j);
				var sv = parseFloat($(".l"+j).find(".s"+ref).attr("value"));
				console.log(cv+" "+sv);
				if(cv<sv){
					
					var hs = sort.html();
					var hc = current.html();
					current.html(hs);
					sort.html(hc);
					cv = sv;
					

				}else{

				}
				//alert(i+" "+j);
			}

				
		}

		//alert("FIN")

}



function triC(ref){

var ligne = [];
var nl =$("#ligne_number").val();

		for(var i=0;i<nl;i++){
			var current = $(".l"+i);
			var cv = parseFloat($(".l"+i).find(".s"+ref).attr("value"));
			for(var j=i+1;j<nl;j++){
				

				var sort= $(".l"+j);
				var sv = parseFloat($(".l"+j).find(".s"+ref).attr("value"));
				console.log(cv+" "+sv);
				if(cv>sv){
					
					var hs = sort.html();
					var hc = current.html();
					current.html(hs);
					sort.html(hc);
					cv = sv;
					

				}else{

				}
				//alert(i+" "+j);
			}

				
		}

		//alert("FIN")

}