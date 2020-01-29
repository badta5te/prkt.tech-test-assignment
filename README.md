[![Build Status](https://travis-ci.com/badta5te/prkt.tech-test-assignment.svg?branch=master)](https://travis-ci.com/badta5te/prkt.tech-test-assignment)
[![Maintainability](https://api.codeclimate.com/v1/badges/5a41768b769963817ca8/maintainability)](https://codeclimate.com/github/badta5te/prkt.tech-test-assignment/maintainability)

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
