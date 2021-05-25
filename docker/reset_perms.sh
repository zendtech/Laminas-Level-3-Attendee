#!/usr/bin/env bash
# Resets group permissions to "apache"
# Usage: reset_perms.sh

echo "Setting permissions ..."
chown apache:apache /srv/www
chgrp -R apache /home/*
chmod -R 775 /home/*
