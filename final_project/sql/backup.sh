#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/sql/backups"
MYSQL_HOST="${MYSQL_HOST:-database}"
MYSQL_USER="${MYSQL_USER}"
MYSQL_PASSWORD="${MYSQL_PASSWORD}"
MYSQL_DATABASE="${MYSQL_DATABASE}"

mysqldump -h $MYSQL_HOST -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > $BACKUP_DIR/backup_$TIMESTAMP.sql

find $BACKUP_DIR -name "backup_*.sql" -type f -mmin +60 -delete

echo "Backup complete!"