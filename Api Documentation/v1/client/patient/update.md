# Client Patient - update

#### (**Client Only**)

Updates an existing patient based on its ID.

**URL** : `/api/v1/patients/{patientId}`

**URL Params**

1. `patientId` = Patient ID.


**Method** : `POST`

**Post Data**

* `firstName` = **Required**. First name
* `middleName` = Middle name
* `lastName` = **Required**. Last name
* `emailAddress` = **Required**. E-mail address
* `gender` = **Required**. Gender. male or female
* `birthDate` = **Required**. Birthdate
* `passportNumber` = Passport number
* `citizen` = Citizen
* `bloodType` = Blood type
* `mothersMaidenName`	= Mother’s maiden name
* `address` = Address
* `city` = City
* `telNumber` = Telephone number
* `faxNumber` = Fax number
* `mobileNumber` = Cellphone number
* `hmoCardNo` = Health Maintenance Organization card number
* `hmoCard` = Health Maintenance Organization card number

**Auth required** : YES

### Success Response

**Code** : `200 OK`

**Response examples**

```json
{
	"data": {
		"id": 9793,
		"code": "irb",
		"globalCustomId": "OL97931577008661",
		"clientCustomId": null,
		"emailAddress": "jany67@yahoo.com",
		"firstName": "Freida",
		"middleName": "middlename",
		"lastName": "Grady",
		"gender": "female",
		"age": 0,
		"birthDateAsTimestamp": -307785600,
		"birthDate": "2019-08-13T16:00:00.000000Z",
		"passportNumber": "0509849356854",
		"citizen": "Pilipino",
		"bloodType": "A",
		"mothersMaidenName": "mothersMaidenName",
		"address": "6828 Marks Parkway\nWest Markusmouth, ND 54420-2663",
		"city": "East Matildemouth",
		"seniorCitizenId": null,
		"telNumber": "1-855-260-1545",
		"faxNumber": "9999999",
		"mobileNumber": "888888",
		"occupation": null,
		"hmoCard": "22222222222222",
		"hmoCardNo": "111111111111",
		"lastVisitAt": null,
		"archivedAt": null,
		"createdAt": 1577008661,
		"updatedAt": 1577008661,
		"client": {
			"id": 183,
			"globalPrefix": null,
			"code": "fo",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "dbogan@gmail.com",
			"firstName": "Devante",
			"lastName": "Lueilwitz",
			"username": "xkilback",
			"businessName": "Jerde PLC",
			"businessAddress": "2096 Bernhard Plaza\nSouth Palmashire, AL 21585",
			"contactNumber": "1-948-334-3285",
			"active": 1,
			"createdAt": 1567405124,
			"updatedAt": 1567405124
		}
	}
}
```
