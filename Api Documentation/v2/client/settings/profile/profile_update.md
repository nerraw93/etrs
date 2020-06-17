# Client Update Profile

#### (**User Only**)

Update user profile details

**URL** : `/api/client/settings/profile/update`

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "id": "$user->id", Required** `auth user->id`
    "first_name": "first_name", Required**
    "last_name": "last_name", Required**
    "business_name": "business_name",
    "business_address": "business_address",
    "contact_number": "contact_number",
}
```

**Content examples**

```json
{
    "success": true,
    "message": "You successfully updated your profile.",
    "user": {
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
