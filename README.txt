GRR
=======================================
http://grr.mutualibre.org


GRR est un outil de gestion et de réservation de ressources. GRR est une adaptation d'une
application MRBS.


1. Installation
2. License
3. Remarques concernant la sécurité


1. Installation
=======================================

Pour obtenir une description complète de la procédure d'installation,
veuillez vous reporter au fichier "INSTALL.txt".

Pour une installation simplifiée, décompressez simplement cette archive sur un
serveur, et indiquez l'adresse où se trouvent les fichiers extraits dans un navigateur (ex: http://www.monsite.fr/grr).

* Préalables pour l'installation automatisée :
- disposer d'un espace FTP sur un serveur, pour y transférer les fichiers
- disposer d'une base de données MySQL (adresse du serveur MySQL, login, mot de passe)

2. Licence
=======================================

GRR est publié sous les termes de la GNU General Public Licence, dont le
contenu est disponible dans le fichier "license.txt", en anglais et dans le fichiers "licence_fr.html" en français.
GRR est gratuit, vous pouvez le copier, le distribuer, et le modifier, à
condition que chaque partie de GRR réutilisée ou modifiée reste sous licence
GNU GPL.
Par ailleurs et dans un soucis d'efficacité, merci de rester en contact avec
le développeur de GRR pour éventuellement intégrer vos contributions à une distribution ultérieure.

Enfin, GRR est livré en l'état sans aucune garantie. Les auteurs de cet outil
ne pourront en aucun cas être tenus pour responsables d'éventuels bugs.


3. Remarques concernant la sécurité
=======================================

La sécurisation de GRR est dépendante de celle du serveur. Nous vous recommandons d'utiliser
un serveur Apache sous Linux, en utilisant le protocole https (transferts de données cryptées), et en
veillant à toujours utiliser les dernières versions des logiciels impliqués
(notamment Apache et PHP).

L'EQUIPE DE DEVELOPPEMENT DE GRR NE SAURAIT EN AUCUN CAS ETRE TENUE
POUR RESPONSABLE EN CAS D'INTRUSION EXTERIEURE LIEE A UNE FAIBLESSE DE GRR OU
DE SON SUPPORT SERVEUR.