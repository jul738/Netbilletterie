<?php
/* Net Billetterie Copyright(C)2012 Jos� Das Neves
 Logiciel de billetterie libre. 
D�velopp� depuis Factux Copyright (C) 2003-2004 Guy Hendrickx
Licensed under the terms of the GNU  General Public License:http://www.opensource.org/licenses/gpl-license.php
File Authors:Guy Hendrickx
Modification : Jos� Das Neves pitu69@hotmail.fr*/

 
error_reporting(0);
$lang_new_config_ok="Votre nouvelle configuration est enregistree";
$lang_nbr_impression="Nombre d'impressions";
$lang_choix_Impression="Utiliser l'impression automatique";
////variables ajout�es
$lang_lots ="Lots";
$lang_choix_use_stock = "Utiliser le module de stocks";
$lang_administra = "Administration";
$lang_choix_theme ="Choisir le theme de Net-Billetterie";
$lang_choix_use_lot ="Utiliser le module de lots";
$lang_use_payement = "Utiliser le module de type de paiement des factures";
$lang_use_list_client = "Utiliser le listage avance des spectateurs ";
$lang_use_cat ="Utiliser le module des categories";
$lang_modif_par ="Modifier les parametres du logiciel";
$lang_cr_lot ="Creer un lot.";
$lang_depenses_par_fournisseur ="Statistiques par fournisseur ";
$lang_conf_env = " Etes-vous sur de vouloir enregister la facture n°";
$lang_conf_env2= "par mail au spectateur";
$lang_conf_notif =" Etes-vous sur de vouloir notifier le spectateur";
$lang_conf_notif2 ="de l\'existence de la facture ";
$lang_par ="par";
$lang_conf_carte_reg =" Etes-vous sur de vouloir regler la facture n° ";
$lang_con_env_pdf=" Etes-vous sur de vouloir envoyer par mail le billet n°";
$lang_con_env_notif=" Etes-vous sur de vouloir notifier par mail le spectateur du billet n°";
$lang_mode_paiement ="Mode de paiement";
$lang_carte_ban ="Carte";
$lang_pay_ok =" reglee ";
$lang_paypal ="Paypal";
$lang_non_pay = "Non payee";
$lang_virement = "Virement";
$lang_visa = "Visa";
$lang_liquide ="Liquide";
$lang_status_pay = " Statut de paiement ";
$lang_Pour_mont ="Pour un montant de";
$lang_aj_au_bon = "Ajouter un autre billet";
$lang_cre_fac_orph ="Creer une facture a partir du billet n°";
$lang_num_dev ="Devis n° ";
$lang_tele = "Telephone";
$lang_fax = "Fax";
$lang_civ = "Civilite";
$lang_nouv_categorie = "Nouvelle categorie ajoutee";
$lang_cat_nom ="nom de la categorie";
$lang_categorie_ajout= "Ajouter une categorie";
$lang_tarif_ajout= "Ajouter un tarif";
$lang_nom_tarif= "nom du tarif";
$lang_tarif_liste= "liste des tarifs";
$lang_prix_tarif= "prix du tarif";
$lang_categorie = "Categorie";
$lang_err_ancien_mdp ="votre ancien mot de passe est incorrect veuillez le verifier ";
$lang_stock="Places restantes";
$lang_stomin="Places min. ";
$lang_stomax="Nbr. places depart ";
$lang_stock_jour="spectacle mis a jour";
$lang_regler_fact2 ="au statut regle ?";
///Variables modifi�es
$lang_conf_effa ="Desirez-vous vraiment effacer cette ligne du bon de livraison ?";
$lang_con_effa = "Desirez-vous vraiment effacer le bon de livraison n° ";
$lang_regler_fact = " Etes-vous sur de vouloir mettre la facture n° ";
$lang_art_effa= " Etes-vous sUr de vouloir effacer le spectacle ";
$lang_lot_inact= " Etes-vous sur de vouloir desactiver le lot n° ";
$lang_cli_effa = " Etes-vous sur de vouloir effacer le spectateur ";
$lang_eff_dev = " Etes-vous sur de vouloir effacer le devis n°";
$lang_convert_dev = " Etes-vous sur de vouloir transformer le devis n°";
$lang_convert_dev2 = "en reservation?";
$lang_dev_perd = " Etes-vous sur de vouloir mettre le devis n°";
$lang_dev_perd2 ="au statut perdu ?";
$lang_eff_conf_dep = "Etes-vous sur de vouloir effacer la depense n°";
////

