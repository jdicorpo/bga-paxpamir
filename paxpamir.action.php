<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * paxpamir implementation : © Jeff DiCorpo <jdicorpo@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 * 
 * paxpamir.action.php
 *
 * paxpamir main action entry point
 *
 *
 * In this file, you are describing all the methods that can be called from your
 * user interface logic (javascript).
 *       
 * If you define a method "myAction" here, then you can call it from your javascript code with:
 * this.ajaxcall( "/paxpamir/paxpamir/myAction.html", ...)
 *
 */
  
  
  class action_paxpamir extends APP_GameAction
  { 
    // Constructor: please do not modify
   	public function __default()
  	{
  	    if( self::isArg( 'notifwindow') )
  	    {
            $this->view = "common_notifwindow";
  	        $this->viewArgs['table'] = self::getArg( "table", AT_posint, true );
  	    }
  	    else
  	    {
            $this->view = "paxpamir_paxpamir";
            self::trace( "Complete reinitialization of board game" );
      }
    } 
    
    public function purchaseCard()
    {
        self::setAjaxMode();     
        $card_id = self::getArg( "card_id", AT_alphanum, true );
        $result = $this->game->purchaseCard($card_id);
        self::ajaxResponse( );
    }

    public function playCard()
    {
        self::setAjaxMode();     
        $card_id = self::getArg( "card_id", AT_alphanum, true );
        $result = $this->game->playCard($card_id);
        self::ajaxResponse( );
    }

    public function passAction()
    {
        self::setAjaxMode();
        $result = $this->game->passAction();
        self::ajaxResponse( );
    }

  }
  

