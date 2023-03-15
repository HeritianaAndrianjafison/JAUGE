$(document).ready(function(){

	 init()
})


function init(){
	/*
	$(".save_new_site").click(function (){
	
		$(".site_list").append("<tr><td></td><td></td><td>"+$(".description").val()+"</td><td></td></tr>")
	})*/
	$(".collect").change(function (){
		var collect = $(this).val();
		if(collect==1){

			$(".site_selected").html($(".telma_option").val());
		}
		if(collect==2){
			$(".site_selected").html($(".orange_option").val());
		}
	})
}