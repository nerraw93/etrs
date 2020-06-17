# Client clinician create

#### (**Client Only**)

Store client clinician

**URL** : `/api/client/settings/clinician/store`

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "name": "$name", Required**
}
```

**Content examples**

```json
{
    "success":true,
    "message":"New clinician has been created.",
    "clinician": {
        "id": 10,
        "user_id": 64,
        "name": "Scarlett Mitchell IV",
        "created_at": "2019-06-15 03:08:09",
        "updated_at": "2019-06-15 03:08:09",
    },
}
```
