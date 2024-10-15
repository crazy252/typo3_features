<?php

namespace Classes;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

class Bootstrap
{
    const EXT_KEY = 'typo3_features';

    public function extLocalconf()
    {
        $this->xClassCoreFeatures();
        $this->xClassExtbaseConfigurationManager();

        $this->fluidViewHelper();

        $this->icons();
    }

    /**
     * Add xclass for Features if original class exists (since v9.1)
     */
    public function xClassCoreFeatures()
    {
        if (!class_exists(\TYPO3\CMS\Core\Configuration\Features::class)) {
            return;
        }
        if ((bool)$this->extConfig()['xclass_core_features'] === false) {
            return;
        }

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Core\Configuration\Features::class] = [
            'className' => \Crazy252\Typo3Features\Xclass\Core\Configuration\Features::class
        ];
    }

    /**
     * Add xclass for Features if feature toggle of extbase does exist (deprecated in v12, removed in v13)
     */
    public function xClassExtbaseConfigurationManager()
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '13.0.0', '>=')) {
            return;
        }
        if (!class_exists(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class)) {
            return;
        }
        if ((bool)$this->extConfig()['xclass_extbase_features'] === false) {
            return;
        }

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Extbase\Configuration\ConfigurationManager::class] = [
            'className' => \Crazy252\Typo3Features\Xclass\Extbase\Configuration\ConfigurationManager::class
        ];
    }

    /**
     * Add viewhelper to fluid namespace if feature viewhelper of fluid does not exist (since v13.2)
     */
    public function fluidViewHelper()
    {
        if (class_exists(\TYPO3\CMS\Fluid\ViewHelpers\FeatureViewHelper::class)) {
            return;
        }
        if ((bool)$this->extConfig()['fluid_viewhelper'] === false) {
            return;
        }

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['f'] = array_merge(
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['f'],
            ['Crazy252\\Typo3Features\\ViewHelpers']
        );
    }

    public function icons()
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '9.4.99', '>')) {
            return;
        }

        $iconRegistry = $this->getInstance(IconRegistry::class);
        $iconRegistry->registerIcon(
            'install-manage-features',
            SvgIconProvider::class,
            ['source' => 'EXT:typo3_feature/Resources/Public/Icons/feature.svg']
        );
    }

    /**
     * @return mixed
     */
    private function extConfig()
    {
        if (class_exists(\TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility::class)) {
            return $this->getInstance(\TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility::class)
                ->getCurrentConfiguration(self::EXT_KEY);
        }
        return $this->getInstance(ExtensionConfiguration::class)->get(self::EXT_KEY);
    }

    /**
     * @param string|class-string $name
     * @return mixed
     */
    private function getInstance($name)
    {
        if (class_exists(\TYPO3\CMS\Extbase\Object\ObjectManager::class)) {
            return GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class)->get($name);
        }
        return GeneralUtility::makeInstance($name);
    }
}
