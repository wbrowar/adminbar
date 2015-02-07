<?php
namespace Craft;

class Adminbar_BarService extends BaseApplicationComponent
{
  public function show($currentEntry)
  {
    // load template and print at point of user variable
    $oldTemplatesPath = craft()->path->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath().'adminbar/templates/';
    craft()->path->setTemplatesPath($newTemplatesPath);
    print(craft()->templates->render('index', ['entry' => $currentEntry]));
    craft()->path->setTemplatesPath($oldTemplatesPath);
  }
}