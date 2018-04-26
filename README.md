# PHP JSON Objects

Treat JSON as objects in PHP instead of strings.

##### Usage

```php
$json = new JsonObject($data);

// encoding to json
$encoded = json_encode($json);
$encoded = $json->encode();
$encoded = (string) $json;

// decoding to data
$decoded = JsonObject::decode($json);

// set options
$json->options(JSON_NUMERIC_CHECK)->encode();

// throw a JsonException on error
$json->withErrors(true)->encode();

// check if the current instance throws an error
$json->isErrorThrown();

// returns the last occurred JsonException
JsonObject::getError();
```

Note that methods `options` and `withErrors` returns a new instance rather than modifying the current JsonObject instance.
