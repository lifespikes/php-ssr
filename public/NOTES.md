# Notes

Use static analysis to determine component type definitions! Then we can
use this as both TS and PHPStan generics.

_Use this? https://github.com/Microsoft/TypeScript/wiki/Standalone-Server-%28tsserver%29_

```ts
setTimeout(() => {
  const state = usePhpSsrStore.getState();
  state.setTree({
    root: [
      {
        id: '1',
        name: 'Page',  /* < --- Get module name from this */
        props: { /* Now we can validate everything in here! */
          title: 'Hello World'
        }
      }
    ]
  });
}, 1000);
```

PHPStan stub example:

```php
namespace Components;

class Page
{
    public string $title;
}
```
