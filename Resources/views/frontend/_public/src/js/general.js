$(document).ready(function() {
    
    $.fn.isInViewport = function(center) {
        var elementHeight = $(this).outerHeight();
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + elementHeight;
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();
        var viewportCenter = (viewportTop + viewportBottom) / 2;

        if (center) {
            return elementTop < viewportCenter && elementBottom > viewportCenter;
        } else {
            return elementBottom - elementHeight / 2 < viewportBottom && elementTop + elementHeight / 2 > viewportTop;
        }
    };

	// Initial
	highlighting();

    $(window).on('resize scroll', function() {
    	highlighting();
    });

    function highlighting() {
        // Jedes span mit Highlight-Einstellung OHNE Intervall
        $('.listing .nnweb_article_highlighting:not(.repeating-interval)').each(function() {

            // Soll sich der Effekt wiederholen?
            if ($(this).hasClass('repeating-event')) {
            	// Highlight einschalten, falls in Viewport
                $toggle = $(this).next().isInViewport($(this).hasClass('event-centered'));
            } else {
            	// Highlight einschalten und nie wieder wegnehmen
                $toggle = $(this).next().isInViewport($(this).hasClass('event-centered')) || $(this).hasClass('highlight');
            }
            
            // Effekt wird nur ausgeführt, wenn highlight hinzukommt
            $(this).toggleClass('highlight',$toggle);
        });
        
        // Jedes span mit Highlight-Einstellung MIT Intervall
        $('.listing .nnweb_article_highlighting.repeating-interval:not(:hover)').each(function() {
        	var interval = $(this).data('interval');
        	
        	// Wenn Interval gesetzt und Element in Viewport
        	if (interval > 0 && $(this).next().isInViewport($(this).hasClass('event-centered'))) {
        		var that = $(this);
        		
        		// Effekt das erste Mal zeigen
				that.addClass('highlight');
        		
        		setInterval(function() {
        			
        			that.removeClass('highlight');
        			
        			setTimeout(function() {
        				if (!that.next().is(':hover')) {
        					that.addClass('highlight');
        				}
        			}, 100);
        		},interval);
        		
        		// Interval nie mehrfach starten
            	$(this).data('interval',0);
        	}
        });
        
        // Kein Effekt on Hover
        $('body').on('hover', '.listing .nnweb_article_highlighting.repeating-interval', function() {
        	$(this).removeClass('highlight');
        });
    }
});