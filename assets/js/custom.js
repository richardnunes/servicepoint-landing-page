(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=482004168577294";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-48384793-1', 'servicepoint.pt');
ga('send', 'pageview');

$('ul.nav a, #down_button a').click(function(e) {
    $('html,body').scrollTo(this.hash, this.hash);
    e.preventDefault();
});

function onScrollInit( items, trigger ) {
    items.each( function() {
        var osElement = $(this),
            osAnimationClass = osElement.attr('data-os-animation'),
            osAnimationDelay = osElement.attr('data-os-animation-delay');

        osElement.css({
            '-webkit-animation-delay':  osAnimationDelay,
            '-moz-animation-delay':     osAnimationDelay,
            'animation-delay':          osAnimationDelay
        });

        var osTrigger = ( trigger ) ? trigger : osElement;

        osTrigger.waypoint(function() {
            osElement.addClass('animated').addClass(osAnimationClass);
        },{
            triggerOnce: true,
            offset: '90%'
        });
    });
}

onScrollInit( $('.os-animation') );
onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );

$(document).ready (function () {
    $(window).scroll (function () {
        var sT = $(this).scrollTop();
        if (sT >= 30) {
            $('#navbar').addClass('navbar-length');
            $('#navbar-ex1-collapse').addClass('navbar-custom-collapse');
        }else {
            $('#navbar-ex1-collapse').removeClass('navbar-custom-collapse');
            $('#navbar').removeClass('navbar-length');
        }
    })
});

$("form").submit(function () {
    return false;
});

$(document).on('click','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
        $(this).collapse('hide');
    }
});

function form_submit(form) {
    var data = $(form).serialize();
    var user_value = $('#name').val();
    var mail_value = $('#email').val();

    function isValidEmailAddress(mail_value) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(mail_value);
    };

    if(isValidEmailAddress(mail_value) && user_value.length >= 3) {
        $("#contactform").innerHTML = "<i class='fa fa-spinner fa-spin fa-3x text-center'></i>";
        $.ajax({
            type: "POST",
            url: "contact-form-handler.php",
            data: data,
            success: function (d, x, y) {
                if (d == "success") {
                    setTimeout(function () {
                        setTimeout(function () {
                            window.location = "#contacto";
                        }, 750);
                        $("<div class='thank-you'>Obrigado pelo seu interesse!<br> Em breve será contactado pela nossa equipa. :)</div>").hide().appendTo(".form-submission").fadeIn(1000);
                        document.getElementById("contactform").innerHTML = "";
                    }, 600);
                } else {
                    setTimeout(function () {
                        setTimeout(function () {
                            window.location = "#contacto";
                        }, 750);
                        document.getElementById("contactform").innerHTML = "";
                        $("<div class='thank-you'>" + d + "</div>").hide().appendTo(".form-submission").fadeIn(1000);
                    }, 600);
                }
            }
        });
    }


}

function register(form) {
    var email = document.getElementById('first_mail').value;
    if (!email) return;
    document.getElementById('email').value = email;
    $('html, body').animate({
        scrollTop: $("#contacto").offset().top
    }, 2000);
}


$(document).ready(function(){
    $('.cases').slick({
        arrows: true,
        dots: true,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 20000
    });
});

