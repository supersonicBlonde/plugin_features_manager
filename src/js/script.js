import 'code-prettify';

window.addEventListener("load", function() {

	PR.prettyPrint();

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	for (var i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}

	function switchTab(event) {
		event.preventDefault();

		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");

		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");

		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");

	}

});

jQuery(document).ready(function($) {

	$('.js-image-upload').click(function(e) {
	
		e.preventDefault();
		console.log("click");
		var $button = $(this);
		var file_frame = wp.media.frames.file_frame = wp.media({

			title: 'Select or upload an Image',
			library: {
				type: 'image'
			},
			button: {
				text: 'Select Image'
			},
			multiple: false 

		});

		file_frame.on('select' , function() {
			var attachment = file_frame.state().get('selection').first().toJSON();
			$button.siblings('.image-upload').val(attachment.url);
		});

		file_frame.open();
	
	})

});