////
$lang_fi_b_c="billet";
$lang_facture="Facture";
$lang_fact_mu_err = "Aucune facture n'a ete cree le ";
$lang_imp_multi = "Impression multiples";
$lang_fact_multi ="Factures multiples";
$lang_facture_impri ="Imprimer les factures";
$lang_facture_onclick ="Imprimer les factures faites le";
$lang_deflang = "Langue par defaut";
$lang_po_acquis = "Pour acquit";
$lang_nouv_d="Nouvelle facture de ";
$lang_nouv_add ="Une nouvelle facture vous a etee adressee par";
$lang_salut_dist="Vous la trouverez en piece jointe de mail\n Salutations distinguees";

$lang_condi_ven = "Vos conditions de vente ici \n deuxieme ligne \n troisieme ligne \n";
$lang_Lister_lots = "Lister les lots";
$lang_com_cont_lot = "Les billets qui contiennent le lot"; 
$lang_lot = "lots";
$lang_num_lot ="N° de lot";
$lang_lot_four = "N° de lot fournisseur ";
$lang_ingred = "Ingredient";
$lang_produit = "Produit";
$lang_all_lots = "Tous les lots";
$lang_impo_del_util = "impossible d'effacer cet utilisateur . Vous devez tout d'abord lui retirer les droits d'administration";
$lang_con_effa_utils = "Ests vous sur de vouloir effacer cet utilisateur ?";
$lang_rest_pay = "Solde à payer";
$lang_acompte = "acompte";
$lang_ctrl = "Vous pouver choisir plusieurs spectateurs en enfoncant la touche 'Ctrl' de votre clavier";
$lang_choi_cli_utis = "Choisir les spectateurs pour cet utilisateur";
$lang_choi_cli_enr = "vous devez a present choisir les spectateurs qu\'il pouras gerer";
$lang_don_rest = "vous aver donne des droits restreints a l'utilisateur"; 
$lang_est_enr = "est maintenant enregistre et a comme login:";
$lang_ret_cli_util = "Retirer un spectateur a cet utilisateur";
$lang_admi_modu = "Les droits d'administration donnent l'acces a tout les autres modules";
$lang_dr_admi = "A les droits d'administrateurs";
$lang_ger_cli ="Peut gerer les spectateurs ?";
$lang_ger_art = "Peut gerer les spectacles ?";
$lang_ger_stat = "Peut gerer les statistiques ?";
$lang_ger_dep = "Peut gerer les depenses ?";
$lang_ger_fact = "Peut gerer les factures ?";
$lang_ger_com = "Peut gerer les reservations ?";
$lang_ger_dev = "Peut gerer les devis ?";
$lang_val_actu = "Valeur Actuelle";
$lang_util_droit = "Les droits de cet utilisateur";
$lang_utilisateur_editer = "Editer un utilisateur";
$lang_retirer = "Retirer";
$lang_multi_ctrl = "Vous pouver choisir plusieurs spectateurs en enfoncant la touche 'Ctrl' de votre clavier";
$lang_ajou_cli_util = "Ajouter un spectateurs pour cet utilisateur";
$lang_oui = "oui";
$lang_non = "non";
$lang_restrint = "restrind";
$lang_list_utl = "Lister les utilisateurs";


