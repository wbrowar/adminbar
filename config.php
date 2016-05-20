<?php

return array(
  // ADMIN BAR
  'additionalLinks' => array(),
  'cacheBar' => true,
  'displayGreeting' => true,
  'displayDashboardLink' => true,
  'displaySettingsLink' => true,
  'displayLogout' => true,
  'enableMobileMenu' => true,
  'scrollLinks' => true,
  
  // EDIT LINKS
  'displayEditDate' => true,
  'displayEditAuthor' => true,
  'displayRevisionNote' => true,
);

// EXAMPLES
// Additional Links
/*
'additionalLinks' => array(
  // an example of a simple url link
  array(
    'title' => 'Craft CMS',
    'url' => 'http://craftcms.com',
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
  // an example of a plugin action link
  array(
    'title' => 'Clear Cache',
    'url' => 'adminbar/clearTemplateCache',
    'type' => 'action',
    'admin' => true,
  ),
),
*/