// Custom JavaScript for Tununue
$(document).ready(function() {
    // Initialize any custom functionality here
    
    // Handle search form submission
    $('#search_form, #search_form2').on('submit', function(e) {
        var searchTerm = $(this).find('input[type="text"]').val();
        if (!searchTerm.trim()) {
            e.preventDefault();
            alert('Please enter a search term');
        }
    });
    
    // Handle mobile menu toggle
    $('.mobile_menu').on('click', function() {
        $('.main_menu').toggleClass('active');
    });
    
    // Handle back to top button
    $('#back-top').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    // Show back to top button on scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
});
