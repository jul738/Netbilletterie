<!--
Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr

saisie billetterie-->

<!-- Div header applique margin auto sur tout le menu -->
<div id="header">

	<!-- Administrateur plein pouvoir-->
	<div id="logo">
		<!--Menu 1er niveau-->
		<a href="login.inc.php" rel="menu0"><img border ="0" src="image/logompt_transparent.png" alt=""></a>
	</div>

<div class="menublock" >
	<!--Menu 1er niveau-->
	<ul id="solidmenu" class="solidblockmenu">
		
		<li><a href="form_client.php" rel="menu1"><img border ="0" src="image/kontact_contacts.png" alt="client"><br><?php echo $lang_clients; ?></a></li>
		<li><a href="form_commande.php" rel="menu2"><img border ="0" src="image/commandes.png" alt="Abonnement"><br>R�servations</a></li>
		<li><a href="new_abonnement.php" rel="menu11" id="abonnement"><img border ="0" src="" alt="Abonnement"><br></a></li>
                <li><a href="form_commande_soir.php" rel="menu7"><img border ="0" src="image/billetterie.png" alt="billetterie"><br>Billetterie</a></li>
                <li><a href="form_commande_attente.php" rel="menu4" id="attente"><img border ="0" src="" alt="Listes d'attente"><br></a></li>
		<li><a href="lister_articles.php" rel="menu3"><img border ="0" src="image/spectacle.png" alt="Spectacles"><br>Spectacles</a></li>
		<li><a href="agenda.php" rel="menu9"><img border ="0" src="image/outil.png" alt="outils"><br>Outils </a></li>
		<li><a href="logout.php" rel="menu10"><img border ="0" src="image/sortir.png" alt="Quiter"><br>Quiter </a></li>
	</ul>

<!--deroulant du menu1 niveau2-->
	<div id="menu1" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion des spectateurs</b></p>
		<div class="column">
			<ul>
				<li><a href="form_client.php"><b>Créer une fiche "Spectateur"</b></a></li><hr/>
                                <li><a href="form_groupe.php"><strong>Créer un groupe</strong></a></li><hr/>
				<li><a href="lister_clients.php"><b>Liste des spectateurs</b></a></li><hr/>
                                <li><a href="lister_groupes.php"><b>Liste des groupes</b></a></li><hr/>
				<li><a href="lister_clients_inactifs.php"><b>Liste des spectateurs inactifs</b></a></li>
			</ul>
		</div>
	</div>

        <div id="menu11" class="mega solidblocktheme">
			<p style="margin:5px 0 10px 0"><b>Gestion des Abonnements</b></p>
			<div class="column">
				<ul>
					<li><li><a href="new_abonnement.php"><b>Creer un abonnement</b></a></li><hr/>
					<li><a href="lister_abonnement.php"><b>Lister les abonnements</b></a></li><hr/>
                                        <li><a href="lister_commandes_non_fact_abo.php"><b>Controler - Encaisser</b></a></li><hr/>
                                        <li><a href=""><b><img src="image/print_mini.png"><br>&nbsp;Imprimer </b></a></li><hr/>
				</ul>
			</div>
			</div>

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
				<li><a href="form_commande_attente.php"><b>Inscrire sur liste d'attente</b></a></li><hr/>
				<li><a href="lister_commandes_attente.php"><b>Voir la liste d'attente</b></a></li><hr/>
				<li><a href="lister_spectacle_attente.php"><b>Voir la liste d'attente par spectacle</b></a></li><hr/>
			</ul>
		</div>
	</div>
		
<!--deroulant du menu7 niveau2-->
	<div id="menu7" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Gestion de la billetterie</b></p>
		<div class="column">
			<ul>
				<li><a href="form_commande_soir.php"><b>Cr�er un enregistrement de billet</b></a></li><hr/>
				<li><a href="form_commande_caisse_postdate.php"><b>Cr�er un enregistrement postdat�</b></a></li><hr/>
				<li><a href="lister_billetterie.php"><b>Voir la liste de la billetterie</b></a></li><hr/>
			</ul>
		</div>
	</div>


		<!--deroulant du menu9 niveau2-->
	<div id="menu9" class="mega solidblocktheme">
		<p style="margin:5px 0 10px 0"><b>Quelques outils d'administration</b></p>
		<div class="column">
			<ul>
				<li><a href="projection.php">Vid�o projection</a></li><hr/>
				<li><a href="agenda.php">Agenda</a></li><hr/>
				<li><a href="include/calculette.html" onclick="window.open('','popup','width=500,height=420,top=200,left=150,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0')" target="popup"><?php echo $lang_calculette; ?></a></li><hr/>
			</ul>
		</div>
	</div>
</div>
