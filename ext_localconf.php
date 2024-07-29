<?php

defined('TYPO3_MODE') or defined('TYPO3') or die();

$t3Version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version();

// Add xclass for Features if original class exists (since v9.1)
if (class_exists(\TYPO3\CMS\Core\Configuration\Features::class)) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Core\Configuration\Features::class] = [
        'className' => \Crazy252\Typo3Features\Xclass\Features::class
    ];
}
// Add xclass for Features if feature toggle of extbase does exist (deprecated in v12, removed in v13)
/*if (version_compare($t3Version, '13.0.0', '<')) {

}*/

// Add viewhelper to fluid namespace if feature viewhelper of fluid does not exist (since v13.2)
if (!class_exists(\TYPO3\CMS\Fluid\ViewHelpers\FeatureViewHelper::class)) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['f'] = array_merge(
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['f'],
        ['Crazy252\\Typo3Features\\ViewHelpers']
    );
}

if (version_compare($t3Version, '9.5.0', '<')) {
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );
    $iconRegistry->registerIcon(
        'install-manage-features',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:typo3_feature/Resources/Public/Icons/feature.svg']
    );
}
