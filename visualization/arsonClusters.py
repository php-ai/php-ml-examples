import csv
import random
from staticmap import StaticMap, CircleMarker

m = StaticMap(1000, 900, url_template='http://a.tile.stamen.com/toner/{z}/{x}/{y}.png')

def cluster_to_color(cluster):
    alpha = 180
    return {
        '0': (246, 81, 29,alpha),
        '1': (255, 180, 0,alpha),
        '2': (0, 166, 237,alpha),
        '3': (127, 184, 0,alpha),
        '4': (67, 188, 20, alpha),
        '5': (102, 46, 155, alpha),
        '6': (175, 127, 242, alpha),
        '7': (146, 181, 29, alpha),
        '8': (155, 100, 0, alpha),
        '9': (100, 106, 237, alpha),
        '10': (27, 84, 0, alpha),
        '11': (167, 228, 20, alpha),
        '12': (202, 146, 155, alpha),
        '13': (75, 187, 42, alpha)
    }[cluster]

with open('data/crimes-clusters.csv') as csvfile:
    reader = csv.reader(csvfile, delimiter=';')
    for row in reader:
        if row[0] == 'C':
            marker = CircleMarker((float(row[2]), float(row[1])), (0,0,0), 15)
        else:
            marker = CircleMarker((float(row[2]), float(row[1])), cluster_to_color(row[0]), 6)
        m.add_marker(marker)

image = m.render(center=[-87.684871189, 41.8348221989])
image.save('crimes-clusters.png')
