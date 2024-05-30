
$(function() {
    "use strict";
    $('html').contextMenu({
        selector: '.chat-message',
        transition: {
            speed: 300, // In milliseconds
            type: 'slideLeft'
        },
        position: {
            my: 'right top-25',
            at: 'left'
        },
        partner: this,
        items: function(e) {
            var user = $(e.target).closest('.chat-message');
            if (!user.data('id')) return;
            return [
                {type: 'title', text: $("<div>").text(user.data('username')).html()},
                {type: 'item', text: locale.sendCoins, click: function() {
                    chat._input.val('/send ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.muteUser, click: function() {
                    chat._input.val('/mute ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.unmuteUser, click: function() {
                    chat._input.val('/unmute ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.giveCoins, click: function() {
                    chat._input.val('/give ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.changeAccess, click: function() {
                    chat._input.val('/access ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.checkCoins, click: function() {
                    chat._input.val('/coins').focus();
                }},
                {type: 'item', text: locale.muteChat, click: function() {
                    chat._input.val('/muteChat').focus();
                }},
                {type: 'item', text: locale.unmuteChat, click: function() {
                    chat._input.val('/unmuteChat').focus();
                }},
                {type: 'item', text: locale.removeMessages, click: function() {
                    chat._input.val('/removeMessages ' + user.data('id')).focus();
                }},
                {type: 'item', text: locale.removeMessage, click: function() {
                    chat._input.val('/removeMessage ' + user.data('uniqueid')).focus();
                }},
                {type: 'item', text: locale.visitProfile, click: function() {
                    var win = window.open('http://steamcommunity.com/profiles/' + user.data('id'), '_blank');
                    win.focus();
                }}
            ]
        }
    });
});
