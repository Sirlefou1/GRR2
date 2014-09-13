<?php
# Les quatre lignes suivantes sont à modifier selon votre configuration
# ligne suivante : l'adresse de l'annuaire LDAP.
# Si c'est le même que celui qui heberge les scripts, mettre "localhost"
$ldap_adresse='toto';
# ligne suivante : le port utilisé
$ldap_port='dsfdsf';
# ligne suivante : l'identifiant et le mot de passe dans le cas d'un accès non anonyme
$ldap_login='dsfdsf';
# Remarque : des problèmes liés à un mot de passe contenant un ou plusieurs caractères accentués ont déjà été constatés.
$ldap_pwd='dsfdsf';
# ligne suivante : le chemin d'accès dans l'annuaire
$ldap_base='';
# ligne suivante : filtre LDAP supplémentaire (facultatif)
$ldap_filter='';
# ligne suivante : utiliser TLS
$use_tls=FALSE;
# Attention : si vous configurez manuellement ce fichier (sans passer par la configuration en ligne)
# vous devez tout de même activer LDAP en choisissant le "statut par défaut des utilisateurs importés".
# Pour cela, rendez-vous sur la page : configuration -> Configuration LDAP.
?>