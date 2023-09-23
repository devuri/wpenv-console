# WPEnv Console

[![License](https://img.shields.io/github/license/devuri/wpenv-console)](https://github.com/devuri/wpenv-console/blob/master/LICENSE)

`WPEnv Console` is a command-line tool designed to simplify WordPress development and management tasks. It provides a set of commands to streamline common WordPress tasks and enhance your workflow. Whether you're setting up a new WordPress environment, managing plugins and themes, or performing routine maintenance, `WPEnv Console` has you covered.

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

Once installed, you can run `WPEnv Console` commands using `php bin/console` followed by the desired command. For example:

```bash
php nino make:env my-project
```

For a complete list of available commands and their descriptions, run:

```bash
php nino list
```

## Documentation

For detailed documentation on each command and how to use them effectively, please refer to the [official documentation](https://github.com/devuri/wpenv-console/wiki).

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to check out the [contributing guidelines](CONTRIBUTING.md) and [code of conduct](CODE_OF_CONDUCT.md).

## License

`WPEnv Console` is open-source software licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute it as per the terms of the license.

## Support and Feedback

For questions, issues, or feedback related to `WPEnv Console`, please visit the [GitHub repository](https://github.com/devuri/wpenv-console) or join the [community](https://community.wpenv.io/).
