<?php
// Copyright 2013 ciruz
if (!defined("IN_ESOTALK")) exit;

ET::$pluginInfo["GoogleAnalytics"] = array(
	"name" => "Google Analytics",
	"description" => "Adds Google Analytics.",
	"version" => "0.1",
	"author" => "ciruz",
	"authorEmail" => "me@ciruz.net",
	"authorURL" => "http://www.ciruz.net",
	"license" => "MIT"
);

class ETPlugin_GoogleAnalytics extends ETPlugin{

	public function handler_init($sender){
		$propertyId = C('plugin.GoogleAnalytics.propertyId');

		if($propertyId)
			$analyticsCode = "<script type=\"text/javascript\">\n var _gaq = _gaq || [];\n _gaq.push(['_setAccount', '".$propertyId."']);\n _gaq.push(['_trackPageview']);\n (function() { \n  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; \n  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n })();\n</script>";

		$sender->addToHead($analyticsCode);
	}

	public function settings($sender){
		$form = ETFactory::make('form');
		$form->action = URL('admin/plugins');
		$form->setValue("propertyId", C("plugin.GoogleAnalytics.propertyId"));

		if ($form->validPostBack('GoogleAnalyticsSave')){
			$config = array();
			$config['plugin.GoogleAnalytics.propertyId'] = trim($form->getValue('propertyId'));

			ET::writeConfig($config);

			$sender->message(T('message.changesSaved'), 'success');
			$sender->redirect(URL('admin/plugins'));
		}

		$sender->data('GoogleAnalyticsForm', $form);
		return $this->getView('settings');
	}

}