$(window).scroll(function () {
    if ($(this).scrollTop() > 160) {
        $(".siteHeader").addClass("has-fixed");
    } else {
        $(".siteHeader").removeClass("has-fixed");
    }
});

$(document).ready(function () {
    sideBarToogled();

    $("#owl-banner").owlCarousel({

        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        items: 1,
        nav: true,
        autoHeight: true

        // "singleItem:true" is a shortcut for:
        // items : 1, 
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false

    });

    $("#beach-carousel").owlCarousel({
        items: 4, //10 items above 1000px browser width
        margin: 20,
        dots: false,
        nav: true,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            640: {
                items: 3
            },
            990: {
                items: 4
            }
        }

    });

    $("#cabin-carousel").owlCarousel({
        items: 4, //10 items above 1000px browser width
        margin: 20,
        dots: false,
        nav: true,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            640: {
                items: 3
            },
            990: {
                items: 4
            }
        }

    });
    $("#resort-carousel").owlCarousel({
        items: 4, //10 items above 1000px browser width
        margin: 20,
        dots: false,
        nav: true,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            640: {
                items: 3
            },
            990: {
                items: 4
            }
        }

    });

    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
});

$(window).resize(function () {
    sideBarToogled();
});

$(function () {

    var $tabs = $('#tabs').tabs();

    // $(".ui-tabs-panel").each(function(i){

    //   var totalSize = $(".ui-tabs-panel").length - 1;

    //   if (i != totalSize) {
    //       next = i + 2;
    //          $(this).append("<a href='#' class='next-tab mover'  rel='" + next + "'>Next</a>");
    //   }

    //   if (i != 0) {
    //       prev = i;
    //          $(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>Prev</a>");
    //   }

    //   if (i == totalSize) {
    //         $(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Publish</a>");
    // }

    // });

    $('.next-tab, .prev-tab').click(function () {
        $tabs.tabs('select', $(this).attr("rel"));
        return false;
    });
});
$(function () {

    var $tabs = $('#tabs-prop').tabs();

});

$(function () {
    var $tabspricing = $('#tabs-pricing').tabs();
});

(function (document, window, index) {
    var inputs = document.querySelectorAll('.inputfile');
    Array.prototype.forEach.call(inputs, function (input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener('change', function (e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                label.querySelector('span').innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener('focus', function () { input.classList.add('has-focus'); });
        input.addEventListener('blur', function () { input.classList.remove('has-focus'); });
    });
}(document, window, 0));

$(function () {

    $('#id9').change(function () {
        $('#id11').show();
    });

    $('#id10').change(function () {
        $('#id11').hide();
    });

});

// $(function () {

//     $('#test1').change(function () {
//         $('#payment2').hide();
//         $('#payment3').hide();
//         $('#fragment-7').hide();
//         $('#fragment-8').hide();
//     });

//     $('#test2').change(function () {
//         $('#payment2').show();
//         $('#payment3').show();
//         $('#fragment-7').show();
//         $('#fragment-8').show();
//     });

// });


var sideBarToogled = function () {
    if ($(window).width() < 991) {
        $('.sidebar').addClass('toggled');
        // $('#sidebarToggle, #sidebarToggleTop').on("click", function() {
        //     $('body').toggleClass('sidebar-toggled');
        // });
    }
    else {
        $('.sidebar').removeClass('toggled');
    }
};