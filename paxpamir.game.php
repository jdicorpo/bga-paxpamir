<?php
 /**
  *------
  * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
  * paxpamir implementation : © Jeff DiCorpo <jdicorpo@gmail.com>
  * 
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  * 
  * paxpamir.game.php
  *
  * This is the main file for your game logic.
  *
  * In this PHP file, you are going to defines the rules of the game.
  *
  */


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );
require_once ('modules/tokens.php');


class paxpamir extends Table
{
	function __construct( )
	{
        // Your global variables labels:
        //  Here, you can assign labels to global variables you are using for this game.
        //  You can use any number of global variables with IDs between 10 and 99.
        //  If your game has options (variants), you also have to associate here a label to
        //  the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();
        
        self::initGameStateLabels( array( 
            "setup" => 10,
            "remaining_actions" => 11,
            "favored_suit" => 12,
            "dominance_checks" => 13,

            //    "my_first_global_variable" => 10,
            //    "my_second_global_variable" => 11,
            //      ...
            //    "my_first_game_variant" => 100,
            //    "my_second_game_variant" => 101,
            //      ...
        ) );        

        $this->tokens = new Tokens();
        // $this->tokens->initGlobalIndex('GINDEX', 0);

        // $this->cards = self::getNew( "module.common.deck" );
        // $this->cards->init("cards");

	}
	
    protected function getGameName( )
    {
		// Used for translations and stuff. Please do not modify.
        return "paxpamir";
    }	

    /*
        setupNewGame:
        
        This method is called only once, when a new game is launched.
        In this method, you must setup the game according to the game rules, so that
        the game is ready to be played.
    */
    protected function setupNewGame( $players, $options = array() )
    {    
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = self::getGameinfos();
        $default_colors = $gameinfos['player_colors'];
        $num = count($players);
 
        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar, loyalty, coins) VALUES ";
        $values = array();
        foreach( $players as $player_id => $player )
        {
            $color = array_shift( $default_colors );
            $loyalty = "null";
            $coins = 4;
            $values[] = "('".$player_id."','$color','".$player['player_canal']."','".addslashes( $player['player_name'] )."','".addslashes( $player['player_avatar'] )."','$loyalty','$coins')";
            $this->tokens->createTokensPack("token_".$player_id."_{INDEX}", "tokens_".$player_id, 10);
        }
        $sql .= implode( $values, ',' );
        self::DbQuery( $sql );
        self::reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
        self::reloadPlayersBasicInfos();
        
        /************ Start the game initialization *****/

        // $this->tokens->createTokensPack("card_{INDEX}", "deck", 116);
        $this->tokens->createTokensPack("card_{INDEX}", "court_cards", 100);
        $this->tokens->createTokensPack("card_{INDEX}", "dom_cards", 4, 101);
        $this->tokens->createTokensPack("card_{INDEX}", "event_cards", 12, 105);
        $this->tokens->shuffle("court_cards");
        $this->tokens->shuffle("event_cards");

        // build deck based on number of players
        for ($i = 6; $i >=1; $i--) {
            $this->tokens->pickTokensForLocation($num+5, 'court_cards', 'pile');
            if ($i == 2) {
                $this->tokens->pickTokensForLocation(2, 'event_cards', 'pile');
            } elseif ($i > 2) {
                $this->tokens->pickTokensForLocation(1, 'event_cards', 'pile');
                $this->tokens->pickTokensForLocation(1, 'dom_cards', 'pile');
            }
            $this->tokens->shuffle('pile');
            $pile = $this->tokens->getTokensInLocation('pile');
            $n_cards = $this->tokens->countTokensInLocation('deck');
            foreach ( $pile as $id => $info) {
                // $this->tokens->insertTokenOnExtremePosition($id, 'deck', true);
                $this->tokens->moveToken($id, 'deck', $info['state'] + $n_cards);
            }
        }

