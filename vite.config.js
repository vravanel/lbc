import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import CustomHmr from "./custom-hmr";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
  server: {
    host: "0.0.0.0",
  },
  plugins: [
    symfonyPlugin({
      stimulus: true,
      viteDevServerHostname: "localhost",
    }),
    CustomHmr(),
  ],
  build: {
    rollupOptions: {
      input: {
        app: "./assets/app.js",
      },
    },
  },
});