<?php
namespace Craft;

class AdminbarVariable
{
  public function show($currentEntry = '', $color = '', $type = 'bar')
  {
    // embed admin bar in twig template
    craft()->adminbar_bar->show($currentEntry, $color, $type);
  }
}