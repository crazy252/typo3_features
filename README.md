# TYPO3 Feature Flags

Introducing the new open-source package for TYPO3, designed to streamline
feature management through the use of feature flags. This package empowers
developers and site administrators with a flexible and intuitive backend
interface for creating and managing feature flags, enabling granular control
over feature deployments. Whether you're rolling out new features incrementally,
running A/B tests, or customizing user experiences, our package supports both
standard and custom flags, offering a robust solution for feature toggling
directly within TYPO3. Unlock seamless feature control and ensure your site's
features are deployed smoothly and efficiently.

## Features

- Custom Features via TYPO3 Backend
- Validate multiple Features at once
- Make your own feature class
- Fluid ViewHelper
- User and Group check for Features (Frontend & Backend)
- Compatible with TYPO3 7-13

## Setup

Installtion via composer

```shell
composer require crazy252/typo3_features
```

## Usage

You can use the original features core class from TYPO3. This class is extended
by this package with a lot of new features.

```php
use TYPO3\CMS\Core\Configuration\Features;

$features = GeneralUtility::makeInstance(Features::class);

$isFeatureEnabled = $features->isFeatureEnabled('dummy-feature');

// You can also check multiple features if you want
$isFeatureEnabled = $features->isFeatureEnabled('dummy-feature,other-feature');
```

### Own feature class

You can also create your own logic for the feature check by adding the class
namespace in the backend feature. After the feature is created in the backend,
you can create a feature class with the interface from the package

```php
namespace Vendor\Extension\Features;

class DummyFeature implements \Crazy252\Typo3Features\Contracts
{
    public function verdict(): bool
    {
        // Custom feature check
    }
}
```

### Feature ViewHelper

This package gives also an viewhelper to check for features in the template.
TYPO3 13.1 has an viewhelper for this. Before that, we backport the viewhelper
to older versions.

```xml

<f:feature name="dummy-feature">
    This is being shown if the flag is enabled
</f:feature>

<f:feature name="dummy-feature,other-feature">
This is being shown if both flags are enabled
</f:feature>
```

## Usage (TYPO3 9.0 or below)

You need to use the legecy class for features which can be replaced in higher
versions easily with the feature core class.

```php
use Crazy252\Typo3Features\Legacy\Features;

$features = GeneralUtility::makeInstance(Features::class);

$isFeatureEnabled = $features->isFeatureEnabled('dummy-feature');

$isFeatureEnabled = $features->isFeatureEnabled('dummy-feature,other-feature');
```


