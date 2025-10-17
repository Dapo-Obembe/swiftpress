import fs from "fs";
import archiver from "archiver";

console.log("🚀 Starting theme packaging process...");

// Define the name of the output zip file and theme folder
const themeName = "swiftpress";
const outputFileName = `${themeName}.zip`;
const output = fs.createWriteStream(outputFileName);
const archive = archiver("zip", { zlib: { level: 9 } });

// This should be a complete list of what WordPress needs.
const filesToInclude = [
  "style.css",
  "theme.json",
  "index.php",
  "functions.php",
  "class-custom-theme-updater.php",
  "screenshot.png",
  "readme.txt",
  "dist/",
  "inc/",
  "templates/",
  "parts/",
  "styles/",
  "patterns/",
  "acf-blocks/",
  "acf-json/",
];

output.on("close", () => {
  console.log(`✅ Success! ${outputFileName} created.`);
  console.log(`Total size: ${(archive.pointer() / 1024 / 1024).toFixed(2)} MB`);
});

archive.on("error", (err) => {
  throw err;
});

archive.pipe(output);

// Add files and folders to a directory inside the zip
filesToInclude.forEach((item) => {
  if (fs.existsSync(item)) {
    if (fs.statSync(item).isDirectory()) {
      archive.directory(item, `${themeName}/${item}`);
    } else {
      archive.file(item, { name: `${themeName}/${item}` });
    }
  }
});

archive.finalize();
