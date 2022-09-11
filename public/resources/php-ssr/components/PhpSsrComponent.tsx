import {SsrComponent} from '../types/tree';
import React, {Fragment, useState} from 'react';
import usePhpSsrStore from '../usePhpSsrStore';

const PhpSsrComponent = React.memo<SsrComponent>((_props: SsrComponent) => {
  const [module, setModule] = useState(null);
  const {children, ...props} = _props.props;
  const resolver = usePhpSsrStore(state => state.componentResolver);

  (async () => {
    const component = await resolver(_props.name);
    setModule(component);
  })();

  const DynamicModule = module;

  return module && (
    <Fragment>
      <DynamicModule {...props}>
        {children.map((component, index) => (
          <PhpSsrComponent key={index} {...component} />
        ))}
      </DynamicModule>
    </Fragment>
  );
}, (prevProps, nextProps) => {
  /**
   * Children are not compared because the actual element they render into
   * is not directly dictated by its parent.
   */

  const cleanProps = (props: SsrComponent) => {
    const {children, ...cleanedProps} = props.props;
    return cleanedProps;
  };

  return JSON.stringify(cleanProps(prevProps)) === JSON.stringify(cleanProps(nextProps));
});

export default PhpSsrComponent;
