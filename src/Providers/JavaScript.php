<?php

namespace Oriceon\Minify\Providers;

use Oriceon\Minify\Contracts\MinifyInterface;
use Oriceon\Minify\Exceptions\CannotSaveFileException;
use JShrink\Minifier;

class JavaScript extends BaseProvider implements MinifyInterface
{
    /**
    *  The extension of the outputted file.
    */
    const EXTENSION = '.js';

    /**
     * @return string
     * @throws CannotSaveFileException
     * @throws \Exception
     */
    public function minify()
    {
        $minified = Minifier::minify($this->appended);

        return $this->put($minified);
    }

    /**
    * @param $file
    * @param array $attributes
    * @return string
    */
    public function tag($file, array $attributes)
    {
        $attributes = ['src' => $file] + $attributes;

        return '<script ' . $this->attributes($attributes) . '></script>' . PHP_EOL;
    }
}
