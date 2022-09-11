import { createRoot } from 'react-dom/client';
import PhpSsrProvider from './php-ssr/components/PhpSsrProvider';
import usePhpSsrStore from './php-ssr/usePhpSsrStore';
// @ts-ignore
import * as allComponents from './components/*.tsx';

const resolver = (module) => {
  return allComponents[module].default;
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
        props: {}
      }
    ]
  });
}, 1000);
