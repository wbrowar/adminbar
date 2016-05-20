<?php
namespace Craft;

class AdminbarVariable
{
  public function bar($config = array())
  {
    // embed admin bar in twig template
    craft()->adminbar->bar($config);
  }
  public function edit($entry, $config = array())
  {
    // embed admin bar in twig template
    craft()->adminbar->edit($entry, $config);
  }
}