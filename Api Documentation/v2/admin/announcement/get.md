# Client list

#### (**Admin Only**)

Used to collect announcement list

**URL** : `/api/admin/announcement`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success": true,
    "message": "",
    "announcements": {
        "current_page": 1,
        "data": [
            {
                "id": "02aaf2ca-6677-4478-ab92-86066f3a2541",
                "type": "App\\Notifications\\Announcement",
                "notifiable_type": "App\\Models\\User",
                "notifiable_id": 15,
                "data": "{\"topic\":\"My Topic\",\"message\":\"My Content\",\"startDate\":\"2019-09-23T08:05:15.392Z\",\"endDate\":\"2019-09-28T08:05:15.390Z\"}",
                "read_at": null,
                "created_at": "2019-09-23 16:05:27",
                "updated_at": "2019-09-23 16:05:27"
            }
        ],
        "first_page_url": "http://localhost:8000/api/admin/announcement?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/admin/announcement?page=1",
        "next_page_url": null,
        "path": "http://localhost:8000/api/admin/announcement",
        "per_page": 5,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

> Result is in `pagination` format. See [Pagination format](../../helper/pagination.md)