$lang_client_droit = "Vous n'avez pas les droit necessaire pour gere les spectateurs contactez l'administrateur si vous penser qu'il y a erreur";
$lang_article_droit = "Vous n'avez pas les droits necessaires pour gerer les spectacles contacter l'administrateur si vous penser qu'il y a erreur";
$lang_tarif_droit = "Vous n'avez pas les droits necessaires pour gerer les tarifs. Contacter l'administrateur si vous penser qu'il y a erreur";
$lang_statistique_droit = "Vous n'avez pas les droits necessaire pour voir les statistiques contactez l'administrateur si vous pensez qu'il y a erreur";
$lang_depense_droit = "Vous n'avez pas les droit pour gere les depenses contacter l'administrateur si vou pensez qu'il y a erreur";
$lang_facture_droit = "Vous n'avez pas les droits necessaire pour gerer les factures contactez l'administrateur si vous pensez qu'il y a erreur.";
$lang_commande_droit = "Vous n'avez pas les droit necessaire pour gerer les reservations contactez l'administrateur si vous pensez qu'il y a erreur.";
$lang_devis_droit = "Vous n'avez pas les droits necessaires pour gerer les devis contactez l'administrateur si vous pensez qu'il y a erreur";
$lang_admin_droit = "vous n'avez pas les droit necessaire il faut etre administrateur pour pouvoir acceder a cette page";


