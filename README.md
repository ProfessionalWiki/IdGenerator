# Numeric Id

[![Build Status](https://travis-ci.org/ProfessionalWiki/NumericId.svg?branch=master)](https://travis-ci.org/ProfessionalWiki/NumericId)
[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/NumericId/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/NumericId/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProfessionalWiki/NumericId/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/NumericId/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/numeric-id/version.png)](https://packagist.org/packages/professional-wiki/numeric-id)
[![Download count](https://poser.pugx.org/professional-wiki/numeric-id/d/total.png)](https://packagist.org/packages/professional-wiki/numeric-id)



## Platform requirements

* PHP 7.1 or later
* MediaWiki 1.31 or later (and likely also older versions)

## Installation

The recommended way to install Numeric Id is using [Composer](https://getcomposer.org) with
[MediaWiki's built-in support for Composer](https://professional.wiki/en/articles/installing-mediawiki-extensions-with-composer).

### Step 1

Change to the base directory of your MediaWiki installation. If you do not have a "composer.local.json" file yet,
create one and add the following content to it:

```
{
	"require": {
		"professional-wiki/numeric-id": "~1.0"
	}
}
```

If you already have a "composer.local.json" file add the following line to the end of the "require"
section in your file:

    "professional-wiki/numeric-id": "~1.0"

Remember to add a comma to the end of the preceding line in this section.

### Step 2

Run the following command in your shell:

    php composer.phar update --no-dev

Note if you have Git installed on your system add the `--prefer-source` flag to the above command.

### Step 3

Add the following line to the end of your "LocalSettings.php" file:

    wfLoadExtension( 'NumericId' );

## Usage


## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/ProfessionalWiki/NumericId/issues)
* [Submit a pull request](https://github.com/ProfessionalWiki/NumericId/pulls)
* [Professional MediaWiki support](https://professional.wiki/en/support) is available via [Professional Wiki](https://professional.wiki/).

## Release notes


### Version 1.0.0

Released on August 16, 2019.

Initial release with
