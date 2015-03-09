<?php
namespace Craft;

class AdminbarPlugin extends BasePlugin
{
  private $_customLinks;
  
  public function init()
	{
		parent::init();
		if (craft()->request->isCpRequest()) {
			$this->_customLinks();
		}
	
  	// add event listeners
    craft()->on('plugins.onLoadPlugins', function(Event $event) {
    	if (!craft()->request->isCpRequest() && $this->getSettings()->autoEmbed == 1) {
      	$element = craft()->urlManager->getMatchedElement();
        craft()->adminbar_bar->show($element, $this->getSettings()->defaultColor, 'primary');
    	}
    });
	}
  
  public function getName()
  {
    return Craft::t('Admin Bar');
  }
  public function getVersion()
  {
    return '1.2.1';
  }
  public function getDeveloper()
  {
    return 'Will Browar';
  }
  public function getDeveloperUrl()
  {
    return 'http://wbrowar.com';
  }
  public function hasCpSection()
  {
    return false;
  }
  
  protected function defineSettings()
	{
		return array(
  		'autoEmbed' => array(AttributeType::Bool, 'default' => false),
			'customLinks' => array(AttributeType::Mixed, 'label' => 'Custom Links', 'default' => array()),
			'defaultColor' => array(AttributeType::String, 'label' => 'Default Color', 'default' => '#d85b4b'),
		);
	}
	public function getSettingsHtml()
	{
		// If not set, create a default row
		if (!$this->_customLinks) {
			$this->_customLinks = array(array('linkLabel' => '', 'linkUrl' => '', 'adminOnly' => ''));
		}
		
		// Generate table for custom links
		$customLinksTable = craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => Craft::t('Custom Links'),
				'instructions' => Craft::t('Add your own links to the Admin Bar. The URL can be absolute or relative.'),
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
		
		// Output settings template
		return craft()->templates->render('adminbar/settings', array(
			'customLinksTable' => $customLinksTable,
			'defaultColorValue' => $this->getSettings()->defaultColor,
			'autoEmbedValue' => $this->getSettings()->autoEmbed,
		));
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
  			$customLinks .= "'{$row['linkLabel']}':'{$row['linkUrl']} . $adminOnly";
			}
		}
	}
}