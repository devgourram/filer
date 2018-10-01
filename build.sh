#!/bin/bash
echo "Debut du build"
branch=$(echo $1 | sed "s/origin\///g")
git fetch -p origin
git checkout $branch
git reset --hard origin/$branch

echo "Composer update"
/usr/sbin/composer -v update --no-interaction --prefer-dist
if [ "$?" != "0" ]; then
    exit 1;
fi
echo "Lancement des tests phpunit"
phpunit
if [ "$?" != "0" ]; then
    exit 1;
fi
echo "PHPCS Symfony2"
/var/lib/jenkins/vendor/bin/phpcs  /var/lib/jenkins/jobs/FilerBundle/workspace/. -n --ignore=Tests,vendor,Controller --error-severity=1 --standard=vendor/escapestudios/symfony2-coding-standard/Symfony2
if [ "$?" != "0" ]; then
    exit 1;
fi

echo "PHPCS PSR2"
/var/lib/jenkins/vendor/bin/phpcs  /var/lib/jenkins/jobs/FilerBundle/workspace/. -n --ignore=Tests,vendor,Controller --error-severity=1 --standard=PSR2
if [ "$?" != "0" ]; then
    exit 1;
fi
echo "build passed"
echo "Fin du build"
exit 0;
