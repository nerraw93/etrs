# Batch list

#### (**Admin Only**)

Used to get list of batch

**URL** : `/api/v1/batches`

**Query Params**

1. `count` = Number of batch to be returned. Defaults to `30`
2. `page` = Page number. Defaults to 1.
3. `status` = This should be `sent`. Other types are: `processing` and `finish`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
	"data": [{
		"id": 658001,
		"code": "r1g9",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "WALK-IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019030,
		"updatedAt": 1575294389,
		"createdBy": null,
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": "reports\/r1g9_U0kbf8Db8r.pdf",
		"transactions": []
	}, {
		"id": 658002,
		"code": "r1ha",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "WALK-IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019030,
		"updatedAt": 1575294518,
		"createdBy": null,
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": "reports\/r1ha_ctWss1dWvT.pdf",
		"transactions": []
	}, {
		"id": 658003,
		"code": "r1hb",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "WALK-IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019031,
		"updatedAt": 1575294394,
		"createdBy": null,
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": "reports\/r1hb_ZUb3twT6yw.pdf",
		"transactions": []
	}, {
		"id": 658004,
		"code": "r1hc",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "WALK-IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019031,
		"updatedAt": 1576738381,
		"createdBy": null,
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": null,
		"transactions": []
	}, {
		"id": 658005,
		"code": "r1hd",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "SEND IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019031,
		"updatedAt": 1575293661,
		"createdBy": {
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
		},
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": "reports\/r1hd_9fXj4QEOn9.pdf",
		"transactions": []
	}, {
		"id": 658006,
		"code": "r1he",
		"source": null,
		"clinician": "",
		"dispatchMode": "",
		"patientType": "SEND IN",
		"paymentMode": "charge",
		"status": "finish",
		"tag": "",
		"slides": null,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": "",
		"createdAt": 1565019031,
		"updatedAt": 1575293659,
		"createdBy": {
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
		},
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": "reports\/r1he_FdBTjjhRAZ.pdf",
		"transactions": []
	}, {
		"id": 658012,
		"code": "r1hk",
		"source": {
			"id": 58,
			"code": "1101",
			"name": "GOPER SOSOS",
			"created_at": "2019-08-05 23:30:27",
			"updated_at": "2019-08-05 23:30:27",
			"deleted_at": null
		},
		"clinician": "",
		"dispatchMode": "",
		"patientType": "SEND IN",
		"paymentMode": "cash",
		"status": "finish",
		"tag": null,
		"slides": 0,
		"blood": 0,
		"forms": 0,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1573559494,
		"updatedAt": 1576740410,
		"createdBy": {
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
		},
		"transactionsCount": 0,
		"labTestsCount": 0,
		"reportId": null,
		"transactions": []
	}, {
		"id": 658043,
		"code": "r1ih",
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
		"patientType": "WALK-IN",
		"paymentMode": "cash",
		"status": "finish",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576740767,
		"updatedAt": 1576999111,
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
	}, {
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
		"status": "finish",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576740780,
		"updatedAt": 1576997796,
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
	}, {
		"id": 658079,
		"code": "r1jj",
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
		"patientType": "WALK-IN",
		"paymentMode": "cash",
		"status": "finish",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576740783,
		"updatedAt": 1576999072,
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
	}, {
		"id": 658094,
		"code": "r1jz",
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
		"patientType": "Dannie",
		"paymentMode": "cash",
		"status": "finish",
		"tag": null,
		"slides": 99,
		"blood": null,
		"forms": null,
		"specimen": null,
		"encodedBy": null,
		"createdAt": 1576740788,
		"updatedAt": 1576740788,
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
	}],
	"links": {
		"first": "http:\/\/dev.etrs.com\/api\/v1\/batches?page=1",
		"last": "http:\/\/dev.etrs.com\/api\/v1\/batches?page=1",
		"prev": null,
		"next": null
	},
	"meta": {
		"current_page": 1,
		"from": 1,
		"last_page": 1,
		"path": "http:\/\/dev.etrs.com\/api\/v1\/batches",
		"per_page": 30,
		"to": 11,
		"total": 11
	}
}
```