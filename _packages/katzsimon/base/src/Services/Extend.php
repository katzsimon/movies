<?php


namespace Katzsimon\Base\Services;


use Illuminate\Support\Facades\Storage;

class Extend
{

    /**
     * Extend a Package Controller into the base app
     * @param string $source
     * @return bool
     */
    public static function controller($source='', $options=[]) {
        if (empty($source)) return false;

        $root = $options['root'] ?? false;
        $force = $options['force'] ?? false;
        $debug = $options['debug'] ?? false;
        $source = file_get_contents("{$source}");
        $template = "<?php namespace App\Http\Controllers\[AUTHOR]\[PACKAGE];

class [SOURCECLASS] extends \[SOURCENAMESPACE]\[SOURCECLASS]
{

}
";

        $destinationNamespace = $options['namespace'] ?? '';
        $sourceNamespace = self::extract($source, 'namespace ', ';');
        $packageName = self::extract($sourceNamespace, '\\', '\\');
        $sourceClass = self::extract($source, 'class ', ' ');
        $author = self::extract($sourceNamespace, '', '\\');

        if (!empty($root)) $template = str_replace('\[AUTHOR]\[PACKAGE]', '', $template);
        $template = str_replace('[AUTHOR]', $author, $template);
        $template = str_replace('[SOURCECLASS]', $sourceClass, $template);
        $template = str_replace('[SOURCENAMESPACE]', $sourceNamespace, $template);
        $template = str_replace('[PACKAGE]', $packageName, $template);

        $destinationPath = $root ? "app/Http/Controllers/" :  "app/Http/Controllers/{$author}/{$packageName}/";
        $destination = "{$destinationPath}{$sourceClass}.php";

        if (!Storage::disk('base')->exists($destination) || $force) Storage::disk('base')->put($destination, $template);

        return true;

    }


    /**
     * Extend a Package Request class into the base app
     *
     * @param string $source
     * @return bool
     */
    public static function request($source='') {
        if (empty($source)) return false;

        $source = file_get_contents("{$source}");
        $template = "<?php namespace App\Http\Requests;

class [SOURCECLASS] extends \[SOURCENAMESPACE]\[SOURCECLASS]
{

}
";

        $sourceNamespace = self::extract($source, 'namespace ', ';');
        $sourceClass = self::extract($source, 'class ', ' ');

        $template = str_replace('[SOURCECLASS]', $sourceClass, $template);
        $template = str_replace('[SOURCENAMESPACE]', $sourceNamespace, $template);


        $destination = "app/Http/Requests/{$sourceClass}.php";
        if (!Storage::disk('base')->exists($destination)) Storage::disk('base')->put($destination, $template);

        return true;

    }


    /**
     * Extend a Package Model into the base app
     *
     * @param string $source
     * @return bool
     */
    public static function model($source='', $options=[]) {
        if (empty($source)) return false;

        $force = $options['force'] ?? false;

        $source = file_get_contents("{$source}");
        //Storage::disk('base')->get($source);
        $template = "<?php namespace App\Models;

class [SOURCECLASS] extends \[SOURCENAMESPACE]\[SOURCECLASS]
{

}
";

        $sourceNamespace = self::extract($source, 'namespace ', ';');
        $sourceClass = self::extract($source, 'class ', ' ');

        $template = str_replace('[SOURCECLASS]', $sourceClass, $template);
        $template = str_replace('[SOURCENAMESPACE]', $sourceNamespace, $template);

        $destination = "app/Models/{$sourceClass}.php";
        if (!Storage::disk('base')->exists($destination) || $force) Storage::disk('base')->put($destination, $template);

        return true;

    }


    /**
     * Extract a substring, between a start and end string
     * Example: extract($txt="one two three", $startString="one ", $endString=" three") = "two"
     *
     * @param string $txt
     * @param string|null $startString
     * @param string|null $endString
     * @return false|string
     */
    public static function extract($txt='', $startString=null, $endString=null) {
        if ($startString!==null && $endString!==null) {
            $p1 = $startString==='' ? 0 : strpos($txt, $startString);
            $p2 = $p1+strlen($startString);
            $p3 = strpos($txt, $endString, $p2);

            if (!($p1===false || $p3===false)) {
                return substr($txt, $p2, $p3-$p2);
            }

        }
        return '';
    }
}
