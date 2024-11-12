// vite.config.js
import { defineConfig } from 'vite'
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
  plugins: [
    symfonyPlugin({
      stimulus: true,
      refresh: true,
      viteDevServerHostname: "localhost",      
      // or specify the path to your controllers.json
      // stimulus: './assets/other-dir/controllers.json'      
    }),    
  ],
  build: {
    rollupOptions: {
      input: {
        "app": "./assets/app.js",
      }
    }
  },  
});