$lang_mdp_jour = "Votre mot de passe a ete mis a jour ";
$lang_dif_mail_mdp = "Modification  de votre mot de passe";
$lang_mdp_chang = "Votre mot de passe a ete change <br>Un mail vas etre envoye avec vos nouveau login et mot de passe ";
$lang_err_mdp_corr = "Erreur les deux mots de passe ne correspondent pas";
$lang_err_chan_mdp = "Erreur!!!!Vous devez absolument remplir touts les champs <br> Veuiller vous reedentifier avec vos ancien login et mot de passe";
$lang_chng_mdp = "Changer de mot de passe";
$lang_con_cli = "convertit par le spectateur";
$lang_bad_log = "Mauvais login / password. Merci de recommencer";
$lang_mail_ref = "refuse par le spectateur";
$lang_conf_conv = "Veuiller confirmer et ajouter un message pour l'administrateur";
$lang_refu = "Refuser";
$lang_accepter = "Accepter";
$lang_non_facu = "Non facturees";
$lang_non_reg = "Non reglees";
$lang_non_com = "Non commande";
$lang_moi_cli = "Par mois un spectateur";
$lang_stat_art = "C.A par spectacle";
$lang_cli_moi = "Par spectateur 1 mois";
$lang_ca_cli = "C.A par spectateur";
$lang_annuelles = "annuelles";
$lang_sortir = "Sortir";
$lang_back_men = "Backup";
$lang_mainling_list ="Mailing-list";
$lang_aj_utl ="Ajout utilisateur";
$lang_cherc = "Chercher";
$lang_creer = "Creer";
$lang_lister = "Lister";
$lang_admini = "administrateur";
$lang_en_cli = "Entree spectateurs";
$lang_en_admi = "Entree administration";
$lang_ident = "Veuiller entrer vos donnees d'identifications. ";
$lang_notif_env = "Notification de changement du mot de passe envoye ";
$lang_pass_modif = "Modification de votre mot de passe";
$lang_mail_li_up1= "Cher spectateur<br>Votre mot de passe a ete mis a jour par l'administrateur<br>Login:";
$lang_mail_cli_up = "Ce mot de passe etant encode dans notre base de donnees, il nous est impossible de vous le renvoyer si vous le perdiez.";
$lang_ba_imp ="Base imposable";
$lang_fact_num_ab = "Facture n°:";
$lang_totaux = "Total:";
$lang_num_bon_ab = "billet n°:";
$lang_de = "de";
$lang_page = "Page";
$lang_condi = "Facturation a suivre fin de mois\n De faktuur zal op het einde van de maand toe gestuurd worden\n";
$lang_prix_htva = "Prix ";
$lang_dev_pdf_soc = "Societe\nSiege social\n Tel/Fax\n  email";
$lang_ajo_fact = "Ajouter un commentaire sur la facture (facultatif)";
$lang_bon_enregistrer = "Enregistrer le billet";
$lang_bon_ajouter = "Ajouter a la reservation";
$lang_bon_editer = "Editer le billet";
$lang_dev_date = "Date du devis";
$lang_ga_per = "Gagne/Perdu";
$lang_de_num = "Devis n°";
$lang_ajo_com_dev = "Ajouter un commentaire sur le devis";
$lang_ajo_com_bo = "Ajouter un commentaire sur la reservation (facultatif)";
$lang_factpdf_penalites_conditions = "Conditions de vente au verso Algemene verkoopsvoorwaarden, zie keerzijde.\n";
$lang_t_tva = "Taux tva";
$lang_con_per = "Etes-vous sur de vouloir mettre ce devis au statut perdu ?";
$lang_con_gag = "Etes-vous sur de vouloir mettre ce devis au statut gagne ?";
$lang_con_effa_dev = "Etes-vous sur de vouloir effacer ce devis ?";
$lang_tarif_effa = "Etes-vous sur de vouloir effacer ce tarif ?";
$lang_mail_a = "mail(s) envoye(s) :";
$lang_benef = "Benefice";
$lang_factux = "Net-Billetterie logiciel libre de billetterie";
$lang_de_per = "Votre devis $num_dev est maintenant au statut de devis perdu";
$lang_sup_li = "Desirez-vous vraiment effacer cette ligne du bon de livraison ?";
$lang_edit_bon = "Editer un billet";
$lang_che_dep = "Chercher une depense";
$lang_no_dep = "N° de depense";
$lang_cli_jour = "Le spectateur a ete mis a jour";
$lang_noti_pa = "Notification du mot de passe envoye ";
$lang_mai_cre = "Cher spectateur<br>Votre mot de passe a ete cree par l'administrateur <br>Login:";
$lang_mai_cr_pa = " Mot de passe:";
$lang_source_fac = "Net-Billetterie est une logiciel open source ";
$lang_mai_cre_enc = "<br><br>vous pouver changer ce mot de passe en ligne mais pas le login. <br>Ce mot de passe est encode dans notre base de donnees .<br>Si vous le perdiez, veuilliez prevevir l ";
$lang_pass_nou = "pour qu'il vous en donne un nouveau ";
$lang_cre_mo_pa = "Creation de votre mot de passe";
$lang_er_mo_pa = "Erreur le login existe deja";
$lang_mot_pa = "Erreur les deux mots de passe ne correspondent pas";
$lang_dev_cov = "Le devis $num_dev a bien ete converti en bon de reservation $max ";
$lang_evo_ben = "Evolution du benefice";
$lang_evo_ca = "Evolution du C.A.";
$lang_periode = "Periode";
$lang_dep_htva = "Depenses hors tva";
$lang_bc_login = "Nom de la base de donnees";
$lang_back_upl = "Si vous desirez restaurer ce backup :<br> 1.Uploader le fichier sql dans le repertoire dump de Net-Billetterie 2.Executer l'utilitaire de Backup et choissiser l'option restaurer un backup";
$lang_back_effac = "Votre demande d'effacement de backup s'est bien deroule";
$lang_back_utili = "Utilitaire de backup de Net-Billetterie";
$lang_voir = "Voir";
$lang_rest = "Restaurer";
$lang_tai = "Taille";
$lang_fichier = "Fichier";
$lang_back_restO2 = "Si vous n'avez recu aucune erreur alors vos tables ont bien ete restaurees. Ce script peut restaurer uniquement les backup crees avec l'utilitaire de backup de Net-Billetterie ";
$lang_back_resto = "Votre restauration de backup a ete effectuee sans problemes ";
$lang_back_ext = "Fichier backup.sql extrait de $file. ";
$lang_back_ti_re = "Utilitaire de backup de Net-Billetterie: Restaurer un backup";
$lang_back_ret = "Retour a l'utilitaire de backup";
$lang_back_lon2 = "Ce fichier ne peut etre restaure que grace a l'utilitaire de backup de Net-Billetterie et la base de donnee doit avoir le meme nom <br> N'oubliez pas d'effacer ce backup apres l'avoir telecharge. Laisser un backup sur le serveur est un risque potentiel pour la securite de Net-Billetterie.";
$lang_back_lon = "Si vous n'aver recu aucunes erreur sur cette page, vous trouverer le backup dans le repertoire 'dump' (sans les guillemets) dans le repertoire d'installation de Net-Billetterie <br> Ce fichier s'apelle 'backup.sql' . <br> Il contient les tables suivantes:<br>";
$lang_back_ok = "Votre backup a ete bien effectue";
$lang_back_titr = "MySQL PHP Backup :: Backup";
$lang_back_ex = "Pas d'extension";
$lang_back_comp = "Nom du fichier compresse:";
$lang_back_gzip = "Telecharger au format Gzip ";
$lang_sql = "Telecharger au format sql";
$lang_back_tel = "Telecharger le backup";
$lang_bac_efkf = "Effacer le backup";
$lang_back_ser = "Le backup doit etre sur le serveur dans le repertoire dump";
$lang_nom_back = "Nom du fichier de backup: backup.sql";
$lang_fi_back = "Creer un backup";
$lang_con_dev_effa = "Desirez-vous vraiment effacer ce devis ?";

