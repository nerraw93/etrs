# Client Staff details

#### (**Client Only**)

Used to get Client Staff details

**URL** : `/api/client/staff/:id/details`

**Params**
1. `id` = client_staff id (not the ID of staff)

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "staff":{
        "id": 7,
        "client_id": 28,
        "staff_id": 29,
        "deleted_at": null,
        "created_at": "2019-08-05 23:30:29",
        "updated_at": "2019-08-05 23:30:29",
        "user": {
          "id": 29,
          "dispatcher_id": null,
          "code": "5",
          "global_prefix": null,
          "role": 3,
          "username": "april_11_cuevas5612",
          "email": "april_11_cuevas@yahoo.com",
          "api_token": null,
          "first_name": "April",
          "last_name": "Cuevas",
          "contact_number": null,
          "business_name": null,
          "business_address": null,
          "is_active": 1,
          "payment_mode": 0,
          "created_at": "2018-04-05 03:23:34",
          "updated_at": "2018-04-05 03:23:34",
          "full_name": "April Cuevas",
        }
    },
}
```
