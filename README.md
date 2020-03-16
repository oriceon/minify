# Minify

[![Build Status](https://travis-ci.org/oriceon/minify.svg)](https://travis-ci.org/oriceon/minify)
[![Latest Stable Version](https://poser.pugx.org/oriceon/minify/v/stable.svg)](https://packagist.org/packages/oriceon/minify)
[![Total Downloads](https://poser.pugx.org/oriceon/minify/downloads.svg)](https://packagist.org/packages/oriceon/minify)
[![License](https://poser.pugx.org/oriceon/minify/license.svg)](https://packagist.org/packages/oriceon/minify)

With this package you can minify your existing stylessheet and javascript files for laravel 6+. This process can be a little tough, this package simplies this process and automates it.

## Installation

Begin by installing this package through Composer.

```composer require oriceon/minify```


Publish the config file:

```php artisan vendor:publish --provider="Oriceon\Minify\MinifyServiceProvider" --force```


Package will auto-discover and you can use this Facade anywhere in your application

#### Stylesheet

```php
	// app/views/hello.blade.php

	<html>
		<head>
			...
			{!! Minify::stylesheet('/css/main.css') !!}

			// or by passing multiple files
			{!! Minify::stylesheet(array('/css/main.css', '/css/bootstrap.css')) !!}

			// add custom attributes
			{!! Minify::stylesheet(array('/css/main.css', '/css/bootstrap.css'), array('foo' => 'bar')) !!}

			// add full uri of the resource
			{!! Minify::stylesheet(array('/css/main.css', '/css/bootstrap.css'))->withFullUrl() !!}
		    {!! Minify::stylesheet(array('//fonts.googleapis.com/css?family=Roboto')) !!}

			// minify and combine all stylesheet files in given folder
			{!! Minify::stylesheetDir('/css/') !!}

			// add custom attributes to minify and combine all stylesheet files in given folder
			{!! Minify::stylesheetDir('/css/', array('foo' => 'bar', 'defer' => true)) !!}

			// minify and combine all stylesheet files in given folder with full uri
			{!! Minify::stylesheetDir('/css/')->withFullUrl() !!}
		</head>
		...
	</html>

```

#### Javascript

```php
	// app/views/hello.blade.php

	<html>
		<body>
		...
		</body>
		{!! Minify::javascript('/js/jquery.js') !!}

		// or by passing multiple files
		{!! Minify::javascript(array('/js/jquery.js', '/js/jquery-ui.js')) !!}

		// add custom attributes
		{!! Minify::javascript(array('/js/jquery.js', '/js/jquery-ui.js'), array('bar' => 'baz')) !!}

		// add full uri of the resource
		{!! Minify::javascript(array('/js/jquery.js', '/js/jquery-ui.js'))->withFullUrl() !!}
        {!! Minify::javascript(array('//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js')) !!}

		// minify and combine all javascript files in given folder
		{!! Minify::javascriptDir('/js/') !!}

		// add custom attributes to minify and combine all javascript files in given folder
		{!! Minify::javascriptDir('/js/', array('bar' => 'baz', 'async' => true)) !!}

		// minify and combine all javascript files in given folder with full uri
		{!! Minify::javascriptDir('/js/')->withFullUrl() !!}
	</html>

```


# Credits to main author

Fwork package : [DevFactoryCH/minify](https://github.com/DevFactoryCH/minify)
