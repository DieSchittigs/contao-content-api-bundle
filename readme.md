# Contao Content API

We at [Die Schittigs](http://www.dieschittigs.de) love
[Contao](https://contao.org/de/), but the web moves
forward and static HTML templating just doesn't cut it anymore. Thus we came up
with an easily digestible JSON-API to access Contao content via JavaScript
(or anything else that can handle JSON).

With the Contao Content API it is possible to write the entire Frontend of your
website in [React.js](https://facebook.github.io/react/), [Angular](https://angular.io/), [vue](https://vuejs.org/), or any other
JS-framework. All while still using the great Contao Backend.

Now that Contao 4 matures, we decided to Open Source our efforts. Mainly to get
feedback and maybe even contribution from the community.

## Requirements

You'll need an up-and-running **Contao 4.3.x** installation.
Please note that the API is **not compatible with Contao 3.x**.

## Installation

Install [composer](https://getcomposer.org) if you haven't already,
enter this command in the main directory of your Contao installation:

    composer require dieschittigs/contao-content-api

Contao Content API is now installed. Next, put a file called `api.php` into your
`/web` folder. Paste the following contents into it:

    <?php

    use DieSchittigs\ContaoContentApi\FrontendApi;
    use Symfony\Component\HttpFoundation\Request;

    $loader = require __DIR__.'/../vendor/autoload.php';

    $api = new FrontendApi($loader);

    $request = Request::createFromGlobals();
    $response = $api->handle($request);
    $response->send();

Alternatively copy the file `api.php` from
`vendor/dieschittigs/contao-content-api/` into your `/web` folder.

## Usage

Once setup, the following routes are available:

##### /api.php/sitemap

Gets the sitemap (=all pages below root) for the given language.

##### /api.php/page?url=/about/team.html

Gets the page, including all articles and contents at this URL.

##### /api.php/news?url=/news/new-website.html

Gets the news reader content from the URL

##### /api.php/?url=/page/or/newsarticle.html

Tries to get the page at this URL, or content from a reader

##### /api.php/user

Gets the logged-in frontend user, if available.

All routes also take the additional `lang` parameter (e.g. `?lang=de`). If you
have a multilingual website.

## Custom readers

Contao has the concept of Reader Module (e.g. News Reader). These can be
inserted anywhere inside of an article where they read the URL to display
their contents. If you want to add additional Reader Modules, you can do
so by adding them in your `api.php`.

    ...
    $api = new FrontendApi($loader);
    $api->addReader('blog', 'BlogModel');
    ...

Please note that the second parameter is the **model** class, **not the module**
class. The new reader is now available at

##### /api.php/blog?url=/blog/detail/on-the-topic.html

or, even more convenient, at

##### /api.php?url=/blog/detail/on-the-topic.html

Internally the API tries to instantiate the model with the alias found in the url.
It also tries to add all `ContentModels` it can find.

## Tips and tricks

If you are using a router in JavaScript (e.g. react-router) you may want to redirect
all frontend traffic to a single file. We found the easiest way to do so is to
create a new `app.html` in the `/web` folder and change the redirect in `.htaccess`
like so:

    ...
    RewriteRule ^contao %{ENV:BASE}/app.php [L]
    RewriteRule ^ %{ENV:BASE}/app.html [L]
    ...

This way all the traffic goes to your JS App, while `/contao` still works.

## Contribution

Bug reports and pull requests are very welcome :)
