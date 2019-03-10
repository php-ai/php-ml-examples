import csv
import random
from staticmap import StaticMap, CircleMarker

m = StaticMap(1000, 900, url_template='http://a.tile.stamen.com/toner/{z}/{x}/{y}.png')


with open('data/crimes-arson.csv') as csvfile:
    reader = csv.reader(csvfile, delimiter=';')
    for row in reader:
        marker = CircleMarker((float(row[1]), float(row[0])), (232, 152, 16, 180), 6)
        m.add_marker(marker)

image = m.render(center=[-87.684871189, 41.8348221989])
image.save('arson.png')
