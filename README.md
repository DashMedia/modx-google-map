#googleMap

DESCRIPTION

This output modifier accepts an address and returns a url for the static map image
```
PARAMETERS: 
w - default: 435
h - default: 300
z - default: 16
sensor (1 or 0) - default: 0
marker (1 or 0) - default: 1
key - Google Maps API v3 Key, note that static maps must be enabled

OUTPUT MODIFIER USAGE:
<img src="[[*tvAddress:googleMap=`w=425,h=300,z=16,key=xxxxxxxxxxx,sensor=0,marker=1`]]" />

SNIPPET USAGE:
<img src="[[googleMap? &address=`[[*tvAddress]]` &key=`xxxxxxxxxxx` &w=`425` &h=`300` &z=`16` &marker=`1` &sensor=`0`]]" />
```

`key` is the only REQUIRED variable, unless you manually create a system setting named `google_api_key`
then the snippet will use that value whenever a vlaue for 'key' is not passed

AUTHOR: Jason Carney, DashMedia.com.au