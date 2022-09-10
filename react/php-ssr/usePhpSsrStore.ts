import create from 'zustand';
import {Tree} from './types/tree';

interface PhpSsrStore {
  sessionId?: string;
  tree: Tree;
}

const usePhpSsrStore = create<PhpSsrStore>((set) => ({
  sessionId: undefined,
  tree: {
    root: []
  },
}));

export default usePhpSsrStore;
