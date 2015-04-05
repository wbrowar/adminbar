<?php
namespace Craft;

class AdminbarService extends BaseApplicationComponent
{
  private $_adminbarEmbedded;
  private $_pluginLinks = array();
  
  // public methods
  public function show($currentEntry, $color, $type)
  {
    // redirect tempalate path to plugin path
    $oldTemplatesPath = craft()->path->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath().'adminbar/templates/';
    craft()->path->setTemplatesPath($newTemplatesPath);
    
    // check to see if defaults are overriden
    if ($color === '') {
      $color = $this->getAdminbarSettings()->defaultColor;
    }
    
    // render admin bar
    $adminbarHtml = craft()->templates->render('bar', [
      'adminbarEmbedded' => $this->_adminbarEmbedded,
      'entry' => $currentEntry,
      'color' => $color,
      'type' => $type,
      'customLinks' => $this->getAdminbarSettings()->customLinks,
      'enabledLinks' => $this->getAdminbarSettings()->enabledLinks,
    ]);
    
    if ($type == 'primary') {
      craft()->templates->includeFootHtml($adminbarHtml);
    } else {
      print($adminbarHtml);
    }
    
    // return templates path to original locatiojn
    craft()->path->setTemplatesPath($oldTemplatesPath);
    
    // change embedded value to true
    $this->_adminbarEmbedded = true;
  }
  
  // private methods
  private function getAdminbarSettings()
  {
    // get values of links set in CP
    $plugin = craft()->plugins->getPlugin('Adminbar');
    return $plugin->getSettings();
  }
  
  // get links from other plugins
  public function addPluginLink(Array $link) {
    array_push($this->_pluginLinks, $link);
  }
  public function onFindPluginLinks(AdminbarEvent $event)
	{
		$this->raiseEvent('onFindPluginLinks', $event);
		
		foreach($this->_pluginLinks as $value) {
  		if (isset($value['title']) && isset($value['url']) && isset($value['type'])) {
    		$value['id'] = str_replace(' ', '', $value['title']) . $value['url'] . $value['type'];
    		array_push($event->pluginLinksData, $value);
  		}
		}
	}
}