<?php

namespace Crazy252\Typo3Features\Xclass;

use Crazy252\Typo3Features\Service\Feature;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Features extends \TYPO3\CMS\Core\Configuration\Features
{
    public function isFeatureEnabled(string $featureName): bool
    {
        return GeneralUtility::makeInstance(Feature::class)->enabled($featureName);
    }
}
