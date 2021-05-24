$ = jQuery;

import ScrollMagic from 'scrollmagic';

export default function initNav() {

  $('.toggle-nav').on('click', () => {

    $('body').toggleClass('menu-active');

    $('.main-nav').attr('aria-expanded', 'true' != $('.main-nav').attr('aria-expanded'));
    $('.main-nav').slideToggle(200);

  });

  $('.site-header-top > li > a').on('click', function () {

    console.log("click");

    $(this).addClass("clicked");

    $(this).parent().toggleClass('expanded');

    $(this).parent().attr('aria-expanded', 'true' != $(this).parent().attr('aria-expanded'));

  });

  /*
  $(window).on('scroll',() => {
    $('.site-header').addClass('scrolled');

    if($(window).scrollTop() > 100){
      $('.site-header').addClass('scrolled');
    }
    else{
      $('.site-header').removeClass('scrolled');
    }
  })*/

  const controller = new ScrollMagic.Controller();

  const toggleHeader = new ScrollMagic.Scene({
    duration: 0,
    offset: 10,
    triggerHook: 0,
    reverse: true
  }).setClassToggle('.site-header','scrolled').addTo(controller);





}
