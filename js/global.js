

window.onload = function() {

	/**
	 * #menu__button event handler
	 * TODO: Refactor
	 */

	/* Women */
	$('#menu__button--women').addEventListener("mouseover", function(){
		$('#nav--women').style.display = 'block';
	});
	$('#nav--women').addEventListener("mouseover", function(){
		$('#nav--women').style.display = 'block';
	});
	$('#menu__button--women').addEventListener("mouseout", function(){
		$('#nav--women').style.display = 'none';
	});
	$('#nav--women').addEventListener("mouseout", function(){
		$('#nav--women').style.display = 'none';
	});

	/* Men */
	$('#menu__button--men').addEventListener("mouseover", function(){
		$('#nav--men').style.display = 'block';
	});
	$('#nav--men').addEventListener("mouseover", function(){
		$('#nav--men').style.display = 'block';
	});
	$('#menu__button--men').addEventListener("mouseout", function(){
		$('#nav--men').style.display = 'none';
	});
	$('#nav--men').addEventListener("mouseout", function(){
		$('#nav--men').style.display = 'none';
	});
}

function $(selector, context) {
	return (context || document).querySelector(selector);
}
