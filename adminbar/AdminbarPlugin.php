<?php
namespace Craft;

class AdminbarPlugin extends BasePlugin
{
  function getName()
  {
    return Craft::t('Admin Bar');
  }
  function getVersion()
  {
    return '1.0';
  }
  function getDeveloper()
  {
    return 'Will Browar';
  }
  function getDeveloperUrl()
  {
    return 'http://wbrowar.com';
  }
}