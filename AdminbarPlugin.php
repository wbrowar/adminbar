<?php
namespace Craft;

class AdminbarPlugin extends BasePlugin
{
  //private $_settings;
  
  public function getName()
  {
    return Craft::t('Admin Bar');
  }
  public function getVersion()
  {
    return '2.1.1';
  }
  public function getSchemaVersion()
  {
    return '2.0.0';
  }
  public function getDescription()
  {
    return 'Front-end shortcuts for users logged into Craft CMS.';
  }
  public function getDeveloper()
  {
    return 'Will Browar';
  }
  public function getDeveloperUrl()
  {
    return 'http://wbrowar.com';
  }
  public function getDocumentationUrl()
  {
    return 'https://github.com/wbrowar/adminbar';
  }
  public function getReleaseFeedUrl()
  {
    return 'https://raw.githubusercontent.com/wbrowar/adminbar/master/releases.json';
  }
  public function hasCpSection()
  {
    return false;
  }
  
  public function init()
  {
    craft()->templates->hook('renderAdminBar', function() {
      $adminbar = craft()->plugins->getPlugin('Adminbar');
      
      if (craft()->adminbar->canEmbed()) {
        $config = array (
          'color' => $adminbar->getSettings()->defaultColor,
          'sticky' => true,
          'type' => 'primary',
          'useCss' => true,
          'useJs' => true,
        );
        
        // get current page element
        $element = craft()->urlManager->getMatchedElement();
        
        if (!empty($element)) {
          if ($element->getElementType() === ElementType::Entry) {
            $config['entry'] = $element;
          } elseif ($element->getElementType() === ElementType::Category) {
            $config['category'] = $element;
          }
        }
        
        // show admin bar in template
        craft()->adminbar->bar($config);
      }
    });
  }
  
  protected function defineSettings()
  {
    return array(
      'autoEmbed' => array(AttributeType::Bool, 'default' => false),
      'customLinks' => array(AttributeType::Mixed, 'default' => array()),
      'defaultColor' => array(AttributeType::String, 'default' => '#d85b4b'),
    );
  }
  public function getSettingsHtml()
  {
    // clear admin bar cache
    craft()->adminbar->clearAdminBarCache();
    
    // output settings template
    return craft()->templates->render('adminbar/settings', array(
      'settings' => $this->getSettings(),
    ));
  }
  public function prepSettings($settings) {
    // if last custom link is deleted, replace old settings with blank array
    if (!isset($settings['customLinks'])) {
      $settings['customLinks'] = array();
    }

    return $settings;
  }
}
