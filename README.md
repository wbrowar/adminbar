# Craft – Admin Bar
Simple front-end shortcut bar for users logged into [Craft CMS](https://buildwithcraft.com).

![Screenshot](resources/screenshots/screenshot-bar.png)

> NOTE: 1.4 might have some bugs related to caching, so please send your feedback my way if you find any

## Installation
1. Upload the adminbar/ folder to your craft/plugins/ folder.
2. Enable the plugin in the CP.
3. Either add the Admin Bar through the plugin settings page, or add the tag, `{{ craft.Adminbar.show(entry) }}`, to your template.

## Auto Embed
Using the "Auto Embed" setting will add the Admin Bar to the top of your `<body>` tag. Doing it this way will base the "Edit" button off of the current page entry. Branding colors will use the color selected through the "Default Color" color picker.

For more control, or to add the admin bar to multiple entries, use the Twig embed tag, below. _NOTE: using Auto Embed caches Admin Bar automatically, where using the Embed Tag leaves caching up to you._

## Embed Options
Format: `{{ craft.Adminbar.bar(currentEntry, color, type) }}`

Embedding the Admin Bar using this tag will let you overwrite the settings found on the plugin settings page.

* **currentEntry** *`entry`*  – Current entry passed in as a TWIG object.
* **color** *`'#d85b4b'`* – The color used for rollovers or highlights. You can change this to better fit the branding of your website. Use any CSS color format.
* **type** *`'bar'`* – Changes the style of the Admin Bar. For now, the only options are `bar` or `none`.
  * `bar` – Creates a black bar that spans 100% the width of the element that it is placed in. It's *slightly* responsive.
  * `none` – Has the same markup as `bar`, but removes all of the CSS, so you may style it however you'd like.

## Adding Links Through Plugins
Links can be added through the `addAdminBarLinks()` method in your main plugin class. Return an array for each link you'd like to add.

```php
public function addAdminBarLinks() {
  return array(
    // an example of a simple url link
    array(
      'title' => 'Craft',
      'url' => 'http://buildwithcraft.com',
      'type' => 'url',
    ),
    // an example of a CP link
    array(
      'title' => 'Entries',
      'url' => 'entries',
      'type' => 'cpUrl',
    ),
    // an example of a url link that passes along some extras
    array(
      'title' => 'Blog',
      'url' => 'blog',
      'type' => 'url',
      'params' => 'foo=1&bar=2',
      'protocol' => 'http',
      'mustShowScriptName' => true,
      'permissions' => array('myPluginPermission', 'thisIsRequiredToo'),
    ),
  );
}
```

* **title** *required*  – The label that will appear for this link in the Admin Bar.
* **url** *required* – The url or path used for the link.
* **type** *required* – The context of the url or path.
  * `url` – Used for relative or absolute URLs.
  * `cpUrl` – Prepends `cpTrigger` to the **url** value for links found within the Control Panel. For example, if you wanted to link to Craft's default Entries page, set **url** to `'entries'` and **type** to `'cpUrl'`. The final url will be `http://example.com/admin/entries`
* **params** – Passes along url parameters, as [documented here](http://buildwithcraft.com/docs/templating/functions#url).
* **protocol** – Changes the url protocol, as [documented here](http://buildwithcraft.com/docs/templating/functions#url). This only supports this string format: `'foo=1&bar=2'`
* **mustShowScriptName** – Appends `index.php`, as [documented here](http://buildwithcraft.com/docs/templating/functions#url).
* **permissions** – An array of required permissions that are needed for this link to be displayed. All permissions in this array will be required.

*Please note: links in the Admin Bar are updated when the user saves the Admin Bar plugin settings. While you can use PHP to determine the argument values and which URLs appear based on your plugin's settings, the links will not update until the user goes back and updates their Admin Bar settings.*

### Plugins using Admin Bar
* [Craft Help](https://github.com/70kft/craft-help)

![Screenshot](resources/screenshots/screenshot-settings.png)

## Clear Template Caches from Admin Bar
Add a link so that content editors can clear the site's template caches from the front-end by adding this setting into your config.php file. The link will not appear if `enableTemplateCaching` is set to `false`.

```php
'adminBarClearCacheLink' => true,
```

## Overriding the Edit Link
By default, Admin Bar will try to look for an `entry` or `category` object and use its `cpEditUrl` property to create the default "Edit" link. In some cases, you might want to change the label, or you might be using a different variable for an entry. It's not that common, but in these cases, you can add an array into your config.php file with the following:

```php
'adminBarEditLink' => array(
  array(
    'label' => 'Edit Page',
    'object' => 'entryAlias',
  ),
  array(
    'label' => 'Edit Page',
    'object' => 'entry',
  ),
  array(
    'label' => 'Edit Category',
    'object' => 'categoryAlias',
    'overrideEdit' => false,
  ),
),
```

In this case, Admin Bar will look for an entry object using the variable, "entryAlias". If it find that object, it will add a link, called "Edit Page", and if not it will look for the next object in the array, "entry". If it finds an "entry" object, it will add that link, as "Edit Page".

Adding `'overrideEdit' => false` will force a link to show up, even if there are other items above it, as long as the object it is referring to exists and has a `cpEditUrl`.

---

## Build Tool Extras
It is probably uncommon to need this, but: if you are using a build tool, such as [Grunt](http://gruntjs.com) or [Gulp](http://gulpjs.com), and you are using the embed tag with the type set to `none`, AND your `plugins` folder happens to be within your build tool root folder, you can find the uncompressed, un-[autoprefixed](https://github.com/postcss/autoprefixer) CSS at this location: `adminbar/buildsource/style.css`. This could be helpful if you want to include Admin Bar CSS into your own stylesheet.

---

## To Do
* Update plugin to support Craft 3
* Add a new type to be used within multiple entries. [Looking for some typical use case suggestions.](https://github.com/wbrowar/craft-admin-bar/issues/new)
* Change—in Craft 3 version—Embed Options in Embed Tag to array

---

## Releases

Release notes moved to [releases.json](https://github.com/wbrowar/adminbar/blob/master/releases.json)

Please, let me know if this plugin is useful or if you have any suggestions or issues. [@wbrowar](https://twitter.com/wbrowar)