        $this->tokens->createTokensPack("coin_{INDEX}", "pool", 36);
        $this->tokens->createTokensPack("afghan_{INDEX}", "pool", 12);
        $this->tokens->createTokensPack("russian_{INDEX}", "pool", 12);
        $this->tokens->createTokensPack("british_{INDEX}", "pool", 12);

        // Init global values with their initial values
        self::setGameStateInitialValue( 'setup', 1 );
        self::setGameStateInitialValue( 'remaining_actions', 2 );
        self::setGameStateInitialValue( 'favored_suit', 0 );
        self::setGameStateInitialValue( 'dominance_checks', 0 );
        
        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        //self::initStat( 'table', 'table_teststat1', 0 );    // Init a table statistics
        //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)

        for ($i = 0; $i < 6; $i++) {
            $this->tokens->pickTokensForLocation(1, 'deck', 'market_0_'.$i);
            $this->tokens->pickTokensForLocation(1, 'deck', 'market_1_'.$i);
        }

        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();

        /************ End of the game initialization *****/
    }

    /*
        getAllDatas: 
        
        Gather all informations about current game situation (visible by the current player).
        
        The method is called each time the game interface is displayed to a player, ie:
        _ when the game starts
        _ when a player refreshes the game page (F5)
    */

    protected function getAllDatas()
    {
        $result = array();
    
        $current_player_id = self::getCurrentPlayerId();    // !! We must only return informations visible by this player !!
    
        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score, loyalty, coins FROM player ";
        $result['players'] = self::getCollectionFromDb( $sql );

        // TODO: Gather all information about current game situation (visible by player $current_player_id).
  
        $players = $this->loadPlayersBasicInfos();
        foreach ( $players as $player_id => $player_info ) {
            $result['court'][$player_id] = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
            // $result['court'][$player_id] = $this->tokens->getTokensInLocation('court_'.$player_id);
            $result['tokens'][$player_id] = $this->tokens->getTokensInLocation('tokens_'.$player_id);
            $result['counts'][$player_id]['coins'] = $this->getPlayerCoins($player_id );
            $result['counts'][$player_id]['tokens'] = count($this->tokens->getTokensOfTypeInLocation('token', 'tokens_'.$player_id ));
            $result['counts'][$player_id]['cards'] = count($this->tokens->getTokensOfTypeInLocation('card', 'hand_'.$player_id ));
            $result['counts'][$player_id]['suits'] = $this->getPlayerSuits($player_id);
            $result['counts'][$player_id]['influence'] = $this->getPlayerInfluence($player_id);
        }

        $result['hand'] = $this->tokens->getTokensInLocation('hand_'.$current_player_id);

        $result['token_types'] = $this->token_types;
        $result['loyalty'] = $this->loyalty;
        $result['suits'] = $this->suits;
        $result['cards'] = array();

        foreach ($this->token_types as $key => $value) {
            if ($this->startsWith($value['type'], 'card')) {
                $result['cards'][] = $key;
            }
        }

        $result['deck'] = $this->tokens->getTokensOfTypeInLocation(null, 'deck', null, 'state');

        for ($i = 0; $i < 6; $i++) {
            // $result['market'][0][$i] = $this->tokens->getTokenOnTop('market_0_'.$i);
            $result['market'][0][$i] = $this->tokens->getTokenOnLocation('market_0_'.$i);
            $result['market'][1][$i] = $this->tokens->getTokenOnLocation('market_1_'.$i);
        }

        $result['coins'] = $this->tokens->getTokensOfTypeInLocation('coin', null);
        // $result['tokens'] = $this->tokens->getTokensOfTypeInLocation('token', null);

        $result['favored_suit'] = $this->getGameStateValue("favored_suit");

        return $result;
    }

    /*
        getGameProgression:
        
        Compute and return the current game progression.
        The number returned must be an integer beween 0 (=the game just started) and
        100 (= the game is finished or almost finished).
    
        This method is called each time we are in a game state with the "updateGameProgression" property set to true 
        (see states.inc.php)
    */
    function getGameProgression()
    {
        // TODO: compute and return the game progression

        return 0;
    }