$lang_dep_choi = "Vous devez soit choisir un fournisseur dans la liste soit en entrer un nouveau !!!";
$lang_dep_enr ="La depense a ete enregitree";
$lang_rappel = "Selectionnez les factures a inclure au rappel";
$lang_erreur_var = " Je peux ecrire dans le fichier include/config/var.php . Veuillez reduire les droits de ce fichier a la lecture simple.";
$lang_erreur_common = "Je peux ecrire dans le fichier include/config/common.php . Veuillez reduire les droits de ce fichier a la lecture simple.<br>";
$lang_erreur_backup = "Il reste un backup dans le repertoire dump ceci presente un risque majeur de securite ";
$lang_erreur_insta ="Le repertoire installeur n'a pas encore ete efface ceci presente un risque majeur de securite<br> cliquer <a href='del_installeur.php?util=del'>ici</a> pour l'effacer ";
$lang_devis_compr = "Le devis de $nom comprend:";
$lang_nv_devis = "Creer un nouveau devis";
$lang_prixunitaire = "Prix unitaire";
$lang_reglement_conditions = "Conditions de reglement: Reglement 30 jours apres livraison";
$lang_interdit = "Vous n\'etes pas autorise a acceder cette zone";
$lang_devis = "Devis";
$lang_edi_cont_devis = "Modifier le contenu du $lang_devis";
$lang_devis_pluriel = "Devis";
$lang_devis_enregistrer = "Enregistrer le $lang_devis";
$lang_devis_ajouter = "Ajouter au $lang_devis";
$lang_devis_gagner="Gagner";
$lang_devis_perdre="Abandonner";
$lang_imprimer = "Imprimer";
$lang_supprimer = "Supprimer";
$lang_client_modifier = "$lang_editer le spectateur";
$lang_voir = "Voir";
$lang_tva = "T.V.A.";
$lang_commandes_lister = "Lister les reservations";
$lang_gagne_perdu = "Resultat";
$lang_articles_liste = "Liste des spectacles";
$lang_article_creer = "Creer un spectacle";
$lang_tarif_creer = "Creer un tarif";
$lang_tarif= "Tarif";
$lang_complement = "Type de reduction";
$lang_rue="Rue";
$lang_code_postal="Code postal";
$lang_ville="Ville";
$lang_numero_tva ="N° $lang_tva";
$lang_email = "e-mail";
$lang_bc_base = "Base de donnees";
$lang_annuler = "Annuler";
$lang_mailing_list_message = "Message";
$lang_mailing_list_titremessage = "Titre du message";
$lang_mailing_list = "La mailing list";
$lang_motdepasse = "Mot de passe";
$lang_motdepasse_changer = "Changer de $lang_motdepasse";
$lang_motdepasse_ancien = "Ancien $lang_motdepasse";
$lang_motdepasse_nouveau = "Nouveau $lang_motdepasse";
$lang_motdepasse_verification = "$lang_motdepasse (pour verification)";
$lang_nom = "Nom & Prenom";
$lang_prenom = "Prenom";
$lang_mail = "Adresse email";
$lang_mot_de_passe = "Mot de passe";
$lang_utilisateur_nom = "Nom d'utilisateur (login ";
$lang_utilisateur_ajouter = "Ajouter un utilisateur";
$lang_ca_par_client_1mois = "Statistiques par spectateur de";
$lang_pourcentage = "Pourcentage";
$lang_ca_annee = "C.A. de l'annee";
$lang_ca_par_client = "C.A. par spectateur pour";
$lang_depenses_liste = "Liste des depenses";
$lang_regler = "Regler";
$lang_depuis ="Depuis";
$lang_resultat_net = "Resultat net";
$lang_oublie_champ = "Vous avez oublie de remplir un champ.";
$lang_authentification_ko = "Vous n'etes pas autorise a acceder cette zone";
$lang_authentification_ok = "Authentification reussie.";
$lang_bienvenue = "Bienvenue";
$lang_facture_creer = "Creer une nouvelle facture";
$lang_date="Date";
$lang_commande_numero = "Reservation n°";
$lang_commandes_non_facturees = "Reservations non facturees";
$lang_commandes_liste="Reservations du mois";
$lang_choisissez="Choisissez";
$lang_commandes_chercher = "Chercher un Reservation";
$lang_devis_numero="$lang_devis n°";
$lang_numero="N°";
$lang_devis_date = "Date du $lang_devis";
$lang_devis_perdus = "Liste des $lang_devis perdus";
$lang_devis_chercher = "Rechercher un $lang_devis";
$lang_devis_cr�er = "Creer un $lang_devis";
$lang_devis_liste = "Liste des $lang_devis";
$lang_clients_existants = "Liste des spectateurs";
$lang_client_accesprive = "Optionnel <br>(pour permettre l'acces a la partie spectateur)<br>
Si vous entrez un login et mot de passe,<br> un mail sera envoye au spectateur <br>pour
lui en faire part. ";
$lang_articles_liste = "Liste des spectacles";
$lang_retablir = "Retablir";
$lang_devis_numero = "$lang_devis n°";
$lang_envoyer = "Enregistrer";
$lang_outils = "Outils";
$lang_articles = "spectacles";
$lang_factures = "Factures";
$lang_commandes = "Billeterie";
$lang_clients = "spectateurs";
$lang_depenses = "Depenses";
$lang_htva = "H.T.";
$lang_depenses_htva = "Depenses $lang_htva";
$lang_ca_htva = "C.A. $lang_htva";
$lang_ttc = "T.T.C.";
$lang_ca_ttc = "C.A. $lang_ttc";
$lang_ca_htva = "Chiffre d'affaire $lang_htva";

