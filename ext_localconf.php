<?php

defined('TYPO3_MODE') or defined('TYPO3') or die();

call_user_func(function () {
    $bootstrap = new \Classes\Bootstrap();
    $bootstrap->xClassCoreFeatures();
    $bootstrap->xClassExtbaseConfigurationManager();
    $bootstrap->fluidViewHelper();
    $bootstrap->icons();
});
