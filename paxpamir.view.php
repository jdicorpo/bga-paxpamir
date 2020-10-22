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
 * paxpamir.view.php
 *
 * This is your "view" file.
 *
 * The method "build_page" below is called each time the game interface is displayed to a player, ie:
 * _ when the game starts
 * _ when a player refreshes the game page (F5)
 *
 * "build_page" method allows you to dynamically modify the HTML generated for the game interface. In
 * particular, you can set here the values of variables elements defined in paxpamir_paxpamir.tpl (elements
 * like {MY_VARIABLE_ELEMENT}), and insert HTML block elements (also defined in your HTML template file)
 *
 * Note: if the HTML of your game interface is always the same, you don't have to place anything here.
 *
 */
  
  require_once( APP_BASE_PATH."view/common/game.view.php" );
  
  class view_paxpamir_paxpamir extends game_view
  {
    function getGameName() {
        return "paxpamir";
    }    
    function getTemplateName() {
      return self::getGameName() . "_" . self::getGameName();
    }   
  	function build_page( $viewArgs )
  	{		
  	    // Get players & players number
        $players = $this->game->loadPlayersBasicInfos();
        $players_nbr = count( $players );
        global $g_user;
        $cplayer = $g_user->get_id();

        /*********** Place your code below:  ************/

        $template = self::getTemplateName();

        $this->page->begin_block($template, "market_card" );

        $hor_scale = 179+21;
        $ver_scale = 251+15;

        for( $x=0; $x<=5; $x++ )
        {
          for( $y=0; $y<=1; $y++ )
          {
            $this->page->insert_block( "market_card", array(
              'ROW' => $y,
              'COL' => $x,
              'LEFT' => round( $x*$hor_scale )+ 28,
              'TOP' => round( $y*$ver_scale ) + 77,
            ) );
          }
        }

        $this->page->begin_block($template, "region" );

        foreach ($this->game->token_types as $token => $token_info) {
          if ($token_info['type'] == 'region') {
            $this->page->insert_block( "region", array(
              'ID' => $token,
              'LEFT' => $token_info['left'],
              'TOP' => $token_info['top'],
              'WIDTH' => $token_info['width'],
              'HEIGHT' => $token_info['height'],
            ) );
          }
        };

        $this->page->begin_block($template, "border" );

        foreach ($this->game->token_types as $token => $token_info) {
          if ($token_info['type'] == 'border') {
            $this->page->insert_block( "border", array(
              'ID' => $token,
              'LEFT' => $token_info['left'],
              'TOP' => $token_info['top'],
              'WIDTH' => $token_info['width'],
              'HEIGHT' => $token_info['height'],
            ) );
          }
        };

        $this->page->begin_block($template, "player");
        
        if (isset($players [$cplayer])) { // may be not set if spectator
            $player_id = $cplayer;
        } else {
            $player_id = $this->game->getNextPlayerTable()[0];
        }

        for ($x = 0; $x < $players_nbr; $x++) {
            $this->page->insert_block("player", array (
                "PLAYER_ID" => $player_id,
                "PLAYER_NAME" => $players[$player_id]['player_name'],
                "PLAYER_COLOR" => $players[$player_id]['player_color']
            ));            
            $player_id = $this->game->getPlayerAfter($player_id);
        }

        /*********** Do not change anything below this line  ************/
  	}
  }
  

