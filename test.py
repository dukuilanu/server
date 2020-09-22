import urllib.request
import time
import board
import busio
import adafruit_bme680
from Adafruit_IO import Client, Feed, RequestError

ADAFRUIT_IO_KEY = 'nope'
ADAFRUIT_IO_USERNAME = 'errans'

aio = Client(ADAFRUIT_IO_USERNAME, ADAFRUIT_IO_KEY)

ops_voc_feed = aio.feeds('ops_voc')

# Create library object using our Bus I2C port
i2c = busio.I2C(board.SCL, board.SDA)
sensor = adafruit_bme680.Adafruit_BME680_I2C(i2c)

#time.sleep(5)
temp = sensor.temperature
temp_f = temp * 9.0 / 5.0 + 32

hum = sensor.humidity
hum = round(hum, 2)

press = sensor.pressure
press_i = press * .02953
press_i = round(press_i, 2)

ops_voc_data = sensor.gas

print("\nTemperature: %0.1f F" % temp_f)
print("Humidity: " + str(hum) + "%")
print("VOC: %d ohm" % ops_voc_data)
print("Pressure: " + str(press_i) + " inHg")

url = 'http://localhost/thermostat_api.php'
uri = '/?inSub=1&temp=' + str(round(temp_f, 2)) + '&humidity=' + str(hum) + '&id=3'

print(url + uri)
req = urllib.request.Request(url + uri)
resp = urllib.request.urlopen(req)
print(resp.read())

print("Sending to AIO")
aio.send(ops_voc_feed.key, ops_voc_data)
