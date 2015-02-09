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
	}
  
  public function getName()
  {
    return Craft::t('Admin Bar');
  }
  public function getVersion()
  {
    return '1.1.0';
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
			//'matrixBlockColors' => array(AttributeType::Mixed, 'label' => 'Matrix Block Colors', 'default' => array()),
			'customLinks' => array(AttributeType::Mixed, 'label' => 'Custom Links', 'default' => array()),
		);
	}
	public function getSettingsHtml()
	{
		// If not set, create a default row
		if (!$this->_customLinks) {
			$this->_customLinks = array(array('linkLabel' => '', 'linkUrl' => ''));
		}
		
		// Generate table
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
				),
				'rows' => $this->_customLinks,
				'addRowLabel'  => Craft::t('Add a link'),
			)
		));
		
		// Output settings template
		return craft()->templates->render('adminbar/settings', array(
			'customLinksTable' => $customLinksTable,
		));
	}
	
	private function _customLinks()
	{
		$this->_customLinks = $this->getSettings()->customLinks;
		$customLinks = '';
		if ($this->_customLinks) {
			foreach ($this->_customLinks as $row) {
				if ($customLinks) {$customLinks .= ',';}
				$customLinks .= "'{$row['linkLabel']}':'{$row['linkUrl']}'";
			}
		}
	}
}