<?php namespace OctoberFa\Virastar;
/**
 *  Virastar is a Persian text cleaner.
 *
 *
 *  @author Sajjad Servatjoo
 */

if (!function_exists('virastar')) {
    /**
     * php persian string normalizer
     *
     * @param string $text Text for normalize.
     * @param array $options Array containing the options.
     *    $options = [
     *      'normalize_eol' => (boolean) replace Windows end of lines with Unix EOL (\n).
     *      'decode_htmlentities' => (boolean) converts all HTML characterSets into original characters.
     *      'fix_dashes' => (boolean) replace double dash to ndash and triple dash to mdash.
     *      'fix_three_dots' => (boolean) replace three dots with ellipsis.
     *      'fix_english_quotes_pairs' => (boolean) replace English quotes pairs (“”) with their Persian equivalent («»).
     *      'fix_english_quotes' => (boolean) replace English quotes, commas and semicolons with their Persian equivalent.
     *      'fix_hamzeh' => (boolean) convert ه ی to هٔ.
     *      'cleanup_rlm' => (boolean) converting Right-to-left marks followed by Persian characters to zero-width non-joiners (ZWNJ).
     *      'cleanup_zwnj' => (boolean) remove more than one zwnj chars, remove unnecessary zwnj chars that are succeeded/preceded by a space, clean zwnj chars after Persian characters that don't conncet to the next letter, clean zwnj chars before English characters, clean zwnj chars after and before punctuation.
     *      'fix_spacing_for_braces_and_quotes' => (boolean) fix spacing for () [] {} “” «» (one space outside, no space inside), correct :;,.?! spacing (one space after and no space before).
     *      'fix_arabic_numbers' => (boolean) replace Arabic numbers with their Persian equivalent.
     *      'fix_english_numbers' => (boolean) replace English numbers with their Persian equivalent, should not replace English numbers in English phrases.
     *      'fix_question_mark' => (boolean) replace question marks with its Persian equivalent.
     *      'skip_markdown_ordered_lists_numbers_conversion' => (boolean) skip converting English numbers of ordered lists in markdown.
     *      'fix_perfix_spacing' => (boolean) put zwnj between word and prefix (mi* nemi*).
     *      'fix_suffix_spacing' => (boolean) put zwnj between word and suffix (*tar *tarin *ha *haye).
     *      'fix_misc_non_persian_chars' => (boolean) replace Arabic kaf and Yeh with its Persian equivalent.
     *      'aggresive' => (boolean) 
     *      'kashidas_as_parenthetic' => (boolean) replace kashidas to ndash in parenthetic.
     *      'cleanup_kashidas' => (boolean) remove all kashidas.
     *      'cleanup_extra_marks' => (boolean) replace more than one ! or ? mark with just one.
     *      'cleanup_spacing' => (boolean) replace more than one space with just a single one.
     *      'cleanup_begin_and_end' => (boolean) remove spaces, tabs, and new lines from the beginning and end of text.
     *      'preserve_HTML' => (boolean) preserve all HTML tags.
     *      'preserve_URIs' => (boolean) preserve all URI links in the text.
     *      'preserve_brackets' => (boolean) preserve strings inside square brackets ([]).
     *      'preserve_braces' => (boolean) preserve strings inside curly braces ({}).
     *      'preserve_code' => (boolean) preserve strings inside html code tag and markdown "```".
     *      'preserve_pre' => (boolean) preserve strings inside html pre tag.
     *    ]
     */
    function virastar($text, $options = [])
    {
        $defaults = [
            "normalize_eol" => true,
            "decode_htmlentities" => true,
            "fix_dashes" => true,
            "fix_three_dots" => true,
            "fix_english_quotes_pairs" => true,
            "fix_english_quotes" => true,
            "fix_hamzeh" => true,
            "cleanup_rlm" => true,
            "cleanup_zwnj" => true,
            "fix_spacing_for_braces_and_quotes" => true,
            "fix_arabic_numbers" => true,
            "fix_english_numbers" => true,
            "fix_question_mark" => true,
            "skip_markdown_ordered_lists_numbers_conversion" => true,
            "fix_perfix_spacing" => true,
            "fix_suffix_spacing" => true,
            "fix_misc_non_persian_chars" => true,
            "aggresive" => true,
            "kashidas_as_parenthetic" => true,
            "cleanup_kashidas" => true,
            "cleanup_extra_marks" => true,
            "cleanup_spacing" => true,
            "cleanup_begin_and_end" => true,
            "preserve_HTML" => true,
            "preserve_URIs" => true,
            "preserve_brackets" => true,
            "preserve_braces" => true,
            'preserve_code' => true,
            'preserve_pre' => true,
        ];

        $options = array_merge($defaults, $options);
        $numbersPersian = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];
        $numbersArabic = ['١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '٠'];
        $numbersEnglish = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        // convert persian chars
        $from = [
            // collection 1
            ['؆', '؇', '؈', '؉', '؊', '؍', '؎', 'ؐ', 'ؑ', 'ؒ', 'ؓ', 'ؔ', 'ؕ', 'ؖ', 'ؘ', 'ؙ', 'ؚ', '؞', 'ٖ', 'ٗ', '٘', 'ٙ', 'ٚ', 'ٛ', 'ٜ', 'ٝ', 'ٞ', 'ٟ', '٪', '٬', '٭', 'ہ', 'ۂ', 'ۃ', '۔', 'ۖ', 'ۗ', 'ۘ', 'ۙ', 'ۚ', 'ۛ', 'ۜ', '۞', '۟', '۠', 'ۡ', 'ۢ', 'ۣ', 'ۤ', 'ۥ', 'ۦ', 'ۧ', 'ۨ', '۩', '۪', '۫', '۬', 'ۭ', 'ۮ', 'ۯ', 'ﮧ', '﮲', '﮳', '﮴', '﮵', '﮶', '﮷', '﮸', '﮹', '﮺', '﮻', '﮼', '﮽', '﮾', '﮿', '﯀', '﯁', 'ﱞ', 'ﱟ', 'ﱠ', 'ﱡ', 'ﱢ', 'ﱣ', 'ﹰ', 'ﹱ', 'ﹲ', 'ﹳ', 'ﹴ', 'ﹶ', 'ﹷ', 'ﹸ', 'ﹹ', 'ﹺ', 'ﹻ', 'ﹼ', 'ﹽ', 'ﹾ', 'ﹿ'],
            // collection 2
            ['أ', 'إ', 'ٱ', 'ٲ', 'ٳ', 'ٵ', 'ݳ', 'ݴ', 'ﭐ', 'ﭑ', 'ﺃ', 'ﺄ', 'ﺇ', 'ﺈ', 'ﺍ', 'ﺎ', '𞺀', 'ﴼ', 'ﴽ', '𞸀'],
            // collection 3
            ['ٮ', 'ݕ', 'ݖ', 'ﭒ', 'ﭓ', 'ﭔ', 'ﭕ', 'ﺏ', 'ﺐ', 'ﺑ', 'ﺒ', '𞸁', '𞸜', '𞸡', '𞹡', '𞹼', '𞺁', '𞺡'],
            // collection 4
            ['ڀ', 'ݐ', 'ݔ', 'ﭖ', 'ﭗ', 'ﭘ', 'ﭙ', 'ﭚ', 'ﭛ', 'ﭜ', 'ﭝ'],
            // collection 5
            ['ٹ', 'ٺ', 'ٻ', 'ټ', 'ݓ', 'ﭞ', 'ﭟ', 'ﭠ', 'ﭡ', 'ﭢ', 'ﭣ', 'ﭤ', 'ﭥ', 'ﭦ', 'ﭧ', 'ﭨ', 'ﭩ', 'ﺕ', 'ﺖ', 'ﺗ', 'ﺘ', '𞸕', '𞸵', '𞹵', '𞺕', '𞺵'],
            // collection 6
            ['ٽ', 'ٿ', 'ݑ', 'ﺙ', 'ﺚ', 'ﺛ', 'ﺜ', '𞸖', '𞸶', '𞹶', '𞺖', '𞺶'],
            // collection 7
            ['ڃ', 'ڄ', 'ﭲ', 'ﭳ', 'ﭴ', 'ﭵ', 'ﭶ', 'ﭷ', 'ﭸ', 'ﭹ', 'ﺝ', 'ﺞ', 'ﺟ', 'ﺠ', '𞸂', '𞸢', '𞹂', '𞹢', '𞺂', '𞺢'],
            // collection 8
            ['ڇ', 'ڿ', 'ݘ', 'ﭺ', 'ﭻ', 'ﭼ', 'ﭽ', 'ﭾ', 'ﭿ', 'ﮀ', 'ﮁ', '𞸃', '𞺃'],
            // collection 9
            ['ځ', 'ݮ', 'ݯ', 'ݲ', 'ݼ', 'ﺡ', 'ﺢ', 'ﺣ', 'ﺤ', '𞸇', '𞸧', '𞹇', '𞹧', '𞺇', '𞺧'],
            // collection 10
            ['ڂ', 'څ', 'ݗ', 'ﺥ', 'ﺦ', 'ﺧ', 'ﺨ', '𞸗', '𞸷', '𞹗', '𞹷', '𞺗', '𞺷'],
            // collection 11
            ['ڈ', 'ډ', 'ڊ', 'ڌ', 'ڍ', 'ڎ', 'ڏ', 'ڐ', 'ݙ', 'ݚ', 'ﺩ', 'ﺪ', '𞺣', 'ﮂ', 'ﮃ', 'ﮈ', 'ﮉ'],
            // collection 12
            ['ﱛ', 'ﱝ', 'ﺫ', 'ﺬ', '𞸘', '𞺘', '𞺸', 'ﮄ', 'ﮅ', 'ﮆ', 'ﮇ'],
            // collection 13
            ['٫', 'ڑ', 'ڒ', 'ړ', 'ڔ', 'ڕ', 'ږ', 'ݛ', 'ݬ', 'ﮌ', 'ﮍ', 'ﱜ', 'ﺭ', 'ﺮ', '𞸓', '𞺓', '𞺳'],
            // collection 14
            ['ڗ', 'ڙ', 'ݫ', 'ݱ', 'ﺯ', 'ﺰ', '𞸆', '𞺆', '𞺦'],
            // collection 15
            ['ﮊ', 'ﮋ', 'ژ'],
            // collection 16
            ['ښ', 'ݽ', 'ݾ', 'ﺱ', 'ﺲ', 'ﺳ', 'ﺴ', '𞸎', '𞸮', '𞹎', '𞹮', '𞺎', '𞺮'],
            // collection 17
            ['ڛ', 'ۺ', 'ݜ', 'ݭ', 'ݰ', 'ﺵ', 'ﺶ', 'ﺷ', 'ﺸ', '𞸔', '𞸴', '𞹔', '𞹴', '𞺔', '𞺴'],
            // collection 18
            ['ڝ', 'ﺹ', 'ﺺ', 'ﺻ', 'ﺼ', '𞸑', '𞹑', '𞸱', '𞹱', '𞺑', '𞺱'],
            // collection 19
            ['ڞ', 'ۻ', 'ﺽ', 'ﺾ', 'ﺿ', 'ﻀ', '𞸙', '𞸹', '𞹙', '𞹹', '𞺙', '𞺹'],
            // collection 20
            ['ﻁ', 'ﻂ', 'ﻃ', 'ﻄ', '𞸈', '𞹨', '𞺈', '𞺨'],
            // collection 21
            ['ڟ', 'ﻅ', 'ﻆ', 'ﻇ', 'ﻈ', '𞸚', '𞹺', '𞺚', '𞺺'],
            // collection 22
            ['؏', 'ڠ', 'ﻉ', 'ﻊ', 'ﻋ', 'ﻌ', '𞸏', '𞸯', '𞹏', '𞹯', '𞺏', '𞺯'],
            // collection 23
            ['ۼ', 'ݝ', 'ݞ', 'ݟ', 'ﻍ', 'ﻎ', 'ﻏ', 'ﻐ', '𞸛', '𞸻', '𞹛', '𞹻', '𞺛', '𞺻'],
            // collection 24
            ['؋', 'ڡ', 'ڢ', 'ڣ', 'ڤ', 'ڥ', 'ڦ', 'ݠ', 'ݡ', 'ﭪ', 'ﭫ', 'ﭬ', 'ﭭ', 'ﭮ', 'ﭯ', 'ﭰ', 'ﭱ', 'ﻑ', 'ﻒ', 'ﻓ', 'ﻔ', '𞸐', '𞸞', '𞸰', '𞹰', '𞹾', '𞺐', '𞺰'],
            // collection 25
            ['ٯ', 'ڧ', 'ڨ', 'ﻕ', 'ﻖ', 'ﻗ', 'ﻘ', '𞸒', '𞸟', '𞸲', '𞹒', '𞹟', '𞹲', '𞺒', '𞺲', '؈'],
            // collection 26
            ['ػ', 'ؼ', 'ك', 'ڪ', 'ګ', 'ڬ', 'ڭ', 'ڮ', 'ݢ', 'ݣ', 'ݤ', 'ݿ', 'ﮎ', 'ﮏ', 'ﮐ', 'ﮑ', 'ﯓ', 'ﯔ', 'ﯕ', 'ﯖ', 'ﻙ', 'ﻚ', 'ﻛ', 'ﻜ', '𞸊', '𞸪', '𞹪'],
            // collection 27
            ['ڰ', 'ڱ', 'ڲ', 'ڳ', 'ڴ', 'ﮒ', 'ﮓ', 'ﮔ', 'ﮕ', 'ﮖ', 'ﮗ', 'ﮘ', 'ﮙ', 'ﮚ', 'ﮛ', 'ﮜ', 'ﮝ'],
            // collection 28
            ['ڵ', 'ڶ', 'ڷ', 'ڸ', 'ݪ', 'ﻝ', 'ﻞ', 'ﻟ', 'ﻠ', '𞸋', '𞸫', '𞹋', '𞺋', '𞺫'],
            // collection 29
            ['۾', 'ݥ', 'ݦ', 'ﻡ', 'ﻢ', 'ﻣ', 'ﻤ', '𞸌', '𞸬', '𞹬', '𞺌', '𞺬'],
            // collection 30
            ['ڹ', 'ں', 'ڻ', 'ڼ', 'ڽ', 'ݧ', 'ݨ', 'ݩ', 'ﮞ', 'ﮟ', 'ﮠ', 'ﮡ', 'ﻥ', 'ﻦ', 'ﻧ', 'ﻨ', '𞸍', '𞸝', '𞸭', '𞹍', '𞹝', '𞹭', '𞺍', '𞺭'],
            // collection 31
            ['ؤ', 'ٶ', 'ٷ', 'ۄ', 'ۅ', 'ۆ', 'ۇ', 'ۈ', 'ۉ', 'ۊ', 'ۋ', 'ۏ', 'ݸ', 'ݹ', 'ﯗ', 'ﯘ', 'ﯙ', 'ﯚ', 'ﯛ', 'ﯜ', 'ﯝ', 'ﯞ', 'ﯟ', 'ﯠ', 'ﯡ', 'ﯢ', 'ﯣ', 'ﺅ', 'ﺆ', 'ﻭ', 'ﻮ', '𞸅', '𞺅', '𞺥'],
            // collection 32
            ['ة', 'ھ', 'ۀ', 'ە', 'ۿ', 'ﮤ', 'ﮥ', 'ﮦ', 'ﮩ', 'ﮨ', 'ﮪ', 'ﮫ', 'ﮬ', 'ﮭ', 'ﺓ', 'ﺔ', 'ﻩ', 'ﻪ', 'ﻫ', 'ﻬ', '𞸤', '𞹤', '𞺄'],
            // collection 33
            ['ؠ', 'ئ', 'ؽ', 'ؾ', 'ؿ', 'ى', 'ي', 'ٸ', 'ۍ', 'ێ', 'ې', 'ۑ', 'ے', 'ۓ', 'ݵ', 'ݶ', 'ݷ', 'ݺ', 'ݻ', 'ﮢ', 'ﮣ', 'ﮮ', 'ﮯ', 'ﮰ', 'ﮱ', 'ﯤ', 'ﯥ', 'ﯦ', 'ﯧ', 'ﯨ', 'ﯩ', 'ﯼ', 'ﯽ', 'ﯾ', 'ﯿ', 'ﺉ', 'ﺊ', 'ﺋ', 'ﺌ', 'ﻯ', 'ﻰ', 'ﻱ', 'ﻲ', 'ﻳ', 'ﻴ', '𞸉', '𞸩', '𞹉', '𞹩', '𞺉', '𞺩'],
            // collection 34
            ['ٴ', '۽', 'ﺀ'],
            // collection 35
            ['ﻵ', 'ﻶ', 'ﻷ', 'ﻸ', 'ﻹ', 'ﻺ', 'ﻻ', 'ﻼ'],
            // collection 36
            ['ﷲ', '﷼', 'ﷳ', 'ﷴ', 'ﷵ', 'ﷶ', 'ﷷ', 'ﷸ', 'ﷹ', 'ﷺ', 'ﷻ'],
        ];
        $to = [
            // collection 1
            '',
            // collection 2
            'ا',
            // collection 3
            'ب',
            // collection 4
            'پ',
            // collection 5
            'ت',
            // collection 6
            'ث',
            // collection 7
            'ج',
            // collection 8
            'چ',
            // collection 9
            'ح',
            // collection 10
            'خ',
            // collection 11
            'د',
            // collection 12
            'ذ',
            // collection 13
            'ر',
            // collection 14
            'ز',
            // collection 15
            'ژ',
            // collection 16
            'س',
            // collection 17
            'ش',
            // collection 18
            'ص',
            // collection 19
            'ض',
            // collection 20
            'ط',
            // collection 21
            'ظ',
            // collection 22
            'ع',
            // collection 23
            'غ',
            // collection 24
            'ف',
            // collection 25
            'ق',
            // collection 26
            'ک',
            // collection 27
            'گ',
            // collection 28
            'ل',
            // collection 29
            'م',
            // collection 30
            'ن',
            // collection 31
            'و',
            // collection 32
            'ه',
            // collection 33
            'ی',
            // collection 34
            'ء',
            // collection 35
            'لا',
            // collection 36
            ['الله', 'ریال', 'اکبر', 'محمد', 'صلعم', 'رسول', 'علیه', 'وسلم', 'صلی', 'صلی الله علیه وسلم', 'جل جلاله'],
        ];

        // removing HTML and markdown code tags [<code></code>, ```] to bring them back at the end of process
        if ($options['preserve_code']) {
            $code = [];
            $text = preg_replace_callback(
                ['/<\s*code[^>]*>(.|\s)*?<\s*\/code\s*>/', "/(```[a-z]*\s*[\s\S]*?\s*```)/"],
                function ($matched) use (&$code) {
                    array_push($code, $matched[0]);
                    return '__CODE__PRESERVER__';
                },
                $text
            );

        }

        // removing <pre> tags to bring them back at the end of process
        if ($options['preserve_pre']) {
            $pre = [];
            $text = preg_replace_callback(
                '/<\s*pre[^>]*>(.|\s)*?<\s*\/pre\s*>/',
                function ($matched) use (&$pre) {
                    array_push($pre, $matched[0]);
                    return '__PRE__PRESERVER__';
                },
                $text
            );
        }

        // removing HTML tags to bring them back at the end of process
        if ($options['preserve_HTML']) {
            $html = [];
            $text = preg_replace_callback(
                '/(<[^<>]+>)/',
                function ($matched) use (&$html) {
                    array_push($html, $matched[0]);
                    return '__HTML__PRESERVER__';
                },
                $text
            );
        }

        // removing URIs to bring them back at the end of process
        if ($options['preserve_URIs']) {
            $uris = [];
            $pattern = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';
            $text = preg_replace_callback($pattern, function ($matched) use (&$uris) {
                array_push($uris, $matched[0]);
                return '__URI__PRESERVER__';
            }, $text);
        }

        // removing brackets to bring them back at the end of process
        if ($options['preserve_brackets']) {
            $brackets = [];
            $text = preg_replace_callback(
                '/(\[.*?\])/',
                function ($matched) use (&$brackets) {
                    array_push($brackets, $matched[0]);
                    return '__BRACKETS__PRESERVER__';
                },
                $text
            );
        }

        // removing braces to bring them back at the end of process
        if ($options['preserve_braces']) {
            $braces = [];
            $text = preg_replace_callback(
                '/(\{.*?\})/',
                function ($matched) use (&$braces) {
                    array_push($braces, $matched[0]);
                    return '__BRACES__PRESERVER__';
                },
                $text
            );
        }

        for ($i = 0; $i < count($from); $i++) {
            $text = str_replace($from[$i], $to[$i], $text);
        }

        // Windows EOL conversion to Unix format
        if ($options['normalize_eol']) {
            $text = preg_replace('/(\r?\n)|(\r\n?)/', "\n", $text);
        }

        // Converts all HTML characterSets into original characters
        if ($options['decode_htmlentities']) {
            $text = html_entity_decode($text);
        }

        // replace double dash to ndash and triple dash to mdash
        if ($options['fix_dashes']) {
            $text = preg_replace(['/-{3}/', '/-{2}/'], ['—', '–'], $text);
        }

        // replace three dots with ellipsis
        if ($options['fix_three_dots']) {
            $text = preg_replace('/\s*\.{3,}/', '…', $text);
        }

        // replace English quotes pairs with their Persian equivalent
        if ($options['fix_english_quotes_pairs']) {
            $text = preg_replace('/(“)(.+?)(”)/', '«$2»', $text);
        }

        // replace English quotes with their Persian equivalent
        if ($options['fix_english_quotes']) {
            $text = preg_replace('/(["\'`]+)(.+?)(\1)/', '«$2»', $text);
        }

        // should convert ه ی to ه
        if ($options['fix_hamzeh']) {
            $text = preg_replace('/(\S)(ه[\s\x{200C}]+[یي])(\s)/u', '$1هٔ$3', $text);
        }

        // converting Right-to-left marks followed by persian characters to zero-width non-joiners (ZWNJ)
        if ($options['cleanup_rlm']) {
            $text = preg_replace('/([^a-zA-Z\-_])(\x{200F})/u', "$1\u{200c}", $text);
        }

        if ($options['cleanup_zwnj']) {
            // remove more than one ZWNJs
            $text = preg_replace('/\x{200C}{2,}/u', "\u{200c}", $text);
            // clean ZWNJs after characters that don't conncet to the next letter
            $text = preg_replace('/([۰-۹0-9إأةؤورزژاآدذ،؛,:«»\\/@#$٪×*()ـ\-=|])\x{200c}/u', '$1', $text);

            // clean ZWNJs before English characters
            $text = preg_replace('/\x{200c}([\w])/u', '$1', $text);
            $text = preg_replace('/([\w])\x{200c}/u', '$1', $text);

            // clean ZWNJs after and before punctuation
            $text = preg_replace('/\x{200c}([\n\s[].،«»:()؛؟?;$!@-=+\\\\])/u', '$1', $text);
            $text = preg_replace('/([\n\s[.،«»:()؛؟?;$!@\-=+\\\\])\x{200c}/u', '$1', $text);

            // remove unnecessary zwnj char that are succeeded/preceded by a space
            $text = preg_replace('/\s+\x{200C}|\x{200C}\s+/u', ' ', $text);
        }

        // replace persian numbers with arabic numbers
        if ($options['fix_arabic_numbers']) {
            $text = str_replace($numbersArabic, $numbersPersian, $text);
        }

        $text = preg_replace_callback(
            '/(^|\s+)(\S+)(?=($|\s+))/',
            function ($matched) use ($options, $numbersEnglish, $numbersPersian) {
                // should not replace to Persian chars in english phrases
                if (preg_match_all('/[a-zA-Z\-_]{2,}/', $matched[2])) {
                    return $matched[0];
                }

                // should not replace to Persian numbers in html entities
                if (preg_match_all('/&#\d+;/', $matched[2])) {
                    return $matched[0];
                }
                // preserve markdown ordered lists numbers
                if ($options['skip_markdown_ordered_lists_numbers_conversion'] && preg_match('/(?:(?:\r?\n)|(?:\r\n?)|(?:^|\n))\d+\.\s/', $matched[0] . $matched[3])) {
                    return $matched[0];
                }
                if ($options['fix_english_numbers']) {
                    $matched[0] = str_replace($numbersEnglish, $numbersPersian, $matched[0]);
                }
                if ($options['fix_misc_non_persian_chars']) {
                    $matched[0] = str_replace([',', ';', '%'], ['،', '؛', '٪'], $matched[0]);
                }
                if ($options['fix_question_mark']) {
                    $matched[0] = preg_replace('/(\?)/', "\u{061F}", $matched[0]);
                }
                return $matched[0];
            },
            $text
        );

        // put zwnj between word and prefix (mi* nemi*)
        // there's a possible bug here: می and نمی could be separate nouns and not prefix
        if ($options['fix_perfix_spacing']) {
            $text = preg_replace('/((\s+|^)ن?می)\x{0020}/u', "$1\u{200C}", $text);
        }

        // put zwnj between word and suffix (*tar *tarin *ha *haye)
        // there's a possible bug here: های and تر could be separate nouns and not suffix
        if ($options['fix_suffix_spacing']) {
            $text = preg_replace('/\x{0020}(تر(ی(ن)?)?|ها(ی)?\s+)/u', "\u{200C}$1", $text);
        }

        // replace more than one ! or ? mark with just one
        if ($options['cleanup_extra_marks']) {
            $text = preg_replace(['/(!){2,}/', '/(\x{061F}){2,}/u'], ['$1', '$1'], $text);
        }

        // replace kashidas to ndash in parenthetic
        if ($options['kashidas_as_parenthetic']) {
            $text = preg_replace(['/(\s)\x{0640}+/u', '/\x{0640}+(\s)/u'], ['$1–', '–$1'], $text);
        }

        // should remove all kashida between non-whitespace characters
        if ($options['cleanup_kashidas']) {
            $text = preg_replace('/(\S)\x{0640}+(\S)/u', '$1$2', $text);
        }

        if ($options['fix_spacing_for_braces_and_quotes']) {
            $text = preg_replace([
                '/[ \t\x{200C}]*(\()\s*([^)]+?)\s*?(\))[ \t\x{200C}]*/u',
                '/[ \t\x{200C}]*(\[)\s*([^\]]+?)\s*?(\])[ \t\x{200C}]*/u',
                '/[ \t\x{200C}]*(\{)\s*([^}]+?)\s*?(\})[ \t\x{200C}]*/u',
                '/[ \t\x{200C}]*(“)\s*([^”]+?)\s*?(”)[ \t\x{200C}]*/u',
                '/[ \t\x{200C}]*(«)\s*([^»]+?)\s*?(»)[ \t\x{200C}]*/u',
                '/(\()\s*([^)]+?)\s*?(\))/',
                '/(\[)\s*([^\]]+?)\s*?(\])/',
                '/(\{)\s*([^}]+?)\s*?(\})/',
                '/(“)\s*([^”]+?)\s*?(”)/',
                '/(«)\s*([^»]+?)\s*?(»)/',
            ], ' $1$2$3 ', $text);

            $text = preg_replace([
                '/[ \t\x{200C}]*([:;,؛،.؟!]{1})[ \t\x{200C}]*/u',
                '/([۰-۹]+):\s+([۰-۹]+)/',
                '/(\x{061F}|!)\s(\{x061F}|!)/u',
            ], ['$1 ', '$1:$2', '$1$2'], $text);
        }

        // should replace more than one space with just a single one
        if ($options['cleanup_spacing']) {
            $text = preg_replace([
                '/[ ]+/',
                '/([\n]+)[ \t\x{200C}]*/u',
            ], [' ', '$1'], $text);
        }

        // remove spaces, tabs, and new lines from the beginning and enf of file
        // http://stackoverflow.com/a/38490203
        if ($options['cleanup_begin_and_end']) {
            $text = preg_replace('/^[\s\x{200c}]+|[\s\x{200c}]+$/u', '', $text);
        }

        // bringing back braces
        if ($options['preserve_braces']) {
            $text = preg_replace_callback(
                '/__BRACES__PRESERVER__/',
                function () use (&$braces) {
                    return array_shift($braces);
                },
                $text
            );
        }

        // bringing back brackets
        if ($options['preserve_brackets']) {
            $text = preg_replace_callback(
                '/__BRACKETS__PRESERVER__/',
                function () use (&$brackets) {
                    return array_shift($brackets);
                },
                $text
            );
        }

        // bringing back URIs
        if ($options['preserve_URIs']) {
            $text = preg_replace_callback(
                '/__URI__PRESERVER__/',
                function () use (&$uris) {
                    return array_shift($uris);
                },
                $text
            );
        }

        // bringing back HTML tags
        if ($options['preserve_HTML']) {
            $text = preg_replace_callback(
                '/__HTML__PRESERVER__/',
                function () use (&$html) {
                    return array_shift($html);
                },
                $text
            );
        }

        // bringing back Code tags
        if ($options['preserve_code']) {
            $text = preg_replace_callback(
                '/__CODE__PRESERVER__/',
                function () use (&$code) {
                    return array_shift($code);
                },
                $text
            );
        }

        // bringing back pre tags
        if ($options['preserve_pre']) {
            $text = preg_replace_callback(
                '/__PRE__PRESERVER__/',
                function () use (&$pre) {
                    return array_shift($pre);
                },
                $text
            );
        }
        return $text;
    }
}
