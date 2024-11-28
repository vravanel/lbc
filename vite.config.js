// vite.config.js
import { defineConfig } from 'vite'
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
  server: {
    host: "0.0.0.0",
    watch: {
      usePolling: true, 
      // interval: 100,  
    }
  },
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
        "global": "./assets/login.js"
      }
    }
  },  
});