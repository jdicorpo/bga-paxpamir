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
    
        <div id="market" class="market">
            <!-- BEGIN market_card -->
            <div id="market_{ROW}_{COL}" class="card market_card" style="left:{LEFT}px; top:{TOP}px;">
                <div id="market_rupees_{ROW}_{COL}" class="market_rupees"></div>
            </div>
            <!-- END market_card -->
        </div>
        <div id="board">
            <!-- BEGIN region -->
            <div id="{ID}" class="region" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END region -->
            <!-- BEGIN border -->
            <div id="{ID}" class="border" style="left:{LEFT}px; top:{TOP}px; width:{WIDTH}px; height:{HEIGHT}px;"></div>
            <!-- END border -->
            <div id="british_army"></div>
        </div>

    </div>

    <div id="player_area_wrapper">
 
    </div>

</div>


<script type="text/javascript">

// Javascript HTML templates

/*
// Example:
var jstpl_some_game_item='<div class="my_game_item" id="my_game_item_${MY_ITEM_ID}"></div>';

*/

</script>  

{OVERALL_GAME_FOOTER}
