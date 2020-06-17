# Login

Used to collect a Token for a registered User.

**URL** : `/oauth/access-token`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "xAuthUsername": "[valid username]",
    "xAuthPassword": "[password in plain text]",
    "xAuthMode": "clientAuth",
}
```

**Data example**

```json
{
    "xAuthUsername": "mysusername",
    "xAuthPassword": "abcd1234",
    "xAuthMode": "clientAuth"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
	"data": {
		"oauthToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVlYzk4OWVlODFlOGQ5YTM3YjdmOTg3MWY0Mjc2NTNjYjhhN2ZmN2NmMDFmYWFiYmVlYTk1NjMxZmY3ZDIyNDljM2Y5ZTczM2UzMzQxODk4In0.eyJhdWQiOiIyIiwianRpIjoiNWVjOTg5ZWU4MWU4ZDlhMzdiN2Y5ODcxZjQyNzY1M2NiOGE3ZmY3Y2YwMWZhYWJiZWVhOTU2MzFmZjdkMjI0OWMzZjllNzMzZTMzNDE4OTgiLCJpYXQiOjE1NzY5OTU4ODksIm5iZiI6MTU3Njk5NTg4OSwiZXhwIjoxNjA4NjE4Mjg5LCJzdWIiOiI3MSIsInNjb3BlcyI6W119.tZ9-dP_lrizttvqeO6-ZnkV4NPbE6tV2jGgUEsrTil3dsMHxkM5Jj8CzESb9FJGYdwzI4f2Lbfovx4unZE6WnUHgxTV_f8xHvMJL1egWM8YSUYUS6zY_6GsjcUSfp56c7rWP1RN4t3juxN8p8hZhLlnDYd85ndRhqlf3qemeq9KeR_WIrv20cOBH-WqfwyKEUd65HmOVpaNsH_uXVOtxUWWMwlEjJQhEdyGvxotyV4Zvj_LshGMx5S_yS7om5i-vfjFoui9uxmiL6l2Q-3Tjvf_3vVSuAKVAcveBUrt6KQUDBUCb_Wj059HZm5qigKPYqAAvMyFkburCk9oNWdclIV5l2Utg3IXKqy5MFJWaUVic8_tlc_3vBtUvzylKkOnFHA0uNRx8fnhKGY7h8-ufbPKeNJLpYhTSZnIdzBl9wPZR4xhK_CPHfCCjttzDeDQk3I6UEFqFifn80YQEK7iMKEVWy5RySkNjWRgX_QtZCtPD4tVMroFTlBydsQZfljun-MxW3UoOcRhjxdOFYj5BjUuaJmIrPOuJA-CvAIfk5Qff_swWH2dkxF9RtJ7DzKRn1TOeeLaMZx5wbYqYAf-eWxDDPFTwlNj_cGfLa5mvGq-iP3MRnwEeN-jr_k9lnX-7dEBln0BkmUQ9wjSfUDOdl2-Eh35lgXgwVfeNCO37QLI",
		"refresh_token": "def502007dd3319cfdb6c2dc48371dc0eda104102e7c9375d12609e1c28e5599bbf738cdd9249b0f0170863605e2cc1596d54872424fc9822626fb2ac62cadeaefda2c9ca03dd1422c1081828a056d1fa7ee72fc1a88d9e83895d6ac10c0b9a8075d83c1de335ef18e4bdfbdf76e8cb8e36c63e66c8a9dc644398e371b0c20c630542ce930d8a66662af658d0e12cf38f2881f59173cc3cd37b9f1b08920173da6296ea8683f4feb0a744ee16794426099503328f6577971d3b1f81467e74ef704baf1f951b612e3099b5e278aa3f797c7110d1bb6fecd266b655263e7479fa5068ed21ee25de7b14ca8f54e2c44736d2b980e488f9bc8e0dc94a0274bb4de561d0d2df01af0c4a19960311e948e1d908574513271a399020e9439454d51be83be00ed8f68d3f48d18458f72eca0786ffcb18b4cfd464921120d131078a12e9e716109f15c9a7d0da15d2a43ebe6ccb31cb482edeffc7bbbd2a28844850b6f8c4f26",
		"expires_in": 31622400,
		"user": {
			"id": 71,
			"globalPrefix": null,
			"code": "cd",
			"type": "client",
			"paymentMode": "cash",
			"emailAddress": "jpshr.1971@gmail.com",
			"firstName": "JP SIOSON GEN.",
			"lastName": "HOSP. & COLLEGES INC.",
			"username": "jpshr19716708",
			"businessName": null,
			"businessAddress": null,
			"contactNumber": null,
			"active": 0,
			"createdAt": 1549306547,
			"updatedAt": 1549242344
		}
	}
}
```

## Error Response

**Condition** : If 'username' and 'password' combination is wrong.

**Code** : `401`

**Content** :

```json
{
	"errors": [{
		"code": 401,
		"message": "Username or password does not match."
	}]
}

```
