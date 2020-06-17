# Batch details

#### (**Admin Only**)

Used to get list of batch

**URL** : `/api/v1/batches/{batchId}`

**Params**

1. `<batchId>` = Batch id

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
	"data": {
		"id": 658142,
		"code": "r1me",
		"source": {
			"id": 43,
			"code": "124094",
			"name": "ASTER DM HEALTHCARE INC.",
			"created_at": "2019-08-05 23:30:26",
			"updated_at": "2019-08-05 23:30:26",
			"deleted_at": null
		},
		"clinician": "Kaylin",
		"dispatchMode": "ONLINE",
		"patientType": "SEND IN",
		"paymentMode": "cash",
		"status": "finish",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576741752,
		"updatedAt": 1577000906,
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
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": null,
		"transactions": []
	}
}
```
