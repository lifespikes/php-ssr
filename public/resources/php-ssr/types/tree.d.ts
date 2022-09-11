export interface RemoteListener {
  id: string;
  listener: (event: Event) => void;
}

export interface SsrComponent {
  id: string;
  name: string;
  props: {
    [key: string]: any;
    [key: `on${string}`]: RemoteListener;
    children?: SsrComponent[];
  };
}

export interface Tree {
  root: SsrComponent[];
}
