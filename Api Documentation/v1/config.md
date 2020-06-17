# Request API Configuration

## Headers Data

#### Guest routes
Sample routes:
* Login

**Method** : `POST`

```
'Content-Type': application/json
'X-Requested-With': XMLHttpRequest
```

#### Auth routes
Sample:
* Admin routes ***(create user, update and delete)***
* User ***(profile, settings) etc***...

**Method** : `GET`

```
'Authorization': Bearer $access_token
```

> **NOTE!** `$access_token` value is returned on `login`

Sample access_token data
```
{
	"data": {
		"oauthToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ4OTZlZDE0N2Y4MThjMTFiZjY2Y2RjOTFjMzc4YTZlZGM4YzJhNGNlYTYwNDExY2FiMTRkNTY2NzE5NTlhYzZiNjZkMjVkOTkxOTY4NmQ2In0.eyJhdWQiOiIyIiwianRpIjoiNDg5NmVkMTQ3ZjgxOGMxMWJmNjZjZGM5MWMzNzhhNmVkYzhjMmE0Y2VhNjA0MTFjYWIxNGQ1NjY3MTk1OWFjNmI2NmQyNWQ5OTE5Njg2ZDYiLCJpYXQiOjE1NzY5ODM3MTEsIm5iZiI6MTU3Njk4MzcxMSwiZXhwIjoxNjA4NjA2MTExLCJzdWIiOiI5OCIsInNjb3BlcyI6W119.O05qHe5SenvngX3yhrQQbcC_LoJk4NDiN5TMZ8KajmfZ0-mB4KCIRSi_EOKXnoljbxAGjh9ocDVuriLiuC7ol5wBc-s5wZ6jv8UTd48hSn1_JTUFigHUUd5qppj1xqG3fiXrvHAxHicLRgSiDp-kz5lDZOwYa6Fe7H_l-7DADsz4nqeUi_x7QFc8PPbi4versYIPk64GiPQAp6R8WwZFoaEBXh1GUZ4SnjFsCDuxCt7qr-DbP7zMxcrdG8uFCTzLAUZw7AMhU5ae-sY4XggzvdY0EWZM1CGTg_8ckXoHFJIyDYdQildKpWG6P0DUsG6P5mrWr6muHQNM9xai2ajwpCk-X56GfMxuWaqUmOPZQ0mpt2kmN_JXQkZCPEV7z6AmwvEUpbMod9jGEIc1oyqJRxcRfsw0uQcvrKL29WQd4SIq7O7bWi4XRN0GJ3kKncfApkeu7CwCYJ-yBChbVdTxKo2KCAurQtiVi6btdSie7yuye2G59ivNnd8UhAYDutS9HyTR-bnAnzEq9vgNLd0DWkPNr4cL92xw-lMV7LHqejjx8UG7rLVbXHqyd3KaXxsZSwGhKOfebJhNkOMQW0hHATOHAZrmxeALmysxopvxAwl3Ogv66aqGdtZIM6l90xCZPow7LBIRkHBEd5Z3Spy7CxzgkjlxbZUdka4CCgRUBXY",
		"refresh_token": "def50200541f40ef0c4b785607514dfceef6743ad2e6b3b7af92b469ab0239dfc9c4a37d724d25f4cd4955796089c8a405720a949569f85367ff5230a75e16592ced750c92c035117aebc9d0f9d787c230e37ba3a43a81cbcf4fa02902fb77236b79ee089250185dfeba3880f55aa50732411d3dfd42b7f713d8ea72368096f9c6dcb5df599addcfc0b1145ddd608b2090c156695a8897ef358433effeea0b32e0e4305c69b5084815a465311aa64ed515130de8664616410bd29a2f3bbdecd7f419b6d8b145648a2896f2bee77ce51b176000e93146959980c46635f3806b336e5636457244ab8a0d8502cddd6932ce3a73fce5d00d551c6e8ff12d04c7042652bb3c447ae19c8e5b0322ccb78a0a47cb5822fdd0f7ac1692ccfec02a44bf82f61563627ea09becf2562935a3a5d0d98ca430188130091ff89ddb8eb813ce57cc404c04466dbda58c1780579338260af13e8a7e360addd9bb4a4e20a54acb7542dc",
		"expires_in": 31622400,
		"user": {
			"id": 98,
			"globalPrefix": null,
			"code": "c6",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "diegosilang@gmail.com",
			"firstName": "Diego",
			"lastName": "Silang",
			"username": "diegosilang1918",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 1,
			"createdAt": 1557128739,
			"updatedAt": 1557128739
		}
	}
}
```

**Method** : `POST`

```
'Authorization': Bearer $access_token,
'X-Requested-With': XMLHttpRequest
```

## Sample
Request Headers:
```
Authorization: Bearer ${acces_token}
Accept: application/json
```