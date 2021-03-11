<?php


namespace Katzsimon\Base\Services;


use Illuminate\Support\Facades\Storage;

class Publish
{

    /**
     * Publish a Test into the base app
     *
     * @param string $source
     * @param array $options
     * @return bool
     */
    public static function test($source='', $options=[]) {
        if (empty($source)) return false;

        $sourceFile = file_get_contents("{$source}");

        $posTest = strpos($source, "/tests/");
        $destination = substr($source, $posTest+1);

        if (!Storage::disk('base')->exists($destination)) Storage::disk('base')->put($destination, $sourceFile);

        return true;


    }



    /**
     * Publish a View into the base app
     *
     * @param string $source
     * @param array $options
     * @return bool
     */
    public static function view($source='', $options=[]) {
        if (empty($source)) return false;

        $sourceFile = file_get_contents("{$source}");

        $posTest = strpos($source, "/views/");
        $destination = substr($source, $posTest+7);
        $destination = 'resources/views/vendor/katzsimon/'.$destination;

        if (!Storage::disk('base')->exists($destination)) Storage::disk('base')->put($destination, $sourceFile);

        return true;
    }


    /**
     * Publish a Resource into the base app
     *
     * @param string $source
     * @param array $options
     * @return bool
     */
    public static function resource($source='', $options=[]) {
        if (empty($source)) return false;

        $sourceFile = file_get_contents("{$source}");

        $posTest = strpos($source, "/resources/");
        $destination = substr($source, $posTest);

        if (!Storage::disk('base')->exists($destination)) Storage::disk('base')->put($destination, $sourceFile);

        return true;
    }


}
