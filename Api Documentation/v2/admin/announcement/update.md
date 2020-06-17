# Client Update

#### (**Admin Only**)

Store client

**URL** : `/api/admin/announcement/:batch_id/update`

**Params**
1. **id** = announcement/batch id

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "topic": "Topic",
    "content": "Content",
    "startDate": "2019-10-01T08:03:36.688Z",
    "endDate": "2019-10-06T08:03:36.688Z",
    "batch_id": 1
}
```

**Content examples**

```json
{
    "success": true,
    "message": "Announcement has been updated.",
    "batch_id": 62
}
```
