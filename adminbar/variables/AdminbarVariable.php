<?php
namespace Craft;

class AdminbarVariable
{
  public function show($currentEntry = '', $color = '#d85b4b', $type = 'bar')
  {
    // load template and print at point of user variable
    $oldTemplatesPath = craft()->path->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath().'adminbar/templates/';
    craft()->path->setTemplatesPath($newTemplatesPath);
    if ($currentEntry != '') {
      print(craft()->templates->render('index', ['entry' => $currentEntry, 'type' => $type, 'color' => $color]));
    } else {
      print(craft()->templates->render('index', ['type' => $type]));
    }
    craft()->path->setTemplatesPath($oldTemplatesPath);
  }
}