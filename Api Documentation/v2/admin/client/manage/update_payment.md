# Client Update

#### (**Admin Only**)

Store client

**URL** : `/api/admin/client/payment_mode/{code}/update`

**Params**
1. code = User code

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "id": "$client->id", **Required
    "payment_mode": "$payment_mode", **Required `0` = Cash; 1 = Charge
}
```

**Content examples**

```json
{
    "success":true,
    "message":":FirstName_LastName client has been updated.",
    "client":{
        "id":33,
        "code":null,
        "global_prefix":null,
        "role":0,
        "username":"SofiaKihn",
        "email":"charlie.padberg@gmail.com",
        "api_token":null,
        "first_name":"Terrell",
        "last_name":"Harber",
        "contact_number":null,
        "business_name":null,
        "business_address":null,
        "is_active":1,
        "created_at":"2019-04-23 15:03:47",
        "updated_at":"2019-04-24 14:54:08"
    }
}
```
