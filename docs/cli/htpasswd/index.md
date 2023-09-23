# Create Htpasswd - Generate .htpasswd File

The `Create Htpasswd` command is a part of `wpenv-console` that allows you to generate an `.htpasswd` file for basic authentication. This file is commonly used to secure access to web resources.

## Usage

To generate an `.htpasswd` file, use the following command:

```bash
php nino make:htpass
```

By default, this command will generate a random username and password. However, you can also specify the username and password using options:

```bash
php nino make:htpass --username <username> --password <password>
```

Replace `<username>` with your desired username and `<password>` with your desired password.

### Example

Generate an `.htpasswd` file with a random username and password:

```bash
php nino make:htpass
```

Generate an `.htpasswd` file with a specific username and password:

```bash
php nino make:htpass --username myuser --password mypassword
```

## .htpasswd File Location

The generated `.htpasswd` file will be created in the `_htpass` directory at the root of your WordPress project:

```
<project_root>/_htpass/.htpasswd
```

## Support and Feedback

For questions, issues, or feedback related to the `Create Htpasswd` command or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
