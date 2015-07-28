var mutual_friends;

(function( $ ) {

    mutual_friends = {

        init: function() {
            $('a.mutual-friends').magnificPopup({
                items: {
                    src: $('<div class="white-popup"></div>'),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {

                    },
                    beforeClose: function() {
                        $('div.white-popup').html( "" );
                    }
                    // e.t.c.
                },
                closeBtnInside:true
            });

            $('a.mutual-friends').on( 'click', mutual_friends.fetch_mutual_friend );
        },

        fetch_mutual_friend: function() {
            $element = $(this);

            var user_id = $element.data('user-id');
            var send_data = {
                action: 'mutual_friends_dialog',
                user_id: user_id
            }

            $.get( ajaxurl, send_data, function( response ) {
                $('div.white-popup').append( response );
            });
        }

    };

    $( document).ready( function() { mutual_friends.init() });
})(jQuery);