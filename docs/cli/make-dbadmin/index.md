# Make Command - Create Database Admin Directory

The `Make Command` is a part of `wpenv-console` that allows you to create a database admin directory for your WordPress project. This directory is typically used to store database-related access, such as adminer.

## Usage

To create a database admin directory, use the following command:

```bash
php nino make:dbadmin
```

By default, this command will generate a unique directory name for your database admin directory. You can specify a custom directory name using the `--dir` option. For example:

```bash
php nino make:dbadmin --dir=mydbadmin
```

The command will create the database admin directory within the `public` directory of your WordPress project and update the `.env` file with the path to the newly created directory.

## Configuration

The `Make Command` updates the `.env` file with the path to the database admin directory using the `WP_DB_PHPADMIN` constant. Ensure that your `.env` file is correctly configured to use this constant.

## Note

If you already have the `WP_DB_PHPADMIN` constant defined in your `.env` file, the command will not create a new directory and will inform you of the existing configuration.

## Support and Feedback

For questions, issues, or feedback related to the `Make Command` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
