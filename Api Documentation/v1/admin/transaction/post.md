# Batch Order update - status **ONLY (process and done)**

#### (**Client Only**)

Update client batch order status - to be updated as `process` or `done`

**URL** : `/api/v1/transactions/{transactionId}/status`

**Params**

1. `transactionId` = transaction ID

**Method** : `POST`

**Post Data**

`status`: **Required** "process" or "done" Status that will be set to update a laboratory transaction.


**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
	"data": {
		"id": 37,
		"idPrefix": "191576748353",
		"patient": {
			"id": 9704,
			"code": "iop",
			"globalCustomId": "OL97041567405150",
			"clientCustomId": null,
			"emailAddress": "darmstrong@gmail.com",
			"firstName": "Jerel",
			"middleName": null,
			"lastName": "Grady",
			"gender": "male",
			"age": 28,
			"birthDateAsTimestamp": -307785600,
			"birthDate": "1991-04-07T16:00:00.000000Z",
			"passportNumber": "2113312244487",
			"citizen": "Pilipino",
			"bloodType": "O",
			"mothersMaidenName": null,
			"address": "37467 Caleigh Avenue Apt. 695\nLake Claudtown, SC 01100-6203",
			"city": "Briaview",
			"seniorCitizenId": null,
			"telNumber": "1-844-475-2248",
			"faxNumber": null,
			"mobileNumber": null,
			"occupation": null,
			"hmoCard": null,
			"hmoCardNo": null,
			"lastVisitAt": null,
			"archivedAt": null,
			"createdAt": 1567405150,
			"updatedAt": 1576593893,
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
		"clinicalInformation": "She was looking about for some time in silence: at last it sat for a long silence after this, and she dropped it hastily, just in time to begin again, it was the Rabbit coming to look down and.",
		"specialInstructions": "Still she went back to yesterday, because I was a very fine day!' said a timid and tremulous sound.] 'That's different from what I see\"!' 'You might just as the soldiers remaining behind to execute.",
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
		"status": "process",
		"isUrgent": 0,
		"tests": [{
			"id": 5948,
			"code": "GDQKodUjUI1567405103",
			"name": "implement leading-edge channels",
			"cost": 5264
		}, {
			"id": 5948,
			"code": "GDQKodUjUI1567405103",
			"name": "implement leading-edge channels",
			"cost": 5264
		}],
		"createdAt": 1576748353
	}
}
```
