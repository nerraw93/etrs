# Order - create

#### (**Client Only**)

Create a new order for a given Batch and Patient

**URL** : `/api/v1/orders`

**Method** : `POST`

**Post Data**

1. `patientId` = **Required**. ID of the patient.
2. `tests` = **Required**. An array of tests.
3. `batchId` = **Required**. ID of the batch to whom the order belongs.
4. `clinicalInformation` = Other clinical information.
5. `specialInstructions` = Other special instructions.
6. `isUrgent` = Integer 1 or 0 flagging if the order is urgent. Defaults to 0, meaning it is not.


**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": {
		"id": 658071,
		"code": "r1jb",
		"source": {
			"id": 58,
			"code": "1101",
			"name": "GOPER SOSOS",
			"created_at": "2019-08-05 23:30:27",
			"updated_at": "2019-08-05 23:30:27",
			"deleted_at": null
		},
		"clinician": "Kaylin",
		"dispatchMode": "ONLINE",
		"patientType": "SEND IN",
		"paymentMode": "cash",
		"status": "draft",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576740780,
		"updatedAt": 1577005054,
		"createdBy": {
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
		"transactionsCount": 1,
		"labTestsCount": 0,
		"reportId": null,
		"transactions": [{
			"id": 59,
			"idPrefix": "191577005621",
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
			"clinicalInformation": "Hatter: 'I'm on the OUTSIDE.' He unfolded the paper as he said in a trembling voice to its children, 'Come away, my dears! It's high time to see the earth takes twenty-four hours to turn round on.",
			"specialInstructions": "SOMEBODY ought to have any rules in particular; at least, if there were no arches left, and all her life. Indeed, she had accidentally upset the milk-jug into his plate. Alice did not venture to go.",
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
			"status": "pending",
			"isUrgent": 0,
			"tests": [{
				"id": 5952,
				"code": "NXdrFRua281567405104",
				"name": "transform 24\/7 vortals",
				"cost": 7592
			}, {
				"id": 5948,
				"code": "GDQKodUjUI1567405103",
				"name": "implement leading-edge channels",
				"cost": 5264
			}],
			"createdAt": 1577005621
		}]
	}
}
```
