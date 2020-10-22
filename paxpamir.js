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
            
            // TODO: Set up your game interface here, according to "gamedatas"
            
            for ( var row = 0; row <= 1; row++ ) {
                this.market[row] = [];
                for (var col = 0; col <= 5; col++) {
                    var id = 'market_'+row+'_'+col;
                    this.market[row][col] = new ebg.stock();
                    this.market[row][col].create( this, $(id), this.cardwidth, this.cardheight);
                    this.market[row][col].image_items_per_row = 12;
                    this.market[row][col].jstpl_stock_item= "<div id=\"${id}\" class=\"stockitem card market_card\" \
                        style=\"top:${top}px;left:${left}px;width:${width}px;height:${height}px;z-index:${position};\
                        background-image:url('${image}');\"></div>";
                    for (var c in gamedatas.cards) {
                        this.market[row][col].addItemType(gamedatas.cards[c], 1, g_gamethemeurl + 'img/cards.jpg', gamedatas.cards[c].split('_')[1] -1);
                    }
                    this.placeCard(this.market[row][col], gamedatas.market[row][col].key);
                }
            }
 
            // Setup game notifications to handle (see "setupNotifications" method below)
            this.setupNotifications();

            console.log( "Ending game setup" );
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

        updatePossibleCards: function() {

            this.clearLastAction();

            dojo.query('.market_card').forEach(
                function (node, index) {
                    dojo.addClass(node, 'possibleCard');
                    this.handles.push(dojo.connect(node,'onclick', this, 'onMarketCard'));
                }, this);

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
                this.updatePossibleCards();
                // this.ajaxcall( "/forbiddenisland/forbiddenisland/captureTreasure.html", {
                    // lock: true,
                // }, this, function( result ) {} );
            }
        }, 
        
        onPlay: function()
        {
            if (! this.checkAction('play'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onPlay' );
                // this.ajaxcall( "/forbiddenisland/forbiddenisland/captureTreasure.html", {
                    // lock: true,
                // }, this, function( result ) {} );
            }
        }, 

        onCardAction: function()
        {
            if (! this.checkAction('card_action'))
            return;

            if( this.isCurrentPlayerActive() )
            {       
                console.log( 'onCardAction' );
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
                // this.ajaxcall( "/forbiddenisland/forbiddenisland/captureTreasure.html", {
                    // lock: true,
                // }, this, function( result ) {} );
            }
        }, 

        onMarketCard: function( evt )
        {
            var card_id = evt.currentTarget.id;
            dojo.stopEvent( evt );
            console.log( 'onMarketCard ' + card_id );

            this.selectedCard = card_id;

            if( this.isCurrentPlayerActive() )
            {       
                this.clearLastAction();
                var node = $( card_id );
                dojo.addClass(node, 'selected');
                var cost = card_id.split('_')[2];
                this.setClientState("client_confirmPurchase", { descriptionmyturn : "Purchase this card for "+cost+" rupees?"});
            }
        }, 

        onCancel: function()
        {
            console.log( 'onCancel' );
            this.clearLastAction();
            this.restoreServerGameState();
        }, 

        onConfirm: function()
        {
            console.log( 'onConfirm' );
            this.clearLastAction();
            this.restoreServerGameState();
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
            
            // TODO: here, associate your game notifications with local methods
            
            // Example 1: standard notification handling
            // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
            
            // Example 2: standard notification handling + tell the user interface to wait
            //            during 3 seconds after calling the method in order to let the players
            //            see what is happening in the game.
            // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
            // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
            // 
        },  
        
        // TODO: from this point and below, you can write your game notifications handling methods
        
        /*
        Example:
        
        notif_cardPlayed: function( notif )
        {
            console.log( 'notif_cardPlayed' );
            console.log( notif );
            
            // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call
            
            // TODO: play the card in the user interface.
        },    
        
        */
   });             
});
