
(function(window, document) {
	
	'use strict';
	
	var touchDown = false;
	var lock      = false;
	
	function addClass(el, className) {
		el.classList.add(className);
	}

	function removeClass(el, className) {
		el.classList.remove(className);
	}
	
	function handleTouch(cart) {
		if(!lock) {
			if(!touchDown) {
				addClass(cart, 'hover');
				touchDown = true;
				lock = true;
				setTimeout(function() {
					lock = false;
				}, 200);
			} else {
				removeClass(cart, 'hover');
				touchDown = false;
				lock = true;
				setTimeout(function() {
					lock = false;
				}, 200);
			}
		}
	}

	function addEventListeners() {
		var cart = document.querySelector('.cart-tab.right');
		var cartButton = document.querySelector('.cart-tab.right a.cart-parent');
		cartButton.addEventListener('mouseover', function(e) {
			handleTouch(cart);
		}, false);
		/*cartButton.addEventListener('touchstart', function(e) {
			handleTouch(cart);
		}, false);*/
	}


	document.addEventListener("DOMContentLoaded", function(event) {
		addEventListeners();
	});
	
})(window, document);