# IP address White List - create

#### (**Admin Only**)

This endpoint will save an IP address to the system’s IP whitelist records. This means that the usage of the whole API will be limited to only those IP addresses

**URL** : `/api/v1/white-list/ips`

**Method** : `POST`

**Post Data**

1. `ipAddress` = **Required** The IP address. In order to determine where to get the IP address, you may need to check on your wifi router/modem or your Internet Service Provider.
2. `userId` = **Optional** ID of the user who owns this IP address.

**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
  data: {
		"id": 40,
		"user": null,
		"address": "60.71.197.216"
	}
}
```
