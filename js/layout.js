const sidebar = $('#sidebar');
const main = $('.main-element');
const sidebarToggle = $('#sidebarToggle');

sidebarToggle.on('click', function() {
    const isActive = sidebar.hasClass('active');

    if (isActive) {
        main.css('margin-left', '0');
    } else {
        main.css('margin-left', '250px');
    }

    sidebar.toggleClass('active');
});


$(window).on('resize', function() {
    if ($(window).width() < 992) {
        sidebar.removeClass('active');
        main.css('margin-left', '0');
    } else {
        sidebar.addClass('active');
        main.css('margin-left', '250px');
    }
}).trigger('resize'); 
