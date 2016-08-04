  jQuery(window).on('scroll', function (){
    "use strict";
    /*----------------------------- Navigation --------------------------*/
    if (jQuery(window).scrollTop() > 100){
      jQuery('#main-menu').addClass('menu-bg-overlay');
    } else {
      jQuery('#main-menu').removeClass('menu-bg-overlay');
    }
    if (jQuery(window).scrollTop() > 800){
      jQuery('#main-menu').addClass('menu-bg');
    } else {
      jQuery('#main-menu').removeClass('menu-bg');
    }


  });


var findID = jQuery('.menu-style2');
if ( findID.length){

var firstMenuHeight = 400;
var secondMenuHeight = 560;  

jQuery(window).bind('scroll', function () {
    if (jQuery(window).scrollTop() > firstMenuHeight) {
        jQuery('.main-menu-container').addClass('fixed-on-top');
    } else {
        jQuery('.main-menu-container').removeClass('fixed-on-top');
    }

    if (jQuery(window).scrollTop() > secondMenuHeight) {
        jQuery('.main-menu-container').addClass('fix-menu');
    } else {
        jQuery('.main-menu-container').removeClass('fix-menu');
    }

});

}

  /*----------------- image popup -----------------*/
  jQuery(".boxer").boxer();


  /*------------------------- Causes Post Slider ----------------------------*/
  var causestSlider = jQuery("#causes-post-slider");

  causestSlider.owlCarousel({
    loop:true,
    // rtl:true,
    margin:10,
    nav:true,
    navContainer: '#causes-owl-nav',
    navText: ['<i class="fa fa-chevron-left"></i> ', '<i class="fa fa-chevron-right"></i>'],
    navClass: ['slide-nav slide-left', 'slide-nav slide-right'],
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        nav:true
      },
      600:{
        items:2,
        nav:true
      },
      1000:{
        items:2,
        nav:true,
        loop:false
      }
    }
      });

 


    /*------------------------- Upcoming Event Slider ----------------------------*/
    var eventSlider = jQuery("#event-post-slider");

    eventSlider.owlCarousel({
      loop:true,
      // rtl:true,
      margin:10,
      nav:true,
      navContainer: '#event-owl-nav',
      navText: ['<i class="fa fa-chevron-left"></i> ', '<i class="fa fa-chevron-right"></i>'],
      navClass: ['slide-nav slide-left', 'slide-nav slide-right'],
      responsiveClass:true,
      responsive:{
        0:{
          items:1,
          nav:true
        },
        600:{
          items:2,
          nav:true
        },
        1000:{
          items:2,
          nav:true,
          loop:false
        }
      }
    });
 

    /*-------------------------------- Parallax ---------------------------------------*/
    jQuery(document).ready(function(){
       "use strict";

      jQuery('#top-section, #donate[data-type="background"], #clients[data-type="background"], .next-event[data-type="background"] ').each(function(){
        var $bgobj = jQuery(this); // assigning the object

        jQuery(window).scroll(function() {
          var $window = jQuery(window);
          var yPos = -($window.scrollTop() / $bgobj.data('speed')); 

            // Put together our final background position
            var coords = '50% '+ yPos + 'px';

            // Move the background
            $bgobj.css({ backgroundPosition: coords });
          }); 
      });    
    });


    jQuery(window).load(function($) {
    "use strict";

      /*------------------------------- Preloader -----------------------------------------*/
      jQuery(".loader").fadeOut();
      jQuery("#preloader").delay(350).fadeOut("slow");

    });


  jQuery(document).ready(function($) {
    "use strict";

    /*--------------------- Gallery Item Filter-----------------*/
    var $container = jQuery('.isotope-gallery-items'),
    colWidth = function () {
      var w = $container.width(), 
      columnNum = 1,
      columnWidth = 0;
      if (w > 960) {
        columnNum  = 4;
      }  else if (w > 768) {
        columnNum  = 3;
      }
      else if (w > 480) {
        columnNum  = 2;
      }
      columnWidth = Math.floor(w/columnNum);
      $container.find('.item').each(function() {
        var $item = $(this),
        multiplier_w = $item.attr('class').match(/item-w(\d)/),
        multiplier_h = $item.attr('class').match(/item-h(\d)/),
        width = multiplier_w ? columnWidth*multiplier_w[1]-10 : columnWidth-10,
        height = multiplier_h ? columnWidth*multiplier_h[1]*0.7-10 : columnWidth*0.7-10;
        $item.css({
          width: width,
          height: height
        });
      });
      return columnWidth;
    },
    isotope = function () {
      $container.isotope({
        resizable: true,
        itemSelector: '.item',
        masonry: {
          columnWidth: colWidth(),
          gutterWidth: 10
        }
      });
    };
    isotope();
    $(window).smartresize(isotope);

    $('.galleryFilter a').click(function(){
      $('.galleryFilter .current').removeClass('current');
      $(this).addClass('current');

      var selector = $(this).attr('data-filter');
      $container.isotope({
        filter: selector,
        animationOptions: {
          duration: 750,
          easing: 'linear',
          queue: false
        }
      });
      return false;
    }); 



    /*------------------------------- Element Appear Effect -----------------------------------------*/
    jQuery('.from-top.delay-normal').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(150).animate({opacity:1,top:"0px"},600);
      }); 
    });

    jQuery('.from-bottom.delay-normal').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(150).animate({opacity:1,bottom:"0px"},600);
      }); 
    });


    jQuery('.from-bottom.delay-200').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(200).animate({opacity:1,bottom:"0px"},600);
      }); 
    });

    jQuery('.from-bottom.delay-600').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(600).animate({opacity:1,bottom:"0px"},600);
      }); 
    });

    jQuery('.from-bottom.delay-1000').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(1000).animate({opacity:1,bottom:"0px"},600);
      }); 
    });

    jQuery('.from-bottom.delay-1400').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(1400).animate({opacity:1,bottom:"0px"},600);
      }); 
    });

    jQuery('.from-left.delay-normal').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(150).animate({opacity:1,left:"0px"},600);
      }); 
    });


    jQuery('.from-right.delay-normal').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(150).animate({opacity:1,right:"0px"},600);
      }); 
    });

    jQuery('.from-right.delay-200').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(200).animate({opacity:1,right:"0px"},600);
      }); 
    });

    jQuery('.from-right.delay-600').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(600).animate({opacity:1,right:"0px"},600);
      }); 
    });

    jQuery('.from-right.delay-1000').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(1000).animate({opacity:1,right:"0px"},600);
      }); 
    });

    jQuery('.from-right.delay-1400').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(1400).animate({opacity:1,right:"0px"},600);
      }); 
    });

    jQuery('.fade-in.delay-normal').each(function () {
        "use strict";
      jQuery(this).appear(function() {
        jQuery(this).delay(150).animate({opacity:1,right:"0px"},600);
      }); 
    });


    /*-------------------------------  Scroll to Top ----------------------------*/
    jQuery(window).scroll(function() {
        "use strict";
      if ($(this).scrollTop() > 200) {
       $('#scroll-to-top').fadeIn('slow');
     } else {
      $('#scroll-to-top').fadeOut('slow');
    }
  }); 

    jQuery('#scroll-to-top').click(function(){
        "use strict";
      jQuery("html,body").animate({ scrollTop: 0 }, 1000);
      return false;
    });

    jQuery('.donate').click(function(){
        "use strict";
      jQuery('html,body').animate({
        scrollTop: $("#donate").offset().top},
        'slow');
    });


  });


