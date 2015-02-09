<?php
namespace Craft;

class Adminbar_BarService extends BaseApplicationComponent
{
  public function show($currentEntry, $color, $type)
  {
    // load template and print at point of user variable
    $oldTemplatesPath = craft()->path->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath().'adminbar/templates/';
    craft()->path->setTemplatesPath($newTemplatesPath);
    print(craft()->templates->render('index', ['entry' => $currentEntry, 'color' => $color, 'type' => $type]));
    craft()->path->setTemplatesPath($oldTemplatesPath);
  }
  
  public function getCustomLinks()
  {
    // get values of links set in CP
      $plugin = craft()->plugins->getPlugin('Adminbar');
      $settings = $plugin->getSettings();
  
      return $settings->customLinks;
  }
}