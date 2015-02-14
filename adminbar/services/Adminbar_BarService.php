<?php
namespace Craft;

class Adminbar_BarService extends BaseApplicationComponent
{
  private $_adminbarEmbedded;
  
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
      'customLinks' => $this->getAdminbarSettings()->customLinks
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
  
  private function getAdminbarSettings()
  {
    // get values of links set in CP
    $plugin = craft()->plugins->getPlugin('Adminbar');
    return $plugin->getSettings();
  }
}