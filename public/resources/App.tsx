import { createRoot } from 'react-dom/client';
import PhpSsrProvider from './php-ssr/components/PhpSsrProvider';
import usePhpSsrStore from './php-ssr/usePhpSsrStore';

const resolver = async (module) => {
  return await import(`./${module}`);
};

createRoot(document.getElementById('app'))
  .render(<PhpSsrProvider {...{resolver}} />);

/* Execute 10 seconds after the page has loaded */

setTimeout(() => {
  const state = usePhpSsrStore.getState();
  state.setTree({
    root: [
      {
        id: '1',
        name: 'Page',
        props: {
          title: 'Hello World'
        }
      }
    ]
  });
}, 10000);
