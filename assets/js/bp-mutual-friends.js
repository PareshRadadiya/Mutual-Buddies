var mutual_friends;
(function( $ ) {

    mutual_friends = {

        init: function() {
            mutual_friends.init_maginific_popup();
            $('body').on( 'click', 'a.mutual-friends', mutual_friends.fetch_mutual_friend );

            $( document ).ajaxComplete( mutual_friends.rebind_magnific_popup );
        },

        fetch_mutual_friend: function( e ) {

            $element = $(this);

            e.preventDefault();

            $('div.bmf-white-popup').html('<div class="bmf-spinner"></div>');

            var user_id = $element.data('user-id');
            var send_data = {
                action: 'mutual_friends_dialog',
                user_id: user_id
            };

            $.post( ajaxurl, send_data, function( response ) {

                $('div.bmf-white-popup').find("div.bmf-spinner").remove();
                $('div.bmf-white-popup').append( '<button title="Close (Esc)" type="button" class="mfp-close">×</button>'+response );
                $('div.bmf-white-popup').perfectScrollbar();
            });
        },

        init_maginific_popup: function () {

            $('a.mutual-friends').magnificPopup({
                items: {
                    src: $('<div id="buddypress" class="bmf-white-popup"></div>'),
                    type: 'inline'
                },
                showCloseBtn: true,
                closeBtnInside:true
            });
        },

        rebind_magnific_popup: function( event, xhr, settings ) {
            var url = settings.data;
            var action = parameter_value( url, 'action' );

            if ( 'members_filter' == action ) {
                var timer = setTimeout( function() {

                    $element = $('#buddypress').find('a.mutual-friends');

                    if ( 'undefined' != typeof $element ) {
                        mutual_friends.init_maginific_popup();
                        clearInterval( timer );
                        return false;
                    }
                }, 1000);
            }
        }

    };

    $( document).ready( function() { mutual_friends.init() });
})(jQuery);

function parameter_value( url, name ) {
    var result = new RegExp( name + "=([^&]*)", "i").exec(url);
    return result && unescape(result[1]) || "";
}