//////////////////////////////////////////////////////////////////////////////
//////////// Utility functions
////////////    

    /*
        In this space, you can put any utility methods useful for your game logic
    */

    function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    } 

    function getPlayerSuits($player_id) {
        $suits = array (
            'political' => 0,
            'military' => 0,
            'economic' => 0,
            'intelligence' => 0
        );
        $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
        for ($i = 0; $i < count($court_cards); $i++) {
            $card_info = $this->token_types[$court_cards[$i]['key']];
            $suits[$card_info['suit']] += $card_info['rank'];
        }
        return $suits;
    }

    function getPlayerInfluence($player_id) {
        $influence = 1;
        $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
        for ($i = 0; $i < count($court_cards); $i++) {
            // $card_info = $this->token_types[$court_cards[$i]['key']];
            // $card_info['suit'] += $card_info['rank'];
        }
        return $influence;
    }

    function getPlayerCoins($player_id) {
        $sql = "SELECT coins FROM player WHERE  player_id='$player_id' ";
        return $this->getUniqueValueFromDB($sql);
    }

    function incPlayerCoins($player_id, $value) {
        $coins = $this->getPlayerCoins($player_id);
        $coins += $value;
        $sql = "UPDATE player SET coins='$coins' 
                WHERE  player_id='$player_id' ";
        self::DbQuery( $sql );
    }

    function getPlayerLoyalty($player_id) {
        $sql = "SELECT loyalty FROM player WHERE  player_id='$player_id' ";
        return $this->getUniqueValueFromDB($sql);
    }

    function setPlayerLoyalty($player_id, $coalition) {
        $sql = "UPDATE player SET loyalty='$coalition' 
        WHERE  player_id='$player_id' ";
        self::DbQuery( $sql );
    }

    function updatePlayerCounts() {
        $counts = array();
        $players = $this->loadPlayersBasicInfos();
        // $sql = "SELECT player_id id, player_score score, loyalty, coins FROM player ";
        // $result['players'] = self::getCollectionFromDb( $sql );
        foreach ( $players as $player_id => $player_info ) {
            $counts[$player_id] = array();
            $counts[$player_id]['coins'] = $this->getPlayerCoins($player_id );
            $counts[$player_id]['tokens'] = count($this->tokens->getTokensOfTypeInLocation('token', 'tokens_'.$player_id ));
            $counts[$player_id]['cards'] = count($this->tokens->getTokensOfTypeInLocation('card', 'hand_'.$player_id ));
            $counts[$player_id]['suits'] = $this->getPlayerSuits($player_id);
            $counts[$player_id]['influence'] = $this->getPlayerInfluence($player_id);
        }

        self::notifyAllPlayers( "updatePlayerCounts", '', array(
            'counts' => $counts
        ) );
    }

    function getUnavailableCards() {

        $result = array();
        
        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < 6; $j++) {
                $res = $this->tokens->getTokensOfTypeInLocation('card', 'market_'.$i.'_'.$j, 1 );
                $card = array_shift( $res );
                if (($card !== NULL) and ($card['state'] == 1)) {
                    $result[] = $card['key'];
                }
            }
        }

        return $result;

    }

    function checkDiscards( $player_id )
    {
        //
        // check for extra cards in hand and court
        //
        $result = array();
        $suits = $this->getPlayerSuits($player_id);
        $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
        $hand = $this->tokens->getTokensOfTypeInLocation('card', 'hand_'.$player_id, null, 'state');
        
        $result['court'] = count($court_cards) - $suits['political'] - 3;
        $result['court'] = max($result['court'], 0);

        $result['hand'] = count($hand) - $suits['intelligence'] - 2;
        $result['hand'] = max($result['hand'], 0);

        return $result;

    }

    function dominanceCheck ()
    {
        //
        // perform dominance check
        //
    }

    function resolveEvent( $event )
    {
        // resolve effect of an event. $event will match one of the following:
        //
        //      favor_mililtary
        //      new_tatics
        //      embarassment_riches
        //      kohinoor_recovered
        //      disregard_customs
        //      courtly_manners
        //      failure_impress
        //      rumor
        //      riots_punjab
        //      conflict_fatigue
        //      riots_herat
        //      nationalism
        //      no_effect
        //      public_withdrawl
        //      riots_kabul
        //      nation_building
        //      riots_persia
        //      persian_aristocracy
        //      confidence_failure
        //      persuasive_methods
        //      favor_intelligence
        //      pashtunwali_values
        //      favor_political
        //      rebuke

    }

