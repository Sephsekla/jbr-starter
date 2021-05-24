echo "Please enter the name of your theme";
read theme_name;
grep -rl '|_NAME_|' ./ | LC_ALL=C xargs sed -i '' "s/|_NAME_|/$theme_name/g";

echo "Please enter the name of your package (for NPM and composer)";
read package_name;
grep -rl '|_PACKAGE_|' ./ | LC_ALL=C xargs sed -i '' "s/|_PACKAGE_|/$package_name/g";

echo "Please enter your theme slug";
read theme_slug;
grep -rl '|_SLUG_|' ./ | LC_ALL=C xargs sed -i '' "s/|_SLUG_|/$theme_slug/g";

echo "Installing dependencies";
pnpm install && composer install;