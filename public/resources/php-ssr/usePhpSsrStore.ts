import create from 'zustand';
import {Tree} from './types/tree';
import {FC} from 'react';

export interface PhpSsrStore {
  sessionId?: string;

  tree: Tree;
  setTree: (tree: Tree) => void

  componentResolver?: (module: string) => FC;
  setComponentResolver: (componentResolver: PhpSsrStore['componentResolver']) => void;
}

const usePhpSsrStore = create<PhpSsrStore>((set) => ({
  sessionId: undefined,

  setTree: (tree) => set({tree}),
  tree: {
    root: []
  },

  setComponentResolver: (componentResolver) => set({componentResolver}),
}));

export default usePhpSsrStore;
