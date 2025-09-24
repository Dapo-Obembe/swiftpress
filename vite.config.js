import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import fs from "fs";
import path from "path";

const blockDir = "./assets/css/blocks";
const patternDir = "./assets/css/patterns";
const blockEntries = fs.readdirSync(blockDir).reduce((entries, file) => {
  if (file.endsWith(".css")) {
    const name = path.parse(file).name;
    entries[`blocks/${name}`] = path.resolve(blockDir, file);
  }
  return entries;
}, {});
const patternEntries = fs.readdirSync(patternDir).reduce((entries, file) => {
  if (file.endsWith(".css")) {
    const name = path.parse(file).name;
    entries[`patterns/${name}`] = path.resolve(patternDir, file);
  }
  return entries;
}, {});

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    outDir: "dist",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        style: "./assets/css/input.css",
        app: "./assets/js/app.js",
        ...blockEntries,
        ...patternEntries,
      },
      output: {
        entryFileNames: "[name].js",
        assetFileNames: (assetInfo) => {
          // keep css grouped by folder
          if (assetInfo.name && assetInfo.name.endsWith(".css")) {
            return "[name][extname]"; // e.g. blocks/button.css
          }
          return "[name][extname]";
        },
      },
    },
  },
});
