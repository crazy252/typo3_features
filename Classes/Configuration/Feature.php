<?php

namespace Crazy252\Typo3Features\Configuration;

use Crazy252\Typo3Features\Contracts\FeatureInterface;
use Crazy252\Typo3Features\Domain\Model\Feature as ModelFeature;
use Crazy252\Typo3Features\Domain\Repository\FeatureRepository;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class Feature
{
    /**
     * @param string $featureNames
     * @return bool
     */
    public function enabled($featureNames)
    {
        $features = GeneralUtility::trimExplode(',', $featureNames);
        // no feature
        if (count($features) === 0) {
            return false;
        }
        // one feature
        if (count($features) === 1) {
            return $this->isFeatureEnabled($features[0]);
        }

        // more than one feature
        $featuresList = [];
        foreach ($features as $feature) {
            $featuresList[$feature] = $this->isFeatureEnabled($feature);
        }

        $featuresEnabled = array_filter($featuresList, function ($res) {
            return $res === true;
        });

        return count($featuresList) === count($featuresEnabled);
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
            return (bool)$GLOBALS['TYPO3_CONF_VARS']['SYS']['features'][$featureName];
        }

        // features in database with special other handling
        /** @var FeatureRepository $featureRepository */
        $featureRepository = $this->initClass(FeatureRepository::class);
        $feature = $featureRepository->getFeature($featureName);

        // check if feature is found
        if (!($feature instanceof ModelFeature) or !is_object($feature)) {
            return false;
        }
        // check if feature is hidden
        if ($feature->getHidden() === true) {
            return false;
        }

        // has class in feature, so init class and call verdict function
        if ($feature->getClassString()) {
            $featureCheck = $this->initClass($feature->getClassString());
            return ($featureCheck ? $featureCheck->verdict() : false);
        }

        // get frontend user session
        $userFrontend = $this->getFrontendUserSession();
        if ($userFrontend and $userFrontend->user) {
            // check assigned frontend users of feature against frontend user
            if (is_string($feature->getFeUsers()) and strlen($feature->getFeUsers()) > 0) {
                $feUsers = GeneralUtility::trimExplode(',', $feature->getFeUsers(), true);
                return in_array($userFrontend->user['uid'], $feUsers, true);
            }

            // check assigned frontend user groups of feature against frontend user
            if (is_string($feature->getFeGroups()) and strlen($feature->getFeGroups()) > 0) {
                $feGroups = GeneralUtility::trimExplode(',', $feature->getFeGroups(), true);
                $userFrontendGroupIds = array_keys($userFrontend->userGroups);

                foreach ($userFrontendGroupIds as $userFrontendGroupId) {
                    return in_array($userFrontendGroupId, $feGroups, true);
                }
            }
        }

        // get backend user session
        $userBackend = $this->getBackendUserSession();
        if ($userBackend and $userBackend->user) {
            // check assigned backend users of feature against backend user
            if (is_string($feature->getBeUsers()) and strlen($feature->getBeUsers()) > 0) {
                $beUsers = GeneralUtility::trimExplode(',', $feature->getBeUsers(), true);
                return in_array($userBackend->user['uid'], $beUsers, true);
            }

            // check assigned backend user groups of feature against backend user
            if (is_string($feature->getBeGroups()) and strlen($feature->getBeGroups()) > 0) {
                $beGroups = GeneralUtility::trimExplode(',', $feature->getBeGroups(), true);
                $userBackendGroupIds = array_keys($userBackend->userGroups);

                foreach ($userBackendGroupIds as $userBackendGroupId) {
                    return in_array($userBackendGroupId, $beGroups, true);
                }
            }
        }

        return false;
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
        return GeneralUtility::makeInstance(ObjectManager::class)->get($targetClass);
    }

    /**
     * @return FrontendUserAuthentication|null
     */
    private function getFrontendUserSession()
    {
        if (class_exists(Context::class) and $this->getContext()->hasAspect('frontend.user')) {
            return $this->getContext()->getAspect('frontend.user');
        }
        if (!isset($GLOBALS['TSFE']) or !isset($GLOBALS['TSFE']->fe_user)) {
            return null;
        }
        return $GLOBALS['TSFE']->fe_user;
    }

    /**
     * @return BackendUserAuthentication|null
     */
    private function getBackendUserSession()
    {
        if (class_exists(Context::class) and $this->getContext()->hasAspect('backend.user')) {
            return $this->getContext()->getAspect('backend.user');
        }
        if (!isset($GLOBALS['BE_USER'])) {
            return null;
        }
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return Context
     */
    private function getContext()
    {
        return GeneralUtility::makeInstance(Context::class);
    }
}
