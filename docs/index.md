# WPEnv Console - Available Commands

**WPEnv Console** is a command-line tool that extends the functionality of the [WPEnv](https://github.com/devuri/wp-env-config) WordPress development environment. 
It provides a set of convenient commands to simplify common development tasks when working with WordPress projects. Below is a list of available commands:

## Table of Contents

- [Backup](#backup)
- [Completion](#completion)
- [Config](#config)
- [Help](#help)
- [Install](#install)
- [List](#list)
- [Serve](#serve)
- [Setup](#setup)
- [SSL](#ssl)
- [Database (DB)](#database-db)
- [DB Backup](#db-backup)
- [Make](#make)
- [Make Composer](#make-composer)
- [Make DB Admin](#make-db-admin)
- [Make Htpass](#make-htpass)
- [WordPress (WP)](#wordpress-wp)
- [WP Install](#wp-install)
- [WP Login](#wp-login)

---

### Backup

Backup the WordPress web application.

**Usage:**

```bash
php bin/nino backup
```

### Completion

Dump the shell completion script.

**Usage:**

```bash
php bin/nino completion
```

### Config

Display a list of constants defined by Setup.

**Usage:**

```bash
php bin/nino config
```

### Help

Display help for a command.

**Usage:**

```bash
php bin/nino help <command_name>
```

### Install

Add a plugin or theme via composer using slug only.

**Usage:**

```bash
php bin/nino install <package_slug> [--type=<plugin_or_theme>]
```

### List

List available commands.

**Usage:**

```bash
php bin/nino list
```

### Serve

Start the built-in PHP web server.

**Usage:**

```bash
php bin/nino serve [--port=<port_number>] [--host=<host_name>] [--docroot=<document_root>] [--ini=<php_ini_file>]
```

### Setup

Search and replace domain in multiple files.

**Usage:**

```bash
php bin/nino setup <replacement_domain>
```

### SSL

Provisions SSL for a domain.

**Usage:**

```bash
php bin/nino ssl <domain>
```

---

### Database (DB)

Database related commands:

#### DB Backup

Backup WordPress database.

**Usage:**

```bash
php bin/nino db:backup
```

---

### Make

Generate files and directories:

#### Make Composer

Generate a fresh copy of composer.json file and run composer install.

**Usage:**

```bash
php bin/nino make:composer
```

#### Make DB Admin

Create DB admin directory.

**Usage:**

```bash
php bin/nino make:dbadmin [--_dir=<directory_name>]
```

#### Make Htpass

Create an .htpasswd file.

**Usage:**

```bash
php bin/nino make:htpass [--username=<username>] [--password=<password>]
```

---

### WordPress (WP)

WordPress related commands:

#### WP Install

Installs WordPress.

**Usage:**

```bash
php bin/nino wp:install [--title=<blog_title>] [--user=<admin_username>] [--email=<admin_email>]
```

#### WP Login

Generate an auto-login URL for a user.

**Usage:**

```bash
php bin/nino wp:login [--user=<admin_username>]
```

---

Feel free to explore and use these commands to streamline your WordPress development workflow with WPEnv Console!
