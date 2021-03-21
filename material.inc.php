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
 * material.inc.php
 *
 * paxpamir game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */


/*

Example:

$this->card_types = array(
    1 => array( "card_name" => ...,
                ...
              )
);

*/

$this->loyalty = array(
  'afghan' => array(
      'name' => clienttranslate("Afghan"),
      'icon' => 0,
      'tooltip' => clienttranslate("Afghan")
  ),
  'russian' => array(
      'name' => clienttranslate("Russian"),
      'icon' => 1,
      'tooltip' => clienttranslate("Russian")
  ),
  'british' => array(
      'name' => clienttranslate("British"),
      'icon' => 2,
      'tooltip' => clienttranslate("British")
  ),
);

$this->suits = array(
  0 => array(
      'suit' => 'political',
      'name' => clienttranslate("Political"),
      'tooltip' => clienttranslate("The favored suit is Political")
  ),
  1 => array(
      'suit' => 'intelligence',
      'name' => clienttranslate("Intelligence"),
      'tooltip' => clienttranslate("The favored suit is Intelligence")
  ),
  2 => array(
      'suit' => 'economic',
      'name' => clienttranslate("Economic"),
      'tooltip' => clienttranslate("The favored suit is Economic")
  ),
  3 => array(
    'suit' => 'military',
    'name' => clienttranslate("Military"),
    'tooltip' => clienttranslate("The favored suit is Military.  The cost to purchase in the market is doubled.")
  ),
);

