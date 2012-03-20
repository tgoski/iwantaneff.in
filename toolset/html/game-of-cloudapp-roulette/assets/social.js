(function ($) {

    function generateQuery (obj) {
        var queryArray = [];
        for (var key in obj)
            queryArray.push( encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]) );
        return '?' + queryArray.join('&');
    }

    $.fn.extend({
        addSocial: function (options) {
            var defaults = {
            };

            var options = $.extend(defaults, options);

            var twsrc = 'http://platform.twitter.com/widgets/tweet_button.html' + generateQuery({
                count  : 'vertical',
                url    : window.location.href,
                text   : document.title
            });

            var fbsrc = 'http://www.facebook.com/plugins/like.php' + generateQuery({
                href   : window.location.href,
                layout : 'box_count',
                width  : 450,
                height : 80,
                action : 'like',
                font   : 'verdana',
                show_faces  : true,
                colorscheme : 'light'
            });

            var tw = $("<iframe>").attr({
                allowTransparency : true,
                frameborder : 0,
                scrolling   : 'no',
                src         : twsrc
            }).css({
                border   : 'none',
                overflow : 'hidden',
                width    : '65px',
                height   : '65px',
                marginLeft : '10px'
            });

            var fb = $('<iframe>').attr({
                allowTransparency : true,
                frameborder : 0,
                scrolling   : 'no',
                src         : fbsrc,
            }).css({
                border   : 'none',
                overflow : 'hidden',
                width    : '80px',
                height   : '65px',
                marginLeft : '10px'
            });
            
            var gp = $('<div class="g-plusone" data-size="tall" data-count="true"></div>').css({
                border   : 'none',
                overflow : 'hidden',
                width    : '50px',
                height   : '60px',
                
            });

            this.append(
            $("<div>").html(gp).css({float: 'left'}),
                $("<div>").html(tw).css({float: 'left'}),
                $("<div>").html(fb).css({float: 'left'}),
                
                $("<div>").css({clear: 'both'})
            );

            return this;
        },
    });
})(jQuery);

