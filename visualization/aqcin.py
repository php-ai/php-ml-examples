import csv
import random
from staticmap import StaticMap, CircleMarker

m = StaticMap(1000, 900, url_template='http://a.tile.stamen.com/toner/{z}/{x}/{y}.png')

def label_to_color(label):
    alpha = 180
    return {
        'good': (0,153,102,alpha),
        'moderate': (255,222,51,alpha),
        'unhealthy for sensitive': (255,153,51,alpha),
        'unhealthy': (204,0,51,alpha),
        'very unhealthy': (102,0,153,alpha),
        'hazardous': (126,0,35,alpha)
    }[label]

with open('data/airVis.csv') as csvfile:
    reader = csv.reader(csvfile, delimiter=';')
    for row in reader:
        marker = CircleMarker((float(row[1]), float(row[0])), label_to_color(row[2]), 6)
        m.add_marker(marker)

image = m.render(zoom=6, center=[15.2793976568, 50.5197351804])
image.save('marker-k3-minkowski.png')

random.random