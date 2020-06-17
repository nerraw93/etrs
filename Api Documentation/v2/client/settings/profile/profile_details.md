# Client details

#### (**Client Only**)

Used to get user profile

**URL** : `/api/client/settings/profile`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "user":{
        "id": 74,
        "dispatcher_id": 4,
        "code": "cg",
        "global_prefix": null,
        "role": 0,
        "username": "RobinFriesen",
        "email": "brenna97@hotmail.com",
        "api_token": null,
        "first_name": "Gabriella",
        "last_name": "Beier",
        "contact_number": null,
        "business_name": null,
        "business_address": null,
        "is_active": 1,
        "payment_mode": 0,
        "created_at": "2019-06-12 01:20:06",
        "updated_at": "2019-06-12 01:20:07",
        "full_name": "Gabriella Beier",
    }
}
```
