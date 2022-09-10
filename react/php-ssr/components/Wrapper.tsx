import {Fragment} from 'react';
import usePhpSsr from '../usePhpSsr';
import SSRComponent from './SSRComponent';

const Wrapper = () => {
  const components = usePhpSsr();

  return (
    <Fragment>
      {components.map((component, index) => (
        <SSRComponent key={index} {...component} />
      ))}
    </Fragment>
  )
};

export default Wrapper;
