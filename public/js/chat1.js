$(function() {
    "use strict";
    window.chat = ({
        _hidden: false,
        _area: $('.chat-messages'),
        _input: $('.chat-input'),
        _lastMessage: 0,
        _chatCooldown: 2,
        _maxMessages: 25,
        _messages: [],
        updateDisplay: function() {
            this._area.empty();
            var self = this;
            this._messages.forEach(function(item) { self.displayMessage(item, true); });
            self._area.animate({scrollTop: self._area[0].scrollHeight}, 0);
        },
        emots: {
            list: 'dislike|ezskins|highfive|kappa|like|money|question|skins|stopkappa',
            rep: function (txt) {
                return txt.replace(new RegExp(this.list,'gi'), function(emote) {
                    return '<img class="emote" src="/img/emotes/' + emote.toLowerCase() + '.png">';
                });
            },
            _area: $('.chat-area'),
            _status: false,
            _list: false,
            _button: false,
            init: function () {
                this._list = $('<div class="emotsList"></div>')
                    .appendTo(this._area);

                this.list.split('|').forEach(function(emote) {
                    $('<img class="emote" data-val="'+emote+'" src="/img/emotes/'+emote+'.png">')
                        .click(function(e) {
                            this._status = false;
                            this._list.fadeOut(300);
                            this._button.css('background-image', 'url(/img/emotes/kappa.png)');

                            chat._input.val( chat._input.val() + ' ' + $(e.currentTarget).data('val'));

                        }.bind(this))
                        .appendTo(this._list);
                }.bind(this));

                this._sendArea = $('<div class="sendArea">' +
                    '<div class="title">Recieve coins to your steamid<div class="steamid">'+(steamid ? steamid : "Need to log in!")+'</div></div>' +
                    '<div class="input-group"><label for="send_steamid">SEND TO</label><input id="send_steamid" /></div>' +
                    '<div class="input-group"><label for="send_amount">AMOUNT</label><input id="send_amount" /></div>' +
                    '</div>')
                    .appendTo(this._area);



                $('<div class="close">X</div>')
                    .appendTo(this._sendArea)
                    .click(function(){
                        this._sendArea.fadeOut(300);
                    }.bind(this));



                this._send_steamid = this._sendArea.find('#send_steamid');
                this._send_amount = this._sendArea.find('#send_amount');

                $('<div class="button">SEND COINS</div>')
                    .appendTo(this._sendArea)
                    .click(function(){
                        socket.emit('chat message', {'type': 'chat', 'message': '/send '+this._send_steamid.val()+' '+this._send_amount.val()});
                        this._send_steamid.val('');
                        this._send_amount.val('');
                        this._sendArea.fadeOut(300);
                    }.bind(this));

                $('<div class="sendButton"></div>')
                    .appendTo(this._area)
                    .click(function() {
                        this._sendArea.fadeIn(300);
                    }.bind(this));

                this._button = $('<div class="emotsButton"></div>')
                    .appendTo(this._area)
                    .click(function() {
                        if (this._status) {
                           this._list.fadeOut(300);
                            this._button.css('background-image', 'url(/img/emotes/kappa.png)');
                        } else {
                            this._list.fadeIn(300);
                            this._button.css('background-image', 'url(/img/emotes/stopkappa.png)');
                        }
                        this._status = !this._status;
                    }.bind(this));


            }
        },
        displayMessage: function(item, bypass) {
            var self = this;
            var scroll = true;

            if (self._area.children().length >= self._maxMessages) {
                self._area.children().first().remove();
                scroll = false;
            }

            if (item.hasOwnProperty('profile')) {
                if (typeof item.message != 'undefined') {
                    item.message = this.emots.rep(item.message);
                }
                
                $('<div class="chat-message" data-uniqueid="' + item.uniqueID + '" data-id="' + item.profile.steamid + '" data-username="' + item.profile.username + '" data-rank="' + item.profile.rank + '" data-affiliate="' + item.profile.affiliate + '"> ' +
                    '<div class="avatar"><img src="' + item.profile.avatar + '"> </div> ' +
                    '<div class="message"> ' +
                    '<div class="nickname ' + item.profile.rank + ' ' + item.profile.affiliate + '"><a target="_blank" href="//steamcommunity.com/profiles/' + item.profile.steamid + '">' + item.profile.username + '</a></div> ' +
                    '<div class="text">' + item.message + '</div>' +
                    (item.time ? '<div class="time">' + getHour(item.time) + '</div></div>' : '') +
                    '</div></div>').hide().appendTo(self._area).fadeIn(500);
            } else if (item.hasOwnProperty('custom')) {
                if (item.custom.message) {
                    item.custom.message = this.emots.rep(item.custom.message);
                }
                
                $('<div class="chat-message"> ' +
                    '<div class="avatar"><img src="/img/avatar.jpg"> </div> ' +
                    '<div class="message"> ' +
                    '<div class="nickname siteAdmin">CSGOTrinity</div> ' +
                    '<div class="text">' + vsprintf((item.custom.messageCode && locale.hasOwnProperty(item.custom.messageCode) ? locale[item.custom.messageCode] : item.custom.message), item.custom.variables || []) + '</div>' +
                    ' </div> ' +
                    (item.time ? '<div class="time">' + getHour(item.time) + '</div></div>' : '')).hide().appendTo(self._area).fadeIn(500);
            }

            if (!bypass) {
                if (scroll) {
                    self._area.animate({scrollTop: self._area[0].scrollHeight}, 1500, 'easeInQuart');
                } else {
                    self._area.animate({scrollTop: self._area[0].scrollHeight}, 0);
                }
            }
        },
        sendMessage: function(message) {
            if (message === '') return;
            if (this._lastMessage > (Date.now() - this._chatCooldown * 1000)) {
                notify('error', vsprintf(locale.chatCooldown, [((this._lastMessage - (Date.now() - (this._chatCooldown * 1000))) / 1000).toFixed(1)]));
                return;
            }
            this._input.val('');
            this._lastMessage = Date.now();
            socket.emit('chat message', {'type': 'chat', 'message': message});
        },
        addChat: function(profile, message, uniqueID, time) {
            if (this._messages.length >= this._maxMessages) this._messages.shift();
            var msg = {profile: profile, message: message, uniqueID: uniqueID, time: time};
            this._messages.push(msg);
            this.displayMessage(msg);
        },
        addCustom: function(message, messageCode, variables) {
            if (this._messages.length >= this._maxMessages) this._messages.shift();
            var msg = {custom: {message: message, messageCode: messageCode, variables: variables}};
            this._messages.push(msg);
            this.displayMessage(msg);
        }
    });

    chat.emots.init();

    socket.on('chat', function(messages) {
        chat._messages = messages;
        chat.updateDisplay();
    });
    socket.on('chat message', function(data) { chat.addChat(data.profile, data.message, data.uniqueID, data.time); });
    socket.on('chat custom message', function(data) { chat.addCustom(data.message, data.messageCode, data.variables); });


    chat._input.on('keypress', function(e) {
        if (e.keyCode == 13) {
            chat.sendMessage(chat._input.val());
            return false;
        }
    });

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
                {type: 'title', text: user.data('username')},
                {type: 'item', text: locale.sendCoins, click: function() {
                    chat._input.val('/send ' + user.data('id') + ' ').focus();
                }},
                {type: 'item', text: locale.visitProfile, click: function() {
                    var win = window.open('http://steamcommunity.com/profiles/' + user.data('id'), '_blank');
                    win.focus();
                }}
            ]
        }
    });

});