# Client add services

#### (**Admin Only**)

Store service on a client

**URL** : `/api/admin/client/{id}/services/store`

**Params**
1. **id** = user/client id

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "user_id": "$user->id", *required
    "source_id": "$service->id", *required
    "price": "$price", *required
}
```

**Content examples**

```json
{
    "success":true,
    "message":"Service has been added to CLIENT_NAME client.",
    "service": {
        "id":346,
        "user_id":28,
        "service_id":2,
        "price":110,
        "created_at":"2019-08-03 01:02:08",
        "updated_at":"2019-08-03 01:02:08",
        "service":{
            "id":2,
            "code":"ABORHR",
            "name":"BT Card Replacement",
            "default_cost":0,
            "created_at":"2019-08-03 01:00:18",
            "updated_at":"2019-08-03 01:00:18"}
        }
    }
}
```
