# Installer - WordPress Installation

The `Installer` command is a part of `wpenv-console` that simplifies the process of installing WordPress for your web application.

## Usage

To install WordPress, use the following command:

```bash
php nino wp:install
```

You can customize the installation by providing the following options:

- `--title` (`-t`): Set the blog title. (Default: "Web Application:{random_number}")
- `--user` (`-u`): Set the admin username. (Default: "admin")
- `--email` (`-e`): Set the admin email address. (Default: "admin@example.com")

For example, to customize the installation with your own title, username, and email:

```bash
php nino wp:install --title "My WordPress Site" --user myadmin --email admin@mywebsite.com
```

## Installation Parameters

The `Installer` command runs the WordPress Quick Installer with the specified parameters. If WordPress is successfully installed, it will provide you with the following information:

- User ID: The user ID for the admin user.
- Username: The admin username.
- Password: The admin password.
- Email: The admin email address.

Be sure to change the login information before deploying to a production environment for security purposes.

## Support and Feedback

For questions, issues, or feedback related to the `Installer` command or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
