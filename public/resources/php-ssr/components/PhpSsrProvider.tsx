import React from 'react';
import usePhpSsrStore, {PhpSsrStore} from '../usePhpSsrStore';
import ManagedComponent from './ManagedComponent';

const PhpSsrProvider = ({resolver} : {resolver: PhpSsrStore['componentResolver']}) => {
  const components = usePhpSsrStore(state => state.tree.root);

  return (
    <>
      {components.map((component, index) => (
        <ManagedComponent key={index} {...{component, resolver}} />
      ))}
    </>
  );
};

export default PhpSsrProvider;
