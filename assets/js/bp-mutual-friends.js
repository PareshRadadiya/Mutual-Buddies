var mutual_friends;

(function( $ ) {

    mutual_friends = {

        init: function() {

            $('a.mutual-friends').magnificPopup({
                items: {
                    src: $('<div id="buddypress" class="bmf-white-popup"></div>'),
                    type: 'inline'
                },
                showCloseBtn: true,
                closeBtnInside:true
            });

            $('a.mutual-friends').live( 'click', mutual_friends.fetch_mutual_friend );

            $('div.bmf-white-popup').perfectScrollbar();
        },

        fetch_mutual_friend: function( e ) {

            e.preventDefault();

            $('div.bmf-white-popup').html('<div class="bmf-spinner"></div>');

            $element = $(this);

            var user_id = $element.data('user-id');
            var send_data = {
                action: 'mutual_friends_dialog',
                user_id: user_id
            };

            $.get( ajaxurl, send_data, function( response ) {

                $('div.bmf-white-popup').find("div.bmf-spinner").remove();
                $('div.bmf-white-popup').append( '<button title="Close (Esc)" type="button" class="mfp-close">×</button>'+response );
            });
        }

    };

    $( document).ready( function() { mutual_friends.init() });
})(jQuery);