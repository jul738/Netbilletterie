<!--
Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr
comptable-->

<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
            	<li><a href="accueil.php" rel="menu12" id="accueil"><img border ="0" src="" alt="Accueil"><br></a></li>
		<li><a href="form_commande.php" rel="menu2" id="reservations"><img border ="0" src="" alt="Réservations"><br></a></li>
		<li><a href="lister_billetterie.php" id="billetterie"><img border ="0" src="" alt="Billetterie"><br></a></li>
		<li><a href="lister_articles.php" id="spectacle"><img border ="0" src="" alt="Spectacles"><br></a></li>
		<li><a href="lister_caisse_billetterie.php" rel="menu5" id="caisse"><img border ="0" src="" alt="Caisse"><br></a></li>
		<li><a href="ca_spectacle.php" rel="menu6" id="statistique"><img border ="0" src="" alt="Statistiques"><br></a></li>
		<li><a href="agenda.php" rel="menu9" id="outils"><img border ="0" src="" alt="Outils"><br></a></li>
		<li><a href="lister_facture.php" rel="menu15" id="factures"><img border ="0" src="" alt="Facture"><br></a></li>		
                <li><a href="logout.php" rel="menu10" id="quitter"><img border ="0" src="" alt="Quiter"><br></a></li>
	</ul>

<!--deroulant du menu2 niveau2-->
		<div id="menu2" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des abonnements et réservations</b></p>
		<div class="column">
			<ul>
				<li><a href="form_commande.php"><b>Créer une réservation</b></a></li><hr/>
                                <li><a href="form_resa_groupe.php"><b>Créer une réservation de groupe</b></a></li><hr/>
				<li><a href="lister_commandes.php"><b>Lister les réservations</b></a></li><hr/>
                                <li><a href="lister_resa_groupes.php"><b>Lister les réservations de groupes</b></a></li><hr/>
				<li><a href="lister_detail_commandes.php"><b>Détail des réservations</b></a></li><hr/>
				<li><a href="lister_commandes_non_facturees.php"><b>Contrôler - Encaisser</b></a></li><hr/>
				<li><a href="impression.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer les listes d�taill�es</b></a></li><hr/>
			</ul>
		</div>
		</div>
		

<!--deroulant du menu3 niveau2-->
	<div id="menu3" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des spectacles</b></p>
		<div class="column">
			<ul>
				<li><a href="lister_articles.php"><b>Lister les spectacles</b></a></li><hr/>
			</ul>
		</div>
		</div>

	<!--deroulant du menu4 niveau2-->
	<div id="menu4" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des listes d'attente</b></p>
		<div class="column">
			<ul>
				<li><a href="lister_commandes_attente.php"><b>Voir la liste d'attente</b></a></li><hr/>
				<li><a href="lister_spectacle_attente.php"><b>Voir la liste d'attente par spectacle</b></a></li><hr/>
			</ul>
		</div>
		</div>


	<!--deroulant du menu5 niveau2-->
	<div id="menu5" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des caisses journalières</b></p>
		<div class="column">
			<ul>
				<li><a href="form_caisse.php"><b>Enregistrer le contenu de caisse</b></a></li><hr/>
				<li><a href="form_caisse.php?retrait=y"><b>Retrait de caisse</b></a></li><hr/>
				<li><a href="lister_caisse_billetterie.php"><b>Caisse "Billetterie"</b></a></li><hr/>
				<li><a href="lister_caisse_bar.php"><b>Caisse "Buvette"</b></a></li><hr/>
				<li><a href="impression_caisse.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer les opérations de caisse</b></a></li><hr/>
			</ul>
		</div>
		</div>


<!--deroulant du menu6 niveau2-->
	<div id="menu6" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Chiffre d'affaire de la saison</b></p>
		<div class="column">
			<ul>
				<li><a href="ca_spectacle.php"><b>Statistiques par spectacle</b></a></li><hr/>
				<li><a href="ca_articles.php"><b>Statistiques par représentation</b></a></li><hr/>
				<li><a href="ca_tarif.php"><b>Statistiques par tarif</b></a></li><hr/>
				<li><a href="impression_stat.php"><b><img src="image/imprimante.png">&nbsp;&nbsp;Imprimer les statistiques</b></a></li><hr/>
			</ul>
		</div>
		</div>


<!--deroulant du menu7 niveau2-->
	<div id="menu7" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion de la billetterie</b></p>
		<div class="column">
			<ul>
				<li><a href="lister_billetterie.php"><b>Voir la liste de la billetterie</b></a></li><hr/>
			</ul>
		</div>
		</div>

		<!--deroulant du menu9 niveau2-->
	<div id="menu9" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Quelques outils d'administration</b></p>
		<div class="column">
			<ul>
				<li><a href="agenda.php">Agenda</a></li><hr/>
				<li><a href="include/calculette.html" onclick="window.open('','popup','width=500,height=420,top=200,left=150,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')" target="popup"><?php echo $lang_calculette; ?></a></li><hr/>
			</ul>
		</div>
	</div>
        <!--deroulant du menu -->
		<div id="menu15" class="mega solidblocktheme">
			<p style="margin:5px 0 10px 0"><b>Facturation</b></p>
			<div class="column">
				<ul>
                                    <li><a href="lister_accompte.php"><b>Liste des accomptes</b></a></li><hr/>
				</ul>
			</div>
		</div>
</div>
