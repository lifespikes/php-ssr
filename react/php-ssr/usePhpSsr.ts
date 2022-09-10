import usePhpSsrStore from './usePhpSsrStore';

const usePhpSsr = (treeLevel = 'root') => {
  return usePhpSsrStore((state) => state.tree[treeLevel]);
};

export default usePhpSsr;
