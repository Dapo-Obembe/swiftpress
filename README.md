# Swiftpress - WordPress Fullsite Editing Starter Theme

A modern WordPress Fullsite Editing Starter Theme that uses Vite + TailwindCSS for crafting swift WordPress website via the Block theme approach.

## Who is SwiftPress for?

This FSE WordPress starter theme is for developers who would love to use WordPress and build a custom solutions via the FSE approach. Non-developers can use it but its made for developers who may want to programmatically perform some magics.

## Features

- 🎨 TailwindCSS integration for utility-first styling
- 🔒 Security best practices
- ⚡ Performance optimized
- 💻 Developer-friendly architecture
- 🧩 Simple and straightforward build process

## Things You Get

- Pre-made patterns you can use to kickstart your development
- Working files on how to create patterns and custom core blocks styles for your clients
- Ability to chose either ACF or React-based(wordpress create-block) Blocks

## Requirement

1. Git Update Plugin.
2. Ability to use Vite, Tailwindcss (in case you want to extend)

## Installation & Updates Guides (to be updated soon)

1. Install GitHub Updater: Download from: https://github.com/afragen/github-updater Or install via WP CLI: `wp plugin install github-updater --activate`
2. Upload/Install this theme to WordPress via the Install Theme tab on Github Updater. Use `https://github.com/Dapo-Obembe/swiftpress` Branch is main.
3. Updates appear automatically in WordPress admin whenener there are any.

## How to use SwiftPress as a Developer

1. Git clone this repo or install and create a child theme
2. Run `composer install` to make it ready for WPCS PHPCS
3. Run `npm install` to install the packages
4. Run `npm run build:theme` to autogenerate the tailwind.config.js and theme.json. Run it again anytime you make changes to any of the jon files. DO NOT DIRECTLY EDIT YOUR THEME.JSON
5. Run `npm run dev` to start development
6. Run `npm run build to build for production.

## Best Way To Make Changes Programmatically

Create a Child theme for SwiftPress so you don't lose your changes (made to the code).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the GPL v2 or later.

## Credits

- Built by [Dapo Obembe]: https://www.dapoobembe.com
- TailwindCSS: https://tailwindcss.com
- WordPress: https://wordpress.org
- Github Updater: https://github.com/afragen/github-updater
- Coolors: https://coolors.co/

## Contact

For support or inquiries, please contact [hello@dapoobembe.com]
