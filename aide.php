<?php 
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/
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
					<a href="#1"> <li>Cr�er un abonnement ou une r�servation</li></a>
					<a href="#2"> <li>Cr�er un abonnement ou une r�servation en attente de paiement</li></a>
					<a href="#3"> <li>Enregistrement billetterie le soir de l'�v�nement</li></a>
					<a href="#3a"> <li>Supprimer une r�servation</li></a>
					<a href="#4"> <li>contr�ler un enregistrement. (Esp�ces ou ch�que)</li></a>
					<a href="#5"> <li>Encaisser une reservation</li></a>
					<a href="#6"> <li>imprimer la liste des encaissements pour la perception</li></a>
				</ul>
    		</div>
		</td>
	</tr>
	<tr id="1">
		<td><h1>Cr�er un abonnement ou une r�servation</h1>
		<p>	<i>Avant de cr�er la reservation il convient de s'assurer que le spectateur existe, sinon il faut le cr�er:</i><br/>
			Spectateur -> Liste des sp�ctateurs <br/>
			Commencer � �crire le nom dans "Rechercher" pour voir s'il est dans la liste.<br/>
			S'il existe il faut cliquer sur le bouton "�diter" � droite de la ligne <br:>
			contr�ler l'adresse mail -> Enregistrer<br/>
			Selectionner le tarif et cliquer "cr�er une r�servation pour..."<br><br/>
			Si vous savez que le spectateur existe vraiment et que le mail est bon, alors:<br/>		
			Dans le menu "R�servations"->"Cr�er une R�servations"<br/>
			Choisir le spectateur ou la famille puis selectionner le" tarif". -> Valider (bouton bleu)<br/>
			Choisir le "nombre" de places.<br/>
			Choisir le ou les "spectacles".-> Ajouter � l'abonnement (bouton jaune)<br/>			
			Vous pouvez laisser un "commentaire". <br/>
			Apres avoir choisi le "mode de paiement" -> Valider (bouton bleu)<br/>
		</p>
		<a href="#0">Retour au sommaire</a> 
		</td>
	</tr>
	<tr id="2">
		<td><h1>Cr�er une r�servation en attente de paiement</h1>
		<p>
		M�me proc�d� que pour la cr�ation d'une r�servation, mais � la fin choisir le mode de paiement "En attente de paiement"<br/>
		
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="3">
		<td><h1>Enregistrement billetterie</h1>
		<p><i>Le proced� est tr�s proche de la cr�ation d'une reservation. Sauf que dans ce cas pr�cis il n'y a pas besoin de cr�er un spectateur ou de le choisir dans la liste.<br/>
			La r�sevation sera enregistr�e sous le nom de "Billetterie soir�e pour "Nom du spectacle" Et il n'y aura pas besion de choisir le spectacle car il sera mis automatiquement.<br/>
			Donc:</i><br/>
			Billetterie ->Cr�er un enregistrement de billet<br/>
			Clic valider. <i>Ou si vous faites l'enregistrement le lendemain clic en dessous "Effectuer un enregistrement de caisse postdat�."</i><br/>
			Choisir le nombre de place<br/>
			Choisir le tarif<br/>
			Choisir le mode de paiemement-> Valider (bouton bleu)<br/>
			Possibilit� de rajout� une autre ligne d'enregistrement avec un nombre et un tarif diff�rent-> Ajouter � l'abonnement (bouton jaune)<br/>
			Vous pouvez laisser un "commentaire". <br/>
			Apres avoir choisi le "mode de paiement" -> Valider (bouton bleu)<br/>	
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="3a">
		<td><h1>Supprimer une r�servation</h1>
		<p>
		<i>Seules les r�servations vides peuvent �tre suprim�es.</i><br/>
		R�servation -> lister les r�servations.<br/>
		Clic -> editer (� droite dans la colonne action)<br/>
		Supprimer chaque lignes pr�sentes dans la r�servation. Ainsi chaque places de spectacle r�serv�es seront lib�r�es.<br/>
		Clic -> Valider (bouton bleu).<br/>
		Maintenant vous pouvez la supprimer (� droite dans la colonne action)
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="4">
		<td><h1>Contr�ler un enregistrement. (Esp�ces, ch�que, CB...)</h1>
		<p>
		Le jour des enregistrements des abonnements ou le soir des spectacles, � la fin, une fois que tout redevient calme, il faut contr�ler les paiements. On constate qu'il y a parfois des erreurs de saisie.<br/>
		R�servation -> lister les r�servations.<br/>
		Clic -> �diter (� droite dans la colonne action)<br/>
		Contr�ler: <br/>
		- le montant du ch�que <br/>
		- s'il est lib�l� correctement et sign�.<br/>
		Si OK, clic sur contr�l�. Citu� sous la zone texte des commentaires.<br/>
		Clic -> Valider (bouton bleu).		<br/><br/>
		Possibilit� de le faire aussi par: R�servation -> Contr�ler - Encaisser
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="5">
		<td><h1>Encaisser une reservation</h1>
		<p>
		<i> Juste avant de porter les paiements � la perception ou � la banque il faut marquer les r�servations par "Encaiss�"</i><br/>
		Une fois la r�servation "Encaisss�" il sera impossible de la modifier, supprimer.<br/>
		Les num�ros des billets ne sont atribu�s qu'aux r�servations encaiss�es<br/>
		R�servation -> Contr�ler - Encaisser<br/>
		Assurez-vous que le contr�le est bien sur OK <br/>
		Choisir la r�servaion et clic sur �diter dans la collonne "Action"<br/>
		Renseigner le nom de la banque<br/>
		Renseigner le nomdu titulaire<br/>
		Possibilit� de donner un commentaire<br/>
		Choisir dans Encaiss� <br/>
		Clic -> Valider (bouton bleu).		
		</p>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
	<tr id="6">
		<td><h1>Imprimer la liste des encaissements pour la perception</h1>
		<p>
		Impression -> R�servations - Encaissements<br/>
		Dans la derni�re ligne "D�tail des encaissements pour la perception" Renseigner l'intervalle des dates.<br/>
		Renseigner le N� de R�gis et clic->imprimer<br/>
		Pour revenir � NetBilleterie il faut cliquer sur retour en haut � gauche de la page.<br/>
		</P>
		<a href="#0">Retour au sommaire</a>
		</td>
	</tr>
</table>

<?php
include_once("include/bas.php"); 
?>



