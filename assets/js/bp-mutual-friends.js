var mutual_friends;

(function( $ ) {

    mutual_friends = {

        init: function() {
            $('a.mutual-friends').magnificPopup({
                items: {
                    src: $('<div class="bmf-white-popup"><div class="bmf-spinner"></div></div>'),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {

                    },
                    beforeClose: function() {
                        $('div.bmf-white-popup').html( "<div class='bmf-spinner'></div>" );
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
            };



            $.get( ajaxurl, send_data, function( response ) {
                $('div.bmf-white-popup').find("div.bmf-spinner").remove();
                $('div.bmf-white-popup').append( response );
            });
        }

    };

    $( document).ready( function() { mutual_friends.init() });
})(jQuery);