php app/console doctrine:generate:entity --no-interaction --entity="WabboxLettreBundle:Personne" --fields="nom:string(50) prenom:string(50) adresse:string(255) codePostal:integer(7) telephone:integer(15) ville:string(50) mail:string(50)" --format=annotation --with-repository
php app/console doctrine:generate:entity --no-interaction --entity="WabboxLettreBundle:Contenu" --fields="objet:string(50) message:text" --format=annotation --with-repository
php app/console doctrine:schema:update --dump-sql
php app/console doctrine:schema:update --force
php app/console generate:doctrine:crud --entity=WabboxLettreBundle:Personne --format=yml --with-write=yes --no-interaction
php app/console generate:doctrine:crud --entity=WabboxLettreBundle:Contenu --format=yml --with-write=yes --no-interaction
