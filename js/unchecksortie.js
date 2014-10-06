$(document).ready(script);

function script(){

			$(".uncheck").click(function(){
				var id = $(this).attr('id');
				$('.' + id).fadeIn();
			});


}