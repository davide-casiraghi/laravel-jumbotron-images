jQuery(document).ready(function () {

	// Check if is mobile
		var isMobile = {
	        Android: function() {
	        	//console.log(navigator.userAgent.match(/Android/i));
	            return navigator.userAgent.match(/Android/i);
	        },
	        BlackBerry: function() {
	        	//console.log(navigator.userAgent.match(/BlackBerry/i));
	            return navigator.userAgent.match(/BlackBerry/i);
	        },
	        iOS: function() {
	        	//console.log(navigator.userAgent.match(/iPhone|iPad|iPod/i));
	            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	        },
	        Opera: function() {
	        	//console.log(navigator.userAgent.match(/Opera Mini/i));
	            return navigator.userAgent.match(/Opera Mini/i);
	        },
	        Windows: function() {
	        	//console.log(navigator.userAgent.match(/IEMobile/i));
	            return navigator.userAgent.match(/IEMobile/i);
	        },
	        any: function() {
	        	//console.log(isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	        }
	    };

	// Parallax with stellar - http://markdalgleish.com/projects/stellar.js
		if( !isMobile.any() ){
	        jQuery(function(){
	                //console.log("is not mobile");
	                jQuery.stellar({
	                    horizontalScrolling: false,
	                    // Refreshes parallax content on window load and resize
	                    responsive: true,
	                    verticalOffset: 60	//original was 40 (with 40 i have a gray line above the big image while scrolling with scalable bar)
	                });
	    	});
		}
		else{
			jQuery(".jumbotronImage .hero.parallax").css("background-attachment", "scroll");
	        jQuery(".jumbotronImage .hero.parallax").css("background-size", "190% 100%");
		}
});
