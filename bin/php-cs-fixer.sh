#!/bin/bash
echo "Fixing src/ folder"
php-cs-fixer fix classification/ --level=symfony

echo "Fixing tests/ folder"
php-cs-fixer fix regression/ --level=symfony
