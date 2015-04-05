<?php
namespace Craft;

class EventExamplePlugin extends BasePlugin
{
  public function init()
	{
		parent::init();
		
    Craft::import('plugins.adminbar.events.AdminbarEvent');
    craft()->on('adminbar.onFindPluginLinks', function(AdminbarEvent $event) {
      craft()->adminbar->addPluginLink(array(
        'title' => 'Craft',
        'url' => 'http://buildwithcraft.com',
        'type' => 'url',
      ));
      craft()->adminbar->addPluginLink(array(
        'title' => 'Entries',
        'url' => 'entries',
        'type' => 'cpUrl',
      ));
    });
	}
  
  public function getName()
  {
    return Craft::t('Admin Bar - Hook Example Plugin');
  }
  public function getVersion()
  {
    return '0.1.0';
  }
  public function getDeveloper()
  {
    return 'Will Browar';
  }
  public function getDeveloperUrl()
  {
    return 'http://wbrowar.com';
  }
  public function hasCpSection()
  {
    return false;
  }
}