//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
//////////// 

    /*
        Each time a player is doing some game action, one of the methods below is called.
        (note: each method below must match an input method in paxpamir.action.php)
    */


    function purchaseCard( $card_id )
    {
        self::checkAction( 'purchase' );

        $player_id = self::getActivePlayerId();
        $card = $this->tokens->getTokenInfo($card_id);
        $card_name = $this->token_types[$card_id]['name'];
        $market_location = $card['location'];
        $row = explode("_", $market_location)[1];
        $row_alt = ($row == 0) ? 1 : 0;
        $col = $cost = explode("_", $market_location)[2];

        if ($this->getGameStateValue("remaining_actions") > 0) {

            if ($cost > $this->getPlayerCoins($player_id)) {
                throw new feException( "Not enough coins" );
            } else {
                $this->incPlayerCoins($player_id, -$cost);
            };

            $this->tokens->moveToken($card_id, 'hand_'.$player_id);
            $this->incGameStateValue("remaining_actions", -1);

            $coins = $this->tokens->getTokensOfTypeInLocation('coin', $card_id);
            // $this->tokens->moveTokens($coins, 'pool');
            $this->incPlayerCoins($player_id, count($coins));
            $this->tokens->moveAllTokensInLocation($card_id, 'pool');

            self::notifyAllPlayers( "log", "purchaseCard", array(
                'card' => $card,
                'col' => $col,
                'row' => $row,
                'market_location' => $market_location,
                'coins' => $coins
            ) );

            $updated_cards = array();

            for ($i = $col-1; $i >= 0; $i--) {
                $location = 'market_'.$row.'_'.$i;
                $m_card = $this->tokens->getTokenOnLocation($location);
                if ($m_card == NULL) {
                    $location = 'market_'.$row_alt.'_'.$i;
                    $m_card = $this->tokens->getTokenOnLocation($location);
                }
                if ($m_card !== NULL) {
                    $c = $this->tokens->getTokenOnTop('pool');
                    $this->tokens->moveToken($c['key'], $m_card["key"]); 
                    $this->tokens->setTokenState($m_card["key"], 1);
                    $updated_cards[] = array(
                        'location' => $location,
                        'card_id' => $m_card["key"],
                        'coin_id' => $c['key']
                    );
                }
            }

            self::notifyAllPlayers( "purchaseCard", clienttranslate( '${player_name} purchased ${card_name}' ), array(
                'player_id' => $player_id,
                'player_name' => self::getActivePlayerName(),
                'card' => $card,
                'card_name' => $card_name,
                'market_location' => $market_location,
                'updated_cards' => $updated_cards,
                'i18n' => array( 'card_name' ),
            ) );

            $this->updatePlayerCounts();

        }

        if ($this->getGameStateValue("remaining_actions") > 0) {
            $this->gamestate->nextState( 'action' );
        } else {
            $this->cleanup();
        }

    }

    function playCard( $card_id, $left_side = true )
    {
        //
        // play a card from hand into the court on either the left or right side
        //

        self::checkAction( 'play' );

        $player_id = self::getActivePlayerId();
        $card = $this->tokens->getTokenInfo($card_id);
        $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
        $card_name = $this->token_types[$card_id]['name'];

        if ($this->getGameStateValue("remaining_actions") > 0) {
            if ($left_side) {
                for ($i = 0; $i < count($court_cards); $i++) {
                    // $this->tokens->setTokenState($court_cards[$i].key, $court_cards[$i].state+1);
                    $this->tokens->setTokenState($court_cards[$i]['key'], $i+2);
                }
                $this->tokens->moveToken($card_id, 'court_'.$player_id, 1);
                $message = clienttranslate( '${player_name} played ${card_name} to the left side of their court' );
            } else {
                $this->tokens->moveToken($card_id, 'court_'.$player_id, count($court_cards) + 1);
                $message = clienttranslate( '${player_name} played ${card_name} to the right side of their court' );
            }
            $this->incGameStateValue("remaining_actions", -1);
            $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');

            self::notifyAllPlayers( "playCard", $message, array(
                'player_id' => $player_id,
                'player_name' => self::getActivePlayerName(),
                'card' => $card,
                'card_name' => $card_name,
                'court_cards' => $court_cards,
                'i18n' => array( 'card_name' ),
            ) );

            $this->updatePlayerCounts();

        }

        if ($this->getGameStateValue("remaining_actions") > 0) {
            $this->gamestate->nextState( 'action' );
        } else {
            $this->cleanup();
        }

    }

    function cleanup( )
    {
        //
        // go to the next state for cleanup:  either discard court, discard hand or refresh market
        //

        $player_id = self::getActivePlayerId();
        $discards = $this->checkDiscards($player_id);

        if ($discards['court'] > 0) {
            $this->gamestate->nextState( 'discard_court' );
        } elseif ($discards['hand'] > 0) {
            $this->gamestate->nextState( 'discard_hand' );
        } else {
            $this->gamestate->nextState( 'refresh_market' );
        }

    }

    function passAction( )
    {
        //
        // pass remaining player actions
        //

        self::checkAction( 'pass' );

        $player_id = self::getActivePlayerId();

        $remaining_actions = $this->getGameStateValue("remaining_actions");
        $state = $this->gamestate->state();

        if (($remaining_actions > 0) and ($state['name'] == 'playerActions')) {
            // self::incStat($remaining_actions, "skip", $player_id);
            $this->setGameStateValue("remaining_actions", 0);

            // Notify
            self::notifyAllPlayers( "passAction", clienttranslate( '${player_name} ended their turn.' ), array(
                'player_id' => $player_id,
                'player_name' => self::getActivePlayerName(),
            ) );
        } 

        $this->cleanup();
        
    }

    function discardCards($cards, $from_hand )
    {
        self::checkAction( 'discard' );

        $player_id = self::getActivePlayerId();
        $discards = $this->checkDiscards($player_id);

        if ($from_hand) {
            if (count($cards) !== $discards['hand'])
                throw new feException( "Incorrect number of discards" );

            foreach ($cards as $card_id) {
                $this->tokens->moveToken($card_id, 'discard');
                $card_name = $this->token_types[$card_id]['name'];
                $removed_card = $this->tokens->getTokenInfo($card_id);
                $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');

                self::notifyAllPlayers( "discardCard", '${player_name} discarded ${card_name} from their hand.', array(
                    'player_id' => $player_id,
                    'player_name' => self::getActivePlayerName(),
                    'card_name' => $card_name,
                    'court_cards' => $court_cards,
                    'card_id' => $card_id,
                    'from' => 'hand'
                ) );
            }

        } else {
            if (count($cards) != $discards['court'])
                throw new feException( "Incorrect number of discards" );

            foreach ($cards as $card_id) {
                $this->tokens->moveToken($card_id, 'discard');
                $card_name = $this->token_types[$card_id]['name'];
                $removed_card = $this->tokens->getTokenInfo($card_id);
                $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');
                                
                // slide card positions down to fill in gap
                foreach ($court_cards as $c) {
                    if ($c['state'] > $removed_card['state'])
                        $this->tokens->setTokenState($c['key'], $c['state'] - 1);
                }

                $court_cards = $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state');

                self::notifyAllPlayers( "discardCard", '${player_name} discarded ${card_name} from their court.', array(
                    'player_id' => $player_id,
                    'player_name' => self::getActivePlayerName(),
                    'card_name' => $card_name,
                    'court_cards' => $court_cards,
                    'card_id' => $card_id,
                    'from' => 'court'
                ) );
            }
        }

        $this->updatePlayerCounts();

        $this->cleanup();

    }

    function chooseLoyalty( $coalition )
    {
        //
        // select starting loyalty during game setup
        //

        self::checkAction( 'choose_loyalty' );

        $player_id = self::getActivePlayerId();
        $coalition_name = $this->loyalty[$coalition]['name'];

        $this->setPlayerLoyalty($player_id, $coalition);

        // Notify
        self::notifyAllPlayers( "chooseLoyalty", clienttranslate( '${player_name} selected ${coalition_name}.' ), array(
            'player_id' => $player_id,
            'player_name' => self::getActivePlayerName(),
            'coalition' => $coalition,
            'coalition_name' => $coalition_name
        ) );

        $this->gamestate->nextState( 'next' );

    }

    
