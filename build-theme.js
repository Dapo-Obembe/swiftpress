import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Load modular theme files
const settingsDir = path.join(__dirname, "theme");
const settings = JSON.parse(
  fs.readFileSync(path.join(settingsDir, "settings.json"), "utf-8")
);
const styles = JSON.parse(
  fs.readFileSync(path.join(settingsDir, "styles.json"), "utf-8")
);
const templateParts = JSON.parse(
  fs.readFileSync(path.join(settingsDir, "templateParts.json"), "utf-8")
);

// Build theme.json
const themeJson = {
  $schema: "https://schemas.wp.org/trunk/theme.json",
  version: 3,
  settings,
  styles,
  templateParts,
};

// Write theme.json
fs.writeFileSync(
  path.join(__dirname, "theme.json"),
  JSON.stringify(themeJson, null, 4)
);

console.log("✅ theme.json built successfully!");

// Generate Tailwind config from theme.json
const generateTailwindConfig = () => {
  const colors = {};
  const spacing = {};
  const fontSize = {};

  // Convert color palette
  settings.color.palette.forEach((color) => {
    const slug = color.slug;
    if (slug === "white") {
      colors.white = color.color;
    } else if (slug.startsWith("gray-")) {
      const shade = slug.replace("gray-", "");
      if (!colors.gray) colors.gray = {};
      colors.gray[shade] = color.color;
    }
  });

  // Convert spacing - use slug as string key
  settings.spacing.spacingSizes.forEach((size) => {
    spacing[`'${size.slug}'`] = size.size;
  });

  // Convert font sizes - use mapped keys as strings where needed
  settings.typography.fontSizes.forEach((size) => {
    const slug = size.slug;
    const sizeMap = {
      small: "sm",
      medium: "base",
      large: "lg",
      "x-large": "3xl",
      "xx-large": "4xl",
    };
    const key = sizeMap[slug] || slug;
    // Wrap numeric-starting keys in quotes
    const finalKey = /^\d/.test(key) ? `'${key}'` : key;
    fontSize[finalKey] = size.size;
  });

  // Extract font family
  const fontFamily = settings.typography.fontFamilies[0];
  const fontFamilyArray = fontFamily.fontFamily
    .split(",")
    .map((f) => f.trim().replace(/['"]/g, ""));

  const tailwindConfig = `/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
    './blocks/**/*.css',
    './assets/css/pages/**/*.css',
    './assets/css/blocks/**/*.css',
    './assets/patterns/*.css',
    './templates/**/*.html',
    './parts/*.html',
  ],
  theme: {
    extend: {
      colors: ${JSON.stringify(colors, null, 6).replace(/"([^"]+)":/g, "$1:")},
      spacing: ${JSON.stringify(spacing, null, 6).replace(
        /"([^"]+)":/g,
        "$1:"
      )},
      fontSize: ${JSON.stringify(fontSize, null, 6).replace(
        /"([^"]+)":/g,
        "$1:"
      )},
      fontFamily: {
        sans: ${JSON.stringify(fontFamilyArray, null, 8)},
      },
      maxWidth: {
        'content': '${settings.layout.contentSize}',
        'wide': '${settings.layout.wideSize}',
      },
    },
  },
  plugins: [],
};`;

  fs.writeFileSync(path.join(__dirname, "tailwind.config.js"), tailwindConfig);

  console.log("✅ tailwind.config.js synced from theme.json!");
};

generateTailwindConfig();
