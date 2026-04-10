test:	
	echo "lancement des tests avec couverture"	
	php vendor/bin/phpunit --coverage-html=coverage --testdox

fixtures:
	echo "chargement des fixtures pour l'env de test"
	php bin/console doctrine:fixtures:load --env=test

quality:
	php ~/Tools/phpcbf.phar src
