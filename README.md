# Free-Mobile-SMS-API

# Surveillance d'état des appareils avec envoi de SMS

Ce script en PHP permet de surveiller l'état de plusieurs appareils en utilisant des requêtes Ping et envoie des SMS via le service FreeboxSMS pour informer de tout changement d'état (en ligne ou hors ligne) des appareils surveillés.

## Configuration

1. Assurez-vous d'avoir les informations d'authentification FreeboxSMS (`USER` et `PASS`) correctes dans le script.

2. Ajoutez les appareils que vous souhaitez surveiller à la liste `$devices` dans le script. Chaque appareil doit être défini avec un nom, une adresse IP et éventuellement un numéro de port.

3. Le fichier de cache `$cacheFile` stocke l'état précédent des appareils. Assurez-vous que le script a la permission d'écrire dans le dossier contenant ce fichier.

## Utilisation

1. Placez le script PHP sur votre serveur ou exécutez-le localement si vous avez un environnement PHP configuré.

2. Le script vérifiera périodiquement l'état des appareils et enverra des SMS lorsque l'état change.

3. Le script enverra un SMS de confirmation au lancement de la surveillance pour chaque nouvel appareil ajouté.

## Dépendances

- Le script utilise la commande `ping` pour vérifier la connectivité avec les appareils. Assurez-vous que cette commande est disponible sur votre système.

- Le script utilise la fonction `file_get_contents` pour envoyer des requêtes HTTP. Assurez-vous que cette fonction est activée sur votre serveur et qu'il est autorisé d'accéder à l'API de FreeboxSMS.

## Avertissements

- Assurez-vous de respecter les limites d'envoi de SMS imposées par le service FreeboxSMS.

- Des erreurs ou des problèmes d'exécution peuvent survenir en fonction de la configuration de votre serveur et de l'environnement PHP.

- Ce script est fourni à titre d'exemple et peut nécessiter des modifications pour répondre à vos besoins spécifiques.
