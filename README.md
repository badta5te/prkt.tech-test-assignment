## About

### Install

`$ composer require pavelmikhaylov/prkt.tech-test-assignment`

### Usage

For installation: `make install`;

For tests: `make test`;

For linter check: `make lint`.

`$searcher = new Searcher($filePath, $config);`

В файле конфигурации есть возможность задать максимальный размер файла, mime-type файла.

`$searcher->getOccurrence($string); // поиск вхождения строки в файл;`
