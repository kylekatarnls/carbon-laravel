# Carbon - Laravel compatibility checking

This project run a daily check on Travis to ensure Carbon is compatible with last minor Laravel version of each
major one according to Laravel versionning (paradigm.major.minor).
 
[![Build Status](https://travis-ci.org/kylekatarnls/carbon-laravel.svg?branch=master)](https://travis-ci.org/kylekatarnls/carbon-laravel)

## Carbon 1 (dev-version-1.next)

|PHP|Laravel|
|---|-------|
|5.4|5.0|
|5.5|5.0 ➡ 5.2|
|5.6|5.0 ➡ 5.4|
|7.0|5.0 ➡ 5.5|
|7.1|5.0 ➡ 5.8|
|7.2|5.0 ➡ 5.8|
|7.3|5.0 ➡ 5.8|

## Carbon 2 (dev-master)

|PHP|Laravel|
|---|-------|
|7.1|5.6 ➡ 5.8|
|7.2|5.6 ➡ 5.9|
|7.3|5.6 ➡ 5.9|

## Tested features

- JSON: ensure there is no conflict with le Laravel JSON layer
- Serialization: ensure there is no conflict with le Laravel serialization layer
- Macros: ensure there is no conflict with le Laravel macros layer
- Auto-update: service dedicated to Laravel locale synchronization
