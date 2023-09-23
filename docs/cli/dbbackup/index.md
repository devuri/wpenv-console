# Database Backup - Backup WordPress Database

The `Database Backup` command is a part of `wpenv-console` that allows you to create a backup of your WordPress database.

## Usage

To create a backup of the WordPress database, use the following command:

```bash
php nino db:backup
```

This command will create a SQL dump of your WordPress database and save it to a designated directory.

## Backup Location

The backup will be saved in the following directory within your WordPress project:

```
<project_root>/storage/.sqldb
```

The backup file will have a unique filename based on your database name, followed by `-db.sql`.

### Example Backup Location

If your database name is `mywordpressdb`, the backup file will be named:

```
<project_root>/storage/.sqldb/mywordpressdb-db.sql
```

## Support and Feedback

For questions, issues, or feedback related to the `Database Backup` command or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
