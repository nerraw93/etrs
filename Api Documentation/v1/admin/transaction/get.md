# Lab transaction details

#### (**Admin Only**)

Used to collect batch order details or lab transaction

**URL** : `/api/v1/transactions/{transactionId}`

**Params**

1. `transactionId` = Lab transaction ID.

**Method** : `GET`

**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": {
		"id": 15,
		"idPrefix": "191573560268",
		"patient": {
			"id": 9702,
			"code": "ion",
			"globalCustomId": "OL97021567405150",
			"clientCustomId": null,
			"emailAddress": "keshawn11@haag.info",
			"firstName": "Eugenia",
			"middleName": null,
			"lastName": "VonRueden",
			"gender": "male",
			"age": 14,
			"birthDateAsTimestamp": -307785600,
			"birthDate": "2005-11-30T16:00:00.000000Z",
			"passportNumber": "9018193179077",
			"citizen": "Pilipino",
			"bloodType": "A",
			"mothersMaidenName": null,
			"address": "74391 Kelli Isle Suite 901\nWilliamsonstad, CT 89371",
			"city": "North Tyreek",
			"seniorCitizenId": null,
			"telNumber": "1-844-834-4711",
			"faxNumber": null,
			"mobileNumber": null,
			"occupation": null,
			"hmoCard": null,
			"hmoCardNo": null,
			"lastVisitAt": null,
			"archivedAt": null,
			"createdAt": 1567405150,
			"updatedAt": 1576595953,
			"client": {
				"id": 136,
				"globalPrefix": null,
				"code": "ea",
				"type": "client",
				"paymentMode": "cash",
				"emailAddress": "perfect_client@gmail.com",
				"firstName": "Alexandro",
				"lastName": "Bruen",
				"username": "smith.marilou",
				"businessName": "Runte Ltd",
				"businessAddress": "3637 Alfreda Trafficway Suite 922\nLake Agneschester, MO 39853",
				"contactNumber": "239-974-6186",
				"active": 1,
				"createdAt": 1567405098,
				"updatedAt": 1567405098
			}
		},
		"clinicalInformation": "I shall remember it in with the distant green leaves. As there seemed to have been changed in the air. She did it at all,' said Alice: 'she's so extremely--' Just then she remembered that she had.",
		"specialInstructions": "The Dormouse had closed its eyes were looking over their heads. She felt that she ought not to make SOME change in my kitchen AT ALL. Soup does very well to introduce it.' 'I don't think it's at all.",
		"orNumber": null,
		"client": {
			"id": 136,
			"globalPrefix": null,
			"code": "ea",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "perfect_client@gmail.com",
			"firstName": "Alexandro",
			"lastName": "Bruen",
			"username": "smith.marilou",
			"businessName": "Runte Ltd",
			"businessAddress": "3637 Alfreda Trafficway Suite 922\nLake Agneschester, MO 39853",
			"contactNumber": "239-974-6186",
			"active": 1,
			"createdAt": 1567405098,
			"updatedAt": 1567405098
		},
		"status": "posted",
		"isUrgent": 0,
		"tests": [{
			"id": 5940,
			"code": "Xzt3NqeCdr1567405103",
			"name": "benchmark back-end action-items",
			"cost": 1427
		}, {
			"id": 5942,
			"code": "pSIOwHqxTa1567405103",
			"name": "synthesize global bandwidth",
			"cost": 8471
		}],
		"createdAt": 1573560268
	}
}
```

**Sample Error response**
```json
{
	"errors": [{
		"code": 401,
		"message": "No query results for model [App\\Models\\BatchOrder] 99889599853132651"
	}]
}
```
