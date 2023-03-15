for /l %%v in (0, 1, 1000000) do (

ECHO 'Loading...'
php -f C:\wamp64\www\JAUGE\update_inventory_orange.php
timeout 60
)