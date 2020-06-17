# Announcement Create

#### (**Admin Only**)

Store announcement

**URL** : `/api/admin/announcement/store`

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "message": "message", // Required*,
    "topic": "topic", // Required*,
    "start_date": "2019-10-25", // Required *
    "end_date": "2019-11-25", // Required *
}
```

**Content examples**

```json
{
    "success":true,
    "message":"Announcement has been created..",
}
```
