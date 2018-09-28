# CSS Variables Framework – README

When using the `sass-variables` post-processing tool, it is good to have in mind the following DO's and DON'Ts:

- - -

**DO NOT** specify property values containing CSS4 variables in multiple lines:

```css
.box-shadow: 0 0 0 $x-box-shadow-color inset,
             0 0 10px $x-box-shadow-color inset;
```

**DO** specify property values in a single line:

```css
.box-shadow: 0 0 0 $x-box-shadow-color inset, 0 0 10px $x-box-shadow-color inset;
```

Having the property values in a single line, makes it easier for the variable replacements and the fallback generation. At this moment, the `sass-variables` parser only supports single line property values.

- - -

**DO NOT** use CSS4 variable names that contain colors:

```css
$x-blue: #0000ff;
```

**DO** use CSS4 variable names that are semantic:

```css
$x-accent-color: #0000ff;
```

Sass will replace color names with the hex counterpart, resulting in broken CSS4 variables. Assuming the `$x-blue` variable above was used, you would end up with `color: var(--#0000ff)`. This replacement is done by Sass, not by the `sass-variables` script.
