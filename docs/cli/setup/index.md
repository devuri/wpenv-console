# Setup Command - Search and Replace Domain in Multiple Files

The `Setup Command` is a part of `wpenv-console` that simplifies the process of configuring and setting up a WordPress environment. This command is particularly useful when you need to quickly setup your WordPress project.

## Usage

To run the `Setup Command`, use the following command:

```bash
php nino setup your-new-domain.com
```

Replace `your-new-domain.com` with the domain you want to set up. The command will search for specific configuration files and update them with the new domain.

## Configuration Files

The `Setup Command` searches for and updates the following configuration files:

- `.env`: The environment configuration file.
- `.htaccess`: The Apache `.htaccess` file.
- `robots.txt`: The `robots.txt` file.

If any of these files do not exist in your project directory, the command will create them based on the corresponding example files (e.g., `.env-example`) if available.

## Database Prefix

The command also generates a random database prefix (e.g., `wp_12345678_`) and updates it in the `.env` file to ensure database table name uniqueness. This is done to prevent conflicts in the database when using multiple WordPress installations.

## Security Salts

Security salts are essential for enhancing the security of your WordPress installation. The command automatically generates salts and appends them to the `.env` file. If the `.env` file does not exist, it will create a new one with the salts.

## Auto-login Secret

The command adds an auto-login secret to the `.env` file, which can be used to generate auto-login URLs for users. This feature can be helpful during development and testing.

## Note

- Ensure that you have a backup of your project before running this command, especially if it involves changing the domain.
- Review the updated configuration files to ensure accuracy after running the command.

## Support and Feedback

For questions, issues, or feedback related to the `Setup Command` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
