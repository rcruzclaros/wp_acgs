jQuery(document).ready(function($) {
    /**/
    $('.sf-field-submit').on('click','input[type="submit"]', function(){
        var state = $('select[name="_sft_state[]"]').val();
        var town = $('select[name="_sft_town[]"]').val();
        var parish = $('select[name="_sft_parish[]"]').val();
        var event = $('select[name="_sft_event-product[]"]').val();
        if(state){
            $('.selected-catalog-filters .container .state').html('<label>'+state+'<a>&times;</a></label>');
        }
        if(town){
            $('.selected-catalog-filters .container .town').html('<label>'+town+'<a>&times;</a></label>');
        }
        if(parish){
            $('.selected-catalog-filters .container .parish').html('<label>'+parish+'<a>&times;</a></label>');
        }
        if(event){
            $('.selected-catalog-filters .container .event').html('<label>'+event+'<a>&times;</a></label>');
        }
    });
    $('.selected-catalog-filters .container .state').on('click','label a', function(e) {
        e.preventDefault();
        $('.selected-catalog-filters .state').html('');
        $('select[name="_sft_state[]"]').val('');
        $('.sf-field-submit input[type="submit"]').trigger('click');
    });
    $('.selected-catalog-filters .container .town').on('click','label a', function(e) {
        e.preventDefault();
        $('.selected-catalog-filters .town').html('');
        $('select[name="_sft_town[]"]').val('');
        $('.sf-field-submit input[type="submit"]').trigger('click');
    });
    $('.selected-catalog-filters .container .parish').on('click','label a', function(e) {
        e.preventDefault();
        $('.selected-catalog-filters .parish').html('');
        $('select[name="_sft_parish[]"]').val('');
        $('.sf-field-submit input[type="submit"]').trigger('click');
    });
    $('.selected-catalog-filters .container .event').on('click','label a', function(e) {
        e.preventDefault();
        $('.selected-catalog-filters .event').html('');
        $('select[name="_sft_event-product[]"]').val('');
        $('.sf-field-submit input[type="submit"]').trigger('click');
    });
    /**sticky menu */
    $('.menu-responsive-left').on('click', function(){
        $(this).toggleClass('active');
        $('#nav_menu-2 .nav-header').toggleClass('active');
    });
    $('.menu-responsive-right').on('click', function(){
        $(this).toggleClass('active');
        $('#nav_menu-3 .menu-top-menu-container').toggleClass('active');
    });
    $(window).on('load', function(){
        $('label[for="billing_address_1"]').html('Address&nbsp;<abbr class="required" title="required">*</abbr>');
        $('label[for="billing_phone"]').html('Home Phone&nbsp;<abbr class="required" title="required">*</abbr>');
        $('#billing_address_2_field').append('<label for="billing_address_2">Address Line 2</label>');
    });
    $(window).scroll(function() {
        if ($(window).scrollTop() > 57) {
            $('body').addClass('sticky-content');
            $('.site-header').addClass('sticky');
        } else {
            $('body').removeClass('sticky-content');
            $('.site-header').removeClass('sticky');
        }
    });

    $('.membership-options ul li').on('click', function(e){
        e.preventDefault();
        $('.membership-options ul li').removeClass('active');
        $(this).addClass('active');
        $('a.get-memberships').removeClass('disabled');
        var current_url = $('.unique_url').attr('url');
        var new_url = current_url + '&variation_id=' + $(this).attr('variation');        
        $('a.get-memberships').attr('href', new_url);
    });
    $('a.disabled').on('click', function(e){
        e.preventDefault();
    });
    $('a.get-memberships').on('click', function(e){
        if ($(this).hasClass('disabled')) {
            e.preventDefault();
        }else{
            window.location.replace($(this).attr('href'));
        }
    });
    /**/
    $('.current-tab').on('click', function(){
        $('.dropdown-tabs').toggle(200);
        $(this).toggleClass('clicked');
    });
    $('.dropdown-tabs a.active').on('click', function(e){
        e.preventDefault();
    });

    /**/
    $('.links-nav-registration a').on('click', function(e){
        e.preventDefault();
        $('.links-nav-registration a').removeClass('active');
        $(this).addClass('active');
        if ($(this).hasClass('login')){
            $('#customer_login .u-column1').show();
            $('#customer_login .u-column2').hide();
        }else{
            $('#customer_login .u-column1').hide();
            $('#customer_login .u-column2').show();
        }
    });
    $('a.become-member').on('click', function(e){
        e.preventDefault();
        $('.links-nav-registration a').removeClass('active');
        $('.links-nav-registration a.register').addClass('active');
        $('#customer_login .u-column1').hide();
        $('#customer_login .u-column2').show();
    });

    /*Sliders Home*/
    jQuery('.events-slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        cssEase: 'linear'
        // asNavFor: '.vertical-slider'
    });

    /*Product Slider*/
    jQuery('.product-slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        nextArrow: '<div class="left-arrow"></div>',
        prevArrow: '<div class="right-arrow"></div>',
        responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
        ]
    });

    /*About Accordion*/
    $('.collapsible').collapsible();

    /*Masonrty Library */
    $('.grid-acgs').masonry({
        itemSelector: '.grid-item',
        // columnWidth: 100,
        // isResizable: true,
        // percentPosition: true,
        gutter: 5
    });

    lc_lightbox('.gallery-acgs', {
        wrap_class: 'lcl_fade_oc',
        gallery: true,
        thumb_attr: 'data-lcl-thumb',
        skin: 'dark',
        fullscreen: true,
        socials: true,
    });

    /**
     * Binnacle detail modal show/close
     */
    $('a[id*="bi_detail_btn"]').click(function(e) {
        e.preventDefault();
        var target = $(this).attr('href');

        $(target).addClass('show');
    });

    $('.binnacle-modal').click(function(e) {
        if(!$(e.target).hasClass('m-dialog') && $(e.target).closest('.m-dialog').length == 0) {
            $(e.target).closest('.binnacle-modal').removeClass('show');
        }
    });

    /* 
     * Confirm binnacle remove modal
     */
    $('#modal_delete_binnacle').modal({
        startingTop: '20%'
    });

    $('a[data-binnacle-confirm-remove]').click(function(e) {
        e.preventDefault();
        var binid = $(this).attr('id'),
            text = $(this).attr('data-binnacle-confirm-remove');

        $('#modal_delete_binnacle [data-binnacle-remove]').attr('data-binnacle-remove', binid);
        $('#modal_delete_binnacle #confirm_delete_message').html('Confirm deletion of item ' + text);
    });

    /* 
     * Binnacle collapse
     */
     $('a[trigger-collapse]').click(function(e) {
        e.preventDefault();
        var target = $(this).attr('href');
            expanded = $(this).attr('aria-expanded');
        
        if(undefined == expanded || 'false' == expanded) {
            $(target).height( $(target+' .collapse-inner').outerHeight(true) );
            $(this).attr('aria-expanded', 'true');
        }
        else {
            $(target).height( 0 );
            $(this).attr('aria-expanded', 'false');
        }
     })
    
});