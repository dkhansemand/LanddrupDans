'use strict';

$(document).ready( () => {
    'use strict';
    $('.modal').modal();
    $(".button-collapse").sideNav();
    $('.btnLoginForm').on('click', () => {
        $('#LoginModal').modal('open');
    });

    /*$('.carousel.carousel-slider').carousel({fullWidth: true, indicators: true});
    setInterval(() => {
        $('.carousel.carousel-slider').carousel('next');

    }, 10 * 1000);*/
    
    $('.carousel.carousel-slider.initialized').attr('style', '');

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 100,
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd', 
        min: new Date(1940,1,1),
        max: new Date(2017,31,12)
    });

    //var date = new Date($('#birthdate').val()).toDateString();
    //console.log(new Date($('#birthdate').val()).toDateString());
    var picker = $('.datepicker').pickadate('picker');
    //picker.set('select', date);
});