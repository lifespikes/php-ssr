export interface RemoteListener {
  id: string;
  listener: (event: Event) => void;
}

export type SsrComponentProps = (
  Record<string, unknown> &
  Record<`on${string}`, RemoteListener> &
  Record<'children', SsrComponent | SsrComponent[]>
)

export interface SsrComponent {
  id: string;
  name: string;
  props: SsrComponentProps;
}

export interface Tree {
  root: SsrComponent[];
}
