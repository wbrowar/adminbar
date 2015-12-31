<?php
namespace Craft;

class AdminbarPlugin extends BasePlugin
{
	private $_customLinks;
	
	public function getName()
	{
		return Craft::t('Admin Bar');
	}
	public function getVersion()
	{
		return '1.4.3';
	}
	public function getSchemaVersion()
	{
		return '1.0.0';
	}
	public function getDescription()
	{
		return 'Simple front-end shortcut bar for users logged into Craft CMS.';
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
		parent::init();
		if (craft()->request->isCpRequest()) {
			// get data for custom links
			$this->_customLinks();
		}
		
		craft()->on('plugins.onLoadPlugins', array($this, 'onLoadPlugins'));
		
		// update settings if new settings aren't set
		if (!isset($this->getSettings()->externalLinksString)) {
			$this->defineSettings();
		}
	}
	
	// handle on load plugins
	public function onLoadPlugins(Event $event) {
		$plugin = craft()->plugins->getPlugin('Adminbar');
		
		if ($this->_canAutoEmbed($plugin)) {
			// show adminbar in template
			$element = craft()->urlManager->getMatchedElement();
			craft()->adminbar->bar($element, $plugin->getSettings()->defaultColor, 'primary');
		}
	}
	
	protected function defineSettings()
	{
		return array(
			'autoEmbed' => array(AttributeType::Bool, 'default' => false),
			'autoEmbedSticky' => array(AttributeType::Bool, 'default' => false),
			'customLinks' => array(AttributeType::Mixed, 'label' => 'Custom Links', 'default' => array()),
			'defaultColor' => array(AttributeType::String, 'label' => 'Default Color', 'default' => '#d85b4b'),
			'enabledLinks' => array(AttributeType::Mixed, 'label' => 'Enabled Link', 'default' => array()),
			'externalLinksString' => array(AttributeType::String, 'label' => 'Plugin Links String', 'default' => '...'),
		);
	}
	public function getSettingsHtml()
	{
		// if not set, create a default row for custom links table
		if (!$this->_customLinks) {
			$this->_customLinks = array(array('linkLabel' => '', 'linkUrl' => '', 'adminOnly' => ''));
		}
		
		// generate table for custom links
		$customLinksTable = craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'				=> Craft::t('Custom Links'),
				'instructions' => Craft::t('Add your own links to the Admin Bar.'),
				'id'					 => 'customLinks',
				'name'				 => 'customLinks',
				'cols'				 => array(
					'linkLabel' => array(
						'heading' => Craft::t('Label'),
						'type'		=> 'singleline',
					),
					'linkUrl' => array(
						'heading' => Craft::t('URL'),
						'type'		=> 'singleline',
					),
					'adminOnly' => array(
						'heading' => Craft::t('Admins Only'),
						'type'		=> 'checkbox',
					),
				),
				'rows' => $this->_customLinks,
				'addRowLabel'	=> Craft::t('Add a link'),
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
	
	public function clearAdminBarCache() {
		$user = craft()->userSession->getUser();
		
		craft()->templateCache->deleteCachesByKey('adminbar' . $user->id);
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

	// check to see if bar should be auto embedded
	private function _canAutoEmbed($plugin)
	{
		return (
			!craft()->isConsole() &&
			!craft()->request->isCpRequest() &&
			!craft()->request->isAjaxRequest() &&
			craft()->userSession->isLoggedIn() &&
			$plugin->getSettings()->autoEmbed == 1
		);
	}
}
