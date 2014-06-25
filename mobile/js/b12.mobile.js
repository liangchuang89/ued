/* 2014-04-18 */
/*
 * JavaScript Document for 12lou mobile
 * Copyright (c) 2014 Acathur, Carbon & 12lou
 */


var eventType = mobilecheck() ? 'touchstart' : 'click';

$(function() {

	var $body = $('body'),
		$cont = $('#b12-content'),
		$fixbar = $('#b12-fixbar'),
		$slideMenu = $('#b12-slide-menu'),
		$swipeCont = $('#b12-swiper-container'),
		$tabber = $('#b12-tabber-warpper'),
		$multiSel = $('select[multiple]');

	
	fixSafariLabels();

	if ($cont.length > 0) {
		scrollFix($cont);
	}
	
	// functional
	if ($fixbar.length > 0) {
		var lastY = 0;

		$cont.bind('touchmove', function(event) {
			var curY = event.touches[0].pageY;

			if (curY > lastY) {
				$body.addClass('b12-functional');
			} else {
				$body.removeClass('b12-functional');
			}
			lastY = curY;
		});

		$body.bind('touchstart', function(event) {
			lastY = event.touches[0].pageY;
		});
	}

	// gallery
	if ($swipeCont.length > 0) {
		var	isGallery = $swipeCont.hasClass('b12-gallery'),
			GalleryNum = $('.b12-swiper-slide', $swipeCont).length;
		
		for (var i = GalleryNum - 1; i >= 0; i--) {
			if (i == GalleryNum - 1) {
				$('#b12-pagination').append('<span class="b12-active-switch"></span>');
			} else {
				$('#b12-pagination').append('<span></span>');
			}
		}

		window.b12Swiper = new Swipe($swipeCont[0], {
			speed: 400,
			auto: 7000,
			callback: function(index, elem) {
				if (isGallery) {
					$swipeCont.css('max-height', $(elem).height());
				}
			},
			transitionEnd: function(index, elem) {
				var index = parseInt(index) + 1;
				$('#b12-pagination > span').removeClass('b12-active-switch');
				$('#b12-pagination > span:nth-child('+ index +')').addClass('b12-active-switch');
			}
		});

		if (isGallery) {
			$swipeCont.css('max-height', $('.b12-swiper-slide:first-child', $swipeCont).height());
		}
	}

	// slide menu
	if ($slideMenu.length > 0) {
		slideMenuFx();
	}

	// tabber
	if ($tabber.length > 0) {
		$('#b12-tabber-nav > a').bind('click', function(event) {
			var index = $(this).index();
			$(this).addClass('b12-cur').siblings().removeClass('b12-cur');
			$('.b12-tabber', $tabber).eq(index).addClass('b12-show').siblings().removeClass('b12-show');
		});
	}

	if ($multiSel.length > 0) {
		$multiSel.mobiscroll().select({
			theme: 'android-holo light',
			lang: 'zh',
			display: 'bottom',
			mode: 'scroller',
			inputClass: 'b12-pure',
			defValue: '请选择',
			minWidth: 200
		});
	}

	// select
	$('.b12-select-list li').bind(eventType, function(event) {
		event.stopPropagation();
		$(this).addClass('b12-seled').siblings('li').removeClass('b12-seled');
	});

	// filter
	$('#b12-filterbar > div > a').click(function(event) {
		$(this).next('ol').addClass('b12-show');
		$body.addClass('b12-pause');
		event.stopPropagation();
	});

	$('#b12-overlay').click(function(event) {
		$('#b12-filterbar > div > ol').removeClass('b12-show');
		$body.removeClass('b12-pause');
		event.stopPropagation();
	});

	// toggle
	$('.b12-desc-block .b12-toggle').bind(eventType, function(event) {
		event.stopPropagation();
		var toggle = $(this),
			toggleCont = toggle.parent('.b12-desc-title').next('.b12-toggle-cont'),
			text = toggle.find('span');
		if (toggle.hasClass('up')) {
			toggleCont.removeClass('show');
			toggle.removeClass('up').addClass('down');
			text.html('展开');
		} else if (toggle.hasClass('down')) {
			toggleCont.addClass('show');
			toggle.removeClass('down').addClass('up');
			text.html('收起');
		}
	});

	$('#b12-fav').bind('click', function(event) {
		event.preventDefault();
		$(this).toggleClass('faved');
	});

	$('#b12-share').bind('click', function(event) {
		event.preventDefault();
		$('body').addClass('b12-pause');
	});

	$('#b12-float-close').bind('click', function(event) {
		event.preventDefault();
		b12closeAlert();
	});


});