$lang_statistiques_basees_bons = "Les statistiques sont basees sur les bons de reservations.";
$lang_statistiques_par_client = "Les statistiques detaillees par spectateur";
$lang_articles_existants = "Les spectacles existants";
$lang_statistiques_annee = "Statistiques de l'annee";
$lang_statistiques = "Statistiques";
$lang_libelle = "Libelle";
$lang_depenses_par_fournisseur_mois = "Par Mois";
$lang_depenses_par_fournisseur_mois_annee = "Stat. Annee";
$lang_calculette = "Calculatrice";
$lang_depenses_tri_par_fournisseur = "Tri des depenses par fournisseur";
$lang_res_rech = "Resultat de la recherche";
$lang_fournisseur = "Fournisseur";
$lang_fournisseur_entrez = "Ou entrez le nom du fournisseur";
$lang_depense_ajouter = "Ajouter une depense";
$lang_oubli_champ = "Vous avez oublié de renseigner un champ.";
$lang_nouv_art = "Votre nouveau spectacle a bien ete ajoute dans la base.";
$lang_nouv_tarif = "Votre nouveau tarif a bien ete ajoute dans la base.";
$lang_commentaire = "Avec comme commentaire";
$lang_choix_client = "Vous devez choisir un spectateur.";
$lang_devis_cree = "Devis cree pour";
$lang_donne_devis = "Entrez les donnees du devis";
$lang_bon_cree = "Reservation cree pour";
$lang_bon_cree2 = "en date du ";
$lang_montant = "Montant";
$lang_facture_creer_bouton = "Creer la facture";
$lang_mois = "Mois";
$lang_donne_bon = "Entrez les donnees du billet";
$lang_quanti = "Quantite";
$lang_article = "spectacle";
$lang_valid = "Valider";
$lang_editer = "Modifier";
$lang_enre = "billet enregistre";
$lang_champ_oubli = "Vous avez oublie de remplir un champ.<br>$lang_editer le billet pour continuer";
$lang_nv_bon = "Creer un nouveau billet";
$lang_bon_compr = "Le billet de $nom comprend:";
$lang_li_tot = " $quanti $uni de $article pour un total de $tot Euro ";