/*-----------------------------------------------------------------------------------*/
/*   troggle hide and show donate button 
/*-----------------------------------------------------------------------------------*/ 

jQuery('.single-causes-post .btn-toggle').click(function(){
  jQuery("#accordion").toggle();
});


/*------------------------------Contact Form 7 Submit Btn  ----------------------*/
jQuery('.wpcf7-form .submit').parent().addClass('submit-btn-container btn custom-btn angle-effect');



/*------------------------------Menu overlay  ----------------------*/

jQuery(document).ready(function ($) {
   "use strict";

    $('[data-popup-target]').click(function () {
        $('html').addClass('overlay');
        var activePopup = $(this).attr('data-popup-target');
        $(activePopup).addClass('visible');
 
    });
 
    $(document).keyup(function (e) {
        if (e.keyCode == 27 && $('html').hasClass('overlay')) {
            clearPopup();
        }
    });
 
    $('.popup-exit').click(function () {
        clearPopup();
 
    });
 
    $('.popup-overlay').click(function () {
        clearPopup();
    });
 
    function clearPopup() {
        $('.popup.visible').addClass('transitioning').removeClass('visible');
        $('html').removeClass('overlay');
 
        setTimeout(function () {
            $('.popup').removeClass('transitioning');
        }, 200);
    }
 
});


/*-----------------------------------------------------------------------------------*/
/*  menu scrooling 
/*-----------------------------------------------------------------------------------*/ 

jQuery(function(cash) {
  "use strict";
  jQuery('#headernavigation li a[href^="#"], .boxed-menus .menu-item a[href^="#"]').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top -70
        }, 1000);
        return false;
      }
    }
  });
});

/**  hide nav menu when click menu link.
--------------------------------------------------------------------------------------------------- */

jQuery(document).ready(function ($) {
 "use strict";
  jQuery("#main-menu li a").click(function(event) {
        // check if window is small enough so dropdown is created
        jQuery("#nav-collapse").removeClass("in").addClass("collapse");
      });

});