/* events */

$(document).bind('touchmove', '.b12-nobounce', function(event) {
	event.preventDefault();
});


/* functions */

function mobilecheck() {
	var check = false;
	(function(a) {
		if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true
	})(navigator.userAgent || navigator.vendor || window.opera);
	return check;
}

function scrollFix(elem) {
	var startY = startTopScroll = deltaY = undefined,
		elem = elem[0] || elem.querySelector(elem);

	if (!elem)
		return;

	elem.addEventListener('touchstart', function(event) {
		startY = event.touches[0].pageY;
		startTopScroll = elem.scrollTop;

		if (startTopScroll <= 0)
			elem.scrollTop = 1;

		if (startTopScroll + elem.offsetHeight >= elem.scrollHeight)
			elem.scrollTop = elem.scrollHeight - elem.offsetHeight - 1;
	}, false);
}

function fixSafariLabels() {
	if (/iP(hone|od|ad)/i.test(navigator.userAgent)) {
		$('label').click(function(event) {
			$('input#'+ $(this).attr('for')).click();
			event.stopPropagation();
		});
		$('html').addClass('iOS');

		if (iOSver()[0] <= 5) {
			$('input[type="text"], textarea').on(eventType, function() {
				this.focus();
				this.setSelectionRange(0, 9999);
			});
		}
	}
}

function iOSver() {
	var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
	return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
}

function b12Alert(text,time,callback) {
	$('#b12-alert > div').html(text);
	$('body').addClass('b12-pause');
	if (time!==undefined && time!=='') {
		setTimeout(function(){
			b12closeAlert();
			if (callback!==undefined) {
				setTimeout(callback,300);
			}
		}, time*1000);
	};
}

function b12closeAlert() {
	$('body').removeClass('b12-pause');
}

function b12Timer(obj) {
	if (wait == 0) {
		$(obj).removeAttr('disabled').removeClass('gray');
		$(obj).val('重新发送');
		wait = 60;
	} else {
		$(obj).attr('disabled', 'true').addClass('gray');
		$(obj).val('重新发送('+ wait +')');
		wait--;
		setTimeout(function() {
			b12Timer(obj);
		}, 1000);
	}
}

function b12sendTimer(obj, url) {
	if (wait == 0) {
		$(obj).html('<a href="'+ url +'"><em class="b12-blue">重新发送校验码>></em></a>');
		wait = 60;
	} else {
		$(obj).children('em').text(wait);
		wait--;
		setTimeout(function() {
			b12sendTimer(obj, url);
		}, 1000);
	}
}

function hasParentClass(e, classname) {
	if (e === document) return false;
	if ($(e).hasClass(classname)) {
		return true;
	}
	return e.parentNode && hasParentClass(e.parentNode, classname);
}

function slideMenuFx() {
	var container = $('#b12-container'),
		resetMenu = function() {
			container.removeClass('b12-slide-menu-open');
		},
		bodyClickFx = function(event) {
			if (!hasParentClass(event.target, 'b12-slide-menu')) {
				resetMenu();
				document.removeEventListener(eventType, bodyClickFx);
			}
		};
	$('#b12-menu-toggle').on(eventType, function(event) {
		event.stopPropagation();
		event.preventDefault();
		setTimeout(function() {
			container.addClass('b12-slide-menu-open');
		}, 25);
		document.addEventListener(eventType, bodyClickFx);
	});
}