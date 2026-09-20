#!/bin/bash
cd /home/o9tc2mmly06p/public_html
timeout 45 /opt/alt/php84/usr/bin/php artisan queue:work database --queue=massive-update-picks,emails-picks,email-notifications,expired-subscriptions --sleep=1 --tries=3 --timeout=40 --max-jobs=20