$lang_suprimer = "Suprimer";
$lang_som_tot = "Pour une somme totale de <font size = 4>$total_bon Euro $lang_htva</font>";
$lang_som_tot2 = "Pour une somme totale de ";
$lang_mont_tva = " et un montant de $lang_tva de ";
$lang_ajou_bon = "Ajouter ce spectacle au carnet";
$lang_ter_enr = "Terminer et enregistrer";
$lang_ex_rech = "Executer une recherche";
$lang_num_bon = "Numero du billet";
$lang_jour = "Jour";
$lang_jours = "jours";
$lang_annee = "Annee";
$lang_tri = "Trier par";
$lang_date = "Date";
$lang_client_enr = "Votre nouveau spectateur $nom a bien été enregistrée.";
$lang_effacer_bon = "Êtes-vous sur de vouloir effacer la réservation $num_bon de $nom ?";
$lang_effacer = "Effacer";
$lang_client = "spectateur";
$lang_rech = "Rechercher";
$lang_client_ajouter = "Ajouter un spectateur";
$lang_bon_effa = "La réservation $num_bon a été effacée.";
$lang_li_effa = "La ligne a été effacée.";
$lang_continuer = "Continuer";
$lang_err_edi_bon = "Ce bon fait partie d'une facture vous ne pouvez plus l'$lang_editer.";
$lang_edi_bon = "$lang_editer un bon de livraison.";
$lang_cont_bon = "Le billet de $nom comprend ";
$lang_cont_devis = "Le devis de $nom comprend ";
$lang_tot_de = "pour un total de";
$lang_bon_comp = "Le billet de $nom comprend:";
$lang_pou_so_to = "Pour une somme totale de <font size = 4>$total_bon Euro $lang_htva";
$lang_to_tva = " et un montant de T.V.A de <font size = 4>$total_tva Euro ";
$lang_edi_cont_bon = "$lang_editer le contenu d'un billet";
$lang_modifier = "Modifier";
$lang_modi_nom = "Modifier le nom";
$lang_err_fact = "Certains billets appartiennent deja a une facture.";
$lang_err_fact_2 = "Il n'y a pas de billets pour ce spectateur durant cette periode.";
$lang_unite = "Unite";
$lang_quantite = "Quantite";
$lang_factpdf_penalites_taux = "Taux de penalite de retard pour l'annee.";
$lanf_tot_arti = "Total spectacle";
$lang_facture_date_debut = "Date d'amission";
$lang_po_rec ="Pour \n reception:";
$lang_devis_date_debut = "Date d'emission";
$lang_devis_date_fin = "Devis valable jusqu'au";

