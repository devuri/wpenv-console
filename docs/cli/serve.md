# Serve Command - Start the Built-in PHP Web Server

The `Serve Command` is a part of `wpenv-console` that allows you to start the built-in PHP web server for your WordPress project. This command is useful for local development and testing purposes.

## Usage

To start the PHP web server, use the following command:

```bash
php nino serve
```

By default, the server will run on `localhost` and port `8000`. You can specify custom options using the following options:

- `--port` (`-p`): The port number to use. (Default: `8000`)
- `--host`: The host name to use. (Default: `localhost`)
- `--docroot`: The document root to use. (Default: `public`)
- `--ini`: The path to the `php.ini` file to use. (Default: `public/.user.ini`)

For example, to run the server on a custom port and host:

```bash
php nino serve --port=8080 --host=myhost
```

The command will start the PHP web server and display the URL where your WordPress project is accessible.

## Configuration

The `Serve Command` checks for the presence of a `.env` file in your project directory. If it doesn't find one, it will use `.env-example`. Make sure your `.env` file contains the correct configuration, including the `WP_HOME` URL with the desired port.

If the port specified via the `--port` option doesn't match the port in your `WP_HOME` URL, the command will override it with the port from the `.env` file.

## Note

- Ensure that the specified document root and `php.ini` file exist.
- The command will run the PHP web server until you stop it manually (e.g., using `Ctrl+C`).

## Support and Feedback

For questions, issues, or feedback related to the `Serve Command` or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
