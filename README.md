# ID Generator

[![Build Status](https://travis-ci.org/ProfessionalWiki/IdGenerator.svg?branch=master)](https://travis-ci.org/ProfessionalWiki/IdGenerator)
[![Code Coverage](https://scrutinizer-ci.com/g/ProfessionalWiki/IdGenerator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/IdGenerator/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProfessionalWiki/IdGenerator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProfessionalWiki/IdGenerator/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/professional-wiki/id-generator/version.png)](https://packagist.org/packages/professional-wiki/id-generator)
[![Download count](https://poser.pugx.org/professional-wiki/id-generator/d/total.png)](https://packagist.org/packages/professional-wiki/id-generator)

The **ID Generator** extension provides a minimalistic sequential numeric ID generation function. It was created by [Professional.Wiki](https://professional.wiki/).

The wikitext `{{#next_number:}}` outputs `1` the first time it is used, then `2`, etc. 

Installable and usable without running the "update.php" maintenance script. Created as alternative to the IDProvider extension, since it cannot be installed via Composer and moreover requires an extra database table.

## Usage

To get a new numeric ID:

    {{#next_number:}}

The above function will output a new number on every reparse of the page. If you want a number to be generated once,
you can use [MediaWiki's `subst` function](https://www.mediawiki.org/wiki/Help:Substitution) as follows:

    {{subst:#next_number:}}

You can have multiple id sequences by providing an ID type. This type can be any string up to 60 characters.

    {{#next_number:project}}

**Number increment details**

* IDs are incremented globally, not per page.
* Increments happen on every parse.
* MediaWiki might parse the parser function more than once per save, so the function output might go from 1 to 3.
* You are guaranteed to get a higher ID on every generation. Usage is not tracked, so there is no reuse.

**Example**

A page with `{{#next_number:}} {{#next_number:}}` will output `1 2`, assuming the extension was just installed.
If the ID counter was already at 100, you'd get `101 102`. If you then refresh this page you'd get `103 104`.

## Platform requirements

* PHP 7.1 or later
* MediaWiki 1.31 or later (and likely also older versions)

## Installation

The recommended way to install ID Generator is using [Composer](https://getcomposer.org) with
[MediaWiki's built-in support for Composer](https://professional.wiki/en/articles/installing-mediawiki-extensions-with-composer).

### Step 1

Change to the base directory of your MediaWiki installation. If you do not have a "composer.local.json" file yet,
create one and add the following content to it:

```
{
	"require": {
		"professional-wiki/id-generator": "~1.0"
	}
}
```

If you already have a "composer.local.json" file add the following line to the end of the "require"
section in your file:

    "professional-wiki/id-generator": "~1.0"

Remember to add a comma to the end of the preceding line in this section.

### Step 2

Run the following command in your shell:

    php composer.phar update --no-dev

Note if you have Git installed on your system add the `--prefer-source` flag to the above command.

### Step 3

Add the following line to the end of your "LocalSettings.php" file:

    wfLoadExtension( 'IdGenerator' );

## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/ProfessionalWiki/IdGenerator/issues)
* [Submit a pull request](https://github.com/ProfessionalWiki/IdGenerator/pulls)
* [Professional MediaWiki support](https://professional.wiki/en/support) is available via [Professional Wiki](https://professional.wiki/).


## License

[BSD 3-Clause "New" or "Revised" License (BSD-3-Clause)](/COPYING).

## Release notes

### Version 1.0.0

Released on January 27th, 2020.

Initial release
