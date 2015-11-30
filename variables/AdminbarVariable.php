<?php
namespace Craft;

class AdminbarVariable
{
  public function bar($currentEntry = '', $color = '', $type = 'bar')
  {
    // embed admin bar in twig template
    craft()->adminbar->bar($currentEntry, $color, $type);
  }
  // duplication of 'bar()', depreciated in 1.4.0
  public function show($currentEntry = '', $color = '', $type = 'bar')
  {
    // embed admin bar in twig template
    craft()->adminbar->bar($currentEntry, $color, $type);
  }
}