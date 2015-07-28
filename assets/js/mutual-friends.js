var mutual_friends;

(function( $ ) {

    mutual_friends = {

        init: function() {
            $('a.mutual-friends').magnificPopup({
                items: {
                    src: $('<div class="white-popup">Dynamically created popup</div>'),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {

                    },
                    close: function() {
                        // Will fire when popup is closed
                    }
                    // e.t.c.
                }
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
                $('div.white-popup').html( response );
            });
        }

    };

    $( document).ready( function() { mutual_friends.init() });
})(jQuery);