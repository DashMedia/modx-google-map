# googleMap

MODX output modifier accepts a street address and returns a url for a Google Maps static map image.

## Parameters:

```
w - default: 435
h - default: 300
z - default: 16
sensor (1 or 0) - default: 0
marker (1 or 0) - default: 1
key - Google Maps API v3 Key, note that static maps must be enabled
```
## Output Modifier Example:

```
<img src="[[*tvAddress:googleMap=`w=425,h=300,z=16,key=xxxxxxxxxxx,sensor=0,marker=1`]]" />
```

## Snippet Example:

```
<img src="[[googleMap? &address=`[[*tvAddress]]` &key=`xxxxxxxxxxx` &w=`425` &h=`300` &z=`16` &marker=`1` &sensor=`0`]]" />
```

`address` is the only REQUIRED variable, you may also set the system setting `googlemap.api_key` as a default so you do not need to pass through a Google API key to the snippet every time

Contributors: Jason Carney, Josh Curtis, Jonathan Haslett

## Building this package (using Repoman)

This package can be compiled using [Repoman by Craftsman Coding](https://github.com/craftsmancoding/repoman). 