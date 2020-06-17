# Get all **unread** announcements

#### (**User Only**)

Used to get all unread announcements

**URL** : `/api/user/announcement/unread`

**Method** : `GET`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Content examples**

```json
{
    "success":true,
    "message":"",
    "notifications": [
        {
            "id": "4cbfcc26-3809-41e5-8b6f-c072ab62aae5",
            "type": "App\Notifications\Announcement",
            "notifiable_type": "App\Models\User",
            "notifiable_id": 57,
            "data": {
                "message": "Shakespeare, in the same tone, exactly as if he doesn't begin.' But she waited for some time with great curiosity, and this was of very little way forwards each time and a large canvas bag, which.",
            }
            "read_at": null,
            "created_at": "2019-09-01 20:26:42",
            "updated_at": "2019-09-01 20:26:42",
        },
        {
            "id": "4cbfcc26-3809-41e5-8b6f-c072ab62aae5",
            "type": "App\Notifications\Announcement",
            "notifiable_type": "App\Models\User",
            "notifiable_id": 57,
            "data": {
                "message": "Shakespeare, in the same tone, exactly as if he doesn't begin.' But she waited for some time with great curiosity, and this was of very little way forwards each time and a large canvas bag, which.",
            }
            "read_at": null,
            "created_at": "2019-09-01 20:26:42",
            "updated_at": "2019-09-01 20:26:42",
        }

    ]
}
```
