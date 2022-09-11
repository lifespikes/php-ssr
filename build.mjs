/**
 * PHP-SSR Bundling and Build Script
 *
 * This script leverages Parcel to handle all necessary build tasks on
 * the JS side of things. We also use Parcel's watcher to detect changes across
 * PHP and JS files, which then trigger stub generation as it is needed.
 *
 * The final goal is to have a package that can be used with more or less any
 * bundler, but Parcel is the only one that is supported at this time.
 *
 * @author Cristian Herrera <cristian@lifespikes.com>
 */

import {Parcel} from '@parcel/core';
import {fileURLToPath} from 'url';
import chokidar from 'chokidar';
import * as fs from 'fs';

let ignoreNextWatcherEvent = false;

let bundler = new Parcel({
  entries: './public/resources/App.tsx',
  defaultConfig: '@parcel/config-default',
  defaultTargetOptions: {
    distDir: './public/dist',
  },
  additionalReporters: [
    {
      packageName: '@parcel/reporter-cli',
      resolveFrom: fileURLToPath(import.meta.url)
    }
  ],
  hmrOptions: {
    port: 3000
  }
});

await bundler.watch();

chokidar.watch('./public/dist/App.js').on('change', () => {
  let bundle = fs.readFileSync('./public/dist/App.js', 'utf8');
  let matches = 0;

  const patterns = [
    [/HMR_PORT\s=\s3000/gm, 'HMR_PORT = "443/parcel-ws"'],
    [/HMR_SECURE\s=\sfalse/gm, 'HMR_SECURE = true']
  ];

  for (let [pattern, replacement] of patterns) {
    if (pattern.test(bundle)) {
      bundle = bundle.replaceAll(pattern, replacement);
      matches++;
    }
  }

  if (matches > 0) {
    console.log('Rewriting HMR stubs...');

    setTimeout(() => {
      fs.writeFileSync('./public/dist/App.js', bundle);
    }, 500);

    console.log('HMR stubs rewritten.');
  }
});