//////////////////////////////////////////////////////////////////////////////
//////////// Game state arguments
////////////

    /*
        Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
        These methods function is to return some additional information that is specific to the current
        game state.
    */

    function argPlayerActions()
    {
        $player_id = self::getActivePlayerId();

        return array(
            'remaining_actions' => $this->getGameStateValue("remaining_actions"),
            'unavailable_cards' => $this->getUnavailableCards(),
            'hand' => $this->tokens->getTokensInLocation('hand_'.$player_id),
            'court' => $this->tokens->getTokensOfTypeInLocation('card', 'court_'.$player_id, null, 'state'),
            'suits' => $this->getPlayerSuits($player_id)
        );
    }

//////////////////////////////////////////////////////////////////////////////
//////////// Game state actions
////////////

    /*
        Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
        The action method of state X is called everytime the current game state is set to X.
    */

    function stRefreshMarket()
    {
        $empty_top = array();
        $empty_bottom = array();
        $card_moves = array();
        $new_cards = array();

        for ($i = 0; $i < 6; $i++) {
            $from_location = 'market_0_'.$i;
            $card = $this->tokens->getTokenOnLocation($from_location);
            if ($card == null) {
                $empty_top[] = $i;
            } else {
                $this->tokens->setTokenState($card["key"], 0);
                if (count($empty_top) > 0) {
                    $to_locaction = 'market_0_'.array_shift($empty_top);
                    $this->tokens->moveToken($card['key'], $to_locaction);
                    $empty_top[] = $i;
                    $card_moves[] = array(
                        'card_id' => $card['key'], 
                        'from' => $from_location, 
                        'to' => $to_locaction
                    );
                    
                    self::notifyAllPlayers( "refreshMarket", '', array(
                        'card_moves' => $card_moves,
                        'new_cards' => $new_cards,
                    ) );
            
                    $this->gamestate->nextState( 'refresh_market' );
                    return;
                }
            }
            
            $from_location = 'market_1_'.$i;
            $card = $this->tokens->getTokenOnLocation($from_location);
            if ($card == null) {
                $empty_bottom[] = $i;
            } else {
                $this->tokens->setTokenState($card["key"], 0);
                if (count($empty_bottom) > 0) {
                    $to_locaction = 'market_1_'.array_shift($empty_bottom);
                    $this->tokens->moveToken($card['key'], $to_locaction );
                    $empty_bottom[] = $i;
                    $card_moves[] = array( 
                        'card_id' => $card['key'], 
                        'from' => $from_location, 
                        'to' => $to_locaction
                    );

                    self::notifyAllPlayers( "refreshMarket", '', array(
                        'card_moves' => $card_moves,
                        'new_cards' => $new_cards,
                    ) );
            
                    $this->gamestate->nextState( 'refresh_market' );
                    return;
                }
            }

        }

        foreach ($empty_top as $i) {
            $card = $this->tokens->pickTokensForLocation(1, 'deck', 'market_0_'.$i)[0];
            $new_cards[] = array(
                'card_id' => $card['key'], 
                'from' => 'deck',
                'to' => 'market_0_'.$i
            );
        }

        foreach ($empty_bottom as $i) {
            $card = $this->tokens->pickTokensForLocation(1, 'deck', 'market_1_'.$i)[0];
            $new_cards[] = array(
                'card_id' => $card['key'], 
                'from' => 'deck', 
                'to' => 'market_1_'.$i
            );
        }

        self::notifyAllPlayers( "refreshMarket", clienttranslate( 'The market has been refreshed.' ), array(
            'card_moves' => $card_moves,
            'new_cards' => $new_cards,
        ) );

        $this->gamestate->nextState( 'next_turn' );

    }

    function stNextPlayer()
    {
        $setup = $this->getGameStateValue("setup");
        // Active next player
        if ($setup == 1) {
            // setup
            $player_id = self::activeNextPlayer();
            $loyalty = $this->getPlayerLoyalty($player_id);
            if ($this->getPlayerLoyalty($player_id) == "null") {
                // choose next loyalty
                $this->giveExtraTime($player_id);

                $this->gamestate->nextState( 'setup' );
            } else {
                // setup complete, go to player actions
                $player_id = self::activePrevPlayer();
                $this->giveExtraTime($player_id);

                $this->setGameStateValue("setup", 0);
                $this->setGameStateValue("remaining_actions", 2);

                $this->gamestate->nextState( 'next_turn' );
            }

        } else {
            // player turn
            $player_id = self::activeNextPlayer();

            $this->setGameStateValue("remaining_actions", 2);
            $this->giveExtraTime($player_id);

            $this->gamestate->nextState( 'next_turn' );
        }

    }
    

