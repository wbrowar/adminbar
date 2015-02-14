# Craft – Admin Bar
Simple front-end shortcut bar for users logged into [Craft CMS](https://buildwithcraft.com).

![Screenshot](screenshot.png)

> 50 shades of any color you want, with the new Default Color option!

## Installation
1. Upload the adminbar/ folder to your craft/plugins/ folder.
2. Enable the plugin in the CP.
3. Either add the Admin Bar through the plugin settings page, or add the tag, `{{ craft.Adminbar.show(entry) }}`, to your template.

## Auto Embed
Using the "Auto Embed" option will add the Admin Bar to the top of your `<body>` tag. Doing it this way will base the "Edit" button off of the current page entry. Branding colors will use the color selected through the "Default Color" color picker.

For more control, or to add the admin bar to multiple entries, use the embed tag, below.

## Embed Options
Format: `{{ craft.Adminbar.show(currentEntry, color, type) }}`

Embedding the Admin Bar using this tag will let you overwrite the settings found on the plugin settings page.

* **currentEntry** *`entry`*  – Current entry passed in as a TWIG object.
* **color** *`'#d85b4b'`* – The color used for rollovers or highlights. You can change this to better fit the branding of your website. Use any CSS color format.
* **type** *`'bar'`* – Changes the style of the Admin Bar. For now, the only options are `bar` or `none`.
  * `bar` – Creates a black bar that spans 100% the width of the element that it is placed in. It's *slightly* responsive.
  * `none` – Has the same markup as `bar`, but removes all of the CSS, so you may style it however you'd like.

## To Do
* ~~Add options to CP.~~
* Add a new type to be used within multiple entries.
* ~~Automatically add the bar to the top of the `<body>` tag.~~
* Add custom hook for other plugins to add custom links.
* Add a way to toggle links from other plugins in the CP if users don't want to use them.

## Releases
#### *1.2.0*
**NOTE:** Craft will ask you to make a one-time database update to accommodate the new options. 
* Added option to make custom links available only to users with the admin role.
* Added option to embed Admin Bar from the plugin settings page.
* Added color picker for default branding color.
* Removed duplicate CSS and JS code for multiple instances of the Admin Bar

#### *1.1.0*
* Added ability to add custom links to CP settings.

#### *1.0*
* Basic admin bar with Edit, Settings, and Logout buttons.

Please, let me know if this plugin is useful or if you have any suggestions or issues. [@wbrowar](https://twitter.com/wbrowar)