<?php
namespace Craft;

class AdminbarVariable
{
  public function show($currentEntry = '', $color = '#d85b4b', $type = 'bar')
  {
    // embed admin bar in twig template
    craft()->adminbar_bar->show($currentEntry, $color, $type);
  }
  
  public function getCustomLinks()
  {
      return craft()->adminbar_bar->getCustomLinks();
  }
}