# WPEnv Console

[![License](https://img.shields.io/github/license/devuri/wpenv-console)](https://github.com/devuri/wpenv-console/blob/master/LICENSE)

`WPEnv Console` is a command-line tool designed to simplify WordPress development and management tasks. It that extends the functionality of the [WPEnv](https://github.com/devuri/wp-env-config) development environment. It provides a set of commands to streamline common WordPress tasks and enhance your workflow. Whether you're setting up a new WordPress environment, managing plugins and themes, or performing routine maintenance, `WPEnv Console` has you covered.

> **Note**
> This repository houses the fundamental console components of wp-env-config. If you are developing an application, please utilize wp-env-app located in this repository: [wp-env-app](https://github.com/devuri/wp-env-app).


## Features

- **WordPress Environment Management:** Easily create, configure, and manage WordPress environments with commands like `make:env`, `serve`, and `setup`.

- **Plugin and Theme Installation:** Install and manage plugins and themes directly from the WordPress Packagist repository using the `install:package` command.

- **Database Management:** Create database backups, generate `.htpasswd` files for authentication, and set up database admin directories with ease.

- **WordPress Installation:** Quickly install WordPress with customizable options using the `wp:install` command.

- **Auto-login URLs:** Generate auto-login URLs for users during development and testing with the `wp:login` command.

## Installation

You can install `WPEnv Console` via Composer by running:

```bash
composer require devuri/wpenv-console
```

## Usage

Once installed, you can run `WPEnv Console` commands using `php bin/nino` followed by the desired command. For example:

```bash
php nino make:env my-project
```

For a complete list of available commands and their descriptions, run:

```bash
php nino list
```

## Available Commands

WPEnv Console offers the following commands to simplify your WordPress development tasks:

1. **Make Environment**: Create a new WordPress environment.

   ```bash
   php bin/nino make:env <name>
   ```

2. **Serve**: Start the built-in PHP web server.

   ```bash
   php bin/nino serve
   ```

3. **Setup**: Creates a fresh .env file .

   ```bash
   php bin/nino setup <replacement_domain>
   ```
   > Running `php nino setup` will check for an existing .env file. If found, 
it creates a new version with a timestamp, facilitating an effortless 
update to the latest .env file standards.

4. **Install Package**: Add a plugin or theme via Composer using the slug only.

   ```bash
   php bin/nino install <package_slug>  <plugin_or_theme>
   ```

5. **Generate .htpasswd**: Create an .htpasswd file for authentication.

   ```bash
   php bin/nino make:htpass [--username=<username>] [--password=<password>]
   ```

6. **Database Backup**: Backup the WordPress database.

   ```bash
   php bin/nino db:backup
   ```

7. **Generate Composer**: Generate a fresh copy of composer.json and run composer install.

   ```bash
   php bin/nino make:composer
   ```

8. **WordPress Installation**: Install WordPress with customizable options.

   ```bash
   php bin/nino wp:install [--title=<blog_title>] [--user=<admin_username>] [--email=<admin_email>]
   ```

9. **WordPress Auto-login**: Generate an auto-login URL for a user.

   ```bash
   php bin/nino wp:login [--user=<admin_username>]
   ```

10. **Create DB Admin Directory**: Create a database admin directory.

    ```bash
    php bin/nino make:dbadmin [--_dir=<directory_name>]
    ```

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to check out the [contributing guidelines](CONTRIBUTING.md) and [code of conduct](CODE_OF_CONDUCT.md).

## License

`WPEnv Console` is open-source software licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute it as per the terms of the license.

## Support and Feedback

For questions, issues, or feedback related to `WPEnv Console`, please visit the [GitHub repository](https://github.com/devuri/wpenv-console) or join the [community](https://community.wpenv.io/).
