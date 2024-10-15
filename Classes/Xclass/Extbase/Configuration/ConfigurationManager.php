<?php

namespace Crazy252\Typo3Features\Xclass\Extbase\Configuration;

use Crazy252\Typo3Features\Configuration\FeatureNew;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConfigurationManager extends \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
{
    public function isFeatureEnabled(string $featureName): bool
    {
        return GeneralUtility::makeInstance(FeatureNew::class)->enabled($featureName);
    }
}
