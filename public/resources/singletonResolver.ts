const singleton = new class {
  public components: any = [];
  public loading: boolean = false;

  async register() {
    if (this.loading) {
      await new Promise<void>(resolve => {
        const i = setInterval(() => {
          if (!this.loading) {
            clearInterval(i);
            resolve();
          }
        }, 100);
      });
    }

    this.loading = true;
    // @ts-ignore
    this.components = await import('./components/*');
    this.loading = false;
  }

  async get(name: string) {
    if (this.components.length < 1) {
      await this.register();
    }

    return this.components[name];
  }
};

export default singleton;
