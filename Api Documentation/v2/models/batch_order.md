# Batch Order

BatchOrder model - every batch has one or many orders in it.

**Column**

* `id` = **integer** | **auto increment**
* `client_id` = **integer(20)**
* `patient_id` = **integer(20)**
* `id_prefix` = **string(255)**
* `or_number` = **string(255)**
* `clinical_information` = **text**
* `special_instructions` = **text**
* `status` = **tinyinteger(1)**
* `is_urgent` = **tinyinteger(1)**
* `deleted_at` = **timestamp**
* `updated_at` = **timestamp**
* `created_at` = **timestamp**

**Column variables**

* `status` = values:
   * `0` = **Pending** Status
   * `1` = **Cancelled** Status  
   * `2` = **Deleted** Status
   * `3` = **Posted** Status


* `is_urgent` = values:
    * `0` = **URGENT**
    * `1` = **MINOR** false
