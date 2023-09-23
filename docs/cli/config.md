# Config Command - WordPress Configuration

The `ConfigCommand` is a part of `wpenv-console` designed to manage various configuration tasks for your WordPress web application.

## Usage

To perform configuration tasks, use the following command:

```bash
php nino config <task>
```

Replace `<task>` with the specific configuration task you want to execute. Here are some available tasks:

- `up`: Enable maintenance mode.
- `down`: Disable maintenance mode.
- `loginkey`: Add an auto-login key to your `.env` file.
- `cryptkey`: Generate an encryption key and store it in a key file.
- `secureit`: Encrypt your `.env` file for added security.
- `create-public-key`: Create a public key file (contains an example key).
- `uuid`: Generate a UUID (Universally Unique Identifier).
- `htpass` or `sechtpass`: Generate an htpasswd file with username and password.

### Example

Enable maintenance mode:

```bash
php nino config up
```

Generate an encryption key and store it in a key file:

```bash
php nino config cryptkey
```

## Configuration

The `Config Command` reads configuration settings from your `.env` file, which should contain the necessary settings for your WordPress setup. Ensure that your `.env` file is properly configured for the tasks you want to perform.

## Support and Feedback

For questions, issues, or feedback related to the `Config Command` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
