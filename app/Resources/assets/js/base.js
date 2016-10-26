if (typeof jQuery === 'undefined') {
    throw new Error('JavaScript requires jQuery')
}

$(document).ready(
    function() {
        $('.rbins-related-content').on(
            'click',
            '.flash-error .close,.flash-warning .close,.flash-success .close',
            function () {
                $(this).parent('.alert-dismissible').fadeOut();
            }
        );
    }
);
