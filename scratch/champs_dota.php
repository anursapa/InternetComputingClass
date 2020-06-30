<?php include_once "header.inc.php" ?>

<div class="container-fluid">
    <div class="row">

        <?php include_once "sidebar.inc.php" ?>

        <div id="admin-main-control" class="col-md-10 p-x-3 p-y-1">
            <div class="content-title m-x-auto">
                <i class="fa fa-dashboard"></i> Champions
            </div>
            <p class="display-4">Dota2 Heros</p>
            <div id="heroPickerInner">
									<div id="heroBioArea"><div id="bioBoxFade"></div>

										<div style="" id="heroBioDynamic">

											<div class="bioBoxHR"></div>
											<p id="heroBioRoles"><span class="bioTextAttack">Ranged</span> - Support - Nuker - Disabler - Escape</p>
																					</div>
									</div>
									<div id="heroFilterArea">
										Filter&nbsp;&nbsp;&nbsp;
										<select onchange="updateFilters()" id="filterRole" class="filterSelect" name="">
											<option value="">By Role</option>
											<option value="">All</option>
																						<option value="Carry">Carry</option>
																						<option value="Disabler">Disabler</option>
																						<option value="LaneSupport">Lane Support</option>
																						<option value="Initiator">Initiator</option>
																						<option value="Jungler">Jungler</option>
																						<option value="Support">Support</option>
																						<option value="Durable">Durable</option>
																						<option value="Nuker">Nuker</option>
																						<option value="Pusher">Pusher</option>
																						<option value="Escape">Escape</option>
																					</select>&nbsp;&nbsp;&nbsp;
										<select onchange="updateFilters()" id="filterAttack" class="filterSelect" name="">
											<option value="">By Attack type</option>
											<option value="">All</option>
											<option value="melee">Melee</option>
											<option value="ranged">Ranged</option>
										</select>&nbsp;&nbsp;&nbsp;
										<select onchange="updateFilters()" id="filterName" class="filterSelect noCaps" name=""><option value="" selected="selected">HERO NAME</option><option value="">All</option><option value="abaddon" style="color: rgb(153, 153, 153);">Abaddon</option><option value="alchemist" style="color: rgb(153, 153, 153);">Alchemist</option><option value="ancient_apparition" style="color: rgb(153, 153, 153);">Ancient Apparition</option><option value="antimage" style="color: rgb(153, 153, 153);">Anti-Mage</option><option value="arc_warden" style="color: rgb(153, 153, 153);">Arc Warden</option><option value="axe" style="color: rgb(153, 153, 153);">Axe</option><option value="bane" style="color: rgb(153, 153, 153);">Bane</option><option value="batrider" style="color: rgb(153, 153, 153);">Batrider</option><option value="beastmaster" style="color: rgb(153, 153, 153);">Beastmaster</option><option value="bloodseeker" style="color: rgb(153, 153, 153);">Bloodseeker</option><option value="bounty_hunter" style="color: rgb(153, 153, 153);">Bounty Hunter</option><option value="brewmaster" style="color: rgb(153, 153, 153);">Brewmaster</option><option value="bristleback" style="color: rgb(153, 153, 153);">Bristleback</option><option value="broodmother" style="color: rgb(153, 153, 153);">Broodmother</option><option value="centaur" style="color: rgb(153, 153, 153);">Centaur Warrunner</option><option value="chaos_knight" style="color: rgb(153, 153, 153);">Chaos Knight</option><option value="chen" style="color: rgb(153, 153, 153);">Chen</option><option value="clinkz" style="color: rgb(153, 153, 153);">Clinkz</option><option value="rattletrap" style="color: rgb(153, 153, 153);">Clockwerk</option><option value="crystal_maiden" style="color: rgb(153, 153, 153);">Crystal Maiden</option><option value="dark_seer" style="color: rgb(153, 153, 153);">Dark Seer</option><option value="dark_willow" style="color: rgb(153, 153, 153);">Dark Willow</option><option value="dazzle" style="color: rgb(153, 153, 153);">Dazzle</option><option value="death_prophet" style="color: rgb(153, 153, 153);">Death Prophet</option><option value="disruptor" style="color: rgb(153, 153, 153);">Disruptor</option><option value="doom_bringer" style="color: rgb(153, 153, 153);">Doom</option><option value="dragon_knight" style="color: rgb(153, 153, 153);">Dragon Knight</option><option value="drow_ranger" style="color: rgb(153, 153, 153);">Drow Ranger</option><option value="earth_spirit" style="color: rgb(153, 153, 153);">Earth Spirit</option><option value="earthshaker" style="color: rgb(153, 153, 153);">Earthshaker</option><option value="elder_titan" style="color: rgb(153, 153, 153);">Elder Titan</option><option value="ember_spirit" style="color: rgb(153, 153, 153);">Ember Spirit</option><option value="enchantress" style="color: rgb(153, 153, 153);">Enchantress</option><option value="enigma" style="color: rgb(153, 153, 153);">Enigma</option><option value="faceless_void" style="color: rgb(153, 153, 153);">Faceless Void</option><option value="grimstroke" style="color: rgb(153, 153, 153);">Grimstroke</option><option value="gyrocopter" style="color: rgb(153, 153, 153);">Gyrocopter</option><option value="huskar" style="color: rgb(153, 153, 153);">Huskar</option><option value="invoker" style="color: rgb(153, 153, 153);">Invoker</option><option value="wisp" style="color: rgb(153, 153, 153);">Io</option><option value="jakiro" style="color: rgb(153, 153, 153);">Jakiro</option><option value="juggernaut" style="color: rgb(153, 153, 153);">Juggernaut</option><option value="keeper_of_the_light" style="color: rgb(153, 153, 153);">Keeper of the Light</option><option value="kunkka" style="color: rgb(153, 153, 153);">Kunkka</option><option value="legion_commander" style="color: rgb(153, 153, 153);">Legion Commander</option><option value="leshrac" style="color: rgb(153, 153, 153);">Leshrac</option><option value="lich" style="color: rgb(153, 153, 153);">Lich</option><option value="life_stealer" style="color: rgb(153, 153, 153);">Lifestealer</option><option value="lina" style="color: rgb(153, 153, 153);">Lina</option><option value="lion" style="color: rgb(153, 153, 153);">Lion</option><option value="lone_druid" style="color: rgb(153, 153, 153);">Lone Druid</option><option value="luna" style="color: rgb(153, 153, 153);">Luna</option><option value="lycan" style="color: rgb(153, 153, 153);">Lycan</option><option value="magnataur" style="color: rgb(153, 153, 153);">Magnus</option><option value="mars" style="color: rgb(153, 153, 153);">Mars</option><option value="medusa" style="color: rgb(153, 153, 153);">Medusa</option><option value="meepo" style="color: rgb(153, 153, 153);">Meepo</option><option value="mirana" style="color: rgb(153, 153, 153);">Mirana</option><option value="monkey_king" style="color: rgb(153, 153, 153);">Monkey King</option><option value="morphling" style="color: rgb(153, 153, 153);">Morphling</option><option value="naga_siren" style="color: rgb(153, 153, 153);">Naga Siren</option><option value="furion" style="color: rgb(153, 153, 153);">Nature's Prophet</option><option value="necrolyte" style="color: rgb(153, 153, 153);">Necrophos</option><option value="night_stalker" style="color: rgb(153, 153, 153);">Night Stalker</option><option value="nyx_assassin" style="color: rgb(153, 153, 153);">Nyx Assassin</option><option value="ogre_magi" style="color: rgb(153, 153, 153);">Ogre Magi</option><option value="omniknight" style="color: rgb(153, 153, 153);">Omniknight</option><option value="oracle" style="color: rgb(153, 153, 153);">Oracle</option><option value="obsidian_destroyer" style="color: rgb(153, 153, 153);">Outworld Devourer</option><option value="pangolier" style="color: rgb(153, 153, 153);">Pangolier</option><option value="phantom_assassin" style="color: rgb(153, 153, 153);">Phantom Assassin</option><option value="phantom_lancer" style="color: rgb(153, 153, 153);">Phantom Lancer</option><option value="phoenix" style="color: rgb(153, 153, 153);">Phoenix</option><option value="puck" style="color: rgb(153, 153, 153);">Puck</option><option value="pudge" style="color: rgb(153, 153, 153);">Pudge</option><option value="pugna" style="color: rgb(153, 153, 153);">Pugna</option><option value="queenofpain" style="color: rgb(153, 153, 153);">Queen of Pain</option><option value="razor" style="color: rgb(153, 153, 153);">Razor</option><option value="riki" style="color: rgb(153, 153, 153);">Riki</option><option value="rubick" style="color: rgb(153, 153, 153);">Rubick</option><option value="sand_king" style="color: rgb(153, 153, 153);">Sand King</option><option value="shadow_demon" style="color: rgb(153, 153, 153);">Shadow Demon</option><option value="nevermore" style="color: rgb(153, 153, 153);">Shadow Fiend</option><option value="shadow_shaman" style="color: rgb(153, 153, 153);">Shadow Shaman</option><option value="silencer" style="color: rgb(153, 153, 153);">Silencer</option><option value="skywrath_mage" style="color: rgb(153, 153, 153);">Skywrath Mage</option><option value="slardar" style="color: rgb(153, 153, 153);">Slardar</option><option value="slark" style="color: rgb(153, 153, 153);">Slark</option><option value="snapfire" style="color: rgb(153, 153, 153);">Snapfire</option><option value="sniper" style="color: rgb(153, 153, 153);">Sniper</option><option value="spectre" style="color: rgb(153, 153, 153);">Spectre</option><option value="spirit_breaker" style="color: rgb(153, 153, 153);">Spirit Breaker</option><option value="storm_spirit" style="color: rgb(153, 153, 153);">Storm Spirit</option><option value="sven" style="color: rgb(153, 153, 153);">Sven</option><option value="techies" style="color: rgb(153, 153, 153);">Techies</option><option value="templar_assassin" style="color: rgb(153, 153, 153);">Templar Assassin</option><option value="terrorblade" style="color: rgb(153, 153, 153);">Terrorblade</option><option value="tidehunter" style="color: rgb(153, 153, 153);">Tidehunter</option><option value="shredder" style="color: rgb(153, 153, 153);">Timbersaw</option><option value="tinker" style="color: rgb(153, 153, 153);">Tinker</option><option value="tiny" style="color: rgb(153, 153, 153);">Tiny</option><option value="treant" style="color: rgb(153, 153, 153);">Treant Protector</option><option value="troll_warlord" style="color: rgb(153, 153, 153);">Troll Warlord</option><option value="tusk" style="color: rgb(153, 153, 153);">Tusk</option><option value="abyssal_underlord" style="color: rgb(153, 153, 153);">Underlord</option><option value="undying" style="color: rgb(153, 153, 153);">Undying</option><option value="ursa" style="color: rgb(153, 153, 153);">Ursa</option><option value="vengefulspirit" style="color: rgb(153, 153, 153);">Vengeful Spirit</option><option value="venomancer" style="color: rgb(153, 153, 153);">Venomancer</option><option value="viper" style="color: rgb(153, 153, 153);">Viper</option><option value="visage" style="color: rgb(153, 153, 153);">Visage</option><option value="void_spirit" style="color: rgb(153, 153, 153);">Void Spirit</option><option value="warlock" style="color: rgb(153, 153, 153);">Warlock</option><option value="weaver" style="color: rgb(153, 153, 153);">Weaver</option><option value="windrunner" style="color: rgb(153, 153, 153);">Windranger</option><option value="winter_wyvern" style="color: rgb(153, 153, 153);">Winter Wyvern</option><option value="witch_doctor" style="color: rgb(153, 153, 153);">Witch Doctor</option><option value="skeleton_king" style="color: rgb(153, 153, 153);">Wraith King</option><option value="zuus" style="color: rgb(153, 153, 153);">Zeus</option></select>
									</div>
									<div class="heroColLeft">
										<div id="columnHeader"><span id="columnHeaderTextStr">Strength</span></div>
										<div class="heroIcons">
																						<a id="link_earthshaker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/earthshaker/">
												<img id="hover_earthshaker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/earthshaker_hphover.png?v=5800661">
												<img id="base_earthshaker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/earthshaker_sb.png?v=5800661">
											</a>
																						<a id="link_sven" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/sven/">
												<img id="hover_sven" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/sven_hphover.png?v=5800661">
												<img id="base_sven" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/sven_sb.png?v=5800661">
											</a>
																						<a id="link_tiny" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/tiny/">
												<img id="hover_tiny" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/tiny_hphover.png?v=5800661">
												<img id="base_tiny" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/tiny_sb.png?v=5800661">
											</a>
																						<a id="link_kunkka" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/kunkka/">
												<img id="hover_kunkka" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/kunkka_hphover.png?v=5800661">
												<img id="base_kunkka" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/kunkka_sb.png?v=5800661">
											</a>
																						<a id="link_beastmaster" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/beastmaster/">
												<img id="hover_beastmaster" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/beastmaster_hphover.png?v=5800661">
												<img id="base_beastmaster" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/beastmaster_sb.png?v=5800661">
											</a>
																						<a id="link_dragon_knight" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/dragon_knight/">
												<img id="hover_dragon_knight" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/dragon_knight_hphover.png?v=5800661">
												<img id="base_dragon_knight" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/dragon_knight_sb.png?v=5800661">
											</a>
																						<a id="link_rattletrap" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/rattletrap/">
												<img id="hover_rattletrap" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/rattletrap_hphover.png?v=5800661">
												<img id="base_rattletrap" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/rattletrap_sb.png?v=5800661">
											</a>
																						<a id="link_omniknight" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/omniknight/">
												<img id="hover_omniknight" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/omniknight_hphover.png?v=5800661">
												<img id="base_omniknight" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/omniknight_sb.png?v=5800661">
											</a>
																						<a id="link_huskar" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/huskar/">
												<img id="hover_huskar" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/huskar_hphover.png?v=5800661">
												<img id="base_huskar" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/huskar_sb.png?v=5800661">
											</a>
																						<a id="link_alchemist" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/alchemist/">
												<img id="hover_alchemist" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/alchemist_hphover.png?v=5800661">
												<img id="base_alchemist" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/alchemist_sb.png?v=5800661">
											</a>
																						<a id="link_brewmaster" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/brewmaster/">
												<img id="hover_brewmaster" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/brewmaster_hphover.png?v=5800661">
												<img id="base_brewmaster" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/brewmaster_sb.png?v=5800661">
											</a>
																						<a id="link_treant" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/treant/">
												<img id="hover_treant" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/treant_hphover.png?v=5800661">
												<img id="base_treant" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/treant_sb.png?v=5800661">
											</a>
																						<a id="link_wisp" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/wisp/">
												<img id="hover_wisp" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/wisp_hphover.png?v=5800661">
												<img id="base_wisp" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/wisp_sb.png?v=5800661">
											</a>
																						<a id="link_centaur" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/centaur/">
												<img id="hover_centaur" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/centaur_hphover.png?v=5800661">
												<img id="base_centaur" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/centaur_sb.png?v=5800661">
											</a>
																						<a id="link_shredder" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/shredder/">
												<img id="hover_shredder" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/shredder_hphover.png?v=5800661">
												<img id="base_shredder" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/shredder_sb.png?v=5800661">
											</a>
																						<a id="link_bristleback" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/bristleback/">
												<img id="hover_bristleback" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/bristleback_hphover.png?v=5800661">
												<img id="base_bristleback" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/bristleback_sb.png?v=5800661">
											</a>
																						<a id="link_tusk" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/tusk/">
												<img id="hover_tusk" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/tusk_hphover.png?v=5800661">
												<img id="base_tusk" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/tusk_sb.png?v=5800661">
											</a>
																						<a id="link_elder_titan" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/elder_titan/">
												<img id="hover_elder_titan" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/elder_titan_hphover.png?v=5800661">
												<img id="base_elder_titan" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/elder_titan_sb.png?v=5800661">
											</a>
																						<a id="link_legion_commander" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/legion_commander/">
												<img id="hover_legion_commander" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/legion_commander_hphover.png?v=5800661">
												<img id="base_legion_commander" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/legion_commander_sb.png?v=5800661">
											</a>
																						<a id="link_earth_spirit" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/earth_spirit/">
												<img id="hover_earth_spirit" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/earth_spirit_hphover.png?v=5800661">
												<img id="base_earth_spirit" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/earth_spirit_sb.png?v=5800661">
											</a>
																						<a id="link_phoenix" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/phoenix/">
												<img id="hover_phoenix" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/phoenix_hphover.png?v=5800661">
												<img id="base_phoenix" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/phoenix_sb.png?v=5800661">
											</a>
																						<a id="link_mars" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/mars/">
												<img id="hover_mars" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/mars_hphover.png?v=5800661">
												<img id="base_mars" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/mars_sb.png?v=5800661">
											</a>
																						<a id="link_snapfire" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/snapfire/">
												<img id="hover_snapfire" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/snapfire_hphover.png?v=5800661">
												<img id="base_snapfire" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/snapfire_sb.png?v=5800661">
											</a>
																					</div>
										<br clear="left">
									</div>
									<div class="heroColMiddle">
										<div id="columnHeader"><span id="columnHeaderTextAgi">Agility</span></div>
										<div class="heroIcons">
																						<a id="link_antimage" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/antimage/">
												<img id="hover_antimage" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/antimage_hphover.png?v=5800661">
												<img id="base_antimage" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/antimage_sb.png?v=5800661">
											</a>
																						<a id="link_drow_ranger" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/drow_ranger/">
												<img id="hover_drow_ranger" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/drow_ranger_hphover.png?v=5800661">
												<img id="base_drow_ranger" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/drow_ranger_sb.png?v=5800661">
											</a>
																						<a id="link_juggernaut" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/juggernaut/">
												<img id="hover_juggernaut" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/juggernaut_hphover.png?v=5800661">
												<img id="base_juggernaut" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/juggernaut_sb.png?v=5800661">
											</a>
																						<a id="link_mirana" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/mirana/">
												<img id="hover_mirana" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/mirana_hphover.png?v=5800661">
												<img id="base_mirana" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/mirana_sb.png?v=5800661">
											</a>
																						<a id="link_morphling" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/morphling/">
												<img id="hover_morphling" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/morphling_hphover.png?v=5800661">
												<img id="base_morphling" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/morphling_sb.png?v=5800661">
											</a>
																						<a id="link_phantom_lancer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/phantom_lancer/">
												<img id="hover_phantom_lancer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/phantom_lancer_hphover.png?v=5800661">
												<img id="base_phantom_lancer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/phantom_lancer_sb.png?v=5800661">
											</a>
																						<a id="link_vengefulspirit" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/vengefulspirit/">
												<img id="hover_vengefulspirit" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/vengefulspirit_hphover.png?v=5800661">
												<img id="base_vengefulspirit" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/vengefulspirit_sb.png?v=5800661">
											</a>
																						<a id="link_riki" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/riki/">
												<img id="hover_riki" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/riki_hphover.png?v=5800661">
												<img id="base_riki" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/riki_sb.png?v=5800661">
											</a>
																						<a id="link_sniper" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/sniper/">
												<img id="hover_sniper" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/sniper_hphover.png?v=5800661">
												<img id="base_sniper" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/sniper_sb.png?v=5800661">
											</a>
																						<a id="link_templar_assassin" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/templar_assassin/">
												<img id="hover_templar_assassin" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/templar_assassin_hphover.png?v=5800661">
												<img id="base_templar_assassin" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/templar_assassin_sb.png?v=5800661">
											</a>
																						<a id="link_luna" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/luna/">
												<img id="hover_luna" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/luna_hphover.png?v=5800661">
												<img id="base_luna" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/luna_sb.png?v=5800661">
											</a>
																						<a id="link_bounty_hunter" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/bounty_hunter/">
												<img id="hover_bounty_hunter" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/bounty_hunter_hphover.png?v=5800661">
												<img id="base_bounty_hunter" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/bounty_hunter_sb.png?v=5800661">
											</a>
																						<a id="link_ursa" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/ursa/">
												<img id="hover_ursa" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/ursa_hphover.png?v=5800661">
												<img id="base_ursa" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/ursa_sb.png?v=5800661">
											</a>
																						<a id="link_gyrocopter" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/gyrocopter/">
												<img id="hover_gyrocopter" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/gyrocopter_hphover.png?v=5800661">
												<img id="base_gyrocopter" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/gyrocopter_sb.png?v=5800661">
											</a>
																						<a id="link_lone_druid" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/lone_druid/">
												<img id="hover_lone_druid" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/lone_druid_hphover.png?v=5800661">
												<img id="base_lone_druid" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/lone_druid_sb.png?v=5800661">
											</a>
																						<a id="link_naga_siren" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/naga_siren/">
												<img id="hover_naga_siren" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/naga_siren_hphover.png?v=5800661">
												<img id="base_naga_siren" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/naga_siren_sb.png?v=5800661">
											</a>
																						<a id="link_troll_warlord" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/troll_warlord/">
												<img id="hover_troll_warlord" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/troll_warlord_hphover.png?v=5800661">
												<img id="base_troll_warlord" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/troll_warlord_sb.png?v=5800661">
											</a>
																						<a id="link_ember_spirit" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/ember_spirit/">
												<img id="hover_ember_spirit" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/ember_spirit_hphover.png?v=5800661">
												<img id="base_ember_spirit" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/ember_spirit_sb.png?v=5800661">
											</a>
																						<a id="link_monkey_king" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/monkey_king/">
												<img id="hover_monkey_king" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/monkey_king_hphover.png?v=5800661">
												<img id="base_monkey_king" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/monkey_king_sb.png?v=5800661">
											</a>
																						<a id="link_pangolier" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/pangolier/">
												<img id="hover_pangolier" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/pangolier_hphover.png?v=5800661">
												<img id="base_pangolier" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/pangolier_sb.png?v=5800661">
											</a>
																					</div>
										<br clear="left">
									</div>
									<div class="heroColRight">
										<div id="columnHeader"><span id="columnHeaderTextInt">Intelligence</span></div>
										<div class="heroIcons">
																						<a id="link_crystal_maiden" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/crystal_maiden/">
												<img id="hover_crystal_maiden" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/crystal_maiden_hphover.png?v=5800661">
												<img id="base_crystal_maiden" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/crystal_maiden_sb.png?v=5800661">
											</a>
																						<a id="link_puck" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/puck/">
												<img id="hover_puck" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/puck_hphover.png?v=5800661">
												<img id="base_puck" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/puck_sb.png?v=5800661">
											</a>
																						<a id="link_storm_spirit" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/storm_spirit/">
												<img id="hover_storm_spirit" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/storm_spirit_hphover.png?v=5800661">
												<img id="base_storm_spirit" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/storm_spirit_sb.png?v=5800661">
											</a>
																						<a id="link_windrunner" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/windrunner/">
												<img id="hover_windrunner" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/windrunner_hphover.png?v=5800661">
												<img id="base_windrunner" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/windrunner_sb.png?v=5800661">
											</a>
																						<a id="link_zuus" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/zuus/">
												<img id="hover_zuus" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/zuus_hphover.png?v=5800661">
												<img id="base_zuus" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/zuus_sb.png?v=5800661">
											</a>
																						<a id="link_lina" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/lina/">
												<img id="hover_lina" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/lina_hphover.png?v=5800661">
												<img id="base_lina" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/lina_sb.png?v=5800661">
											</a>
																						<a id="link_shadow_shaman" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/shadow_shaman/">
												<img id="hover_shadow_shaman" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/shadow_shaman_hphover.png?v=5800661">
												<img id="base_shadow_shaman" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/shadow_shaman_sb.png?v=5800661">
											</a>
																						<a id="link_tinker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/tinker/">
												<img id="hover_tinker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/tinker_hphover.png?v=5800661">
												<img id="base_tinker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/tinker_sb.png?v=5800661">
											</a>
																						<a id="link_furion" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/furion/">
												<img id="hover_furion" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/furion_hphover.png?v=5800661">
												<img id="base_furion" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/furion_sb.png?v=5800661">
											</a>
																						<a id="link_enchantress" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/enchantress/">
												<img id="hover_enchantress" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/enchantress_hphover.png?v=5800661">
												<img id="base_enchantress" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/enchantress_sb.png?v=5800661">
											</a>
																						<a id="link_jakiro" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/jakiro/">
												<img id="hover_jakiro" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/jakiro_hphover.png?v=5800661">
												<img id="base_jakiro" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/jakiro_sb.png?v=5800661">
											</a>
																						<a id="link_chen" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/chen/">
												<img id="hover_chen" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/chen_hphover.png?v=5800661">
												<img id="base_chen" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/chen_sb.png?v=5800661">
											</a>
																						<a id="link_silencer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/silencer/">
												<img id="hover_silencer" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/silencer_hphover.png?v=5800661">
												<img id="base_silencer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/silencer_sb.png?v=5800661">
											</a>
																						<a id="link_ogre_magi" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/ogre_magi/">
												<img id="hover_ogre_magi" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/ogre_magi_hphover.png?v=5800661">
												<img id="base_ogre_magi" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/ogre_magi_sb.png?v=5800661">
											</a>
																						<a id="link_rubick" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/rubick/">
												<img id="hover_rubick" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/rubick_hphover.png?v=5800661">
												<img id="base_rubick" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/rubick_sb.png?v=5800661">
											</a>
																						<a id="link_disruptor" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/disruptor/">
												<img id="hover_disruptor" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/disruptor_hphover.png?v=5800661">
												<img id="base_disruptor" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/disruptor_sb.png?v=5800661">
											</a>
																						<a id="link_keeper_of_the_light" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/keeper_of_the_light/">
												<img id="hover_keeper_of_the_light" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/keeper_of_the_light_hphover.png?v=5800661">
												<img id="base_keeper_of_the_light" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/keeper_of_the_light_sb.png?v=5800661">
											</a>
																						<a id="link_skywrath_mage" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/Skywrath_Mage/">
												<img id="hover_skywrath_mage" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/skywrath_mage_hphover.png?v=5800661">
												<img id="base_skywrath_mage" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/skywrath_mage_sb.png?v=5800661">
											</a>
																						<a id="link_oracle" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/oracle/">
												<img id="hover_oracle" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/oracle_hphover.png?v=5800661">
												<img id="base_oracle" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/oracle_sb.png?v=5800661">
											</a>
																						<a id="link_techies" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/techies/">
												<img id="hover_techies" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/techies_hphover.png?v=5800661">
												<img id="base_techies" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/techies_sb.png?v=5800661">
											</a>
																						<a id="link_dark_willow" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/dark_willow/">
												<img id="hover_dark_willow" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/dark_willow_hphover.png?v=5800661">
												<img id="base_dark_willow" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/dark_willow_sb.png?v=5800661">
											</a>
																						<a id="link_void_spirit" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/void_spirit/">
												<img id="hover_void_spirit" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/void_spirit_hphover.png?v=5800661">
												<img id="base_void_spirit" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/void_spirit_sb.png?v=5800661">
											</a>
																					</div>
										<br clear="left">
									</div>
									<div class="heroColLeft" style="clear:left">
										<div class="heroIcons">
																						<a id="link_axe" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/axe/">
												<img id="hover_axe" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/axe_hphover.png?v=5800661">
												<img id="base_axe" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/axe_sb.png?v=5800661">
											</a>
																						<a id="link_pudge" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/pudge/">
												<img id="hover_pudge" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/pudge_hphover.png?v=5800661">
												<img id="base_pudge" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/pudge_sb.png?v=5800661">
											</a>
																						<a id="link_sand_king" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/sand_king/">
												<img id="hover_sand_king" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/sand_king_hphover.png?v=5800661">
												<img id="base_sand_king" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/sand_king_sb.png?v=5800661">
											</a>
																						<a id="link_slardar" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/slardar/">
												<img id="hover_slardar" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/slardar_hphover.png?v=5800661">
												<img id="base_slardar" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/slardar_sb.png?v=5800661">
											</a>
																						<a id="link_tidehunter" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/tidehunter/">
												<img id="hover_tidehunter" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/tidehunter_hphover.png?v=5800661">
												<img id="base_tidehunter" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/tidehunter_sb.png?v=5800661">
											</a>
																						<a id="link_skeleton_king" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/skeleton_king/">
												<img id="hover_skeleton_king" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/skeleton_king_hphover.png?v=5800661">
												<img id="base_skeleton_king" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/skeleton_king_sb.png?v=5800661">
											</a>
																						<a id="link_life_stealer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/life_stealer/">
												<img id="hover_life_stealer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/life_stealer_hphover.png?v=5800661">
												<img id="base_life_stealer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/life_stealer_sb.png?v=5800661">
											</a>
																						<a id="link_night_stalker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/night_stalker/">
												<img id="hover_night_stalker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/night_stalker_hphover.png?v=5800661">
												<img id="base_night_stalker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/night_stalker_sb.png?v=5800661">
											</a>
																						<a id="link_doom_bringer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/doom_bringer/">
												<img id="hover_doom_bringer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/doom_bringer_hphover.png?v=5800661">
												<img id="base_doom_bringer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/doom_bringer_sb.png?v=5800661">
											</a>
																						<a id="link_spirit_breaker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/spirit_breaker/">
												<img id="hover_spirit_breaker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/spirit_breaker_hphover.png?v=5800661">
												<img id="base_spirit_breaker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/spirit_breaker_sb.png?v=5800661">
											</a>
																						<a id="link_lycan" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/lycan/">
												<img id="hover_lycan" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/lycan_hphover.png?v=5800661">
												<img id="base_lycan" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/lycan_sb.png?v=5800661">
											</a>
																						<a id="link_chaos_knight" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/chaos_knight/">
												<img id="hover_chaos_knight" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/chaos_knight_hphover.png?v=5800661">
												<img id="base_chaos_knight" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/chaos_knight_sb.png?v=5800661">
											</a>
																						<a id="link_undying" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/undying/">
												<img id="hover_undying" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/undying_hphover.png?v=5800661">
												<img id="base_undying" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/undying_sb.png?v=5800661">
											</a>
																						<a id="link_magnataur" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/magnataur/">
												<img id="hover_magnataur" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/magnataur_hphover.png?v=5800661">
												<img id="base_magnataur" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/magnataur_sb.png?v=5800661">
											</a>
																						<a id="link_abaddon" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/abaddon/">
												<img id="hover_abaddon" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/abaddon_hphover.png?v=5800661">
												<img id="base_abaddon" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/abaddon_sb.png?v=5800661">
											</a>
																						<a id="link_abyssal_underlord" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/abyssal_underlord/">
												<img id="hover_abyssal_underlord" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/abyssal_underlord_hphover.png?v=5800661">
												<img id="base_abyssal_underlord" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/abyssal_underlord_sb.png?v=5800661">
											</a>
																					</div>
										<br clear="left">
									</div>
									<div class="heroColMiddle">
										<div class="heroIcons">
																						<a id="link_bloodseeker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/bloodseeker/">
												<img id="hover_bloodseeker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/bloodseeker_hphover.png?v=5800661">
												<img id="base_bloodseeker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/bloodseeker_sb.png?v=5800661">
											</a>
																						<a id="link_nevermore" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/nevermore/">
												<img id="hover_nevermore" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/nevermore_hphover.png?v=5800661">
												<img id="base_nevermore" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/nevermore_sb.png?v=5800661">
											</a>
																						<a id="link_razor" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/razor/">
												<img id="hover_razor" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/razor_hphover.png?v=5800661">
												<img id="base_razor" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/razor_sb.png?v=5800661">
											</a>
																						<a id="link_venomancer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/venomancer/">
												<img id="hover_venomancer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/venomancer_hphover.png?v=5800661">
												<img id="base_venomancer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/venomancer_sb.png?v=5800661">
											</a>
																						<a id="link_faceless_void" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/faceless_void/">
												<img id="hover_faceless_void" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/faceless_void_hphover.png?v=5800661">
												<img id="base_faceless_void" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/faceless_void_sb.png?v=5800661">
											</a>
																						<a id="link_phantom_assassin" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/phantom_assassin/">
												<img id="hover_phantom_assassin" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/phantom_assassin_hphover.png?v=5800661">
												<img id="base_phantom_assassin" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/phantom_assassin_sb.png?v=5800661">
											</a>
																						<a id="link_viper" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/viper/">
												<img id="hover_viper" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/viper_hphover.png?v=5800661">
												<img id="base_viper" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/viper_sb.png?v=5800661">
											</a>
																						<a id="link_clinkz" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/clinkz/">
												<img id="hover_clinkz" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/clinkz_hphover.png?v=5800661">
												<img id="base_clinkz" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/clinkz_sb.png?v=5800661">
											</a>
																						<a id="link_broodmother" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/broodmother/">
												<img id="hover_broodmother" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/broodmother_hphover.png?v=5800661">
												<img id="base_broodmother" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/broodmother_sb.png?v=5800661">
											</a>
																						<a id="link_weaver" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/weaver/">
												<img id="hover_weaver" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/weaver_hphover.png?v=5800661">
												<img id="base_weaver" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/weaver_sb.png?v=5800661">
											</a>
																						<a id="link_spectre" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/spectre/">
												<img id="hover_spectre" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/spectre_hphover.png?v=5800661">
												<img id="base_spectre" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/spectre_sb.png?v=5800661">
											</a>
																						<a id="link_meepo" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/meepo/">
												<img id="hover_meepo" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/meepo_hphover.png?v=5800661">
												<img id="base_meepo" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/meepo_sb.png?v=5800661">
											</a>
																						<a id="link_nyx_assassin" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/nyx_assassin/">
												<img id="hover_nyx_assassin" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/nyx_assassin_hphover.png?v=5800661">
												<img id="base_nyx_assassin" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/nyx_assassin_sb.png?v=5800661">
											</a>
																						<a id="link_slark" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/slark/">
												<img id="hover_slark" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/slark_hphover.png?v=5800661">
												<img id="base_slark" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/slark_sb.png?v=5800661">
											</a>
																						<a id="link_medusa" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/medusa/">
												<img id="hover_medusa" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/medusa_hphover.png?v=5800661">
												<img id="base_medusa" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/medusa_sb.png?v=5800661">
											</a>
																						<a id="link_terrorblade" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/terrorblade/">
												<img id="hover_terrorblade" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/terrorblade_hphover.png?v=5800661">
												<img id="base_terrorblade" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/terrorblade_sb.png?v=5800661">
											</a>
																						<a id="link_arc_warden" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/arc_warden/">
												<img id="hover_arc_warden" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/arc_warden_hphover.png?v=5800661">
												<img id="base_arc_warden" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/arc_warden_sb.png?v=5800661">
											</a>
																					</div>
										<br clear="left">
									</div>
									<div class="heroColRight">
										<div class="heroIcons">
																						<a id="link_bane" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/bane/">
												<img id="hover_bane" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/bane_hphover.png">
												<img id="base_bane" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/bane_sb.png">
											</a>
																						<a id="link_lich" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/lich/">
												<img id="hover_lich" class="heroHoverLarge" style="display: none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/lich_hphover.png">
												<img id="base_lich" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/lich_sb.png">
											</a>
																						<a id="link_lion" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/lion/">
												<img id="hover_lion" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/lion_hphover.png">
												<img id="base_lion" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/lion_sb.png">
											</a>
																						<a id="link_witch_doctor" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/witch_doctor/">
												<img id="hover_witch_doctor" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/witch_doctor_hphover.png">
												<img id="base_witch_doctor" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/witch_doctor_sb.png">
											</a>
																						<a id="link_enigma" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/enigma/">
												<img id="hover_enigma" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/enigma_hphover.png">
												<img id="base_enigma" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/enigma_sb.png">
											</a>
																						<a id="link_necrolyte" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/necrolyte/">
												<img id="hover_necrolyte" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/necrolyte_hphover.png">
												<img id="base_necrolyte" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/necrolyte_sb.png">
											</a>
																						<a id="link_warlock" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/warlock/">
												<img id="hover_warlock" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/warlock_hphover.png">
												<img id="base_warlock" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/warlock_sb.png">
											</a>
																						<a id="link_queenofpain" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/queenofpain/">
												<img id="hover_queenofpain" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/queenofpain_hphover.png">
												<img id="base_queenofpain" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/queenofpain_sb.png">
											</a>
																						<a id="link_death_prophet" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/death_prophet/">
												<img id="hover_death_prophet" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/death_prophet_hphover.png">
												<img id="base_death_prophet" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/death_prophet_sb.png">
											</a>
																						<a id="link_pugna" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/pugna/">
												<img id="hover_pugna" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/pugna_hphover.png">
												<img id="base_pugna" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/pugna_sb.png">
											</a>
																						<a id="link_dazzle" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/dazzle/">
												<img id="hover_dazzle" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/dazzle_hphover.png">
												<img id="base_dazzle" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/dazzle_sb.png">
											</a>
																						<a id="link_leshrac" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/leshrac/">
												<img id="hover_leshrac" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/leshrac_hphover.png">
												<img id="base_leshrac" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/leshrac_sb.png">
											</a>
																						<a id="link_dark_seer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/dark_seer/">
												<img id="hover_dark_seer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/dark_seer_hphover.png">
												<img id="base_dark_seer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/dark_seer_sb.png">
											</a>
																						<a id="link_batrider" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/batrider/">
												<img id="hover_batrider" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/batrider_hphover.png">
												<img id="base_batrider" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/batrider_sb.png">
											</a>
																						<a id="link_ancient_apparition" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/ancient_apparition/">
												<img id="hover_ancient_apparition" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/ancient_apparition_hphover.png">
												<img id="base_ancient_apparition" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/ancient_apparition_sb.png">
											</a>
																						<a id="link_invoker" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/invoker/">
												<img id="hover_invoker" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/invoker_hphover.png">
												<img id="base_invoker" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/invoker_sb.png">
											</a>
																						<a id="link_obsidian_destroyer" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/obsidian_destroyer/">
												<img id="hover_obsidian_destroyer" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/obsidian_destroyer_hphover.png">
												<img id="base_obsidian_destroyer" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/obsidian_destroyer_sb.png">
											</a>
																						<a id="link_shadow_demon" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/shadow_demon/">
												<img id="hover_shadow_demon" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/shadow_demon_hphover.png">
												<img id="base_shadow_demon" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/shadow_demon_sb.png">
											</a>
																						<a id="link_visage" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/visage/">
												<img id="hover_visage" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/visage_hphover.png">
												<img id="base_visage" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/visage_sb.png">
											</a>
																						<a id="link_winter_wyvern" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/winter_wyvern/">
												<img id="hover_winter_wyvern" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/winter_wyvern_hphover.png">
												<img id="base_winter_wyvern" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/winter_wyvern_sb.png">
											</a>
																						<a id="link_grimstroke" class="heroPickerIconLink filterMatchedHero" href="http://www.dota2.com/hero/grimstroke/">
												<img id="hover_grimstroke" class="heroHoverLarge" style="display:none;" src="http://cdn.dota2.com/apps/dota2/images/heroes/grimstroke_hphover.png">
												<img id="base_grimstroke" class="heroHoverSmall" src="http://cdn.dota2.com/apps/dota2/images/heroes/grimstroke_sb.png">
											</a>
																					</div>
										<br clear="left">
									</div>
									<br clear="left">
								</div>
            <hr>
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->

    <?php include_once "footer.inc.php" ?>
