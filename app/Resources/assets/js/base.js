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

        $('.rbins-cards-actions-open').on(
            'click',
            function (){
                $(this).toggle().next('.rbins-cards-actions-close').toggle();
            }
        );
        $('.rbins-cards-actions-close').on(
            'click',
            function (){
                $(this).toggle().prev('.rbins-cards-actions-open').toggle();
            }
        );

        $('[data-toggle="tooltip"]').tooltip()

    }
);
