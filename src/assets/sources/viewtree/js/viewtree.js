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

	$(".viewTreeToggleSlide").before('<p><span class="viewTreeToggleSlideButton btn btn-default btn-xs">Развернуть</span></p>');

	/**
	 * Устанавливаем на кнопке флаг разрешающий запустить анимацию сворачивания/разворачивания
	 */
	var viewTreeStopListen = function () {
		var button = $(this).parents(".viewTree").eq(0).prev().children("span.viewTreeToggleSlideButton")[0];
		button.haveAnimate = false;
	}

	/**
	 * Сворачиваем или разворачиваем всё дерево только в том случае, если дерево в данный момент не анимируется
	 * jQuery.Event event событие при клике на кнопку
	 */
	var viewTreeSlider = function (event) {
		console.log(event);
		var button = $(event.target);
		var tree = $(event.target).parent().eq(0).next(".viewTree");
		if (!event.target.haveAnimate) {
			event.target.haveAnimate = true; // Установим флаг запуска анимации
			if ( button.text() === 'Развернуть' ) {
				tree.find("ul").slideDown(400, viewTreeStopListen ).parents("li").children("div.drop").css({'background-position':"-11px 0"});
				button.text('Свернуть');
			} else {
				tree.find("ul").slideUp(400, viewTreeStopListen ).parents("li").children("div.drop").css({'background-position':"0 0"});
				button.text('Развернуть');
			}
		}
	};

	$(".viewTreeToggleSlideButton").click(
		viewTreeSlider
	);
});
