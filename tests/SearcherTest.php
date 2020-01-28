<?php

namespace App\Prkt\Tests;

use \PHPUnit\Framework\TestCase;
use \App\Prkt\Searcher;
use \App\Prkt\exceptions\MaxSizeException;

class SearcherTest extends TestCase
{
    public function testGetOccurrence()
    {
        $file = __DIR__ . '/text.txt';
        $config = '../src/config.yaml';
        $string = 'things';
        $result = 'Row: 1, position: 32';

        $searcher = new Searcher($file, $config);

        $this->assertEquals($result, $searcher->getOccurrence($string));

        $searcher2 = new Searcher($file, $config);
        $string = '123123123';
        $this->assertEquals('Occurrences not found', $searcher2->getOccurrence($string));
    }

    public function testExceptionGetOccurrence()
    {
        $file = __DIR__ . '/text.txt';
        $config = '../src/configWithLowSize.yaml';
        $string = 'things';

        $searcher = new Searcher($file, $config);
        $this->expectException(MaxSizeException::class);
        $searcher->getOccurrence($string);
    }
}
