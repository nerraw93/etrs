# Update global prefix

#### (**Admin Only**)

Update admin global prefix value

**URL** : `/api/admin/system/global-prefix/update`

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
    "global_prefix": $global_prefix, Required**
}
```

**Content examples**

```json
{
    "success":true,
    "message":"Global prefix has been updated to :value.",
    "global_prefix": "OL",
}
```
