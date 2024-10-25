<?php

namespace YoastSEO_Vendor\GuzzleHttp\Psr7;

/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream implements \YoastSEO_Vendor\Psr\Http\Message\StreamInterface
{
    use StreamDecoratorTrait;

    public function seek($offset, $whence = \SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }

    public function isSeekable()
    {
        return \false;
    }
}
