echo "Please enter the name of your theme e.g. My Awesome Theme";
read theme_name;
grep -rl --exclude-dir={node_modules,.git,vendor} '|_NAME_|' ./ | LC_ALL=C xargs sed -i '' "s/|_NAME_|/${theme_name//\//\\/}/g";

echo "Please enter your theme slug e.g. my_awesome_theme";
read theme_slug;
grep -rl --exclude-dir={node_modules,.git,vendor} '|_SLUG_|' ./ | LC_ALL=C xargs sed -i '' "s/|_SLUG_|/${theme_slug//\//\\/}/g";

echo "Please enter the name of your PHP package (for Composer) e.g. vendor/package";
read package_name;
grep -rl --exclude-dir={node_modules,.git,vendor} '|_PACKAGE_|' ./ | LC_ALL=C xargs sed -i '' "s/|_PACKAGE_|/${package_name//\//\\/}/g";

echo "Please enter the name of your JS package (for NPM) e.g. @scope/package";
read js_package_name;
grep -rl --exclude-dir={node_modules,.git,vendor} '|_JS_PACKAGE_|' ./ | LC_ALL=C xargs sed -i '' "s/|_JS_PACKAGE_|/${js_package_name//\//\\/}/g";

echo "Installing dependencies";
pnpm install && composer install;