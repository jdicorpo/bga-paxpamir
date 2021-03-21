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
            <!-- <img id="map" src='img/paxpamir_board.jpg' border="0" width="1054" height="692" orgWidth="1054" orgHeight="692" usemap="#transcapia" alt="" />
            <map name="transcapia" id="map_transcapia">
            <area shape="poly" coords="83,84,115,84,152,84,237,83,338,85,445,85,458,84,460,103,460,125,460,150,459,177,456,195,454,225,447,248,442,271,431,285,417,289,410,292,400,299,392,306,381,315,371,323,357,329,347,338,338,343,328,351,320,363,312,373,303,385,297,389,286,390,276,387,262,384,249,380,233,375,220,371,203,367,191,365,174,365,160,362,147,360,134,361,121,360,109,361,99,361,88,362,79,363" style="outline:none;" target="_self"  \
                onmouseover="if(document.images) document.getElementById('map').src= '';" onmouseout="if(document.images) document.getElementById('map').src= 'img/paxpamir_board.jpg';"  />
            </map> -->

            <!-- BEGIN region -->
            <div id="{ID}" class="region" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END region -->
            <!-- BEGIN border -->
            <div id="{ID}" class="border" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END border -->
            <div id="favored_political" class="favored_suit"></div>
            <div id="favored_intelligence" class="favored_suit"></div>
            <div id="favored_economic" class="favored_suit"></div>
            <div id="favored_military" class="favored_suit"></div>
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
            <div id="loyalty_{PLAYER_ID}" class="player_loyalty_area">
                <div id="loyalty_wheel_{PLAYER_ID}" class="loyalty_wheel"></div>
                <div id="loyalty_holder_{PLAYER_ID}" class="loyalty_holder"></div>
            </div>
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
var jstpl_player_board = '\<div id="p_board_${id}" class="p_board">\
    <div id="p_board_icon_${id}" class="p_board_icons">\
    <div id="loyalty_icon_${id}" class="loyalty_icon"><span id="influence_${id}"  class="influence">0</span></div>\
    <div id="coins_${id}" class="coin_icon"><span id="coincount_${id}"  class="coincount">0</span></div>\
    <div id="tokens_${id}" class="token_icon" style="background-position:-${x}px 0"><span id="tokencount_${id}"  class="tokencount">0</span></div>\
    <div id="cards_${id}" class="card_icon"><span id="cardcount_${id}"  class="cardcount">0</span></div>\
    <div id="suits_${id}">\
        <div class="suit_icon economic"><span id="economic_${id}"  class="suitcount">0</span></div>\
        <div class="suit_icon military"><span id="military_${id}"  class="suitcount">0</span></div>\
        <div class="suit_icon political"><span id="political_${id}"  class="suitcount">0</span></div>\
        <div class="suit_icon intelligence"><span id="intelligence_${id}"  class="suitcount">0</span></div>\
    </div>\
</div>';
var jstpl_loyalty_icon='<div id="loyalty_icon_${id}" class="loyalty_icon" style="background-position:-${x}px 0"> \
    <span id="influence_${id}"  class="influence">0</span>\
    </div>';
var jstpl_loyalty_holder='<div id="loyalty_holder_${id}" class="loyalty_holder" style="background-position:-${x}px 0"></div>';

</script>  

{OVERALL_GAME_FOOTER}
