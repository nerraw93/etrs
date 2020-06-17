# Client search

#### (**Admin Only**)

Search clients

**URL** : `/api/v1/clients/search`

**Query Params**

1. `name` = **Required** The name to search for. It can be the first or last name of a client.
1. `count` = Number of batch to be returned. Defaults to `10`
2. `page` = Page number. Defaults to 1.

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": [{
		"id": 3,
		"globalPrefix": null,
		"code": "d",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "test_client_2@test.com",
		"firstName": "test_client_2",
		"lastName": "test_client_2",
		"username": "test_client_26971",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 0,
		"createdAt": 1522869970,
		"updatedAt": 1576999111
	}, {
		"id": 4,
		"globalPrefix": null,
		"code": "e",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "alexandra@hi-precision.com.ph",
		"firstName": "alexandra",
		"lastName": "alexandra",
		"username": "alexandra6903",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 0,
		"createdAt": 1522869936,
		"updatedAt": 1576728276
	}, {
		"id": 6,
		"globalPrefix": null,
		"code": "g",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "glevinzon.zeal@gmail.com",
		"firstName": "Glevinzon",
		"lastName": "Dapal",
		"username": "glevinzonzeal5669",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 1,
		"createdAt": 1487619814,
		"updatedAt": 1576595423
	}, {
		"id": 7,
		"globalPrefix": null,
		"code": "h",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "marylizatibre@gmail.com",
		"firstName": "marylizatibre",
		"lastName": "marylizatibre",
		"username": "marylizatibre2209",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 0,
		"createdAt": 1522869965,
		"updatedAt": 1576595440
	}, {
		"id": 8,
		"globalPrefix": null,
		"code": "i",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "marylizatibre@ymail.com",
		"firstName": "marylizatibre",
		"lastName": "marylizatibre",
		"username": "marylizatibre8146",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 1,
		"createdAt": 1508272467,
		"updatedAt": 1576595467
	}, {
		"id": 9,
		"globalPrefix": null,
		"code": "j",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "foo@bar.com",
		"firstName": "Foo",
		"lastName": "Bar",
		"username": "foo03809",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 1,
		"createdAt": 1500575026,
		"updatedAt": 1576595516
	}, {
		"id": 10,
		"globalPrefix": null,
		"code": "k",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "kristinapineda@hi-precision.com.ph",
		"firstName": "kristinapineda",
		"lastName": "kristinapineda",
		"username": "kristinapineda7380",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 0,
		"createdAt": 1502667185,
		"updatedAt": 1576595575
	}, {
		"id": 11,
		"globalPrefix": null,
		"code": "m",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "tinz.pineda@gmail.com",
		"firstName": "tinz.pineda",
		"lastName": "tinz.pineda",
		"username": "tinzpineda6713",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 1,
		"createdAt": 1502667203,
		"updatedAt": 1576595655
	}, {
		"id": 13,
		"globalPrefix": null,
		"code": "o",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "client@one.com",
		"firstName": "Client",
		"lastName": "One",
		"username": "client4903",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 1,
		"createdAt": 1532370045,
		"updatedAt": 1576595678
	}, {
		"id": 14,
		"globalPrefix": null,
		"code": "p",
		"type": "client",
		"paymentMode": "cash",
		"emailAddress": "clienttest@one.com",
		"firstName": "Client",
		"lastName": "Test",
		"username": "clienttest1284",
		"businessName": null,
		"businessAddress": null,
		"contactNumber": null,
		"active": 0,
		"createdAt": 1553202926,
		"updatedAt": 1576595781
	}],
	"links": {
		"first": "http:\/\/dev.etrs.com\/api\/v1\/clients?page=1",
		"last": "http:\/\/dev.etrs.com\/api\/v1\/clients?page=14",
		"prev": null,
		"next": "http:\/\/dev.etrs.com\/api\/v1\/clients?page=2"
	},
	"meta": {
		"current_page": 1,
		"from": 1,
		"last_page": 14,
		"path": "http:\/\/dev.etrs.com\/api\/v1\/clients",
		"per_page": 10,
		"to": 10,
		"total": 135
	}
}
```
