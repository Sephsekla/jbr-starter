echo "Please enter the name of your theme";
read theme_name;
grep -rl '|_NAME_|' ./ | LC_ALL=C xargs sed -i '' "s/|_NAME_|/$theme_name/g";