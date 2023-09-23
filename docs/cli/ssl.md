
# SSL Provisioning

This a part of `wpenv-console` that simplifies SSL certificate provisioning using Certbot.

## Installation

Ensure you have Certbot installed on your system. For installation instructions, refer to the Certbot website: [Certbot Installation Guide](https://certbot.eff.org/).

## Usage

To provision an SSL certificate for a domain, use:

```bash
php nino ssl-certbot --domain <domain> --email <email>
```

Replace `<domain>` with your domain name and `<email>` with your email address for certificate notifications.

### Example

Provision an SSL certificate for `example.com`:

```bash
php nino ssl-certbot --domain example.com --email admin@example.com
```


## Support and Feedback

For questions, issues, or feedback related to `wpenv-console` or this command, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
