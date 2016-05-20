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
    return '2.0.0';
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
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  /*
  
  
  public function getSettingsHtml()
  {
    // if not set, create a default row for custom links table
    if (!$this->_customLinks) {
      $this->_customLinks = array(array('linkLabel' => '', 'linkUrl' => '', 'adminOnly' => ''));
    }
    
    // generate table for custom links
    $customLinksTable = craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
      array(
        'label'        => Craft::t('Custom Links'),
        'instructions' => Craft::t('Add your own links to the Admin Bar.'),
        'id'           => 'customLinks',
        'name'         => 'customLinks',
        'cols'         => array(
          'linkLabel' => array(
            'heading' => Craft::t('Label'),
            'type'    => 'singleline',
          ),
          'linkUrl' => array(
            'heading' => Craft::t('URL'),
            'type'    => 'singleline',
          ),
          'adminOnly' => array(
            'heading' => Craft::t('Admins Only'),
            'type'    => 'checkbox',
          ),
        ),
        'rows' => $this->_customLinks,
        'addRowLabel'  => Craft::t('Add a link'),
      )
    ));
    
    // get links from other plugins
    $pluginLinksHook = craft()->plugins->call('addAdminBarLinks');
    $pluginLinks = array();
    
    foreach ($pluginLinksHook as $key => $link) {
      $pluginName = craft()->plugins->getPlugin($key)->getName();
      
      for($i=0; $i<count($link); $i++) {
        if (isset($link[$i]['title']) && isset($link[$i]['url']) && isset($link[$i]['type'])) {
          $link[$i]['id'] = str_replace(' ', '', $link[$i]['title']) . $link[$i]['url'] . $link[$i]['type'];
          $link[$i]['originator'] = $pluginName;
          array_push($pluginLinks, $link[$i]);
        }
      }
    }
    
    $this->clearAdminBarCache();
    
    // output settings template
    return craft()->templates->render('adminbar/settings', array(
      'autoEmbedValue' => $this->getSettings()->autoEmbed,
      'autoEmbedStickyValue' => $this->getSettings()->autoEmbedSticky,
      'defaultColorValue' => $this->getSettings()->defaultColor,
      'customLinksTable' => $customLinksTable,
      'pluginLinks' => $pluginLinks,
      'enabledLinks' => $this->getSettings()->enabledLinks,
    ));
  }
  public function prepSettings($settings) {
    if (!isset($settings['customLinks'])) {
      $settings['customLinks'] = array();
    }
  
    return $settings;
  }
  
  // retrieve custom links settings
  private function _customLinks()
  {
    $this->_customLinks = $this->getSettings()->customLinks;
    $customLinks = '';
    if ($this->_customLinks) {
      foreach ($this->_customLinks as $row) {
        if ($customLinks) {$customLinks .= ',';}
        $adminOnly = isset($row['adminOnly']) ? ":'{$row['adminOnly']}'" : null;
        // @TODO 2.0 remove and combine
        $customLinks .= "'{$row['linkLabel']}':'{$row['linkUrl']} . $adminOnly";
      }
    }
  }
  */
}
