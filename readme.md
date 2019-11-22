# Contao Content API

We at [Die Schittigs](http://www.dieschittigs.de) love
[Contao](https://contao.org/de/), but the web moves
forward and static HTML templating just doesn't cut it anymore. Thus we came up
with an easily digestible JSON-API to access Contao content via JavaScript
(or anything else that can handle JSON).

With the Contao Content API it is possible to write the entire Frontend of your
website in [React.js](https://facebook.github.io/react/), [Angular](https://angular.io/), [vue](https://vuejs.org/), or any other
JS-framework. All while still using the great Contao Backend.

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

Gets the sitemap including the root pages.

[Example](examples/sitemap.json)

##### /api/sitemap/flat

Gets all pages as key value pairings where the key is the URL.

[Example](examples/sitemap_flat.json)

##### /api/urls[?file=sitemap]

Gets all URLs from the generated sitemap XML(s). If you define a `file`, only that XML will be parsed.

[Example](examples/urls.json)

##### /api/page?url=/about/team.html

Gets the page, including all articles and contents at the `url`.

[Example](examples/page.json)

##### /api/newsreader?url=/news/detail/new-website.html

Gets the news reader content from the `url`

[Example](examples/newsreader.json)

##### /api/?url=/page/or/newsarticle.html

Tries to get the page at the `url`, and contents from any reader

[Example](examples/page_newsreader.json)

##### /api/user

Gets the logged-in frontend user, if available.

[Example](examples/user.json)

##### /api/module?id=5

Gets the content of a module by id

[Example](examples/module.json)

##### /api/text?file=tl_news,modules

Gets the content of a language file by filename(s)

[Example](examples/text.json)

##### /api/file?path=files/uploads&depth=2

Gets the file or directory at `path` and also it's children, limited by `depth`

[Example](examples/file.json)

All routes also take the additional `lang` parameter (e.g. `?lang=de`). If you
need to override the language.

## Configuration

### Disabling the API

Edit your `parameters.yml`.

    parameters:
    …
    content_api_enabled:
        false
    …

The API routes are now all disabled. This may be helpful if you only
want to use the classes included in the bundle.

### Response headers

Edit your `parameters.yml`.

    parameters:
    …
    content_api_headers:
        'Access-Control-Allow-Origin': 'https://mysite.org'
    …

These headers will be added to all responses from the API.

### Custom readers

Contao has the concept of Reader Module (e.g. News Reader). These can be
inserted anywhere inside of an article where they read the URL to display
their contents. If you want to add additional Reader Modules, you can do
so by adding them in your `parameters.yml`.

    parameters:
    …
        content_api_readers:
            newsreader: NewsModel
            blogreader: BlogModel
    …

Please note that the second parameter is the **model** class, **not the module**
class. The new reader is now available at

##### /api/blogreader?url=/blog/detail/on-the-topic.html

or, if you want to include the whole page, at

##### /api?url=/blog/detail/on-the-topic.html

Internally the API tries to instantiate the model with the alias found in the url.
It also tries to add all `ContentModels` it can find.

## Hooks

We provide some basic hooks:

```
class Hooks{

    // $GLOBALS['TL_HOOKS']['apiBeforeInit']
    public static apiBeforeInit(Request $request){
        return $request
    }

    // $GLOBALS['TL_HOOKS']['apiAfterInit']
    public static apiAfterInit(Request $request){
        return $request
    }

    // $GLOBALS['TL_HOOKS']['apiContaoJson']
    public static apiContaoJson(ContaoJson $contaoJson, mixed $data){
        if($data instanceof ContentModel){
            $contaoJson->data = null;
            // End of the line
            return false;
        }
        // Do your thing, ContaoJson
        return true;

    }

    // $GLOBALS['TL_HOOKS']['apiResponse']
    public static apiResponse(mixed $data){
        $data->tamperedWith = true;
        return $data;

    }

    // $GLOBALS['TL_HOOKS']['apiModuleGenerated']
    public static function apiModuleGenerated(ApiModule $module, string $moduleClass)
    {
        // Override the way certain modules are handled
        if ($moduleClass != 'Contao\ModuleBlogList') {
            return;
        }
        $_module = new ModuleBlogList($module->model, null);
        $module->items = $_module->fetchItems(
            $module->category
        );
    }
}
```

## Documentation

The classes crafted for the API might be a good starting point if you want
to build anything on top of Contao.

[Check out the docs here](docs/ApiIndex.md)

## Contribution

Bug reports and pull requests are very welcome :)

---

© Die Schittigs GmbH 2019
