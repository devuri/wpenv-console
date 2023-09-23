# Make Composer - Generate Composer Configuration

The `Make Composer` command is a part of `wpenv-console` that simplifies the process of generating a fresh `composer.json` file and running `composer install` for your WordPress project.

## Usage

To generate a fresh `composer.json` file and run `composer install`, use the following command:

```bash
php nino make:composer
```

This command will generate a `composer.json` file with a basic configuration for a WordPress project and then run `composer install` to install the required dependencies.

## Composer Configuration

The generated `composer.json` file includes the following configuration:

- Project name: `devuri/wp-env-app`
- License: MIT
- Description: A base WordPress project to create web applications using environment variables.
- Minimum stability: dev
- Prefer stable: true
- Required plugins:
  - `devuri/wp-env-config` (dev-master)
  - `wpackagist-plugin/query-monitor` (*)
  - `wpackagist-plugin/email-log` (*)
  - `wpackagist-theme/hello-elementor` (*)
  - `wpackagist-theme/twentytwentythree` (*)

The configuration also specifies the WordPress installation directory and installer paths for WordPress plugins, themes, and mu-plugins.

## Support and Feedback

For questions, issues, or feedback related to the `Generate Composer` command or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
