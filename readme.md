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

You'll need an up-and-running **Contao 4.4.x** installation.
Please note that the API is **not compatible with Contao 3.x**.

## Installation

Install [composer](https://getcomposer.org) if you haven't already,
enter this command in the main directory of your Contao installation:

    composer require dieschittigs/contao-content-api

Contao Content API is now installed and ready to use.

## Usage

Once installed, the following routes are available:

##### /api/sitemap

Gets the sitemap (=all pages below root).

##### /api/page?url=/about/team.html

Gets the page, including all articles and contents at the `url`.

##### /api/news?url=/news/new-website.html

Gets the news reader content from the `url`

##### /api/?url=/page/or/newsarticle.html

Tries to get the page at the `url`, and contents from any reader

##### /api/user

Gets the logged-in frontend user, if available.

##### /api/module?id=5

Gets the content of a module by id

##### /api/text?file=tl_news,modules

Gets the content of a language file by filename(s)

##### /api/file?path=files/uploads&depth=2

Gets the file or directory at `path` and also it's children, limited by `depth`

All routes also take the additional `lang` parameter (e.g. `?lang=de`). If you
need to override the language.

## Custom readers

Contao has the concept of Reader Module (e.g. News Reader). These can be
inserted anywhere inside of an article where they read the URL to display
their contents. If you want to add additional Reader Modules, you can do
so by adding them in your `parameters.yml`.

    parameters:
    ...
        content_api_readers:
            news: NewsModel
            blog: BlogModel
    ...

Please note that the second parameter is the **model** class, **not the module**
class. The new reader is now available at

##### /api/blog?url=/blog/detail/on-the-topic.html

or, if you want to include the articles, at

##### /api?url=/blog/detail/on-the-topic.html

Internally the API tries to instantiate the model with the alias found in the url.
It also tries to add all `ContentModels` it can find.

## Tips and tricks

If you are using a router in JavaScript (e.g. react-router) you may want to redirect
all frontend traffic to a single file. We found the easiest way to do so is to
create a new `app.html` in the `/web` folder and change the redirect in `.htaccess`
like so:

    ...
    RewriteRule ^contao %{ENV:BASE}/app.php [L]
    RewriteRule ^api %{ENV:BASE}/app.php [L]
    RewriteRule ^ %{ENV:BASE}/app.html [L]
    ...

This way all the traffic goes to your JS App, while `/contao` and `/api` still work.

## Contribution

Bug reports and pull requests are very welcome :)
