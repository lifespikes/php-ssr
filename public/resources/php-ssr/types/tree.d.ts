import {Attributes} from 'react';

export interface RemoteListener {
  id: string;
  listener: (event: Event) => void;
}

export interface SsrComponent {
  id: string;
  name: string;
  props: Attributes & {
    [key: `on${string}`]: RemoteListener;
    _children?: SsrComponent[];
  };
}

export interface Tree {
  root: SsrComponent[];
}
