{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- paxpamir implementation : © Jeff DiCorpo <jdicorpo@gmail.com>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    paxpamir_paxpamir.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->


<div id="thething" class="thething">
    <div id="board_wrapper" class="board_wrapper">
    
        <div id="market_wrapper" class="market_wrapper">
            <div id="market" class="market">
                <!-- BEGIN market_card -->
                <div id="market_{ROW}_{COL}" class="card" style="left:{LEFT}px; top:{TOP}px;">
                    <!-- <div id="market_rupees_{ROW}_{COL}" class="market_rupees"></div> -->
                </div>
                <!-- END market_card -->
                <div id="deck" class="card"></div>
                <div id="discard" class="card"></div>
            </div>
        </div>
        <div id="board">
            <!-- BEGIN region -->
            <div id="{ID}" class="region" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END region -->
            <!-- BEGIN border -->
            <div id="{ID}" class="border" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END border -->
            <div id="british_army"></div>
            <div id="token_black" class="token"></div>
            <div id="token_gray" class="token"></div>
            <div id="token_red" class="token"></div>
            <div id="token_blue" class="token"></div>
            <div id="token_tan" class="token"></div>
        </div>

    </div>

    <div id="player_hand_area" class="player_area whiteblock">
        <div class="side_title_wrapper">
            <div class="side_title color_{PLAYER_COLOR}">MY HAND</div>
        </div>
        <div id="title_sep_{PLAYER_COLOR}"></div>
        <div id="player_hand" class="player_card_area"></div>
    </div>

    <div id="player_area_wrapper">
         <!-- BEGIN player -->
         <div id="player_area" class="player_area whiteblock">
             <!-- <h3> {PLAYER_NAME} </h3> -->
            <div class="side_title_wrapper">
                <div id="player_area_{PLAYER_COLOR}" class="side_title color_{PLAYER_COLOR}">{PLAYER_NAME}'s Court</div>
            </div>
            <div id="title_sep_{PLAYER_COLOR}"></div>
            <!-- <div id="player_adventurer_{PLAYER_ID}" class="player_adventurer"></div> -->
            <div id="court_{PLAYER_ID}" class="player_card_area"></div>
            <div id="tokens_{PLAYER_ID}" class="player_token_area"></div>
            <!-- <div id="player_figure_area_{PLAYER_ID}" class="player_figure_area"></div> -->
        </div>
        <!-- END player -->    
    </div>

</div>


<script type="text/javascript">

// Javascript HTML templates

/*
// Example:
var jstpl_some_game_item='<div class="my_game_item" id="my_game_item_${MY_ITEM_ID}"></div>';

*/
var jstpl_coin='<div id="${id}" class="token coin" style="background-position:-250px 0"></div>';
var jstpl_token='<div id="${id}" class="token coin" style="background-position:-${x}px 0"></div>';

</script>  

{OVERALL_GAME_FOOTER}
