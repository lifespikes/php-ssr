# PHP-SSR
A proof-of-concept library for bridging the gap between PHP and JavaScript. Mainly, the objective of this library is to provide server-side rendering capabilities with an additional layer of interoperability between PHP and JavaScript.

Some of the features we want to achieve are:

- [ ] Server-side rendering of React components
- [ ] Support for different JS development environments
- [ ] PHPStan and TypeScript stub generation
- [ ] 1-to-1 translation of JS and PHP ASTs
- [ ] Event listeners written in PHP, executed in JS

The list is not exhaustive, and we are open to suggestions.

## Installation
First things first, you will need to have the `php-v8js` extension installed. For your convenience, we've added a small shell script that will build the extension for you _(Only for OS X)_. You can run it by executing the following command:

```bash
$ ./build/mac-php-v8.sh
```

After that, you should be able to just enable the extension in your `php.ini` file.

```ini
extension=v8js.so
```

Now you can just clone the repository and install your dependencies as you usually would. This library is again, designed to **bridge the gap**, that includes its own dependency management. You can use our command line to install and prepare your SSR app for both PHP and JS:

```bash
$ php bin/ssr dependencies
```

For now, we only support `yarn`, but you can feel free to add new drivers as you see fit.

## Usage
This library is meant to be designed to be simple at its core, but powerful in implementation. This usage does **not** reflect the current state of the project, but rather, what we want it to be.

### Rendering a page
We expect the library to be used alongside existing frameworks like **Laravel**, **Symfony**, **Phalcon**, and so on. Mainly, we expect it to be used alongside a router, so we can render a page based on a route.

```php
namespace App\Http\Controllers;

use LifeSpikes\SSR\Application as SSR;

class AuthController
{
    public function login()
    {
        return SSR::render('Auth/Login', [
            'prop' => 'value',
        ]);
    }
}
```

> **Note:** For the sake of simplicity, all examples should be read in the context of the previous example, unless otherwise specified.

### Working with components
Another goal is being able to provide a higher degree of control over the state of the UI from the server. This means being able to render and control components using PHP.

```php
# Assume we're still in AuthController@login

$page = SSR::render('Auth/Login', [
    'children' => [
        $form = SSR::component('Auth/LoginForm', [
            'message' => 'Please authenticate yourself',
        ]),
    ],
]);

return $page;
```

While the use case for this doesn't make sense **quite yet**, since scripts run synchronously, the idea is to provide an API that reflects server changes in the client.

```php
# Assume we're still in AuthController@login

$form->setProps([
    'message' => 'Hello, this is a new message',
]);

return $page;
```

### Working with events
Going off our previous examples, the ability to set props will come in handy mostly when doing event handling, which we also want to make possible from the server.

This is probably the most complex but useful feature of what we want this project to be.

For us, one of the biggest use cases would be form submissions, so we'll use that as an example.

```php
# Assume we're still in AuthController@login

$form->setProps([
    'onSubmit' => function (FormEvent $event) {
        $event->preventDefault();
        $form = SSRForm::fromEvent($event);
        
        $form->setProps([
            'message' => 'Please wait...',
        ]);
        
        if (AuthHelper::tryLogin($form->getValues())) {
            $form->setProps([
                'message' => 'Success!',
            ]);
        } else {
            $form->setProps([
                'message' => 'Invalid credentials',
            ]);
        }
    }
]);
```

Any component **messages** are sent on an as-invoked basis, so if you expect a given operation to take a bit you can send instructions to display a loading message or something similar. In most instances you'll be using PHP synchronously, so there's not a need to account for a message being sent before a previous operation has finished.

Naturally this type of closure-based event handling can get ugly really fast, so you can also pass methods or classes that will receive the same arguments as the closure.

```php
# Assume we're still in AuthController@login

$form->setProps([
    'onSubmit' => 'attemptLogin'
    # Or
    'onSubmit' => [AuthHelper::class, 'attemptLogin']
    # Or even just this if the event name matches the method
    'onSubmit' => AuthHelper::class
]);
```

### Re-using components
I know it sounds redundant, but we want to be able to re-use not just **components**, but **usages** of components. An example of this could be something like an **Alert** component that can be used in multiple places but is roughly used the same way.

```php
# This would be a separate file

class Alert extends SSRComponent
{
    protected string $component = 'Utils/Alert';

    public function __construct(
        public AlertType $type, /* Enums must be string-backed */
        public string $message,
        public bool $collapsed = false
    ) {
        $this->setProps([
            'onCollapse' => function () {
                $this->setProps(['collapsed' => true]);
            } 
        ]);
    }
    
    public function setMessage(string $message)
    {
        /*
         * SSR helps us use server-side data without having
         * to maintain a separate state, or having to
         * manually execute and handle XHR requests
         */
         
        $user = AuthHelper::user();
        $this->setProps(['message' => "Alert for $user->name: $message"]);
    }
}
```

You could then use this for example:

```php
# Assume we're still in AuthController@login

$page->setProps([
    /* This is how we re-use a handler on PHP-SSR */
    'children' => [new Alert('This is an alert!'), $form] 
]);
```

### Working with state