//////////////////////////////////////////////////////////////////////////////
//////////// Zombie
////////////

    /*
        zombieTurn:
        
        This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
        You can do whatever you want in order to make sure the turn of this player ends appropriately
        (ex: pass).
        
        Important: your zombie code will be called when the player leaves the game. This action is triggered
        from the main site and propagated to the gameserver from a server, not from a browser.
        As a consequence, there is no current player associated to this action. In your zombieTurn function,
        you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message. 
    */

    function zombieTurn( $state, $active_player )
    {
    	$statename = $state['name'];
    	
        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState( "zombiePass" );
                	break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive( $active_player, '' );
            
            return;
        }

        throw new feException( "Zombie mode not supported at this game state: ".$statename );
    }
    
///////////////////////////////////////////////////////////////////////////////////:
////////// DB upgrade
//////////

    /*
        upgradeTableDb:
        
        You don't have to care about this until your game has been published on BGA.
        Once your game is on BGA, this method is called everytime the system detects a game running with your old
        Database scheme.
        In this case, if you change your Database scheme, you just have to apply the needed changes in order to
        update the game database and allow the game to continue to run with your new version.
    
    */
    
    function upgradeTableDb( $from_version )
    {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345
        
        // Example:
//        if( $from_version <= 1404301345 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        if( $from_version <= 1405061421 )
//        {
//            // ! important ! Use DBPREFIX_<table_name> for all tables
//
//            $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
//            self::applyDbUpgradeToAllDB( $sql );
//        }
//        // Please add your future database scheme changes here
//
//


    }    
}
