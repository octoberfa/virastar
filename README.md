# Virastar (ویراستار)
Virastar is a Persian text cleaner.  

[![Latest Stable Version](https://poser.pugx.org/octoberfa/virastar/v/stable)](https://packagist.org/packages/octoberfa/virastar)
[![Latest Unstable Version](https://poser.pugx.org/octoberfa/virastar/v/unstable)](https://packagist.org/packages/octoberfa/virastar)
[![Build Status](https://travis-ci.org/octoberfa/virastar.svg?branch=master)](https://travis-ci.org/octoberfa/virastar)
[![Total Downloads](https://poser.pugx.org/octoberfa/virastar/downloads)](https://packagist.org/packages/octoberfa/virastar)
[![License](https://poser.pugx.org/octoberfa/virastar/license)](https://packagist.org/packages/octoberfa/virastar)
[![composer.lock](https://poser.pugx.org/octoberfa/virastar/composerlock)](https://packagist.org/packages/octoberfa/virastar)

A php port of [juvee/virastar](https://github.com/juvee/virastar)


## Install
``` bash
composer require octoberfa/virastar
```

## Usage
```php
require "./vendor/autoload.php";
echo virastar("فارسي را كمی درست تر می نويسيم");
// Outputs: "فارسی را کمی درست‌تر می‌نویسیم"
```

#### virastar([text] [,options])

##### text
Type: `string`

String of Persian source to be cleaned.

##### options
Type: `array`

```php
virastar("سلام 123" ,["fix_english_numbers":false]);
// Outputs:"سلام 123"
```

## Options and Specifications
Virastar comes with a list of options to control its behavior.

_all options are **enabled** by default._

* `normalize_eol`
	- replace Windows end of lines with Unix EOL (`\n`)


* `decode_htmlentities`
	- converts all HTML characterSets into original characters


* `fix_dashes`
	- replace double dash to ndash and triple dash to mdash


* `fix_three_dots`
	- replace three dots with ellipsis


* `fix_english_quotes_pairs`
	- replace English quotes pairs (`“”`) with their Persian equivalent (`«»`)


* `fix_english_quotes`
	- replace English quotes, commas and semicolons with their Persian equivalent


* `fix_hamzeh`
	- convert `ه ی` to `هٔ`


* `cleanup_rlm`
	- converting Right-to-left marks followed by Persian characters to zero-width non-joiners (ZWNJ)


* `cleanup_zwnj`
	- remove more than one zwnj chars  
	- remove unnecessary zwnj chars that are succeeded/preceded by a space  
	- clean zwnj chars after Persian characters that don't conncet to the next letter  
	- clean zwnj chars before English characters  
	- clean zwnj chars after and before punctuation  


* `fix_arabic_numbers`
	- replace Arabic numbers with their Persian equivalent


* `fix_english_numbers`
	- replace English numbers with their Persian equivalent
	- should not replace English numbers in English phrases


* `skip_markdown_ordered_lists_numbers_conversion`
	- skip converting English numbers of ordered lists in markdown


* `fix_misc_non_persian_chars`
	- replace Arabic kaf and Yeh with its Persian equivalent


* `fix_question_mark`
	- replace question marks with its Persian equivalent


* `fix_perfix_spacing`
	- put zwnj between word and prefix (`mi*` `nemi*`)


* `fix_suffix_spacing`
	- put zwnj between word and suffix (`*tar` `*tarin` `*ha` `*haye`)


* `fix_spacing_for_braces_and_quotes`
	- fix spacing for `()` `[]` `{}`  `“”` `«»` (one space outside, no space inside)
	- correct `:;,.?!` spacing (one space after and no space before)


* `cleanup_spacing`
	- replace more than one space with just a single one


* `cleanup_begin_and_end`
	- remove spaces, tabs, and new lines from the beginning and end of text

* `cleanup_extra_marks`
	- replace more than one `!` or `?` mark with just one

* `kashidas_as_parenthetic`
	- replace kashidas to ndash in parenthetic

* `cleanup_kashidas`
	- remove all kashidas

* `preserve_HTML`
	- preserve all HTML tags


* `preserve_URIs`
	- preserve all URI links in the text


* `preserve_brackets`
	- preserve strings inside square brackets (`[]`)


* `preserve_braces`
	- preserve strings inside curly braces (`{}`)

* `preserve_code`
  - preserve strings inside html code tag and markdown "```"

* `preserve_pre`
  - preserve strings inside html pre tag
## License

This software is licensed under the MIT License. [View the license](LICENSE).
