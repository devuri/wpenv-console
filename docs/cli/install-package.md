# Install Package - Add Plugins or Themes via Composer

The `Install Package` command is a part of `wpenv-console` that allows you to easily add WordPress plugins or themes to your web application via Composer using only the package slug.

## Usage

To add a plugin or theme via Composer, use the following command:

```bash
php nino install brisko theme
```

You must provide the package slug as an argument. Additionally, you can specify the package type argument:

Specify the package type. Use `plugin` for plugins or `theme` for themes.

For example, to add the plugin "brisko," you can use the following command:

```bash
php nino install classic-editor plugin
```

To add the theme "mytheme," you can use:

```bash
php nino install mytheme theme
```

If you don't specify the package type, the command will prompt you to do so.

## Installation

The `Install Package` command runs `composer require` to install the specified package. If the installation is successful, it will display a success message.

## Support and Feedback

For questions, issues, or feedback related to the `Install Package` command or `wpenv-console`, please create an issue on [GitHub](https://github.com/devuri/wpenv-console/issues).
