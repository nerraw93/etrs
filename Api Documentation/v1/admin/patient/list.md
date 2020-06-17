# Patient list

#### (**Admin Only**)

Used to get list of patients

**URL** : `/api/v1/patients`

**Query Params**

1. `count` = Number of batch to be returned. Defaults to `30`
2. `page` = Page number. Defaults to 1.

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": [{
		"id": 906,
		"code": "2x",
		"globalCustomId": "OL9061565018476",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "RODRIGO",
		"middleName": "AUREA (LINGAP-OPD)",
		"lastName": "CLEMENTE",
		"gender": "male",
		"age": 62,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1957-01-30T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522707490,
		"updatedAt": 1522707490,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 919,
		"code": "3b",
		"globalCustomId": "OL9191565018477",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "ELENA",
		"middleName": "CUSTODIO ( LINGAP-ONCO)",
		"lastName": "RAMIREZ",
		"gender": "female",
		"age": 56,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1963-07-21T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522781443,
		"updatedAt": 1522781443,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 921,
		"code": "3d",
		"globalCustomId": "OL9211565018477",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "MA.GILDA",
		"middleName": "GOLILAO ( LINGAP-IN PATIENT)",
		"lastName": "NATAD",
		"gender": "female",
		"age": 55,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1964-09-27T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522792169,
		"updatedAt": 1522792273,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 925,
		"code": "3h",
		"globalCustomId": "OL9251565018477",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "MARCELINO",
		"middleName": "MATANGGIHAN (LINGAP-OPD)",
		"lastName": "TERRIBLE",
		"gender": "male",
		"age": 78,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1941-04-25T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522947981,
		"updatedAt": 1522947981,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 926,
		"code": "3i",
		"globalCustomId": "OL9261565018477",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "ROMULO DONATO",
		"middleName": "PESIGAN (LINGAP-OPD)",
		"lastName": "AMPONIN",
		"gender": "male",
		"age": 67,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1952-02-08T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522948703,
		"updatedAt": 1522948703,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 927,
		"code": "3j",
		"globalCustomId": "OL9271565018477",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "RUEL",
		"middleName": "APRECIO (LINGAP-OPD)",
		"lastName": "PONCE",
		"gender": "male",
		"age": 44,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1975-06-22T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522958821,
		"updatedAt": 1522958821,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 928,
		"code": "3k",
		"globalCustomId": "OL9281565018478",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "AMADO",
		"middleName": "SILVA (LINGAP-OPD)",
		"lastName": "DE OCAMPO",
		"gender": "male",
		"age": 82,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1937-01-05T15:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1522968349,
		"updatedAt": 1522968349,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 938,
		"code": "3v",
		"globalCustomId": "OL9381565018478",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "ROEL",
		"middleName": "GARCIA (LINGAP-IN PATIENT)",
		"lastName": "RUIZ",
		"gender": "male",
		"age": 50,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1969-08-15T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1523301234,
		"updatedAt": 1523304224,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 939,
		"code": "3w",
		"globalCustomId": "OL9391565018478",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "ROLANDO",
		"middleName": "NAVARRO",
		"lastName": "SAGUM",
		"gender": "male",
		"age": 63,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1956-03-09T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1523384492,
		"updatedAt": 1523384492,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}, {
		"id": 960,
		"code": "4i",
		"globalCustomId": "OL9601565018479",
		"clientCustomId": "",
		"emailAddress": "",
		"firstName": "RICO",
		"middleName": "MANLAPAS",
		"lastName": "ABEJUELA",
		"gender": "male",
		"age": 21,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "1998-08-24T16:00:00.000000Z",
		"passportNumber": "",
		"citizen": "",
		"bloodType": "",
		"mothersMaidenName": "",
		"address": "",
		"city": "",
		"seniorCitizenId": "",
		"telNumber": "",
		"faxNumber": "",
		"mobileNumber": "",
		"occupation": "",
		"hmoCard": "",
		"hmoCardNo": "",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1523481535,
		"updatedAt": 1523481535,
		"client": {
			"id": 28,
			"globalPrefix": null,
			"code": "4",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dswd@dswd.com",
			"firstName": "DSWD",
			"lastName": "DSWD",
			"username": "dswd3126",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1522689964,
			"updatedAt": 1576596119
		}
	}],
	"links": {
		"first": "http:\/\/dev.etrs.com\/api\/v1\/patients?page=1",
		"last": "http:\/\/dev.etrs.com\/api\/v1\/patients?page=850",
		"prev": null,
		"next": "http:\/\/dev.etrs.com\/api\/v1\/patients?page=2"
	},
	"meta": {
		"current_page": 1,
		"from": 1,
		"last_page": 850,
		"path": "http:\/\/dev.etrs.com\/api\/v1\/patients",
		"per_page": 10,
		"to": 10,
		"total": 8495
	}
}
```