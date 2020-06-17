# RESTAPIDocs

## Api Request Setup
#### Important! [Please Read...](config.md)


## Open Endpoints

Open endpoints require no Authentication.

* [Login](auth/login.md) : `POST /api/auth/login`

## Endpoints that require Authentication

Closed endpoints require a valid Token to be included in the header of the
request. A Token can be acquired from the Login view above.

### Admin related

Each endpoint manipulates or displays information related to the Admin whose
Token is provided with the request:

* [Dashboard info](admin/dashboard/index.md)
* [Client info](admin/client/client.md)
* [Processor info](admin/processor/processor.md)
* [Batch info](admin/batch/index.md)

* System
    * [Source info](admin/system/source/source.md)
    * [Announcement info](admin/announcement/index.md)
    * [Service info](admin/service/service.md)
    * [Dispatcher info](admin/system/dispatcher/dispatcher.md)
    * [Patient Type info](admin/system/patient_type/patient_type.md)
    * [White Listed Ip info](admin/system/white_listed_ip/white_listed_ip.md)
    * [Global Prefix info](admin/system/global_prefix/index.md)

#### Admin Client related

* [Client service info](admin/client/service/index.md)
* [Client source info](admin/client/sources/sources.md)

### Client related

* [Dashboard info](client/dashboard/index.md)
* [Client staff info](client/staff/staff.md)
* [Client patient info](client/patient/index.md)
* [Client profile info](client/settings/profile/index.md)
* [Client clinician info](client/settings/clinician/index.md)
* [Client sources info](client/others/sources.md)
* [Client batch info](client/batch/index.md)
* [Get client patiient types](client/others/patient_types.md)
* [Get client dispatchers](client/others/dispatchers.md)
* [Get client services](client/others/services.md)

### Staff related
* [Batch info](staff/batch/index.md)

### User related

* [Get User data](user/index.md)
* [Reset Password](user/password.md)
* [Get User Announcement](user/announcement/index.md)


## Backend Models

* [User table](models/user.md)
* [Batch table](models/batch.md)
* [Batch Order table](models/batch_order.md)

## Helper

* [Pagination format](helper/pagination.md)

## Response
All responses, if error occur on the request **(especially on request validation)** it will always return `success:false` sample:

```json
{
    "success":false,
    "message":"The given data was invalid.",
    "errors":{
        "id":[
            "The selected id is invalid."
        ]
    }
}
```
> Sample error on update request if given id is not found or does not exist.

## Deployment

1. To used the whitelist ip feature make sure to **update the `.env` file** and set the `APP_ENV` to `production` or `live`.
2. Run migrator (`php artisan etrs:migrate`) and update `.env` file on live and pont the old database to be migrated.

## Development

1. When creating/updating API's make sure to update the `API Documentation` folders/files too. Must be same format for the method and description.
