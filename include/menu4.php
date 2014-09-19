<!--
Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr

Charger de communication-->
<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
		
		<li><a href="lister_spectacle_attente.php" rel="menu4"><img border ="0" src="image/commandes_attente02.png" alt="Listes d'attente"><br>Listes d'attente</a></li>
                <li><a href="accueil.php" rel="menu12" id="accueil"><img border ="0" src="" alt="Accueil"><br></a></li>
		<li><a href="lister_clients.php" rel="menu1" id="spectateurs"><img border ="0" src="" alt="Spectateurs"><br></a></li>
		<li><a href="form_commande.php" rel="menu2" id="reservations"><img border ="0" src="" alt="Réservations"><br></a></li>
                <li><a href="form_commande_soir.php" rel="menu7" id="billetterie"><img border ="0" src="" alt="Billetterie"><br></a></li>
                <li><a href="lister_spectacle_attente.php" rel="menu4" id="attente"><img border ="0" src="" alt="Listes d'attente"><br></a></li>
		<li><a href="lister_articles.php" rel="menu3" id="spectacle"><img border ="0" src="" alt="Spectacles"><br></a></li>
                <li><a href="form_mailing.php" rel="menu8" id="mailing"><img border ="0" src="" alt="Mailing"><br></a></li>
                <li><a href="agenda.php" rel="menu9" id="outils"><img border ="0" src="" alt="Outils"><br></a></li>
		<li><a href="logout.php" rel="menu10" id="quitter"><img border ="0" src="" alt="Quiter"><br></a></li>
        </ul>

<!--deroulant du menu1 niveau2-->
	<div id="menu1" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des spectateurs</b></p>
		<div class="column">
			<ul>
				<li><a href="form_client.php"><b>Cr�er une fiche "Spectateur"</b></a></li><hr/>
                                <li><a href="form_groupe.php"><strong>Cr�er un groupe</strong></a></li><hr/>
				<li><a href="lister_clients.php"><b>Liste des spectateurs</b></a></li><hr/>
                                <li><a href="lister_groupes.php"><b>Liste des groupes</b></a></li><hr/>
				<li><a href="rechercher_clients.php"><b>Chercher par crit�re </b></a></li><hr/>
				<li><a href="lister_clients_inactifs.php"><b>Liste des spectateurs inactifs</b></a></li>
			</ul>
		</div>
		</div>

<!--deroulant du menu8 niveau2-->
	<div id="menu8" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des courriels</b></p>
		<div class="column">
			<ul>
				<li><a href="form_mailing.php"><b>Mailing � tous les spectateurs </b></a></li><hr/>
				<li><a href="form_mailing_spectateurs_cible.php"><b>Mailing aux spectateurs d'un spectacle</b></a></li><hr/>
				<li><a href="form_mailing_spectateur.php"><b>Mailing � un spectateur</b></a></li><hr/><hr/>
				<li><a href="lister_mail.php"><b>Liste des mails envoy�s</b></a></li><hr/>
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
</div>
