<?php

namespace Crazy252\Typo3Features\Service;

use Crazy252\Typo3Features\Contracts\FeatureInterface;
use Crazy252\Typo3Features\Domain\Repository\FeatureRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class Feature
{
    /**
     * @param string $featureName
     * @return bool
     */
    public function enabled($featureName)
    {
        $features = GeneralUtility::trimExplode(',', $featureName);
        // no feature
        if (count($features) === 0) {
            return false;
        }
        // one feature
        if (count($features) === 1) {
            return $this->isFeatureEnabled($features[0]);
        }

        // more than one feature
        $result = [];
        foreach ($features as $feature) {
            $result[$feature] = $this->isFeatureEnabled($feature);
        }

        $resultEnabled = array_filter($result, function ($res) {
            return $res === true;
        });

        return count($result) === count($resultEnabled);
    }

    /**
     * @param string $featureName
     * @return bool
     */
    private function isFeatureEnabled($featureName)
    {
        // always active features from the core
        if (isset($this->alwaysActiveFeatures) and in_array($featureName, $this->alwaysActiveFeatures, true)) {
            return true;
        }

        // features from the configuration
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['features'][$featureName])) {
            return $GLOBALS['TYPO3_CONF_VARS']['SYS']['features'][$featureName];
        }

        // features in database with special other handling
        $featureRepository = $this->initClass(FeatureRepository::class);
        $feature = $featureRepository->getFeature($featureName);

        // check if feature is found
        if (!is_array($feature) or !is_object($feature)) {
            return false;
        }

        // has class in feature, so init class and call verdict function
        if ($feature->getClassString()) {
            $featureCheck = $this->initClass($feature->getClassString());
            return ($featureCheck ? $featureCheck->verdict() : false);
        }

        // TODO: add FE/BE-Groups for checking

        return $feature->getHidden();
    }

    /**
     * @param string $targetClass
     * @return FeatureInterface|null
     */
    private function initClass($targetClass)
    {
        if (!class_exists($targetClass)) {
            return null;
        }
        // Check if ObjectManager does not exist. So we are in a version where DI is possible via makeInstance
        if (!class_exists(ObjectManager::class)) {
            return GeneralUtility::makeInstance($targetClass);
        }
        // Use ObjectManager for DI
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get($targetClass);
    }

    /*private function getFrontendUserSession()
    {
        if (class_exists(Context::class)) {
            return GeneralUtility::makeInstance(Context::class)->getAspect('frontend.user');
        }
        if (!isset($GLOBALS['TSFE']) || !$GLOBALS['TSFE']->loginUser) {
            return null;
        }
        return $GLOBALS['TSFE']->fe_user;
    }*/
}
