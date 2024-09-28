<?php

namespace Crazy252\Typo3Features\ViewHelpers;

use Crazy252\Typo3Features\Legacy\Features;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class FeatureViewHelper extends AbstractConditionViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'name of the feature flag that should be checked', true);
    }

    /**
     * @param array $arguments
     * @param RenderingContextInterface $renderingContext
     */
    public static function verdict($arguments, $renderingContext)
    {
        return GeneralUtility::makeInstance(Features::class)->isFeatureEnabled($arguments['name']);
    }
}
