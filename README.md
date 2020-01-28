## About

### Install

`$ composer require pavelmikhaylov/prkt.tech-test-assignment`

### Usage

`$searcher = new Searcher($filePath, $config);`

В файле конфигурации есть возможность задать максимальный размер файла, mime-type файла (+ в процессе реализации возможность задать поиск с учетом регистра или без).

`$searcher->getOccurrence($string); // поиск вхождения строки в файл;`
