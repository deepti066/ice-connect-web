$(document).ready(function(){

     $('.fa-bars').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });
    




    // $(window).on('load scroll', function () {
    //     $('.fa-bars').removeClass('fa-times');
    //     $('.navbar').removeClass('nav-toggle');
    
    //     if ($(window).scrollTop() > 35) {
    //         $('.header').css({
    //             'background': 'rgba(173, 216, 230, 0.3)', // Light water-like transparency
    //             'box-shadow': '0 .2rem .5rem rgba(0,0,0,.2)',
    //             'backdrop-filter': 'blur(10px)' // Adds a glassy water effect
    //         });
    //     } else {
    //         $('.header').css({
    //             'background': 'transparent',
    //             'box-shadow': 'none',
    //             'backdrop-filter': 'none'
    //         });
    //     }
    // });
    
    
    
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 35) {
            {
                $('.header').css({
                    'background': 'linear-gradient(to right, #d3d3d3, #808080)',
                    'box-shadow': '0 .2rem .5rem rgba(0,0,0,.4)'
                });
                
            }
        } else {
            $('.header').css({
                'background': 'linear-gradient(to right, #d3d3d3, #808080)',
                'box-shadow': '0 .2rem .5rem rgba(0,0,0,.4)'
            });
            
        }
    });
    
let currentIndex = 0;
const slides = document.querySelectorAll(".slide");
const totalSlides = slides.length;

function updateSlide() {
    document.querySelector(".slider").style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Next Slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide();
}

// Previous Slide
function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlide();
}

setInterval(nextSlide, 3000);


    const counters = document.querySelectorAll('.counter');
    const speed = 120;
    counters.forEach(counter => {
	const updateCount = () => {
		const target = +counter.getAttribute('data-target');
		const count = +counter.innerText;
		const inc = target / speed;
		if (count < target) {
			counter.innerText = count + inc;
			setTimeout(updateCount, 1);
		} else {
			counter.innerText = target;
		}
	};
	  updateCount();
   });

   (function ($) {
    "use strict";


    $(document).ready(function() {
        $("#readMoreBtn").click(function() {
            $("#hiddenContent").slideToggle("slow"); // Toggle the content
            $("html, body").animate({
                scrollTop: $("#hiddenContent").is(":visible") ? $("#hiddenContent").offset().top : $("#about").offset().top
            }, 800);
    
            // Change button text
            let btnText = $(this).text() === "Read More" ? "Read Less" : "Read More";
            $(this).text(btnText);
        });
    });
    
    
    $(".clients-carousel").owlCarousel({
        autoplay: true,
        dots: true,
        margin: 10,
        loop: true,
        responsive: { 0: {items: 2}, 768: {items: 4}, 900: {items: 6} }
    });

    $(".testimonials-carousel").owlCarousel({
        autoplay: true,
        dots: true,
        margin: 10,
        loop: true,
        responsive: { 0: {items: 1}, 576: {items: 2}, 768: {items: 3}, 992: {items: 4} }
    });
    
})(jQuery);

$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
});
$('.back-to-top').click(function () {
    $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
    return false;
});

$('.accordion-header').click(function(){
    $('.accordion .accordion-body').slideUp(500);
    $(this).next('.accordion-body').slideDown(500);
    $('.accordion .accordion-header span').text('+');
    $(this).children('span').text('-');
});

});