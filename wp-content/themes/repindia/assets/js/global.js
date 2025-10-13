var _functions = {};
(function ($) {
    "use strict";
    var swipers = [],
        winW, winH, headerH, winScr, footerTop, _isresponsive, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

    _functions.pageCalculations = function(){
        winW = jQuery(window).width();
        winH = jQuery(window).height();
    };
    $(window).scroll(function()
    {
        if ($(this).scrollTop() > 10){  
          $('.main_header').addClass("sticky_header ");
        }
        else{
        $('.main_header').removeClass('sticky_header');
        }
    });
    $('.side_menu #menu-main-menu li a,.side_menu #menu-main-menu li .caret').on('click', function() {
        $(this).closest('.caret').find('.caret').removeClass('DDopen');
        $(this).parent().find('> ul').addClass('DDopen');
        $(this).closest('ul').find('ul').removeClass('opened');
        $(this).parent().find('> ul').addClass('opened');
        $(this).closest('ul').find('ul').not('.opened').slideUp(350);
        $(this).parent().find('> ul').slideToggle(350);
        $(this).closest('ul').find('i').not(this).removeClass('DDopen');
    });
    $(".side_menu #menu-main-menu li.menu-item-has-children").addClass("dropdown");
    $(".side_menu #menu-main-menu li.menu-item-has-children ul").addClass("dropdown-submenu");
    $(".side_menu div#menu-main-menu > ul > li.page_item_has_children > ul ").addClass("sub-menu dropdown-submenu");
    $(".side_menu div#menu-main-menu > ul > li.page_item_has_children > ul > li.page_item_has_children > ul").addClass("sub-menu dropdown-submenu");
    $( ".side_menu #menu-main-menu" ).removeClass( "display_none" );
    $('.side_menu ul#menu-main-menu  li.menu-item > .caret').click(function()
    {
            $(this).parents('li').siblings('li').find('a').removeClass('clicked_back_color');
            $(this).prev('a').toggleClass('clicked_back_color');
    });
})(jQuery);
jQuery(document).ready(function($) 
{

    $('.humburgar').click(function(){
        $(this).toggleClass('open');
        $('.sidebar_nav_menu').toggleClass('openmenu');
    });
    $('.scrollermenu').click(function() {
        // Check if the popup is already open
        if ($('.humburgar').hasClass('open') && $('.sidebar_nav_menu').hasClass('openmenu')) {
            // Close the popup if it's open
            $('.humburgar').removeClass('open');
            $('.sidebar_nav_menu').removeClass('openmenu');
        }
    });

    // Tabbing
    $('.tab-link').click( function() {
        var tabID = $(this).attr('data-tab');
        $(this).addClass('active').siblings().removeClass('active');
        $('#tab-'+tabID).addClass('active').siblings().removeClass('active');
    });
  //  Header Search
    if ($('.search-popup__toggler').length) {
        $('.search-popup__toggler').on('click', function(e) {
            $('.search-popup').toggleClass('active');
            e.preventDefault();
        });
    }

    if ($('.search-popup__overlay').length) {
        $('.search-popup__overlay').on('click', function(e) {
            $('.search-popup').removeClass('active');
            e.preventDefault();
        });
    }
    //Form Validation
    $(document).on(
      "input propertychange",
      "textarea[name='message'],textarea[name='message']",
      function () {
        var c = this.selectionStart,
          r = /[^a-z0-9 . , - @ ! \n ]/gi,
          v = $(this).val();
        if (r.test(v)) {
          $(this).val(v.replace(r, ""));
          c--;
        }
        this.setSelectionRange(c, c);
      });
    $("input[id=yourname]").bind("input", function () {
      var c = this.selectionStart,
        r = /[^a-z ]/gi,
        v = $(this).val();
      if (r.test(v)) {
        $(this).val(v.replace(r, ""));
        c--;
      }
      this.setSelectionRange(c, c);
    });
    $("input[name='mobile'] input[name='experience'] ").bind("input", function () {
      var c = this.selectionStart,
        r = /[^0-9 ]/gi,
        v = $(this).val();
      if (r.test(v)) {
        $(this).val(v.replace(r, ""));
        c--;
      }
      this.setSelectionRange(c, c);
    }); 
});



