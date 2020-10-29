/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * paxpamir implementation : © Jeff DiCorpo <jdicorpo@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * paxpamir.js
 *
 * paxpamir user interface script
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
    "dojo","dojo/_base/declare",
    "ebg/core/gamegui",
    "ebg/counter",
    "ebg/stock",
    "ebg/zone",
],
function (dojo, declare) {
    return declare("bgagame.paxpamir", ebg.core.gamegui, {
        constructor: function(){
            console.log('paxpamir constructor');

            this.interface_max_width = 1500;
            this.interface_max_height = 750;

            this.cardwidth = 179;
            this.cardheight = 251;
              
            this.market = [];
            this.player_hand = new ebg.stock();
            this.court = [];
            this.player_token_area = [];

            this.clientStateArgs = {};
            this.handles = [];

        },
        
        /*
            setup:
            
            This method must set up the game user interface according to current game situation specified
            in parameters.
            
            The method is called each time the game interface is displayed to a player, ie:
            _ when the game starts
            _ when a player refreshes the game page (F5)
            
            "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
        */
        
        setup: function( gamedatas )
        {
            console.log( "Starting game setup" );
            
            // Setting up player boards
            for( var player_id in gamedatas.players )
            {
                var player = gamedatas.players[player_id];
                         
                // TODO: Setting up players boards if needed
            }
            
            for ( var row = 0; row <= 1; row++ ) {
                this.market[row] = [];
                for (var col = 0; col <= 5; col++) {
                    var id = 'market_'+row+'_'+col;
                    this.market[row][col] = new ebg.stock();
                    this.setup_cards(this.market[row][col], $(id), 'market_card');

                    if (gamedatas.market[row][col] !== null) {
                        this.placeCard(this.market[row][col], gamedatas.market[row][col].key);
                    }
                }
            }

            this.setup_cards(this.player_hand, $('player_hand'), 'hand');

            for (var c in gamedatas.hand) {
                this.placeCard(this.player_hand, c );
            }

            for( var player_id in gamedatas.players ) {
                var id = 'court_' + player_id;
                this.court[player_id] = new ebg.stock();
                this.setup_cards(this.court[player_id], $(id), 'court');

                for (var c in gamedatas.court[player_id]) {
                    this.placeCard(this.court[player_id], c );
                }
                this.player_token_area[player_id] = new ebg.stock();
                this.player_token_area[player_id].create( this, $( 'tokens_' + player_id ), 50, 50 );
                for ( var i = 1; i <= 10; i++ ) {
                    var player_color = gamedatas.players[player_id].color;
                    this.player_token_area[player_id].addItemType( 
                        'token_' + player_id + '_' + i, 
                        1, g_gamethemeurl + 'img/tokens.png', 
                        gamedatas.token_types.token_colors[player_color] 
                    );
                }
                this.player_token_area[player_id].jstpl_stock_item= "<div id=\"${id}\" class=\"stockitem card token\" \
                style=\"top:${top}px;left:${left}px;width:${width}px;height:${height}px;z-index:${position};\
                background-image:url('${image}');\"></div>";

                for (var t in gamedatas.tokens[player_id]) {
                    this.placeToken(this.player_token_area[player_id], t );
                }
            }
 
            // Setup game notifications to handle (see "setupNotifications" method below)
            this.setupNotifications();

            console.log( "Ending game setup" );

        },

        setup_cards: function( stock, node, class_name ) {
            stock.create( this, node, this.cardwidth, this.cardheight );
            stock.image_items_per_row = 12;
            stock.jstpl_stock_item= "<div id=\"${id}\" class=\"stockitem card " + class_name + "\" \
                style=\"top:${top}px;left:${left}px;width:${width}px;height:${height}px;z-index:${position};\
                background-image:url('${image}');\"></div>";
            
            for (var c in this.gamedatas.cards) {
                stock.addItemType( this.gamedatas.cards[c], 1, g_gamethemeurl + 'img/cards.jpg', this.gamedatas.cards[c].split('_')[1] -1 );
            }
        },

        adaptViewportSize : function() {
            var pageid = "page-content";
            var nodeid = "thething";
    
            var bodycoords = dojo.marginBox(pageid);
            var contentWidth = bodycoords.w;
    
            var browserZoomLevel = window.devicePixelRatio; 
            // console.log("zoom",browserZoomLevel);
            // console.log("contentWidth", contentWidth);

            // if (contentWidth >= this.interface_max_width || browserZoomLevel >1  || this.control3dmode3d) {
            if (contentWidth >= interface_max_width || this.control3dmode3d) {
            // if (this.large_screen || this.control3dmode3d) {
                dojo.style(nodeid,'transform','');
                dojo.style(nodeid,'-webkit-transform','');
                // console.log("contentWidth", contentWidth, '>', board_width);
                return;
            }
    
            var scale_percent = contentWidth / interface_max_width;
            // console.log("scale = ", scale_percent);

            dojo.style(nodeid, "transform", "scale(" + scale_percent + ")");
            dojo.style(nodeid, "-webkit-transform", "scale(" + scale_percent + ")");

        },
       

        ///////////////////////////////////////////////////
        //// Game & client states
        
        // onEnteringState: this method is called each time we are entering into a new game state.
        //                  You can use this method to perform some user interface changes at this moment.
        //
        onEnteringState: function( stateName, args )
        {
            console.log( 'Entering state: '+stateName );
            
            switch( stateName )
            {
            case 'playerActions':
                this.remaining_actions = args.args.remaining_actions;
                break;
            
            case 'dummmy':
                break;
            }
        },

        // onLeavingState: this method is called each time we are leaving a game state.
        //                 You can use this method to perform some user interface changes at this moment.
        //
        onLeavingState: function( stateName )
        {
            console.log( 'Leaving state: '+stateName );
            
            switch( stateName )
            {
            
            case 'dummmy':
                break;
            }               
        }, 

        // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
        //                        action status bar (ie: the HTML links in the status bar).
        //        
        onUpdateActionButtons: function( stateName, args )
        {
            console.log( 'onUpdateActionButtons: '+stateName );
                      
            if( this.isCurrentPlayerActive() )
            {            
                switch( stateName )
                {
                    case 'playerActions':
                        var main = $('pagemaintitletext');
                        if (args.remaining_actions > 0) {
                            main.innerHTML += _(' may take ') + '<span id="remaining_actions_value" style="font-weight:bold;color:#ED0023;">' 
                                + args.remaining_actions + '</span>' + _(' action(s): ');
                            this.addActionButton( 'purchase_btn', _('Purchase'), 'onPurchase' );
                            this.addActionButton( 'play_btn', _('Play'), 'onPlay' );
                            this.addActionButton( 'card_action_btn', _('Card Action'), 'onCardAction' );
                            this.addActionButton( 'pass_btn', _('End Turn'), 'onPass', null, false, 'gray' ); 
                        } else {
                            main.innerHTML += _(' have ') + '<span id="remaining_actions_value" style="font-weight:bold;color:#ED0023;">' 
                            + args.remaining_actions + '</span>' + _(' remaining actions: ');

                            this.addActionButton( 'pass_btn', _('End Turn'), 'onPass', null, false, 'blue' );
                        }
                        break;

                    case 'client_confirmPurchase':
                        this.addActionButton( 'confirm_btn', _('Confirm'), 'onConfirm', null, false, 'blue' );
                        this.addActionButton( 'cancel_btn', _('Cancel'), 'onCancel', null, false, 'red' );
                        break;

                    case 'client_endTurn':
                        this.addActionButton( 'confirm_btn', _('Confirm'), 'onConfirm', null, false, 'red' );
                        this.addActionButton( 'cancel_btn', _('Cancel'), 'onCancel', null, false, 'gray' );
                        break;

                    case 'client_selectPurchase':
                    case 'client_selectPlay':
                        this.addActionButton( 'cancel_btn', _('Cancel'), 'onCancel', null, false, 'red' );
                        break;
                    default:
                        break;
                }
            }
        },        

        ///////////////////////////////////////////////////
        //// Utility methods
        
        /*
        
            Here, you can defines some utility methods that you can use everywhere in your javascript
            script.
        
        */

        placeCard : function(location, id) {
            console.log( 'placeCard' );

            // var idx = this.gamedatas.flood_list[id].img_id
            // var tooltip = this.gamedatas.flood_list[id].name;

            location.addToStockWithId(id, id, 'deck');
            // location.addToStockWithId(id, id, this.flood_deck);

            // this.addTooltip( this.flood_card_area.getItemDivId(id), tooltip, '' );

        },

        moveCard : function(id, from_location, to_location) {
            console.log( 'moveCard' );

            if (from_location !== null) {
                var from_div = from_location.getItemDivId(id);
            } else {
                from_div = null;
            }
            if (to_location !== null) {
                to_location.addToStockWithId(id, id, from_div);
            }
            if (from_location !== null) {
                from_location.removeFromStockById(id);
            }

            // if ('tooltip' in this.gamedatas.treasure_list[card.type]) {
            //     var tooltip = _( this.gamedatas.treasure_list[card.type].tooltip );
            //     this.addTooltip( this.player_card_area[target_player_id].getItemDivId(id), tooltip, '' );
            // }

        },

        updatePossibleCards: function() {

            this.clearLastAction();

            switch (this.selectedAction) {
                case 'purchase':
                    dojo.query('.market_card').forEach(
                        function (node, index) {
                            dojo.addClass(node, 'possibleCard');
                            this.handles.push(dojo.connect(node,'onclick', this, 'onCard'));
                        }, this);
                    break;
                case 'play':
                    dojo.query('.hand').forEach(
                        function (node, index) {
                            dojo.addClass(node, 'possibleCard');
                            this.handles.push(dojo.connect(node,'onclick', this, 'onCard'));
                        }, this);
                    break;
                case 'card_action':
                    break;
                default:
                    break;
            }

        },

        placeToken : function(location, id) {
            console.log( 'placeToken' );

            // var idx = this.gamedatas.flood_list[id].img_id
            // var tooltip = this.gamedatas.flood_list[id].name;

            location.addToStockWithId(id, id, 'deck');
            // location.addToStockWithId(id, id, this.flood_deck);

            // this.addTooltip( this.flood_card_area.getItemDivId(id), tooltip, '' );

        },

        clearLastAction : function( )
        {
            console.log( 'clearLastAction, handles = ' + this.handles.length );

            // Remove current possible moves
            dojo.query( '.possibleMove' ).removeClass( 'possibleMove' );
            dojo.query( '.otherPlayer' ).removeClass( 'otherPlayer' );
            dojo.query( '.possibleCard' ).removeClass( 'possibleCard' );
            dojo.query( '.possiblePlayer' ).removeClass( 'possiblePlayer' );
            dojo.query( '.possiblePawn' ).removeClass( 'possiblePawn' );
            dojo.query( '.selected' ).removeClass( 'selected' );
            dojo.query( '.selectedPawn' ).removeClass( 'selectedPawn' );
            dojo.query( '.fadeTile' ).removeClass( 'fadeTile' );

            dojo.forEach(this.handles, dojo.disconnect);
            this.handles = [];

        },


        ///////////////////////////////////////////////////
        //// Player's action
        
        /*
        
            Here, you are defining methods to handle player's action (ex: results of mouse click on 
            game objects).
            
            Most of the time, these methods:
            _ check the action is possible at this game state.
            _ make a call to the game server
        
        */

        onPurchase: function()
        {
            if (! this.checkAction('purchase'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onPurchase' );
                this.selectedAction = 'purchase';
                this.updatePossibleCards();
                this.setClientState("client_selectPurchase", { descriptionmyturn : _( "${you} must select a card to purchase") });
            }
        }, 
        
        onPlay: function()
        {
            if (! this.checkAction('play'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onPlay' );
                this.selectedAction = 'play';
                this.updatePossibleCards();
                this.setClientState("client_selectPlay", { descriptionmyturn : _( "${you} must select a card to play") });
            }
        }, 

        onCardAction: function()
        {
            if (! this.checkAction('card_action'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onCardAction' );
                this.selectedAction = 'card_action';
                // this.ajaxcall( "/forbiddenisland/forbiddenisland/captureTreasure.html", {
                    // lock: true,
                // }, this, function( result ) {} );
            }
        }, 

        onPass: function()
        {
            if (! this.checkAction('pass'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onPass' );
                this.selectedAction = 'pass';
                if (this.remaining_actions == 0) {
                    this.ajaxcall( "/paxpamir/paxpamir/passAction.html", {
                        lock: true
                    }, this, function( result ) {} );
                } else {
                    this.setClientState("client_endTurn", { descriptionmyturn : _( "Confirm to your end turn ") });
                }
            }
        }, 

        onCard: function( evt )
        {
            var card_id = evt.currentTarget.id;
            dojo.stopEvent( evt );
            console.log( 'onCard ' + card_id );

            this.selectedCard = card_id;

            if( this.isCurrentPlayerActive() )
            {   
                switch (this.selectedAction) {
                    case 'purchase':    
                        this.clearLastAction();
                        var node = $( card_id );
                        dojo.addClass(node, 'selected');
                        var cost = card_id.split('_')[2];
                        this.setClientState("client_confirmPurchase", { descriptionmyturn : "Purchase this card for "+cost+" rupees?"});
                        break;

                    case 'play':    
                        this.clearLastAction();
                        var node = $( card_id );
                        dojo.addClass(node, 'selected');
                        var card_id = 'card_' + this.selectedCard.split('_')[4];
                        this.ajaxcall( "/paxpamir/paxpamir/playCard.html", { 
                            lock: true,
                            card_id:card_id,
                        }, this, function( result ) {} );  
                        break;

                    default:
                        break;
                }
            }
        }, 

        onCancel: function()
        {
            console.log( 'onCancel' );
            this.clearLastAction();
            this.selectedAction = '';
            this.restoreServerGameState();
        }, 

        onConfirm: function()
        {
            console.log( 'onConfirm' );

            switch (this.selectedAction) {
                case 'purchase':
                    var card_id = 'card_' + this.selectedCard.split('_')[5];
                    this.ajaxcall( "/paxpamir/paxpamir/purchaseCard.html", { 
                        lock: true,
                        card_id:card_id,
                    }, this, function( result ) {} );  
                    break;
                    
                case 'pass':
                    this.ajaxcall( "/paxpamir/paxpamir/passAction.html", { 
                        lock: true,
                    }, this, function( result ) {} ); 
                    break;

                default:
                    break;
            }

        }, 
        
        
        ///////////////////////////////////////////////////
        //// Reaction to cometD notifications

        /*
            setupNotifications:
            
            In this method, you associate each of your game notifications with your local method to handle it.
            
            Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
                  your paxpamir.game.php file.
        
        */
        setupNotifications: function()
        {
            console.log( 'notifications subscriptions setup' );

            dojo.subscribe( 'purchaseCard', this, "notif_purchaseCard" );
            this.notifqueue.setSynchronous( 'purchaseCard', 2000 );

            dojo.subscribe( 'playCard', this, "notif_playCard" );
            this.notifqueue.setSynchronous( 'playCard', 2000 );

            dojo.subscribe( 'refreshMarket', this, "notif_refreshMarket" );
            this.notifqueue.setSynchronous( 'refreshMarket', 500 );
            
        },  

        notif_purchaseCard: function( notif )
        {
            console.log( 'notif_purchaseCard' );
            console.log( notif );

            this.clearLastAction();
            var row = notif.args.market_location.split('_')[1];
            var col = notif.args.market_location.split('_')[2];

            if (notif.args.player_id == this.player_id) {
                this.moveCard(notif.args.card.key, this.market[row][col], this.player_hand);
            } else {
                this.moveCard(notif.args.card.key, this.market[row][col], null);
            }
        },

        notif_playCard: function( notif )
        {
            console.log( 'notif_playCard' );
            console.log( notif );

            this.clearLastAction();
            var player_id = notif.args.player_id;

            if (player_id == this.player_id) {
                this.moveCard(notif.args.card.key, this.player_hand, this.court[player_id]);
            } else {
                this.moveCard(notif.args.card.key, null, this.court[player_id]);
            }
        },

        notif_refreshMarket: function( notif )
        {
            console.log( 'notif_refreshMarket' );
            console.log( notif );

            this.clearLastAction();

            notif.args.card_moves.forEach (
                function (move, index) {
                    this.moveCard( 
                        move.card_id, 
                        this.market[move.from.split('_')[1]][move.from.split('_')[2]], 
                        this.market[move.to.split('_')[1]][move.to.split('_')[2]]
                    );
                }, this);

            notif.args.new_cards.forEach (
                function (move, index) {
                    this.placeCard(
                        this.market[move.to.split('_')[1]][move.to.split('_')[2]], 
                        move.card_id );
                }, this);

        },
        
   });             
});
