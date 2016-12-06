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

	$(".viewTreeToggle").click(
			function (event) {
				// console.log($(event.target).parent().eq(0).next(".viewTree"));
				var button = $(event.target);
				var tree = $(event.target).parent().eq(0).next(".viewTree");
				if (button.hasClass("show")) {
					tree.find("ul").slideDown(400).parents("li").children("div.drop").css({'background-position':"-11px 0"});
					button.removeClass("show");
				} else {
					tree.find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position':"0 0"});
					button.addClass("show");
				}
			}
	);
});
