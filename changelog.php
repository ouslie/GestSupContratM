<meta charset="UTF-8" />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 24/09/2018             <br />
# @Version : 3.1.35     	 	 <br />
#################################<br />
<br />
<u>Notice:</u><br />
- Système: L'extenstion PHP curl est désormais requise<br />
<br />
<u>Update:</u><br />
- Connecteur IMAP : La date de création du ticket correspond à la date du mail (./mail2ticket.php ./components/PHPImap/mailbox.php)<br />
- Composant : Highcharts 6.1.3 (./components/Highcharts/*)<br />
- Adminisration : des nouveaux styles sont disponible dans la liste des états des tickets (./admin/list.php)<br />
- Système : Ajout d'un contrôle sur le listing des répertoires. (./system.php)<br />
<br />
<br />
<u>Bugfix:</u><br />
- URL : mise en conformité avec la RFC1738 (menu.php)<br />
- Paramètres : Une erreur SQL pouvait apparaitre lors de la validation des paramètres de la fonction disponibilité (plugin/availability/admin/parameters.php)<br />
- Liste des tickets : Dans certains cas le filtre utilisateur était vide (SQL)<br />
- Fil d'Ariane : Dans certains une erreur de redirection était observée (./index.php)<br />
- Ticket : Les libellé d'identation des éditeurs de texte était inversé (./wisiwyg.php)<br />
- Ticket : Lors de la saisie d'un titre possèdant des guillemets, si un changement de catégorie était réalisée le texte était tronqué (./tidecket.php)<br />
- Ticket : Lors d'une copie de lien hypertext possèdant une balise href dans la résolution, erreur d'affichage du lien. (./thread.php)<br />
- Ticket : Des erreurs pouvait apparaitre avec l'utilisation du droit ticket_date_hope_disp (./ticket.php)<br />
- Ticket : Désactivation de la mémorisation des champs date qui masquaient les datepickers (./ticket.php)<br />
- Ticket : Lors de la création de ticket avec la planification sans enregistrelement des problèmes apparaissaient (./ticket.php)<br />
- Liste des tickets : Certains tickets caractère dans le titre des tickets entrainait des défaut d'affichage dans la liste (./dashboard.php)<br />
- Équipement : Désactivation de la mémorisation des champs date qui masquaient les datepicker (./asset.php)<br />
- Statistques : Erreur de prise en compte du filtre agence sur l'export CSV sur certaines configurations. (./core/export_ticket.php)<br />
- Calendrier : Erreur de double chargement des styles fullcalendar. (./index.php)<br />
- Administration : Ajout d'un contrôle sur la verification de la formation des adresses mails sur la fiche utilisateur. (./admin/user.php)<br />
- Administration : Ajout d'un controle sur l'existance du login lors de l'ajout ou la modification d'un utilisateur. (./admin/user.php)<br />
- Fiche utilisateur : La section "Membre du groupe" de l'onglet paramètre conservait les groupes supprimés. (./admin/user.php)<br />
- Mail : La notification automatique d'attribution au technicien ne fonctionnait pas lorsque toutes les notificiations automatiques étaient activées. (./core/auto_mail.php)<br />
- Mail : Contrôle de la présence d'une adresse mail de destination avant d'envoyer le mail. (./core/mail.php)<br />
- Sauvegardes : Sur certaines configurations une erreur lors du dump SQL se produisait (./admin/backup.php)<br />
- Connecteur LDAP : Gestion des comptes AD avec les valeurs UserAccountControl à 544, 546, 66080, 66082 (./core/ldap.php)<br />
- Connecteur LDAP : Lors de l'utilisation de l'authentification, un message d'erreur apparaissait dans les logs apache en cas d'erreur d'identifiant ou de mot de passe (./login.php)<br />
- Connecteur IMAP : Erreur sur l'import de certains mails avec certaines pièces jointe (./mail2ticket.php)<br />
- Session : Erreur de déconnexion automatique lorsque l'actualisation automatique était activée sur la liste des tickets (./index.php)<br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 17/08/2018             <br />
# @Version : 3.1.34     	 	 <br />
#################################<br />
<br />
<u>Update:</u><br />
- SSO : Compatibilité avec IIS Server (./index.php)<br />
- LDAP : Suppression de limite de synchronisation à 1000 utilisateurs pour les serveurs LDAP AD (./core/ldap.php)<br />
- Composant : Highcharts 6.1.1 (./components/Highcharts/*)<br />
- Composant : PHPmysqldump 2.5 (./components/PHPmysqldump/*)<br />
- Composant : FullCalendar 3.0.9 (./components/Fullcalendar/*)<br />
<br />
<br />
<u>Bugfix:</u><br />
- Mail : Envoi de mail automatique de clôture fonctionne en utilisant le bouton "clôturer ticket" pour un profil technicien ou administrateur(./core/auto_mail.php)<br />
- Mail : Envoi de mail automatique de sondage fonctionne en utilisant le bouton "clôturer ticket" pour un profil technicien ou administrateur(./core/auto_mail.php)<br />
- Mail : L'affichage de l'ordre ante-chronologique ne fonctionnait pas dans certains cas (./core/mail.php)<br />
- Ticket : les saut de lignes n'était pas enregistrés dans certains cas.(./core/ticket.php)<br />
- Ticket : Sur le champ type la sélection de l'entrée "aucun" n'était pas conservée lors de la sélection d'une catégorie.(./ticket.php)<br />
- Ticket : Le passage multiple en privée d'un element de résolution n'était pas pris en compte .(./thread.php)<br />
- Traduction : Certains libellé n'était pas traduit.(./calendar.php)<br />
- Équipement : lors de l'utilisation de la fonction d'import la création du fabricant ne fonctionnait pas dans certains cas.(./core/import_assets.php)<br />
- Équipement : lors de l'utilisation de la fonction d'import la comparaison avec les données du logiciel ne tiennent plus compte de la casse.(./core/import_assets.php)<br />
- Statistiques : Message d'erreur dans certains cas lors de l'export de ticket, si un ticket était associé à un groupe de technicien (./core/export_ticket.php)<br />
- Administration : Sur les paramètres du connecteur IMAP le dossier n'était pas sauvegardé (./admin/parameters.php)<br />
- Calendrier : Le calendrier gère le multi-langues (./calendar.php)<br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 11/06/2018             <br />
# @Version : 3.1.33     	 	 <br />
#################################<br />
<br />
<u>Update:</u><br />
- Statistiques : Mise à jour du composant Highcharts en version 6.1.0 (./components/Highcharts/* ./stat.php)<br />
- Ticket : mise en forme de l'impression identique aux mails (./ticket_print.php)<br />
- Ticket : Sur le champ titre, limite de la saisie à 100 caractères. (./ticket.php)<br />
<br />
<br />
<u>Bugfix:</u><br />
- Mail : le mail automatique lors de l'assignation d'un ticket à un technicien est émit aussi lorsque le bouton sauvegarder et quitter est utilisé (./core/auto_mail.php)<br />
- Mail : le mail automatique lors de l'assignation d'un ticket à un technicien est émit depuis l'adresse mail de l'utilisateur connecté si non renseigné dans les paramètres (./core/auto_mail.php)<br />
- Mail : Erreur SQL lors de l'utilisation d'agences (./core/mail.php)<br />
- Menu : Sur la page des statistique il n'était pas possible de réduire le menu de gauche (./index.php)<br />
- Connecteur LDAP : Erreur SQL sur la synchronisation de groupe de service AD (./core/ldap_services.php)<br />
- Équipement : la recherche multi-critère ne fonctionne pas dans certains cas. (./core/searchengine_asset.php)<br />
- Équipement : Export lors de l'export . (./core/searchengine_asset.php)<br />
- Administration : Dans les listes l'id interne 0 n'apparait plus . (./admin/list.php)<br />
- Administration : Dans les paramètres généraux, le logo est redimensionné . (./admin/parameters.php)<br />
- Droit : Erreur de droit sur le droit side_all_agency_disp . (./index.php)<br />
- Ticket : Dans certains cas avec les navigateurs Microsoft, une résolution vide était ajouté . (./core/ticket.php)<br />
- Ticket : Erreur dans le nom du technicien sur un transfert . (./core/ticket.php)<br />
- Moniteur : Erreur d'accès avec certaines clés privés . (./monitor.php)<br />
- Traduction : Erreur de traduction du téléphone sur la fiche utilisateur . (./locale/.php)<br />
- Traduction : Sur PHP7 et un serveur Windows des pages non traduites pouvait apparaitre de manière aléatoire. (./localization.php)<br />
- Système : Amélioration du contrôle du post_max_size et upload_max_filesize . (./system.php)<br />
- Fiche utilisateur : Sur le champ service lors de l'ajout d'un nouveau service la liste contenait des services désactivés . (./admin/user.php)<br />
- Procédure : Dans certains cas le texte n'était pas sauvegarder . (./wysiwyg.php)<br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 08/05/2018             <br />
# @Version : 3.1.32     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Administration: Dans les paramètres généraux les listes: "État par défaut à la connexion" et "État par défaut lors de la création de tickets" tient compte des nouveaux états crée dans la liste des états des tickets (./admin/parameters.php) <br />
- Calendrier: Un nouveau bouton est "Ouvrir le ticket est disponible" (./admin/parameters.php) <br />
- Calendrier: Lors de la planification d'un ticket depuis le ticket, le titre de l'événement intègre le numéro du ticket (./event.php) <br />
- Composant: Mise à jour de PHPMailer en version 6.0.5 (./components/PHPmailer/*)<br />
- Ticket: Sur l'ajout ou modification d'un utilisateur la liste déroulante était trop large avec des noms sociétés longs. (./ticket_adduser.php)<br />
- Ticket: Sur un ticket avec une intervention planifié, lien disponible qui ouvre un nouvel onglet vers le calendrier. (./ticket.php)<br />
- Ticket: Une confirmation est demandée avant la suppression d'un ticket. (./ticket.php)<br />
- Ticket: Lors de la suppression d'un ticket, si des événements dans le calendrier ils sont aussi supprimés. (./core/ticket.php)<br />
- Ticket: Mise à jour de l'icône des pièces jointes. (./attachement.php)<br />
- Mail: Envoi automatique de mail au technicien lors de l'attribution d'une ticket au technicien. (./admin/auto_mail.php.php)<br />
<br />
<br />
<u>Bugfix:</u><br />
- Menu: Erreur menu déroulant "Tous les tickets" depuis la page Calendrier (./index.php) <br />
- Ticket: Erreur lors de la planification d'un ticket si ce dernier à un apostrophe dans le titre (./event.php) <br />
- Ticket: Erreur du chargement de certaines pièces jointes possédant certains caractères spéciaux (./core/upload.php) <br />
- Ticket: Erreur dans le fil de résolution lors de l'ouverture d'un ticket par le connecteur IMAP dans le nom de l'éxecutant (./thread.php)
- Connecteur IMAP: Erreur d'affichage des tickets sur les mails possédant la balise "base" (./mail2ticket.php) <br />
- Connecteur IMAP: Erreur d'envoi de mail automatique à l'utilisateur lors de l'utilisation en ligne de commande (./mail2ticket.php ./core/mail.php) <br />
- Fonction Sondage: Le ticket passait en non lu pour le technicien lors de la clôture du sondage" (./survey.php) <br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 20/03/2018             <br />
# @Version : 3.1.31     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Composant: Mise à jour de PHPimap en version 3.0.6 (/components/PHPimap/*)<br />
- Mail: Sur les mails manuels il est possible de spécifier une adresse saisie manuellement dans les paramètres du message (./core/mail.php ./preview_mail.php)<br />
- Mail: Ajout d'un contrôle sur la présence du mail de l'administrateur dans les envois de mail automatique à l'administrateur (./core/auto_mail.php)<br />
- Calendrier: Refonte complète de la fonction (./calendar.php ./index.php ./menu.php ./core/calendar.php ./template/assets/js/bootbox.min.js ./template/assets/js/jquery-ui.custom.min.js ./template/assets/js/jquery.min.js  ./template/assets/css/fullcalendar.css ./template/assets/js/uncompressed/fullcalendar.js)<br />
- Export Ticket: Ajout de la colonne lieu (./core/export_ticket.php)<br />
- Erreurs Apache: Mise à disposition des pages d'erreur apache répertoire /error/* cf documentation apache<br />
- Fiche utilisateur: Gestion du téléphone mobile en plus du téléphone fixe (./admin/user.php ./ticket_adduser.php ./core/ldap.php)<br />
- Mobile: Optimisation mobile (./thread.php ./ticket.php ./admin/user.php)<br />
- Sauvegarde: intégration du composant mysqldump-php, pour la sauvegarde de la base de données (./admin/backup.php ./components/mysqldump-php/*)<br />
- Administration des listes: La liste des sous-catégories est trié par catégorie puis sous-catégorie (./admin/list.php )<br />
<br />
<br />
<u>Bugfix:</u><br />
- Traduction: Le contenu de la liste déroulante de la sous-catégorie sur un ticket n'était pas traduite (./ticket.php) <br />
- Mail: Pas d'envoi de message automatique si le demandeur est un groupe (./core/auto_update)<br />
- Mail: Sur certaines pièce jointes avec certains caractères spéciaux l'extension était mal formé (./core/upload.php)<br />
- Ticket: l'ordre des types n'était pas pris en compte (./ticket.php)<br />
- Ticket: Alignement du cadre de la description par rapport à la résolution (./ticket.php)<br />
- Administration: La liste des utilisateur était trié par nom uniquement ajout du trie par nom et prénom (./admin/user.php)<br />
- Statistiques: Certains graphique ne s'affichait pas si un simple guillemet était présent dans le nom du technicien (./stat/histo_load.php + pie_tickets_tech.php)<br />
- Import équipement: insertion de multiple états (./core/import_asset.php)<br />
- Fonction sondage: prise en compte du timezone définit dans les paramètres (./survey.php)<br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 19/02/2018             <br />
# @Version : 3.1.30     	 	 <br />
#################################<br />
<br />
<u>Notice:</u><br />
- Monitor: Page déplacée, utiliser le nouveau lien présent dans les paramètres.<br />
<br />
<u>Update:</u><br />
-  Paramètre: un nouveau paramètre permet de définir le timeout de la session (./index.php ./admin/parameters.php)<br />
-  Paramètre: un nouveau paramètre permet de forcer le fuseau horaire, sur une valeur différente de celle de php.ini(./index.php ./admin/parameters.php)<br />
-  Système: Mise à jour des informations de sécurité (./system.php)<br />
-  Barre utilisateur: Mise à jour des avatars des profils (./images/avatar/*)<br />
-  Composant: Mise à jour du composant WOL version 2.1 (./components/wol/*)<br />
-  Sauvegarde manuelle: Ajout d'un contrôle sur la présence du dump SQL (./admin/backup.php)<br />
-  Mail automatique: Nouveau paramètre envoi a l'utilisateur lors de l'ouverture d'un ticket par l'utilisateur (./core/auto_mail.php ./core/ticket.php ./mail2ticket.php)<br />
<br />
<br />
<u>Bugfix:</u><br />
-  Fiche utilisateur: Erreur sur la liste des vues (./admin/user.php) <br />
-  Mail: Certains mails automatique n'était pas envoyé à l'adresse de copie si le demandeur n'avait pas d'adresse mail (./core/auto_mail.php) <br />
-  Connecteur IMAP: Lors de la reception d'un mail non HTML, l'adresse mail de l'émetteur n'était pas affiché dans la description du ticket (./mail2ticket.php) <br />
-  Liste des tickets: la priorité aucune n'avait pas la couleur grise (SQL) <br />
-  Ticket: lors de la sélection du demandeur, la liste des priorité faisait apparaitre deux fois la valeur sélectionnée dans la liste (./ticket.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 20/01/2018             <br />
# @Version : 3.1.29     	 	 <br />
#################################<br />
<br />

<u>Update:</u><br />
- Composant PHPMailer: Nouvelle version 6.0.3 (./components/PhpMailer)<br />
- Passage en requêtes préparées: (./admin/* ./register.php ./login.php)<br />
- Connecteur LDAP: Compatibilité avec Samba4 (./core/ldap.php)<br />
- Connecteur LDAP: Amélioration de la prise en charge des connexion chiffrés (./core/ldap.php)<br />
- Connecteur LDAP: SSO disponible cf FAQ (./index.php)<br />
- Système: Contrôle de version de PHP pour respecter les prérequis serveur (./system.php)<br />
- Paramètre: Augmentation de la taille maximal des adresses mail en copie à 150 char. (SQL)<br />
- Tickets: Insertion de lien possible dans la description, click droit pour ouvrir. (./wysiwyg.php)<br />

<br />
<br />
<u>Bugfix:</u><br />
- Paramètres Généraux: La liste des états par défaut ne tenait pas compte du renommage dans la liste des états (./admin/parameters.php) <br />
- Connecteur IMAP: erreur lors de la réception des mails (./mail2ticket.php) <br />
- Connecteur LDAP: Erreur de modification d'une fiche utilisateur suite synchro AD(./login.php) <br />
- Mail: Message d'erreur si le champ début de mail était à vide et l'utilisateur avec la langue anglaise (./core/mail.php) <br />
- Mail: Erreur lors de l'utilisation du bouton mail par l'utilisateur (./core/mail.php) <br />
- Mail: Erreur lors de l'envoi de mail avec le profile utilisateur avec pouvoir sur les mails d'ouverture automatique  (./core/auto_mail.php) <br />
- Variable non initialisée: La variable user_agent n'était pas initialisée, si non transmise par le navigateur (./index.php) <br />
- Ticket: Le champ résolution pouvaient ne pas être pris en compte sur les nouveaux tickets (./core/ticket.php) <br />
- Enregistrement utilisateurs: Certains message d'erreur n'était pas traduit si une langue différente du français était détectée (./register.php) <br />
- Liste des réseaux des équipements: Sur certaines colonnes la traduction n'était pas correct (./admin/list.php) <br />
- Équipements: Gestion de la date de derniers ping par interface (./core/asset_network_scan.php) <br />
- Fonction sondage: erreur SQL sur l'utilisation du lien présent dans le mail (./survey.php) <br />
- Statistiques: Le filtre par technicien n'était pas appliqué sur certains tableaux (./stat/tables.php) <br />
- Installation: Erreur de détection de l'HTTPS (./install/index.php) <br />
- Liste des équipements: La liste des équipements pouvait être mélangé si aucune ip n'étaient renseignés (./asset_list.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 04/12/2017             <br />
# @Version : 3.1.28     	 	 <br />
#################################<br />
<br />
<u>Update:</u><br />
- Composant PHPImap: Nouvelle version 3.0.5 (./components/PHPImap/*)<br />
- Équipement: Le bouton ping sur l'équipement IP, lance désormais un ping sur toutes les interfaces et affiche le drapeau à coté (./core/ping.php, ./asset.php)<br />
- Ticket: L'ordre d'affichage de la liste des catégories peut être définie manuellement dans l'administration des listes (./admin/list.php, ./ticket.php)<br />
- Fiche utilisateur: La saisie de mot de passe vide n'est plus autorisé (./admin/user.php)<br />

<br />
<br />
<u>Bugfix:</u><br />
- Menu Société: l'ouverture des tickets du menu société s'affichait avec une page blanche (./index.php) <br />
- Variable non initialisée: Si User-Agent header est filtré par un firewall (./index.php) <br />
- Variable non initialisée: La variable imap_user n'était pas initialisée(./admin/parameters.php) <br />
- Ticket: Dans certains cas des erreurs s'affichaient dans la liste des demandeurs (./ticket.php) <br />
- Ticket: AccessKey du bouton "Enregistrer et fermer" est désormais F (./ticket.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 17/10/2017             <br />
# @Version : 3.1.27     	 	 <br />
#################################<br />
<br />
<u>Update:</u><br />
- Composant PHPMailer: Nouvelle version 6.0.1 (./components/PHPMailer/*)<br />
- Ticket: Pour les utilisateurs du champ "service du demandeur" ce dernier est désormais associé au service du demandeur par défaut, si il n'en dispose que d'un (./ticket.php)<br />
- Profile utilisateur: Si la gestion des agences est activé alors il est possible de visualiser et modifier les associations d'agences sur la fiche utilisateur (./ticket.php)<br />
- Système: Ajout d'une section sécurité. (./system.php)<br />
<br />
<br />
<u>Bugfix:</u><br />
- Procédure: Les fichiers de plus de 10MO n'étaient pas transférés (./procedure.php) <br />
- Mails: Erreur lors de l'envoi de mail automatique alors que l'utilisateur ne dispose pas de mail ou que le demandeur "Aucun" à été sélectionné (./core/auto_mail.php) <br />
- Ticket: Suppression de l'affichage du pourcentage d'avancement du ticket dans le titre si le temps passé et temps estimé ne sont pas affichés (./core/ticket.php) <br />
- Ticket: L'ordre de trie des criticité tien uniquement compte de l'ordre définit dans la gestion des listes. (./ticket.php) <br />
- Liste des tickets: L'icône horloge rouge indiquant un retard, ne s'affiche plus si le droit sur la date de résolution estimé du ticket est désactivé. (./dashboard.php) <br />
- Barre utilisateur: Suppression de l'affichage du bloc "Charge" si l'affichage du temps passé et estimé ne sont pas affichés (./index.php) <br />
- Ticket non lu: erreur lors de l'utilisation du bouton cloture de ticket sur un profil technicien ou administrateur (./core/ticket.php)<br />
- Système: Erreur de contrôle de la quantité de mémoire quand la valeur était en gigabytes. (./system.php)<br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 14/09/2017             <br />
# @Version : 3.1.26     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Ticket: Deux icônes sont présent dans la barre des titre si un ticket est planifié ou si une alerte est positionnée (./ticket.php)<br />
- Ticket: Possibilité d'activer ou de désactiver le cloisonnement par service du champ type via un nouveau droit ticket_type_service_limit  (./ticket.php)<br />
- Ticket: Lors de la suppression d'une entrée dans la liste des temps, la valeur était perdu sur le ticket lors d'un nouvel enregistrement (./ticket.php)<br />
- Équipements: Il est possible de cloisonner les équipements par société, jonction entre un équipement et une société via l'utilisateur associé cf droit asset_list_company_only et doc. (./menu.php ./asset_list.php)<br />
- Procédure: Il est possible de cloisonner les procédure par société cf droit procedure_list_company_only et procedure_company. (./procedure.php)<br />
- Procédure: Le bouton de création d'une nouvelle procédure est désormais dans le menu de gauche, afin de s'uniformiser avec les création de ticket ou d'équipement. (./menu.php ./procedure)<br />
- Statistique Équipements: Il est possible de filtrer les graphiques par société a l'aide d'un nouveau filtre. (./procedure.php)<br />
- Export CSV Équipements: Le fichier CSV exporté contenant les équipement dispose d'une nouvelle colonne société. (./core/export_asset.php)<br />

<br /><br />
<u>Bugfix:</u><br />
- Ticket: Les tickets supprimés était encore accessible via le lien sur un mail (./index.php) <br />
- Calendrier: Les tickets supprimés était encore visible (./planning.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 04/09/2017             <br />
# @Version : 3.1.25     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Composant PHPImap: Nouvelle version 2.0.9 (./components/PHPimap/*)<br />
- Composant PHPMailer: Nouvelle version majeure 6.0.0 (./components/PHPMailer/*)<br />
- Mobile: Optimisation de l'affichage des tickets et des matériels sur mobile<br />
- Ticket et Fiche équipement: Il est possible d'utiliser les raccourcis clavier ALT+SHIFT+ X consulter les infos bulles des boutons pour connaitre les raccourcis (./ticket.php asset.php)<br />
- Ticket: Il est possible de cloisonner le type et la priorité par service (./ticket.php)<br />
- Liste des tickets: Sur les colonnes techniciens et utilisateur affichage du prénom et nom complet au survol de la souris (./dashboard.php)<br />

<br /><br />
<u>Bugfix:</u><br />
- Ticket: Nouveau droit permettant d'activer ou désactiver le verrouillage du champ technicien lorsque la limite par ticket est activée et qu'il déclare un ticket pour un autre service (./ticket.php) <br />
- Ticket: Lors de l'utilisation d'un modèle de ticket le lieu n'était pas dupliqué (./ticket_template.php) <br />
- Ticket: Lors de la modification d'un ticket, lors de la modification du service le premier changement n'était pas pris en compte (./ticket.php) <br />
- Liste des tickets: Dans la vue activité erreur lors de l'utilisation du filtre technicien deux fois de suite (./index.php ./dashboard.php) <br />
- Liste des tickets: Dans la vue activité lors de l'utilisation du bouton nouveau ticket si l'on envoi un mail la redirection n'était pas faites sur la vue activité (./menu.php ./core/ticket.php ./core/mail.php) <br />
- Mobile: Les champs d'auto complétion ne fonctionnait pas sur mobile (./asset.php ./ticket.php) <br />
- Statistique: La courbe des tickets résolu tenait compte uniquement de la date de résolution et pas de l'état(./stat/line_tickets.php ) <br />
- Système: Variable non initialisée si apache est en mode ServerTokens=Prod (./stat/system.php ) <br />
- Mails: Défaut d'affichage des mail dans outlook lors de l'impression liée à la taille du cadre (./core/mail.php ) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 04/08/2017             <br />
# @Version : 3.1.24     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Composant PHPMailer: Nouvelle version disponible https://github.com/PHPMailer/PHPMailer/releases/tag/v5.2.24 (./components/PHPMailer/*)<br />
- Liste des tickets: Il est possible de personnaliser pour l'ensemble des utilisateurs de l'application l'état par défaut à la connexion de l'application (nouveau paramètre). (./parameters.php ./login.php)<br />
- Tickets: Dans les éléments de résolution si un texte type lien est détecté, il est alors convertit en lien hypertexte. (./threads.php)<br />
- Équipements: les champs demandeur et localisation ont été optimisés avec de l'auto-complétion (./index.php ./asset.php)<br />
- Équipements: Amélioration de la vue garantie (./index.php ./asset.php)<br />
- Gestion des agences: Un utilisateur peut faire partie d'un service et d'une agence (./index.php)<br />
<br /><br />
<u>Bugfix:</u><br />
- Liste des tickets: Un défaut d'affichage pouvait apparaitre lors l'affichage de la colonne société (./dashboard.php) <br />
- Liste des tickets: Sur la vue activité certains anciens tickets pouvaient s'afficher en non lus (./dashboard.php) <br />
- Ticket: le bouton impression ne lançait plus la fenêtre système d'impression (./ticket_print.php) <br />
- Composant: le fichier de version de php-gettext pouvais ne pas être présent (components\php-gettext\VERSION) <br />
- Impressions: Les impressions dans le navigateur n'affiche plus les URL de tous les liens (./template/bootstrap) <br />
- Mail automatique: Avec certaines combinaison de paramétrage dans les mail automatique, l'option d'envoi de mail au technicien lors de la modification d'un ticket par un utilisateur ne fonctionnait pas (./core/auto_mail.php) <br />
- Statistiques: Sur le premier graphique d'évolution des tickets, les compteurs sous le titre étaient erronés et la courbe des tickets avancés ne donnait pas le nombre de tickets distinct (./stat_line.php ./stat/line_ticket.php)<br  />
- Statistiques: Sur le premier graphique la courbe des tickets avancés tenait compte des tickets fermés également (./core/ticket_line.php )<br  />
- Statistiques: Sur le filtre par technicien les administrateurs n'était pas présent dans la liste si paramétré  (./ticket_stat.php)<br  />
- Administration: Dans la gestion des listes les nom des colonnes sont désormais traduite (./admin/list.php)<br />
- Connecteur LDAP: la mise a jour d'adresse mail avec des apostrophes posait problème (./core/ldap.php)<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 18/07/2017             <br />
# @Version : 3.1.23     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Liste des tickets: Nouveaux compteurs disponible dans la vue activité, avec les tickets ouverts, fermés et avancé dans la période (./dashboard.php)<br />
- Liste des tickets: Nouvelles couleurs sur les numéros de tickets voir le détail en passant le curseur sur le numéro, un nouvel indicateur de nouveau ticket est présent: une pastille rouge, les couleurs sont valables sur la vue activité prenant en compte la période sélectionnée et sur les listes des tickets (./dashboard.php)<br />
- Liste des tickets: Nouvelle colonne disponible "service du demandeur" activable par un nouveau droit "dashboard_col_user_service" (./dashboard.php)<br />
- Ticket: Sur le champ agence avec un profil technicien lors de l'enregistrement d'un ticket, la liste des agences reste limité à celles associées au demandeur (./ticket.php)<br />
- Statistiques: Changement des couleurs des courbes d'évolution des tickets, rouge ouverts, vert fermés, bleu avancés (./stats/line_ticket.php)<br />
- Statistiques: Ajout de deux nouvelles colonnes dans le tableau des répartition des temps par statuts (./stats/tables.php)<br />
- Gestion des agences: Un technicien peut faire partie d'une agence et d'un service (./admin/parameters.php ./core/mail.php)<br />
<br /><br />
<u>Bugfix:</u><br />
- Ticket: l'ordre de trie du champ criticité après validation était inversé (./ticket.php)<br />
- Ticket: Le champ équipement restait affiché si la fonction équipement était active et que le champ était désactivé dans les droits (./ticket.php)<br />
- Liste des tickets: le filtre par lieu avoir des dysfonctionnements dans certains cas (./dashboard.php)<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 05/07/2017             <br />
# @Version : 3.1.22     	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Connecteur IMAP: Il est possible de supprimer l'indicateur "--- vous pouvez répondre..." dans les messages émit via une nouvelle option dans Administration > Paramètres > Connecteur IMAP "Gérer les réponses dans les mails" (./admin/parameters.php ./core/mail.php)<br />
- Connecteur IMAP: Possibilité d'activer ou désactiver la verification des certificats SSL du serveur de messagerie (./admin/parameters.php)<br />
- Connecteur LDAP: Il est possible de ne pas désactiver les utilisateurs crée manuellement dans GestSup lors d'une synchronisation LDAP cf paramètre du connecteur (./admin/parameters.php ./core/ldap.php)<br />
- Fonction sondage: L'adresse mail d'émission du mail de sondage est celle paramétré dans "Adresse de l'émetteur", si ce paramètre n'est pas renseigné alors c'est l'adresse mail du technicien qui est utilisé (./core/auto_mail.php)<br />
- Ticket: Il est possible d'associer un équipement à un ticket en fonction de l'utilisateur cf documentation et nouveaux droits (ticket_new_asset_disp,ticket_asset_disp,ticket_asset,ticket_asset_mandatory,dashboard_col_asset) (./ticket.php ./index.php ./core/ticket.php ./dashboard.php) <br />
- Ticket: Un nouveau droit permet d'afficher les techniciens sans les administrateurs dans la liste des techniciens cf "ticket_tech_admin" (./ticket.php) <br />
- Ticket: Un nouveau droit permet d'afficher les superviseurs dans la liste des techniciens cf "ticket_tech_super" (./ticket.php) <br />
- Ticket: Un nouveau paramètre permet de définir l'état par défaut des tickets (./ticket.php) <br />
- Menu: lors de l'utilisation du menu de gauche réduit avec le thème bleu affichage de l'icône de creation d'un nouveau ticket (./manu.php) <br />
<br /><br />
<u>Bugfix:</u><br />
- Lien nouvel onglet: Dans certains les liens sur nouveaux onglets ne fonctionnaient pas (./*) <br />
- Lien mail: Des anomalies pouvait être rencontré lors de l'utilisation du lien envoyé dans les mails aux utilisateurs (./login.php) <br />
- Fonction sondage: La date de résolution n'était pas automatiquement inséré lors de la cloture du ticket automatique par l'utilisateur (./survey.php) <br />
- Fonction sondage: Pas de mail de sondage à l'utilisateur si l'envoi de mail automatique à la création du ticket était paramétré et que le changement d'état avait lieu à l'ouverture du tickets (./survey.php) <br />
- Fonction sondage: L'utilisateur pouvait valider le sondage sans répondre à la dernière question (./survey.php) <br />
- Fonction sondage: Le mail à destination de l'utilisateur est émit avec l'adresse paramétré dans "Adresse de l'émetteur" dans les paramètres, si le champ est vide alors le mail sera émit avec l'adresse du technicien en charge du ticket (./core/auto_mail.php) <br />
- Fonction sondage: Le mail émit à destination de l'utilisateur gère désormais les serveurs de messagerie avec des certificats non vérifier (./core/messages.php) <br />
- Fonction disponibilité: La condition de prise en compte d'un ticket, ne fonctionnait pas avec le type (./ticket.php) <br />
- Fonction équipement: le WOL sur linux ne fonctionnait plus (./core/wol.php) <br />
- Fonction équipement: Dans l'administration de la liste des modèle lors de la création d'un nouvelle équipement la valeur IP n'était pas conservé. (./admin/list.php) <br />
- Fonction équipement: Augmentation du nombre de caractère disponible sur le champs numéro de prise de 10 à 50. (SQL) <br />
- Ticket: Erreur de changement automatique d'état lors de lors d'un transfert d'un technicien à un groupe de technicien (./survey.php) <br />
- Ticket: Lors de l'utilisation du paramètre "les utilisateurs ne voient que les tickets de leurs service" un technicien ne pouvait pas visualiser un ticket qu'il avait ouvert pour un autre service (./index.php ./dashboard.php ./menu.php) <br />
- Ticket: La liste des demandeurs n'affiche plus les utilisateurs n'ayant ni prénom ni nom.(./index.php ./dashboard.php ./menu.php) <br />
- Ticket: La liste priorité n'était pas trié par numéro.(./ticket.php) <br />
- Ticket: Erreur sur la priorité par défaut lors de la suppression des valeurs par défaut dans la liste des priorité.(./ticket.php) <br />
- Liste des tickets: Lorsque le demandeur ne possédait pas de prénom il n'était pas visible dans le filtre des demandeurs.(./dashboard.php) <br />
- Connecteur IMAP: Suppression de la gestion du protocole POP ne gérant pas les mails non lus (./admin/parameters.php) <br />
- Connecteur IMAP: Affichage des messages d'erreurs si le mode debug est activé (./mail2ticket.php) <br />
- Connecteur IMAP: erreur d'association avec l'utilisateur lorsque deux utilisateurs avait le même mail et l'un était désactivé (./mail2ticket.php) <br />
- Connecteur LDAP: Sur la synchronisation d'agences et de service le caractère Œ n'était pas gérée (./core/ldap_services.php, ./core/ldap_agencies.php) <br />
- Connecteur LDAP: Sur la synchronisation du champ société, gestion de la casse lors des mises à jours  (./ldap.php) <br />
- Connecteur LDAP: La liste des agences pour le déplacement n'était pas trié par ordre alphabétique (./admin/parameters.php) <br />
- Connecteur LDAP: Les unité d'organisations avec accents et espace sont géré (./core/ldap.php) <br />
- Statistique: Dans la répartition du temps par status, le temps total de traitement ne tenait pas compte du filtre par technicien (./stats/tables.php) <br />
- Statistique: Dans le tableau du top 10 demandeur la période sélectionnée n'était pas prise en compte (./stats/tables.php) <br />
- Enregistrement utilisateur: sur le formulaire d'enregistrement autonome des utilisateurs, les champs saisis étaient perdus en cas d'erreur (./register.php) <br />
- Utilisateur: Augmentation du nombre maximal de caractère pour le champ fonction, passage à 100 (SQL) <br />
- Service: Augmentation du nombre maximal de caractères pour le champ nom, passage à 100 (SQL) <br />
- Profil utilisateur: La liste des service ne tenait pas compte de la désactivation des services. (./admin/user.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 23/05/2017             <br />
# @Version : 3.1.21      	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Équipements: Les équipements IP qui n'ont pas de modèle IP mais possèdent une adresse IP disposent des boutons d'action IP et du drapeau de dernier ping (./asset.php)<br />
- Équipements: Module de scan réseau permettant de créer et mettre à jour des équipements IP, module en ligne de commande uniquement cf doc (./core/asset_network_scan.php)<br />
- Équipements: Nouveau paramètre dans la fonction équipement pour activer la prise de contrôle web VNC vers un équipement distant cf doc (./asset.php ./ticket.php ./admin/parameters.php)<br />
- Équipements: La fonction d'import des équipements gère les mises à jour dans GestSup si l'adresse MAC est renseigné, l'import peut être automatisé en ligne de commande cf doc (./core/import_asset.php)<br /> 
- Liste des équipements: Amélioration du tri par adresses ip avec INET_ATON (./asset_list.php)<br />
- Ticket: Les champs: technicien, titre et description peuvent remplit de manière obligatoire cf droits: ticket_tech_mandatory, ticket_title_mandatory, ticket_description_mandatory (./ticket.php ./core/ticket.php)<br /> 
- Ticket: Focus par défaut sur le champ demandeur (./ticket.php)<br />
- Mails: Possibilité de paramétrer le texte de fin de mail (Administration > Paramètres généraux), des balises sont disponibles pour le prénom, nom et téléphone du technicien (./core/mail.php ./admin/parameters.php)<br />
- Moniteur: Ajout de nouveaux compteurs (./monitor.php)<br />
- Statistiques: Fusion des graphiques sur les tickets ouverts et fermés et les résolutions (./monitor.php)<br />
<br /><br />
<u>Bugfix:</u><br />
- Ticket: Dans certains cas le champ service était affiché alors que le droit était désactivé (./ticket.php) <br />
- Ticket: Erreur de redirection avec les boutons annuler et clôturer ticket avec un profil utilisateur et le paramètre "Les utilisateurs peuvent voir tous les tickets de leur société" (./index.php) <br />
- Mail: le lien vers le ticket n'était pas inséré dans le mail lorsqu'un technicien n'avait pas de téléphone (./core/mail.php) <br />
- Statistiques: Dans certains cas une variable pouvait ne pas être initialisée sur le tableau d'évolutions des résolutions (./stat/line_tickets_activity.php)<br />
- Statistiques: Le filtre par agence ne fonctionnait pas pour certains profil (./stat.php)<br />
- Statistiques: Dans la répartition des temps par status certains états n'avait pas de valeurs (./stat.php)<br />
- Statistiques: Avec la gestion des agences et la restriction par service l'export des tickets en admin était vide (./core/export.php)<br />
- Équipement: Désactivation des interfaces associées à un équipement supprimé (./core/asset.php)<br />
- Ajout utilisateur: Lors de l'ajout d'un utilisateur ayant le profil technicien ou admin la selection d'une vue personnel effaçait les valeurs du formulaire saisie (./admin/user.php)<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 03/05/2017             <br />
# @Version : 3.1.20        	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Répertoire logs: nouveau repertoire logs disponible pour certaines fonction du connecteur LDAP (./logs/ldap_agencies.log ./logs/ldap_services.log) <br />
- Droits: le bouton de désactivation du droit admin est supprimé pour le profile administrateur (./admin/profile.php) <br />
- Mise à jour: Optimisation de la detection des droits d'écriture pour l'installation des mises à jour semi-automatique (./admin/update.php) <br />
- Paramètres: Augmentation du nombre de caractères de l'adresse mail d'envoi passage à 200 caractères (SQL) <br />
- Paramètre: Cloisonnement des utilisateurs par service<br />
- Paramètre: Cloisonnement des utilisateurs par agences<br />
- Utilisateur: Gestion de plusieurs service par utilisateur<br />
- Connecteur LDAP: Synchronisation des groupe LDAP de service ou d'agence<br />
- Connecteur IMAP: Gestion multi-bal par service<br />
- Fonction sondage: Nouvelle fonction sondage permettant de demander à l'utilisateur de remplir un questionnaire.(./survey.php ./core/export_surevey.php ./core/auto_mail.php ./core/ticket.php)<br />

<br /><br />
<u>Bugfix:</u><br />
- Administration: dans certains cas la liste des utilisateurs n'affichait pas la page 2 (./admin/user.php) <br />
- Liste des tickets: Avec certaines configurations apache les liens vers les tickets ne fonctionnaient pas (./dashboard.php) <br />
- Liste des tickets: lors de la selection des tickets en attente d'attribution dans le menu tous les tickets le menu vos tickets se dépliait (./menu.php) <br />
- Liste des tickets: Amélioration de l'affichage pour les résolution 1280*1024 (./dashboard.php) <br />
- Liste des tickets: Lors de l'utilisation du filtre par date de création ou date de résolution sur la vue activité redirection sur tous les ticket de la date sélectionnée (./core/ticket.php) <br />
- Liste des tickets: Lors de l'affichage de la colonne société avec un compte utilisateur un message d'erreur apparaissait (./dashboard.php) <br />
- Ticket: Lors de l'activation des champs obligatoire sur un ticket, les informations de changement d'état dans les éléments de résolution pouvaient être insérés en double (./core/ticket.php) <br />
- Ticket: Lors de la création d'un nouveau ticket le bouton impression est désactivé car aucune donnée n'est encore enregistrée (./ticket.php) <br />
- Ticket: Avec Internet explorer ajout de commentaire vide lors de l'enregistrement si l'on ajoute pas de texte (./core/ticket.php)<br />
- Ticket: Utilisateur Aucun était en double dans la liste des demandeurs lors de création d'un nouveau ticket dans certains cas (./ticket.php)<br />
- Ticket: Lorsqu'un utilisateur appuyai sur le bouton "clôture ticket" la date de résolution n'était pas inséré sur le ticket (./core/ticket.php)<br />
- Ticket: La liste des techniciens comportait aussi les administrateurs.(./ticket.php)<br />
- Ticket: La valeur par défaut du temps estimé sur un nouveau ticket crée par un utilisateur était d'un mois modification à 5 minutes.(./ticket.php)<br />
- Statistiques: Le chemin de fer de la sections statistique ne fonctionnait pas (./index.php)<br />
- Statistiques tickets: le tableaux top 10 des demandeurs de temps ne tenait pas compte du filtre global de service (./stats/tables.php)<br />
- Statistiques matériels: Le graphique d'évolution des équipements installés et recyclé ne tient plus compte des date d'installation à 0 sur la vue toutes les années  (./stats/line_asset.php)<br />
- Connecteur SMTP: Lors de l'envoi de mail contenant des images dans le corp quand elle n'était pas en base64 un message apparaissaient (./core/mail.php) <br />
- Connecteur IMAP: Lors de la reception d'un mail contenant une signature avec image en provenance d'un client outlook, défaut d'affichage dans les mail émit (./mail2ticket.php) <br />
- Connecteur LDAP: Suppression message d'avertissement T_() lors de l'utilisation de cron  (./core/ldap.php) <br />
- Connecteur LDAP: Gestion des adresses mail avec des apostrophes (./core/ldap.php) <br />
- Connecteur LDAP: Amélioration de la déconnexion serveur (./core/ldap*) <br />
- Rappel de ticket: Suppression de la description pouvant provoquer des difficultés d'affichage avec du code HTML (./event.php) <br />
- Rappel de ticket: L'ajout à la valeur demain ne fonctionnait pas (./event.php) <br />
- Rappel de ticket: L'utilisateur associé au rappel était le technicien du ticket, modification pour que ce soit l'utilisateur connecté.(./event.php) <br />
- Mise à jour automatique: un message d'avertissement apparaissait lors de l'installation de la mise à jour.(./admin/update.php) <br />
- Fonction disponibilité: un message d'erreur pouvait apparaitre avec certaines valeurs nulles.(./plugins/availability/core.php) <br />
- Administration liste modèle équipement: Sur l'ajout d'un nouvelle entrée les valeurs IP et WIFI n'était pas prises en compte.(./admin/list.php) <br />
<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 06/04/2017             <br />
# @Version : 3.1.19        	 	 <br />
#################################<br />
<br />
<u>Notice:</u><br />Augmentation du prés-requis mémoire allouée à PHP, passage de 256MB à 512MB. <br />
<br />
<u>Update:</u><br />
- Liste des tickets: Le bouton ce jour devient activité, montrant tous les tickets ouverts, fermés et sur lequel un élément de résolution à été ajouté aujourd'hui. (./dashboard.php) <br />
- Liste des tickets: Modification de la couleur des numéro de tickets, vert pour les fermés du jour, orange pour les ouverts du jour, bleu pour les tickets sur lesquels un élément de résolution à été ajouté et rouge pour les tickets non lu par le technicien en charge (./dashboard.php) <br />
- Liste des tickets: Sur la vue activité une selection de période est possible (./dashboard.php) <br />
- Liste des tickets: Lorsque le droit d'affichage de l'heure est donnée à la colonne date de création les secondes n'apparaissent plus. (./dashboard.php) <br />
- Ticket: Lors de la création d'un ticket par un technicien, si ce dernier ajoute directement une résolution alors le ticket passe automatiquement à en cours. (./core/ticket.php) <br />
- Ticket: Lors de la création d'un ticket par un utilisateur ne disposant pas de droit de modification de l'état le ticket passai dans l'état en attente de PEC au lieu de en attente d'attribution. (./core/ticket.php) <br />
- Ticket: Lors de l'ajout d'une résolution par un technicien lorsque le ticket est dans l'état en attente de PEC, la modification automatique de statut vers l'état en cours ne crée pas automatiquement de balise de changement d'état dans le fil de résolution. (./core/ticket.php) <br />
- Statistique: L'export des tickets et des matériels tiennent compte du filtre global. (./core/export_asset.php ./core/export_tickets ./stat.php) <br />
- Statistique: Nouvelle courbe de l'évolution des éléments de résolution dans la list tickets. (./ticket_stat.php ./stat/line_tickets_activity.php) <br />
- Statistique: Nouveau tableau reflétant les temps par status sur les tickets. (./ticket_stat.php ./stat/table.php) <br />
- Liste des équipements: une nouvelle colonne localisation est disponible cf droit asset_list_col_location (./asset_list.php) <br />
- Équipements: Nouveau champ localisation disponible sur la fiche équipement voir droit asset_location_disp (./asset.php ./core/asset.php) <br />
- Équipements: Redimensionnement automatique de l'image associée au modèle si cette dernière dépasse 250px.  (./core/ticket.php) <br />
- Équipements: Possibilité d'ajouter plusieurs interfaces IP à un équipement, une gestion des rôles d'interface est disponible dans la gestion des listes. (./images/images/plug.png ./tasset_iface.php ./asset.php ./core/asset.php ./admin/liste.php) <br />
- Équipements: La liste des états est trié par ordre définit dans la liste des états. (./) <br />
- Équipements: Sur la recherche de nouvelle adresse IP disponible, il est possible de configurer les états d'équipement à exclure de la recherche, paramètre "block_ip_search" dans la liste des états des équipements . (./asset_findip.php ./core/asset.php) <br />
- Équipements: Gestion des équipements virtuels, voir la liste des types d'équipement pour l'activer sur un type et ajouter le droit asset_virtualization_disp, certains champs de la fiche équipement seront automatiquement masqué si l'équipement est marqué comme virtuel (./asset.php) <br />
- Équipements: sur la fonction ping des équipements IP une vérification de la bonne formation d'une IPv4 est réalisé avant de déclencher le ping (./core/ping.php) <br />
- Menu: Toutes les section du logiciel dispose d'un favicon(./index.php ./images/favicon*) <br />
- Mise à jour: Ajout d'un contrôle sur les droits d'écriture sur la page des mises à jour (./core/update.php) <br />
- SQL: Optimisation des requêtes et des index (SQL ./*) <br />
- Composants: Mise à jour de PHPMailer en version 5.2.23 (./components/PHPmailer/*) <br />
- Traduction: Amélioration des traductions (./locale/*) <br />
<br /><br />
<u>Bugfix:</u><br />
- Ticket: Lors de la désactivation d'un utilisateur ce dernier n'était pas conservé sur le ticket en cas de ré-enregistrement (./ticket.php) <br />
- Ticket: Lors de la création d'un ticket par un utilisateur, pour le technicien la liste déroulante technicien pouvait contenir deux fois la valeur aucun (./ticket.php) <br />
- Ticket: Lors de la création d'un nouveau ticket avec le navigateur edge un élément de résolution vide apparaissait (./core/ticket.php) <br />
- Liste des tickets: Certaines colonnes n'étaient pas centrées (./dashboard.php) <br />
- Liste des tickets: Sur le filtre des lieux la page 2 ne fonctionnai pas, perte du filtre.(./dashboard.php) <br />
- Liste des tickets: Les filtres de date affichaient la valeur au format SQL "YYYY-MM-DD" au lieu de "DD/MM/YYYY".(./dashboard.php) <br />
- Liste des tickets: Le filtre titre ne fonctionnai plus. (./dashboard.php) <br />
- Liste des tickets: Le champ filtre de la date de création pouvait ne pas être centré sur les grands écrans.(./dashboard.php) <br />
- Liste des équipements: Lors du changement de filtre du status le choix vide (tous) n'était pas conservé. (./asset_list.php) <br />
- Liste des équipements: la selection courante ou la recherche pouvait être perdu à la suite de la suite de certaines modification d'un ticket. (./index.php ./asset_list.php ./asset.php ./core/asset.php) <br />
- Recherche tickets: Lors de la recherche de ticket avec un mot clé égale à un nom d'utilisateur, la recherche pouvait être erronée si deux utilisateurs avec le même nom étaient présent. (./core/searchengine_ticket.php) <br />
- Recherche tickets: Perte de la recherche lors de l'utilisation d'un filtre. (./core/searchengine_ticket.php) <br />
- Recherche équipement: Perte de la recherche lors de l'utilisation d'un filtre. (./core/searchengine_asset.php) <br />
- Équipement import: le fichier modèle d'import CSV avait un défaut d'encodage avec Excel (./downloads/tassets_template.csv)<br />
- Connecteur SMTP: Les messages émit par l'application possédant des images intégré dans les champs description ou résolution n'apparaissaient dans certain clients de messagerie (./core/mail.php) <br />
- Connecteur SMTP: Erreur sur certains serveurs de messagerie lors de l'envoi de message, cf nouveau paramètre connecteur "Vérification SSL" (./core/mail.php ./admin/parameters.php) <br />
- Connecteur LDAP: Lors de la synchronisation LDAP les utilisateurs disposant de login possédant des simple quote bloquai la synchronisation (./core/ldap.php) <br />
- Système: Les valeurs de mémoire alloué à PHP n'était pas vérifié dans certains cas (./core/mail.php) <br />
- Statistiques: Le graphique de répartition des tickets par société pouvait être affiché même lorsqu'il y en avait aucune (./ticket_stat.php) <br />
- Administration: Dans la liste des utilisateurs un défaut d'affichage sur la fiche prouvai apparaitre dans certains cas (./admin/user.php) <br />
- Fonction disponibilité: certaines variable pouvaient être non initialisé en l'absence de tickets (./plugins/availability/core.php) <br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 01/03/2017             <br />
# @Version : 3.1.18        	 	 <br />
#################################<br />

<br />
<u>Notice:</u><br />Pour les utilisateurs du connecteur IMAP, sachez que pour une meilleur gestion de la récupération des réponses dans les mails deux nouvelles lignes sont présentes sur les messages émit. <br />
<br />
<u>Update:</u><br />
- Ticket: Lien hypertexte de type "tel:" sur le numéro de téléphone, pour jonction application IPBX (./ticket.php) <br />
- Ticket: Le nom de la société peut être affichée dans la liste déroulante des demandeurs cf droit "ticket_user_company" (./ticket.php) <br />
- Liste des tickets: Les colonnes catégorie et sous-catégorie peuvent être masquées cf droit dashboard_col_subcat et dashboard_col_category (./dashboard.php)<br />
- Liste des tickets: Une nouvelle colonne avec la société associé à l'utilisateur est disponible cf droit dashboard_col_company (./dashboard.php)<br />
- Liste des tickets: Il est possible d'affiche l'heure de création des ticket en plus de la date cf droit dashboard_col_date_create_hour (./dashboard.php)<br />
- Liste des tickets: Il est possible d'arriver directement sur l'état "Tous les tickets à traiter", via le paramètre personnel "État par défaut" (./login.php ./admin/user.php)<br />
- Liste des sociétés: Ajout du champ "Country" dans la liste des sociétés dans la gestion des listes de la partie administration (SQL) <br />
- Paramètre ticket: Un nouveau paramètre "Numéro d'incrémentation" permet d'initialiser le compteur de ticket à une valeur souhaitée (./admin/parameters.php)<br />
- Connecteur IMAP: Il est possible d'exclure des adresses mails ou des domaines lors l'import de message, cf paramètre du connecteur (./mail2ticket.php /admin/parameters.php) <br />
- Connecteur IMAP: Il est possible de supprimer le mail ou le déplacer dans un dossier une fois convertit en ticket, cf paramètre du connecteur (./mail2ticket.php /admin/parameters.php) <br />
- Mails: L'ordre d'affichage des éléments de résolution dans les mails peut être antéchronologique, cf paramètre des messages (./core/mail.php /admin/parameters.php) <br />

<br /><br />
<u>Bugfix:</u><br />
- Ticket: Lors de la désactivation d'un technicien perte du technicien sur l'édition d'un ticket lui appartenant (./ticket.php) <br />
- Ticket: Problème d'alignement du champ mail sur l'édition d'un utilisateur (./ticket_useradd.php) <br />
- Ticket: Suppression de l'édition de l'utilisateur "Aucun" dans la liste des demandeurs (./ticket.php) <br />
- Liste des tickets: Dans la liste déroulante des techniciens les groupes de techniciens ne comportaient pas le préfixe [G] (./dashboard.php) <br />
- Mail: Le lien intégré vers le ticket n'était pas présent quand un groupe de technicien était en charge du ticket. (./core/mail.php) <br />
- Ajout utilisateur: Lors de l'ajout d'un nouvel utilisateur via "Administration" > "Nouvel Utilisateur" dans le champ téléphone un simple quote apparaissait. (./admin/user.php) <br />
- Connecteur IMAP: Ajout de tag sur les mails envoyés pour une meilleur récupération de la réponse (./core/mail.php ./mail2ticket.php) <br />
- Connecteur SMTP: Erreur d'envoi de message error:14090086:SSL avec certaines ancienne version de PHP (./core/mail.php) <br />
- Connecteur LDAP: Une variable pouvait être non initialisée (./core/ldap.php) <br />
- Statistiques: Le filtre sur le service n'était pas pris en compte sur le graphique de l'évolution dans le temps  (./stats/line_tickets.php ./stats/asset_stat.php) <br />
- W3C: Correction HTML balise font size obsolète<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 10/02/2017             <br />
# @Version : 3.1.17        	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Ticket: Les messages de résolution peuvent être masqués pour les utilisateurs cf droit ticket_thread_private ticket_thread_private_button (./core/ticket.php ./core/auto_mail.php ./ticket.php) <br />
- Affichage: Optimisations de l'affichage pour smart phones. (./index.php ./ticket.php)<br />
- Procédure: Ajout de fichiers joint.(./procedure.php)<br />
- Équipements: Possibilité de gérer des équipements non IP uniquement, cf paramètre de la fonction équipements.<br /> 

<br /><br />
<u>Bugfix:</u><br />
- Import d'équipement: Le répertoire d'import est automatiquement crée si il n'existe pas (./admin/parameters.php) <br />
- Ticket: La modification d'état ne fonctionnait pas si un technicien venait d'être attribué (./core/ticket.php) <br />
- Ticket: lors de la création d'un ticket issue du connecteur IMAP, si l'utilisateur est connu de l'application il devient le créateur du ticket (./mail2ticket.php)<br />
- Liste tickets: couleur grise sur la priorité aucune au lieu de la blanche qui n'était pas visible.<br />
- Liste tickets: Erreur sur l'affichage de la catégorie ou sous-catégorie aucune lors de l'affichage avec une autre langue (./dashboard.php).<br />
- Liste tickets: Le titre des vues n'apparaissaient pas (./dashboard.php).<br />
- Impression ticket: La traduction n'était pas prise en compte. (./ticket_print.php).<br />
- Statistique: Erreur d'affichage sur la charge par technicien (./stat_histo.php)<br />
- Statistique: Lors de la selection du service dans le filtre global une valeur erroné restai sélectionner (./ticket_stat.php)<br />
- Mail: Dans le contenu du mail, le tableau n'était pas bien dimensionné par certains clients de messagerie (./core/mail.php)<br />
- Menu: La sélection de l'état est conservé depuis un ticket ou la fiche d'un équipement (./ticket.php ./menu.php) <br />
- Menu: Le menu vos tickets restai ouvert même si l'on était sur la vue tous les tickets (./menu.php)<br />
- Paramètre: Le logo était supprimée lors de la modification d'un paramètre de l'onglet général (./parameters.php)<br />
- Moniteur: La page n'était pas traduite (./parameters.php ./monitor.php)<br />
- Fiche utilisateur: Lors du rattachement d'un utilisateur à un technicien, le nom de l'utilisateur apparaissait toujours dans la liste des utilisateurs  (./admin/user.php)<br />
- LDAP: Lors de la synchronisation LDAP le compte admin GestSup était désactivé si non présent dans l'annuaire AD (./core/ldap.php)<br />
- LDAP: Lors de la synchronisation LDAP erreur lors de la création d'utilisateur possédant des apostrophe dans le nom de leur ville (./core/ldap.php)<br />
- Connecteur IMAP: Défaut de nettoyage html dans certains mails émit par les clients outlook (./mail2ticket.php)<br />
- Administration: Dans la liste des utilisateurs si il y avait 31 utilisateurs alors une page 3 était affiché (./admin/user.php)<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 30/01/2017             <br />
# @Version : 3.1.16        	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Logo: Les logo trop grands sont automatiquement redimensionnés sur la page de login et dans le logiciel (./login.php ./index.php).<br />
- Procédure: un nouveau droit nommé "procedure_modify" permet de bloquer l'accès en modification sur les procédures à certains profils (./procedures.php)<br />
- PhpMailer: mise à jour 5.2.22 (./components/phpmailer/*.php)<br />
- Liste des tickets: Les colonnes "Type" et "Criticité" sont activables ou désactivables via les droits "dashboard_col_type" et dashboard_col_criticality (./dashboard.php ./index.php)<br />
- Équipement: Bouton retour liste disponible sur la fiche d'un équipement (./index.php)<br />
- Import de équipements depuis un csv: (./admin/parameters.php ./downloads/tassets_template.csv ./upload/asset ./core/import_assets.php)<br />
- Équipement: changement de nom des matériels pour équipements, car ils peuvent être virtuels (./locale/* ./stat/* ./asset*)<br />

<br /><br />
<u>Bugfix:</u><br />
- Ticket: Les noms des états dans la résolution lors d'un changement d'état n'étaient pas traduit. (./thread.php)<br />
- Ticket: Lors de la planification d'une intervention, l'utilisateur associé était celui connecté et non le technicien rattaché au ticket . (./thread.php)<br />
- Ticket: Le bouton retour liste ne conservait pas le numéro de la page. (./index.php ./dashboard.php ./core/ticket.php)<br />
- Liste tickets: Perte du filtre lors de l'appui sur le bouton "annuler" ou "Enregistrer fermer"  sur le ticket.(./core/ticket.php ./index.php ./dashboard.php)<br />
- Liste tickets: Perte de l'ordre de trie sur retour d'un ticket.(./core/ticket.php ./index.php ./dashboard.php)<br />
- Login: La langue du navigateur était affiché. (./localization.php)<br />
- Planning: la liste déroulante des techniciens ne conservait pas la selection. (./planning.php)<br />
- Planning: la liste déroulante des techniciens pouvait contenir des techniciens désactivés (./planning.php)<br />
- Planning: Variables numérique non initialisé avec PHP 7 (./planning.php)<br />
- Statistiques: Le camembert concernant la répartition de la charge de travail par catégorie restait à 100% sur une catégorie (./stats/pie_load.php)<br />
- Connecteur IMAP: Certaines images dans le contenu du message ne n'affichai pas correctement (./mail2ticket.php)<br />
- Connecteur IMAP: Lors de l'intégration de réponse depuis des clients Outlook certaines informations était en trop (./mail2ticket.php)<br />
- Login: La variable de langue pouvait ne pas être initialisé (./localization.php)<br />
- Écran de supervision: variable non initialisé au premier lancement (./monitor.php)<br />
- Rappel: variable non initialisé dans certains cas(./event.php)<br />
- Système: l'icône de MySQL ou MariaDB pouvait dans certain cas ne pas s'afficher (./images/MySQL.png ./images/MariaDB.png)<br />
- Équipement: sur la fiche équipement perte des données saisie avec le bouton "Enregistrer et Fermer" en cas d'erreur de l'adresse MAC (./core/asset.php)<br />
- Équipement: sur la fiche équipement sur le champ date de fin de garantie il n'était plus possible de le remettre à vide si les années de garantie était spécifié sur le modèle (./asset.php)<br />
- Équipement: Lors de la création d'un nouveau équipement la date d'installation n'apparaissait pas (./asset.php ./core/asset.php)<br />
- Liste équipements: Perte du numéro de la page en cours lors de l'utilisation du bouton "Annuler" ou "Enregistrer et Fermer" sur la fiche d'un équipement (./asset_list.php ./core/asset.php)<br />
- Liste équipements: Le trie par numéro n'affichait pas les flèches de trie (./asset_list.php)<br />
- Liste équipements: Perte du trie lors de l'utilisation de la flèche retour sur une fiche équipement (./core/asset.php)<br />
- Administration des listes: Les listes n'étaient pas triées par ordre alphabétique des noms (./admin/list.php)<br />
- Administration des groupes: variable type pouvait ne pas être initialisée (./admin/group.php)<br />
- Thème: L'arrière plan du thème gris possédait des rayures horizontales. (./template/assets/css/ace-skins.min.css)<br />

<br />
#################################<br />
# @Name : GestSup Release Notes  <br />
# @Date : 05/01/2017             <br />
# @Version : 3.1.15        	 	 <br />
#################################<br />

<br />
<u>Update:</u><br />
- Traduction: L'application est complètement disponible en Anglais, Allemand, Espagnol  (./*).<br />
- Composant: Mise à jour de PHPMailer version 5.2.21(./components/phpmailer/*).<br />
- Système: Affichage de la version des composants dans l'état système(./system.php ./components/*).<br />
- Mail2ticket: Diminution de l'affichage des informations d'import lorsque le mode debug n'est pas activé(./mail2ticket.php).<br />
- Ticket: Les changements d'état sont enregistrés dans la résolution (./core/ticket.php ./thread.php)<br />
- Équipement: Il est possible de planifier un ping pour tous les équipements réseau afin de remonter les équipements obsolète cf FAQ (./asset.php ./core/export_asset.php ./core/ping.php)<br />
- SGBDR: Compatibilité avec MariaDB, port personnalisable à l'installation de la version 3.1.15 (./images/mariadb.png ./images/mysql.png ./install/index.php ./system.php)<br />

<br /><br />
<u>Bugfix:</u><br />
- Menu des équipements: les compteurs par état ne fonctionnai pas. (./menu.php)<br />
- WOL: Le réveil des équipements par le réseau ne fonctionnai pas avec un serveur Windows quand le répertoire de l'application possédait un espace. (./core/wol.php)<br />
- Statistiques: Dans l'onglet équipement le comptage des équipements recyclés n'étaient pas correcte. (./stat/line_assets.php)<br />
- Statistiques: Sur le filtre la liste déroulante concernant les années n'était pas trié. (./asset_stat.php ./ticket_stat.php)<br />
- Liste des tickets: lors de la modification en lot vers l'état résolu, la date de résolution n'était pas renseignée sur le ticket (./dashboard.php)<br />
- Connecteur LDAP: Pas de création d'utilisateur GestSup si la valeur de l'identifiant retourné est vide (./core/ldap.php)<br />
- Planning: Erreur de numérotation de certains jours de la semaine en janvier 2017 (./planning.php)<br />
- Ticket: Erreur lors de la planification d'une intervention la date de début était à 0 (./event.php)<br />