# Default Blogging Theme

This is the **development** project of the upcoming default blogging theme for WordPress.com.

<u>This repository is **not** an installable WordPress theme</u>. It is a project that _builds_ a fully functional theme.

Development demo live at https://blogging-theme.ernesto.blog/

### Instructions

If you don't want to build the theme yourself, download one of the [pre-built releases](https://github.com/Automattic/default-blogging-theme-dev/releases) and install via WP Admin » Themes.

To **build** the theme after you clone it:

```
$ make deps build
```

To **watch for changes** and compile your Sass files automatically, run:

```
$ make dev
```

### Working with CSS Variables.

Every Sass variable you add with a prefix of `$x-` will automatically be compiled as a CSS variable.

For example, the `$x-body-background` Sass variable will be compiled as `var(--body-background)` and so on.

The compilation, replacements, and fallbacks are handled automatically for you. All you need to do is add the variable prefix, and everything will be taken care for you during the build process.

To compile your `style.css` with CSS variables, do:

```
$ make css-vars
```

Have in mind that CSS variables are not automatically compiled when running `make dev`.

If something goes wrong, make sure you read the [DO's and DON'Ts](https://github.com/Automattic/default-blogging-theme-dev/blob/master/readme-cssvars.md) for using CSS variables with this project.



