$this->token_types = array(
// --- gen php begin ---
'deck' => array(
  'type' => 'deck',
  'name' => clienttranslate("Deck"),
  'tooltip' => clienttranslate("Player's Card Deck"),
  'loc'=>2,'content'=>0,'counter'=>1 ,
),
'discard' => array(
  'type' => 'discard',
  'name' => clienttranslate("Discard"),
  'tooltip' => clienttranslate("Player's Discard Pile"),
  'loc'=>2,'content'=>1,'counter'=>1 ,
),
'hand' => array(
  'type' => 'hand',
  'name' => '',
  'loc'=>2,'content'=>2,'counter'=>1 ,
),
'player_1' => array(
  'type' => 'player',
  'name' => clienttranslate("red"),
  'color' => 'd30505', 'idx' => 0,
),
'player_2' => array(
  'type' => 'player',
  'name' => clienttranslate("blue"),
  'color' => '305a72', 'idx' => 0,
),
'player_3' => array(
  'type' => 'player',
  'name' => clienttranslate("tan"),
  'color' => 'd30505', 'idx' => 0,
),
'player_4' => array(
  'type' => 'player',
  'name' => clienttranslate("gray"),
  'color' => 'd30505', 'idx' => 0,
),
'player_5' => array(
  'type' => 'player',
  'name' => clienttranslate("black"),
  'color' => 'd30505', 'idx' => 0,
),
'token_colors' => array(
  'type' => 'token_colors',
  'name' => clienttranslate("token_colors"),
   'd30505' => 3, '305a72' => 1, 'cfa580' => 4, '6b6663' => 2, '292623' => 0 ,
),
'transcaspia' => array(
  'type' => 'region',
  'name' => clienttranslate("Transcaspia"),
  'left' => 100, 'top' => 100, 'width' => 270, 'height' => 220, 'borders' => 'persia, herat, kabul',
),
'kabul' => array(
  'type' => 'region',
  'name' => clienttranslate("Kabul"),
  'left' => 500, 'top' => 100, 'width' => 300, 'height' => 200, 'borders' => 'transcaspia, herat, kandahar, punjab',
),
'persia' => array(
  'type' => 'region',
  'name' => clienttranslate("Persia"),
  'left' => 100, 'top' => 400, 'width' => 180, 'height' => 200, 'borders' => 'transcaspia, herat',
),
'herat' => array(
  'type' => 'region',
  'name' => clienttranslate("Herat"),
  'left' => 330, 'top' => 370, 'width' => 200, 'height' => 230, 'borders' => 'persia, transcaspia, kabul, kandahar',
),
'kandahar' => array(
  'type' => 'region',
  'name' => clienttranslate("Kandahar"),
  'left' => 600, 'top' => 400, 'width' => 200, 'height' => 200, 'borders' => 'herat, kabul, punjab',
),
'punjab' => array(
  'type' => 'region',
  'name' => clienttranslate("Punjab"),
  'left' => 860, 'top' => 280, 'width' => 100, 'height' => 320, 'borders' => 'kabul, kandahar',
),
'border_transcaspia_kabul' => array(
  'type' => 'border',
  'name' => clienttranslate("Transcaspia-Kabul Border"),
  'left' => 410, 'top' => 100, 'width' => 75, 'height' => 200, 'regions' => 'transcaspia, kabul',
),
'border_kabul_punjab' => array(
  'type' => 'border',
  'name' => clienttranslate("Kabul-Punjab Border"),
  'left' => 820, 'top' => 100, 'width' => 100, 'height' => 250, 'regions' => 'transcaspia, kabul',
),
'border_transcaspia_herat' => array(
  'type' => 'border',
  'name' => clienttranslate("Transcaspia-Herat Border"),
  'left' => 280, 'top' => 280, 'width' => 150, 'height' => 100, 'regions' => 'transcaspia, herat',
),
'border_herat_kabul' => array(
  'type' => 'border',
  'name' => clienttranslate("Herat-Kabul Border"),
  'left' => 440, 'top' => 280, 'width' => 150, 'height' => 100, 'regions' => 'transcaspia, herat',
),
'border_transcaspia_persia' => array(
  'type' => 'border',
  'name' => clienttranslate("Transcaspia-Persia Border"),
  'left' => 100, 'top' => 330, 'width' => 200, 'height' => 60, 'regions' => 'transcaspia, persia',
),
'border_kandahar_kabul' => array(
  'type' => 'border',
  'name' => clienttranslate("Kandahar-Kabul Border"),
  'left' => 590, 'top' => 330, 'width' => 200, 'height' => 60, 'regions' => 'transcaspia, persia',
),
'border_persia_herat' => array(
  'type' => 'border',
  'name' => clienttranslate("Persia-Herat Border"),
  'left' => 280, 'top' => 400, 'width' => 60, 'height' => 200, 'regions' => 'herat, persia',
),
'border_herat_kandahar' => array(
  'type' => 'border',
  'name' => clienttranslate("Herat-Kandahar Border"),
  'left' => 540, 'top' => 400, 'width' => 60, 'height' => 200, 'regions' => 'herat, persia',
),
'border_kandahar_punjab' => array(
  'type' => 'border',
  'name' => clienttranslate("Kandahar-Punjab Border"),
  'left' => 800, 'top' => 400, 'width' => 60, 'height' => 200, 'regions' => 'herat, persia',
),
'special_1' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_2' => array(
  'type' => 'special',
  'name' => clienttranslate("Insurrection"),
  'tooltip' => clienttranslate("After resolving a Dominance Check, place two Afghan armies in Kabul."),
),
'special_3' => array(
  'type' => 'special',
  'name' => clienttranslate("Claim of Ancient Lineage"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_4' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_5' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_6' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_7' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_8' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_9' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_10' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_11' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_12' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_13' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_14' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'special_15' => array(
  'type' => 'special',
  'name' => clienttranslate("Indispensable Advisors"),
  'tooltip' => clienttranslate("Your spies cannot be removed in battles with other spies."),
),
'card_1' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Mohan Lal"),
  'region' => 'kabul',
  'suit' => 'intelligence',
  'rank' => 3,
  'impact' => 's,s,s',
  'actions' => 'mv',
  'special' => 1,
  'prize' => 'ru',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_2' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Jan-Fishan Khan"),
  'region' => 'kabul',
  'suit' => 'intelligence',
  'rank' => 2,
  'impact' => 's,s,a,fm',
  'actions' => 'ba,mv',
  'prize' => 'ru',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_3' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Prince Akbar Khan"),
  'region' => 'kabul',
  'suit' => 'intelligence',
  'rank' => 2,
  'impact' => 's,s,a',
  'actions' => 'ba',
  'special' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_4' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Charles Stoddart"),
  'region' => 'kabul',
  'suit' => 'intelligence',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_5' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Shah Shujah Durrani"),
  'region' => 'kabul',
  'suit' => 'political',
  'tooltip_action' => clienttranslate("political"),
),
'card_6' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Aminullah Khan Logari"),
  'region' => 'kabul',
  'suit' => 'political',
  'tooltip_action' => clienttranslate("political"),
),
'card_7' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Dost Mohammad"),
  'region' => 'kabul',
  'suit' => 'political',
  'tooltip_action' => clienttranslate("political"),
),
'card_8' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Kabul Bazaar"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_9' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Afghan Handicrafts"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_10' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Balkh Arsenic Mine"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_11' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Lapis Lazuli Mine"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_12' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("City of Ghazni"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_13' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Ghilzai Nomads"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_14' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Money Lenders"),
  'region' => 'kabul',
  'suit' => 'economic',
  'tooltip_action' => clienttranslate("economic"),
),
'card_15' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Durrani Royal Guard"),
  'region' => 'kabul',
  'suit' => 'military',
  'tooltip_action' => clienttranslate("military"),
),
'card_16' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Bala Hissar"),
  'region' => 'kabul',
  'suit' => 'military',
  'tooltip_action' => clienttranslate("military"),
),
'card_17' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Citadel of Ghazni"),
  'region' => 'kabul',
  'suit' => 'military',
  'tooltip_action' => clienttranslate("military"),
),
'card_18' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Harry Flashman"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '1',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_19' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Eldred Pottinger"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '1',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_20' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Henry Rawlinson"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '1',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_21' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Alexander Burnes"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '2',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_22' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("George Hayward"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '1',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_23' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Henry Pottinger"),
  'region' => 'punjab',
  'suit' => 'intelligence',
  'impact' => '1',
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_24' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Ranjit Singh"),
  'region' => 'punjab',
  'suit' => 'political',
  'rank' => 2,
  'tooltip_action' => clienttranslate("political"),
),
'card_25' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Josiah Harlan"),
  'region' => 'punjab',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_26' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Paolo Avitabile"),
  'region' => 'punjab',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_27' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Maqpon Dynasty"),
  'region' => 'punjab',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_28' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Anarkali Bazaar"),
  'region' => 'punjab',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_29' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Khyber Pass"),
  'region' => 'punjab',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_30' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Sikh Merchants in Lahore"),
  'region' => 'punjab',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_31' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Company Weapons"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_32' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Army of the Indus"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 3,
  'tooltip_action' => clienttranslate("military"),
),
'card_33' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Zorawar Singh Kahluria"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_34' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Sindhi Warriors"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_35' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Hari Singh Nalwa"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_36' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Bengal Native Infantry"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_37' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Seaforth Highlanders"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_38' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Akali Sikhs"),
  'region' => 'punjab',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_39' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("William Moorcroft"),
  'region' => 'kandahar',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_40' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("William Hay Macnaghten"),
  'region' => 'kandahar',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_41' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Charles Masson"),
  'region' => 'kandahar',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_42' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Barakzai Sadars"),
  'region' => 'kandahar',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_43' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Giljee Nobles"),
  'region' => 'kandahar',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_44' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Baluchi Chiefs"),
  'region' => 'kandahar',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_45' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Haji Khan Kakar"),
  'region' => 'kandahar',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_46' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Bank"),
  'region' => 'kandahar',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_47' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Bolan Pass"),
  'region' => 'kandahar',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_48' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Fruit Markets"),
  'region' => 'kandahar',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_49' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Kandahari Markets"),
  'region' => 'kandahar',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_50' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("British Regulars"),
  'region' => 'kandahar',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_51' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Sir John Keane"),
  'region' => 'kandahar',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_52' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Pashtun Mercenary"),
  'region' => 'kandahar',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_53' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Jezail Sharpshooters"),
  'region' => 'kandahar',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_54' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Herati Bandits"),
  'region' => 'herat',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_55' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Hazara Chiefs"),
  'region' => 'herat',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_56' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Yar Mohammad Alikozai"),
  'region' => 'herat',
  'suit' => 'political',
  'rank' => 2,
  'tooltip_action' => clienttranslate("political"),
),
'card_57' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Exiled Durrani Nobility"),
  'region' => 'herat',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_58' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Ishaqzai Chiefs"),
  'region' => 'herat',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_59' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Tajik Warband"),
  'region' => 'herat',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_60' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Nomadic Warlord"),
  'region' => 'herat',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_61' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Karakul Sheep"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_62' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Qanat System"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_63' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Farah Road"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 3,
  'tooltip_action' => clienttranslate("economic"),
),
'card_64' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Opium Fields"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_65' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Minaret of Jam"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_66' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Baluchi Smugglers"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_67' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Wheat Fields"),
  'region' => 'herat',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_68' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Ghaem Magham Farahani"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_69' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Count Ivan Simonich"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_70' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Alexander Griboyedov"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_71' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Joseph Wolf"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_72' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Claude Wade"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_73' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Jean-François Allard"),
  'region' => 'persia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_74' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Hajj Mirza Aghasi"),
  'region' => 'persia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_75' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Abbas Mirza"),
  'region' => 'persia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_76' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Fath-Ali Shah"),
  'region' => 'persia',
  'suit' => 'political',
  'rank' => 2,
  'tooltip_action' => clienttranslate("political"),
),
'card_77' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Mohammad Shah"),
  'region' => 'persia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_78' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Civic Improvements"),
  'region' => 'persia',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_79' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Persian Slave Markets"),
  'region' => 'persia',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_80' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Anglo-Persian Trade"),
  'region' => 'persia',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_81' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Russo-Persian Trade"),
  'region' => 'persia',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_82' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Persian Army"),
  'region' => 'persia',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_83' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Shah’s Guard"),
  'region' => 'persia',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_84' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Russian Regulars"),
  'region' => 'persia',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_85' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Bukharan Jews"),
  'region' => 'transcaspia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_86' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Jan Prosper Witkiewicz"),
  'region' => 'transcaspia',
  'suit' => 'intelligence',
  'rank' => 2,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_87' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Imperial Surveyors"),
  'region' => 'transcaspia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_88' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Arthur Conolly"),
  'region' => 'transcaspia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_89' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Aga Mehdi"),
  'region' => 'transcaspia',
  'suit' => 'intelligence',
  'rank' => 1,
  'tooltip_action' => clienttranslate("intelligence"),
),
'card_90' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Nasrullah Khan"),
  'region' => 'transcaspia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_91' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Allah Quli Bahadur"),
  'region' => 'transcaspia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_92' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Mir Murad Beg"),
  'region' => 'transcaspia',
  'suit' => 'political',
  'rank' => 1,
  'tooltip_action' => clienttranslate("political"),
),
'card_93' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Madali Khan"),
  'region' => 'transcaspia',
  'suit' => 'political',
  'rank' => 2,
  'tooltip_action' => clienttranslate("political"),
),
'card_94' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Khivan Slave Markets"),
  'region' => 'transcaspia',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_95' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Supplies from Orenburg"),
  'region' => 'transcaspia',
  'suit' => 'economic',
  'rank' => 1,
  'tooltip_action' => clienttranslate("economic"),
),
'card_96' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Panjdeh Oasis"),
  'region' => 'transcaspia',
  'suit' => 'economic',
  'rank' => 2,
  'tooltip_action' => clienttranslate("economic"),
),
'card_97' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("The Ark of Bukhara"),
  'region' => 'transcaspia',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_98' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("European Cannons"),
  'region' => 'transcaspia',
  'suit' => 'military',
  'rank' => 3,
  'tooltip_action' => clienttranslate("military"),
),
'card_99' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Cossacks"),
  'region' => 'transcaspia',
  'suit' => 'military',
  'rank' => 1,
  'tooltip_action' => clienttranslate("military"),
),
'card_100' => array(
  'type' => 'card court_card',
  'name' => clienttranslate("Count Perovsky"),
  'region' => 'transcaspia',
  'suit' => 'military',
  'rank' => 2,
  'tooltip_action' => clienttranslate("military"),
),
'card_101' => array(
  'type' => 'card event_card dom_check',
  'name' => clienttranslate("Dominance Check"),
),
'card_102' => array(
  'type' => 'card event_card dom_check',
  'name' => clienttranslate("Dominance Check"),
),
'card_103' => array(
  'type' => 'card event_card dom_check',
  'name' => clienttranslate("Dominance Check"),
),
'card_104' => array(
  'type' => 'card event_card dom_check',
  'name' => clienttranslate("Dominance Check"),
),
'card_105' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Favor Military', 'purchased' => 'New Tactics',
),
'card_106' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Embarrassment of Riches', 'purchased' => 'Koh-i-noor Recovered',
),
'card_107' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Disregard for Customs', 'purchased' => 'Courtly Manners',
),
'card_108' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Failure to Impress', 'purchased' => 'Rumor',
),
'card_109' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Riots in Punjab', 'purchased' => 'Conflict Fatigue',
),
'card_110' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Riots in Herat', 'purchased' => 'Nationalism',
),
'card_111' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'No Effect', 'purchased' => 'Public Withdrawal',
),
'card_112' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Riots in Kabul', 'purchased' => 'Nation Building',
),
'card_113' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Riots in Persia', 'purchased' => 'Backing of Persian Aristocracy',
),
'card_114' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Confidence Failure', 'purchased' => 'Other Persuasive Methods',
),
'card_115' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Favor Intelligence', 'purchased' => 'Pashtunwali Values',
),
'card_116' => array(
  'type' => 'card event_card',
  'name' => clienttranslate("Event Card"),
  'discarded' => 'Favor Political', 'purchased' => 'Rebuke',
),
// --- gen php end --- 
);




