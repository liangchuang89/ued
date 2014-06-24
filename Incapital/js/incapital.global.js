/* 2014-06-17 */
/*
 * JavaScript Document for Incapital
 * Copyright (c) 2014 Acathur, Carbon & Incapital
 */


var lteIE9 = document.all && !window.atob;

$(function() {

	var $asNav = $('#inc-aside-nav'),
		$caseList = $('#inc-cases-list'),
		$footer = $('.inc-footer');

	fixFooter($footer);
	
	$(window).resize(function(event) {
		fixFooter($footer);
	});

	// aside nav fix
	if ($asNav.length > 0) {
		var navTop = $asNav.offset().top;

		$(window).bind('mousewheel scroll', function() {
			var scrollTop = $(this).scrollTop();
			if (scrollTop > navTop - 45) {
				$asNav.addClass('inc-nav-fix');
			} else {
				$asNav.removeClass('inc-nav-fix');
			}
		});
	}
	
});

// fix footer

function fixFooter(elem) {
	if (elem.offset().top < $(document).height()) {
		elem.addClass('fixed');
	} else {
		elem.removeClass('fixed');
	}
}