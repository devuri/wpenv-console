# Generate Auto-login URL for WordPress User

The `Login Command` is a part of `wpenv-console` that allows you to generate an auto-login URL for a WordPress user. This URL enables quick and convenient access to the WordPress admin dashboard without the need to enter credentials.

## Usage

To generate an auto-login URL for a WordPress user, use the following command:

```bash
php nino wp:login
```

You can specify the WordPress user for whom you want to generate the auto-login URL using the `--user` option. For example:

```bash
php nino wp:login --user=admin
```

By default, the `--user` option is set to "admin."

The command will generate the auto-login URL, and it will be displayed in the terminal.

## How it Works

The `LoginCommand` generates an auto-login URL by:

1. Creating a secure token.
2. Adding the current timestamp.
3. Including the username.
4. Generating a site-specific ID.
5. Creating a signature using a secret key.
6. Constructing the auto-login URL with all the parameters.

## Configuration

The `Login Command` uses environment variables from the `.env` file to create the auto-login URL. Ensure that the necessary environment variables are correctly configured.

## Support and Feedback

For questions, issues, or feedback related to the `Login Command` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
