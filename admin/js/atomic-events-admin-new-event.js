(function ($) {
	"use strict";

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
})(jQuery);

function atmvnts_showAdditionalFields(country) {
	var states = document.getElementById("additional_fields_state");
	var regions = document.getElementById("additional_fields_region");
	if (country === "US") {
		states.style.display = "block";
		regions.style.display = "none";
		// regions.value = ''; // Clear region input value if shown
	} else {
		states.style.display = "none";
		regions.style.display = "block";
		// states.value = ''; // Clear state select value if shown
	}
}

// on window load event
window.addEventListener("load", function () {
	var states = document.getElementById("additional_fields_state");
	var regions = document.getElementById("additional_fields_region");
	var country_select = document.getElementById("event_country");
	var country = country_select.value;

	if (country === "US") {
		states.style.display = "block";
		regions.style.display = "none";
		// regions.value = ''; // Clear region input value if shown
	} else {
		states.style.display = "none";
		regions.style.display = "block";
		// states.value = ''; // Clear state select value if shown
	}
});
