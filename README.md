# Craft – Admin Bar
Simple front-end shortcut bar for users logged into [Craft CMS](https://buildwithcraft.com).

![Screenshot](screenshot.png)

> Now with custom links!

## Installation
1. Upload the adminbar/ folder to your craft/plugins/ folder.
2. Enable the plugin in the CP.
3. Add custom links on the settings page.
4. In your template, add the tag `{{ craft.Adminbar.show(entry) }}` at the top of the `<body>` tag or wherever you want it to show up.

## Options
Format: `{{ craft.Adminbar.show(currentEntry, color, type) }}`

* **currentEntry**  – Current entry passed in as a TWIG object.
* **color** *#d85b4b* – The color used for rollovers or highlights. You can change this to better fit the branding of your website. Use any CSS color format.
* **type** *bar* – Changes the style of the Admin Bar. For now, the only options are `bar` or `none`.
  * `bar` – Creates a black bar that spans 100% the width of the element that it is placed in. It's *slightly* responsive.
  * `none` – Has the same markup as `bar`, but removes all of the CSS, so you may style it however you'd like.

## To Do
* Add options to CP.
* Add a new type to be used within multiple entries.
* Automatically add the bar to the top of the `<body>` tag depending on options selected (is this a good idea?).

## Releases
* *1.1.0* – Added ability to add custom links to CP settings.
* *1.0* – Basic admin bar with Edit, Settings, and Logout buttons.

Please, let me know if this plugin is useful or if you have any suggestions or issues. [@wbrowar](https://twitter.com/wbrowar)