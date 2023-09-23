# Backup Command - WordPress Backup

The `BackupCommand` is a part of `wpenv-console` designed to simplify the process of creating backups for your WordPress web application, including database backups and file backups.

## Usage

To create a backup of your WordPress web application, use the following command:

```bash
php nino backup
```

This command will create a backup of your entire WordPress setup, including both database and file backups.

### Configuration

The `BackupCommand` reads configuration settings from your `.env` file to determine various parameters for the backup process. Ensure that your `.env` file contains the necessary settings:

- `DB_NAME`: The name of your WordPress database.
- `DB_USER`: The database username.
- `DB_PASSWORD`: The database password.
- `DB_HOST`: The database host.
- `DB_PREFIX`: The database table prefix.
- `WP_HOME`: The WordPress home URL.
- `S3_BACKUP_DIR`: (Optional) Specify a custom directory for storing backups on Amazon S3.
- `BACKUP_PLUGINS`: (Optional) Enable or disable including plugins in the backup.

### Example

Create a backup of your WordPress web application:

```bash
php nino backup
```

## Support and Feedback

For questions, issues, or feedback related to the `BackupCommand` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
