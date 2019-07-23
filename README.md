# PHP Random image generator

[![Build Status](https://travis-ci.com/survivorbat/php-random-image-generator.svg?branch=master)](https://travis-ci.com/survivorbat/php-random-image-generator)

![Example image](docs/example.png "Example image")

This project came to be after a random thought popped into my head about what would happen
if you were to generate a random picture from code with random colors. This is a severely
over-engineered 7-line script that I made out of boredom and my desire to try out php
7.4 and some image creation from code.

## Prerequisites

In order to run this application in an isolated environment and to make installing it
easier, all you need is Docker. It's also advisable to have Make installed to
make use of the makefile.

## Getting started

### Docker image

Using the application is as easy as:
1. Run `docker run --rm -u php -v $(pwd):/app/out survivorbat/random-image-generator:v0.1 bin/console img:create:random`

Afterwards you should find a random image in your working directory.
Alternatively you can open the shell by using:

`docker run --entrypoint=/bin/sh --rm -it -u php -v $(pwd):/app/out survivorbat/random-image-generator:v0.1`

### Download source

Setting up the application is as easy as:
1. `git clone` the application
2. Run `make install` to install dependencies
3. Run `make run cmd="img:create:random"` to create an image

It might be easier to use the command line of the php container to execute,
in order to get this working use `make shell`, this will bring you to the
shell of a running php environment and allows you to use commands in the form
of: `bin/console list`.

## Plans for the future

- ~~Add image dimensions to CLI~~
- ~~Add more image output types~~
- ~~Perhaps add symfony/console for easier command line management~~
- ~~Create a docker image of the application itself~~
- Add extra parameters to allow user to influence the end result of the image (make a more red, green or blue image result)
- Add xdebug for generating coverage reports
- Add more tests
- Add a phpunit xml file with testsuites
- Add jpeg and webp output types
- Add more generators
- Add more output formatting
- Make sure php-cs-fixer works with 7.4

## Known quirks

- Php-cs-fixer is not supported for 7.4 yet
