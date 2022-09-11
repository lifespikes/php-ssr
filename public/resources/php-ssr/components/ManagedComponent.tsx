import {SsrComponent} from '../types/tree';
import {PhpSsrStore} from '../usePhpSsrStore';
import React, {Fragment} from 'react';

type ManagedComponentProps = {
  component: SsrComponent,
  resolver: PhpSsrStore['componentResolver']
};

const ManagedComponent = ({ component, resolver }: ManagedComponentProps) => {
  const componentModule = resolver(component.name);
  const element = React.createElement(componentModule, component.props);

  return (
    <Fragment key={component.id}>
      {element}
    </Fragment>
  );
};

export default ManagedComponent;
