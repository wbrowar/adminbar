<?php
namespace Craft;

class AdminbarVariable
{
  public function show($currentEntry = '', $color = '', $type = 'bar')
  {
    // embed admin bar in twig template
    craft()->adminbar->show($currentEntry, $color, $type);
  }
}