$lang_dev_effa = "Le devis a bien ete efface";
$lang_societe = "Societe";
$lang_siege_social = "Adresse";
$lang_tel_fax = "Tel / Fax";
$lang_numero_tva = "N° TVA";
$lang_email = "e-mail";
$lang_sortir = "Sortir";
$lang_factures_non_reglees_total = "Total";
$lang_rappel = "Rappel";
$lang_prix_h_tva = "Prix H.T.";
$lang_total_h_tva = "Total H.T.";
$lang_total_ttc = "Total";
$lang_taux_tva = "% $lang_tva";
$lang_tot_tva = "Total $lang_tva";
$lang_date_bon = "Date du billet";
$lang_impri = "Imprimer";
$lang_total = "Total";
$lang_total_annee = "$lang_total de l'annee";
$lang_total_mois = "$lang_total du mois";
$lang_tot_ttc = "$lang_total $lang_ttc";
$lang_tou_fact = "Toutes les factures";
$lang_factures_non_reglees = "Factures non reglees";
$lang_factures_chercher = "Chercher des Factures";
$lang_li_tot2 = "$quanti$uni de $article au prix de $tot";
$lang_date_fact = "date fact";
$lang_date_deb = "Date de debut";
$lang_date_fin = "Date de fin";
$lang_facture_date = "Date de la facture";
$lang_pay = "Reglee ?";
$lang_action = "Action";
$lang_err_efa_bon = "Ce billet fait partie d'une facture, vous ne pouvez plus le supprimer.";
$lang_err_vider_bon = "Pour pouvoir effacer cette reservation,<br> il faut d'abord la vider avec l'outil \" modifier la reservation\" <br> situe dans la liste.<br> Seules les reservations avec 0.00&euro; au Total, peuvent etre supprimees </br><a href='lister_commandes.php'>Retour a la liste</a>";
$lang_err_vider_bon2 = "Pour pouvoir effacer cette reservation,<br> il faut d'abord la vider avec l'outil \" modifier la reservation\" <br> situe dans la liste.<br> Seules les reservations avec 0.00&euro; au Total, peuvent etre supprimees </br><a href='lister_billetterie.php'>Retour a la liste</a>";
$lang_art_jour = "Prix du spectacle mis a jour";
$lang_montant_htva = "Montant ";
$lang_total_htva = "$lang_total ";
$lang_montant_ttc = "Montant ";
$lang_modi_pri ="Modifier le spectacle";
$lang_nv_pr_art = "Nouveau prix  unitaire de";
$lang_ajou_art ="Ajouter un nouvel spectacle";
$lang_art_no = "Nom du spectacle";
$lang_tarif_no = "Nom du tarif";
$lang_uni_art = "Unite du spectacle (kg, pcs, gr....)";
$lang_prix_uni = "Prix  unitaire";
$lang_prix_uni_abrege = "P.U.";
$lang_ttva = "% $lang_tva";
$langCommentaire ="Commentaire (optionel)";
$langCommentaire2 ="Commentaire";
$lang_cre_bon = "Choisir un spectateur";
$lang_10_der_bon ="Les 10 derniers billets";
$lang_crer_bon = "Editer une reservation";
$lang_fai_rec = "Faire une recherche";
$lang_bc_bata_pwd = "Mot de passe";
$lang_login = "Login";
$lang_bc_bata = "mot de passe mysql";
$lang_bc_host = "Host";
$lang_bc_titre = "Sauvegarde de la base de donnees";
$lang_devis_editer = "$lang_editer le devis";
$code_langue = "fr_FR";

// Variable rajouter par la Maison pour Tous Salle des Rancy, Lyon //
$lang_abonne_jp = " Abonnee jeune public ";
$lang_abonne_chanson = " Abonnee chansons ";

?>
