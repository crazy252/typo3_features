<?php

namespace Crazy252\Typo3Features\Legacy;

use Crazy252\Typo3Features\Service\Feature;
use TYPO3\CMS\Core\Configuration\Features as CoreFeatures;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Features
{
    /**
     * @param string $featureName
     * @return bool
     */
    public function isFeatureEnabled($featureName)
    {
        if (class_exists(CoreFeatures::class)) {
            return GeneralUtility::makeInstance(CoreFeatures::class)->isFeatureEnabled($featureName);
        }

        return GeneralUtility::makeInstance(Feature::class)->enabled($featureName);
    }
}
