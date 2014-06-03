<?php 
/* Net Billetterie Copyright(C)2012 José Das Neves
 Logiciel de billetterie libre. 
Développé depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : José Das Neves pitu69@hotmail.fr*/
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php"); 
include_once("include/headers.php");
include_once("include/fonction.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/head.php");
include_once("include/finhead.php");

?> 


<table  class="page">

	<tr>
    	<td>
    		<h1 id="0">Mode d'emploi de NetBilletterie</h1>
    	</td>	
    </tr>	
    <tr>
    	<td>
    		<div >
    		<h2>SOMMAIRE</h2>
				<ul>
					<a href="#1"> <li>Créer un abonnement ou une réservation</li></a>
					<a href="#2"> <li>Créer un abonnement ou une réservation en attente de paiement</li></a>
					<a href="#3"> <li>Enregistrement billetterie le soir de l'évènement</li></a>
					<a href="#3a"> <li>Supprimer une réservation</li></a>
					<a href="#4"> <li>contrôler un enregistrement. (Espèces ou chéque)</li></a>
					<a href="#5"> <li>Encaisser une reservation</li></a>
					<a href="#6"> <li>imprimer la liste des encaissements pour la perception</li></a>
				</ul>
    		</div>
		</td>
	</tr>
	<tr id="1">
		<td><h1>Créer un abonnement ou une réservation</h1>
		<p>	<i>Avant de créer la reservation il convient de s'assurer que le spectateur existe, sinon il faut le créer:</i><br/>
			Spectateur -> Liste des spéctateurs <br/>
			Commencer à écrire le nom dans "Rechercher" pour voir s'il est dans la liste.<br/>
			S'il existe il faut cliquer sur le bouton "éditer" à droite de la ligne <br:>
			contrôler l'adresse mail -> Enregistrer<br/>
			Selectionner le tarif et cliquer "créer une réservation pour..."<br><br/>
			Si vous savez que le spectateur existe vraiment et que le mail est bon, alors:<br/>		
			Dans le menu "Réservations"->"Créer une Réservations"<br/>
			Choisir le spectateur ou la famille puis selectionner le" tarif". -> Valider (bouton bleu)<br/>
			Choisir le "nombre" de places.<br/>
			Choisir le ou les "spectacles".-> Ajouter à l'abonnement (bouton jaune)<br/>			
			Vous pouvez laisser un "commentaire". <br/>
			Apres avoir choisi le "mode de paiement" -> Valider (bouton bleu)<br/>
		</p>
		<a href="#0">Retour au sommaire</a> 
		</td>
	</tr>
	<tr id="2">
		<td><h1>Créer une réservation en attente de paiement</h1>
		<p>
		Même procédé que pour la création d'une réservation, mais à la fin choisir le mode de paiement "En attente de paiement"<br/>
		
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="3">
		<td><h1>Enregistrement billetterie</h1>
		<p><i>Le procedé est très proche de la création d'une reservation. Sauf que dans ce cas précis il n'y a pas besoin de créer un spectateur ou de le choisir dans la liste.<br/>
			La résevation sera enregistrée sous le nom de "Billetterie soirée pour "Nom du spectacle" Et il n'y aura pas besion de choisir le spectacle car il sera mis automatiquement.<br/>
			Donc:</i><br/>
			Billetterie ->Créer un enregistrement de billet<br/>
			Clic valider. <i>Ou si vous faites l'enregistrement le lendemain clic en dessous "Effectuer un enregistrement de caisse postdaté."</i><br/>
			Choisir le nombre de place<br/>
			Choisir le tarif<br/>
			Choisir le mode de paiemement-> Valider (bouton bleu)<br/>
			Possibilité de rajouté une autre ligne d'enregistrement avec un nombre et un tarif différent-> Ajouter à l'abonnement (bouton jaune)<br/>
			Vous pouvez laisser un "commentaire". <br/>
			Apres avoir choisi le "mode de paiement" -> Valider (bouton bleu)<br/>	
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="3a">
		<td><h1>Supprimer une réservation</h1>
		<p>
		<i>Seules les réservations vides peuvent être suprimées.</i><br/>
		Réservation -> lister les réservations.<br/>
		Clic -> editer (à droite dans la colonne action)<br/>
		Supprimer chaque lignes présentes dans la réservation. Ainsi chaque places de spectacle réservées seront libérées.<br/>
		Clic -> Valider (bouton bleu).<br/>
		Maintenant vous pouvez la supprimer (à droite dans la colonne action)
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="4">
		<td><h1>Contrôler un enregistrement. (Espèces, chéque, CB...)</h1>
		<p>
		Le jour des enregistrements des abonnements ou le soir des spectacles, à la fin, une fois que tout redevient calme, il faut contrôler les paiements. On constate qu'il y a parfois des erreurs de saisie.<br/>
		Réservation -> lister les réservations.<br/>
		Clic -> éditer (à droite dans la colonne action)<br/>
		Contrôler: <br/>
		- le montant du chèque <br/>
		- s'il est libélé correctement et signé.<br/>
		Si OK, clic sur contrôlé. Citué sous la zone texte des commentaires.<br/>
		Clic -> Valider (bouton bleu).		<br/><br/>
		Possibilité de le faire aussi par: Réservation -> Contrôler - Encaisser
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="5">
		<td><h1>Encaisser une reservation</h1>
		<p>
		<i> Juste avant de porter les paiements à la perception ou à la banque il faut marquer les réservations par "Encaissé"</i><br/>
		Une fois la réservation "Encaisssé" il sera impossible de la modifier, supprimer.<br/>
		Les numéros des billets ne sont atribués qu'aux réservations encaissées<br/>
		Réservation -> Contrôler - Encaisser<br/>
		Assurez-vous que le contrôle est bien sur OK <br/>
		Choisir la réservaion et clic sur éditer dans la collonne "Action"<br/>
		Renseigner le nom de la banque<br/>
		Renseigner le nomdu titulaire<br/>
		Possibilité de donner un commentaire<br/>
		Choisir dans Encaissé <br/>
		Clic -> Valider (bouton bleu).		
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="6">
		<td><h1>Imprimer la liste des encaissements pour la perception</h1>
		<p>
		Impression -> Réservations - Encaissements<br/>
		Dans la dernière ligne "Détail des encaissements pour la perception" Renseigner l'intervalle des dates.<br/>
		Renseigner le N° de Régis et clic->imprimer<br/>
		Pour revenir à NetBilleterie il faut cliquer sur retour en haut à gauche de la page.<br/>
		</P>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
</table>

<?php
include_once("include/bas.php"); 
?>



