output=$(phpunit --coverage-text)
if [ $? -eq 0 ]; then
    echo "$output" | grep "Lines" | grep -v "Methods" | sed "s/\sLines\://g" | sed "s/%.*//g" | sed -e 's/^[[:space:]]*//' -e 's/[[:space:]]*$//' | awk '{if ($0 > 80) exit 0; else print "Test coverage " $0 "% under 80%!"; exit 1;}'
else
  echo -e "$output";
  exit 1;
fi
