import {Fragment, useEffect} from 'react';
import usePhpSsrStore, {PhpSsrStore} from '../usePhpSsrStore';
import PhpSsrComponent from './PhpSsrComponent';

const PhpSsrProvider = ({resolver} : {resolver: PhpSsrStore['componentResolver']}) => {
  const setResolver = usePhpSsrStore(state => state.setComponentResolver);
  const components = usePhpSsrStore(state => state.tree.root);

  useEffect(() => {
    setResolver(resolver);
  }, [resolver]);

  return (
    <Fragment>
      {components.map((component, index) => (
        <PhpSsrComponent key={index} {...component} />
      ))}
    </Fragment>
  )
};

export default PhpSsrProvider;
