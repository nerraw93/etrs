# IP Address Whitelist

#### (**Admin Only**)

IP Address Whitelist items.

**URL** : `/api/v1/white-list/ips`

**Params**

1. `filter` = **Optional**. This can either be `admin` or `client`. When set, it will filter the IP addresses and return only those of all admins or clients. Else, it will return all IP addresses.

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": [{
		"id": 39,
		"user": {
			"id": 49,
			"globalPrefix": null,
			"code": "bq",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "pnpghlaboratory@yahoo.com",
			"firstName": "PNP ",
			"lastName": "GENERAL HOSPITAL",
			"username": "pnpghlaboratory6972",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1546981654,
			"updatedAt": 1546827097
		},
		"address": "91.120.146.212"
	}, {
		"id": 40,
		"user": null,
		"address": "60.71.197.216"
	}, {
		"id": 41,
		"user": {
			"id": 74,
			"globalPrefix": null,
			"code": "cg",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "mary.marco@astermedicalcentre.com",
			"firstName": "ASTER DM",
			"lastName": "HEALTHCARE INC.",
			"username": "marymarco9531",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1549315150,
			"updatedAt": 1549310758
		},
		"address": "117.19.234.230"
	}, {
		"id": 42,
		"user": null,
		"address": "62.169.23.96"
	}, {
		"id": 43,
		"user": {
			"id": 78,
			"globalPrefix": null,
			"code": "ck",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "jokeng@yahoo.com",
			"firstName": "MEDICARD",
			"lastName": "FAIRVIEW",
			"username": "jokeng9090",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1549927399,
			"updatedAt": 1549916333
		},
		"address": "152.175.176.44"
	}, {
		"id": 112,
		"user": {
			"id": 130,
			"globalPrefix": null,
			"code": "d4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "georgiana01@yahoo.com",
			"firstName": "Presley",
			"lastName": "Armstrong",
			"username": "ssanford",
			"businessName": "Koch-Lebsack",
			"businessAddress": "745 Wintheiser Hollow\nNorth Linatown, MO 84437",
			"contactNumber": "(250) 569-0596 x3890",
			"active": 1,
			"createdAt": 1567405097,
			"updatedAt": 1567405097
		},
		"address": "181.193.219.142"
	}]
}
```
