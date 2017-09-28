<?php
/**
 * Ok, glad you are here
 * first we get a config instance, and set the settings
 * $config = HTMLPurifier_Config::createDefault();
 * $config->set('Core.Encoding', $this->config->get('purifier.encoding'));
 * $config->set('Cache.SerializerPath', $this->config->get('purifier.cachePath'));
 * if ( ! $this->config->get('purifier.finalize')) {
 *     $config->autoFinalize = false;
 * }
 * $config->loadArray($this->getConfig());
 *
 * You must NOT delete the default settings
 * anything in settings should be compacted with params that needed to instance HTMLPurifier_Config.
 *
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 */

return [
    'encoding'      => 'UTF-8',
    'finalize'      => true,
    'cachePath'     => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings'      => [
        'default1' => [
            'HTML.Doctype'             => 'XHTML 1.0 Strict',
            'HTML.Allowed'             => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'   => true,
        ],

        'default' => [
	        'Attr' => [
		        'AllowedRel'      => [],
		        'DefaultImageAlt' => NULL,
	        ],

	        'Core' => [
		        'EscapeInvalidTags' => FALSE,
		        'CollectErrors'     => TRUE, // somehow with this option, purifier doesn't touch newlines and whitespaces
	        ],

	        'HTML' => [
		        'AllowedElements'   => [],
		        'AllowedAttributes' => [],
		        'Doctype'           => NULL,
	        ],

	        'URI' => [
	        	'AllowedSchemes' => [],
		        'Base'           => NULL,
	        ],
        ],

        'with_tags' => [
	        'Core' => [
	        	'EscapeInvalidTags' => FALSE,
		        'CollectErrors' => TRUE, // somehow with this option, purifier doesn't touch newlines and whitespaces
	        ],

	        'HTML' => [
		        'DefinitionID'  => 'customDefinition',
		        'DefinitionRev' => 1,

		        'Doctype' => 'HTML 4.01 Transitional',
		        'Allowed' => 'h1,h2,h3,h4,h5,h6,a[href],b,strong,i,em,s,strike,u,hr,blockquote,table,th,td,tr,sup,sub,abbr[title],acronym[title],pre,ul,li,ol,li,br,p',
	        ]
        ],

        'test'    => [
            'Attr.EnableID' => true
        ],

        "youtube" => [
            "HTML.SafeIframe"      => 'true',
            "URI.SafeIframeRegexp" => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%",
        ],
    ],

];
