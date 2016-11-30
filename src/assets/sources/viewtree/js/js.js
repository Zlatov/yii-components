$(document).ready(function(){
	$(".viewTreeDrop").find("li:has(ul)").prepend('<div class="drop"></div>');
	$(".viewTreeDrop div.drop").click(function() {
		if ($(this).nextAll("ul").css('display')=='none') {
			$(this).nextAll("ul").slideDown(400);
			$(this).css({'background-position':"-11px 0"});
		} else {
			$(this).nextAll("ul").slideUp(400);
			$(this).css({'background-position':"0 0"});
		}
	});
	$(".viewTreeDrop").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position':"0 0"});
});
