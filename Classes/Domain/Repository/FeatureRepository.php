<?php

namespace Crazy252\Typo3Features\Domain\Repository;

use Crazy252\Typo3Features\Domain\Model\Feature;
use TYPO3\CMS\Extbase\Persistence\Repository;

class FeatureRepository extends Repository
{
    /**
     * @param string $featureName
     * @return Feature|object|null
     */
    public function getFeature($featureName)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('key', $featureName));
        return $query->execute()->getFirst();
    }
}
