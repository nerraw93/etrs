# Client Delete Service

#### (**Admin Only**)

Delete client service

**URL** : `/api/admin/client/{id}/services/{serviceId}/destroy`

**Params**
1. **id** = user/client id
1. **serviceId** = service ID

**Method** : `POST`

**Auth required** : YES

## Success Response

**Code** : `200 OK`

**Post Data**

```json
{
}
```

**Content examples**

```json
{
    "success":true,
    "message":"Client service has been deleted."
}
```
