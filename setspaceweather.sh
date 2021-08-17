#!/bin/bash
outfile=/home/pi/www/weather/spacecast_final.txt
grep -E -i -v 'jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec' /home/pi/www/weather/spacecast.txt > /home/pi/www/weather/spacetemp.txt
sed -i "s/Minor\s/Minor-/g" /home/pi/www/weather/spacetemp.txt
sed -i "s/Moderate\s/Mid-/g" /home/pi/www/weather/spacetemp.txt
sed -i "s/Strong-Extreme\s/High-/g" /home/pi/www/weather/spacetemp.txt
sed -i "s/\//\<\/td\>\<td\>/g" /home/pi/www/weather/spacetemp.txt
sed -i "s/\s/\<\/td\>\<td\>/g" /home/pi/www/weather/spacetemp.txt

echo '<span style="color:rgb(28,255,28)">Remote Stellar Environment:</span><br />' > $outfile
echo '<table>' >> $outfile
echo "<tr style='color:rgb(28,255,28)'><td>Threat</td><td>+00</td><td>+24</td><td>+48</td></tr>" >> $outfile
while read i; do
  echo "<tr style='color:rgb(28,255,28)'><td>$i</td></tr>" >> $outfile

done < /home/pi/www/weather/spacetemp.txt

echo '</table>' >> $outfile
