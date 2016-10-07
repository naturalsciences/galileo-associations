$(document).ready(
    function() {
        // ===== Scroll to Top ====
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 80) {        // If page is scrolled more than 50px
                $('#return-to-top').stop().fadeIn(200);    // Fade in the arrow
            } else {
                $('#return-to-top').stop().fadeOut(200);   // Else fade out the arrow
            }
        });

        $('#return-to-top').click(function () {      // When arrow is clicked
            $('body,html').animate({
                scrollTop: 0                       // Scroll to top of body
            }, 500);
        });

        $('.rbins-content-collapse, .rbins-search-collapse').on(
            'click',
            function(event) {
                var target = $(this).data('target');
                var parent = $(this).data('collapse-parent');

                if ( $(target).hasClass('in') ) {
                    if ( $(parent).find('.rbins-tab-content.in, .rbins-search-content.in').length <= 1 ) {
                        event.stopPropagation();
                        return true;
                    }
                    else {
                        $(parent).find('.rbins-tab-content.in, .rbins-search-content.in').not(target).removeClass('in');
                    }
                }
                else {
                    $(parent).find('.rbins-tab-content.in, .rbins-search-content.in').not(target).removeClass('in');
                }

                if ( $(parent).find('ul.rbins-lateral-tabs').length > 0 && $(this).data('tab-id').length > 0) {
                    $(parent).find('ul.rbins-lateral-tabs').find('li, li a').removeClass('active');
                    $(parent).find('ul.rbins-lateral-tabs').find($(this).data('tab-id'), $(this).data('tab-id')+' a').addClass('active');
                }

                return true;

            }
        );

        $('.rbins-lateral-tabs li').on(
            'click',
            function(event) {
                if ( !$(this).hasClass('active') ) {
                    event.preventDefault();
                    var target = $(this).data('target');
                    $(target).addClass('in').fadeIn();
                    $('.rbins-tab-content').not(target).removeClass('in');
                    $('.rbins-lateral-tabs li, .rbins-lateral-tabs li a').removeClass('active');
                    $(this).addClass('active');
                }

                return true;

            }
        );

    }
);
