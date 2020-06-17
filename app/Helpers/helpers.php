<?php

if (!function_exists('appHelper'))
{
    function appHelper()
    {
        return app('app.aider');
    }
}

if (!function_exists('jsonify'))
{
    function jsonify($success, $data = [])
    {
        return appHelper()->jsonify($success, $data);
    }
}

if (!function_exists('successify'))
{
    function successify($message = '', $extra = [])
    {
        return appHelper()->successify($message, $extra);
    }
}

if (!function_exists('successful'))
{
    function successful($message, $extra = [], $status = 200)
    {
        return appHelper()->successful($message, $extra, $status);
    }
}

if (!function_exists('errorify'))
{
    function errorify($message, $extra = [])
    {
        return appHelper()->errorify($message, $extra);
    }
}

if (!function_exists('erroneous'))
{
    function erroneous($message, $extra = [], $status = 422)
    {
        return appHelper()->erroneous($message, $extra, $status);
    }
}

if (!function_exists('success_data'))
{
    function success_data($message = '', $extra = [], $status = 200)
    {
        return appHelper()->successData($message, $extra, $status);
    }
}

if (!function_exists('passport_client_credentials'))
{
    function passport_client_credentials()
    {
        return appHelper()->passportClientCredentials();
    }
}

if (!function_exists('int_to_code'))
{
    function int_to_code($num)
    {
        return appHelper()->intToCode($num);
    }
}

if (!function_exists('code_to_int'))
{
    function code_to_int($code)
    {
        return appHelper()->codeToInt($code);
    }
}

if (!function_exists('global_prefix'))
{
    function global_prefix($id = '')
    {
        return appHelper()->globalPrefix($id);
    }
}

if (!function_exists('get_user_id'))
{
    function get_user_id($code)
    {
        return appHelper()->getUserId($code);
    }
}

if (!function_exists('get_staff_client_id'))
{
    function get_staff_client_id()
    {
        return appHelper()->getStaffClientId();
    }
}

if (!function_exists('get_client_id'))
{
    function get_client_id()
    {
        return appHelper()->getClientId();
    }
}

if (!function_exists('is_client_or_staff'))
{
    function is_client_or_staff()
    {
        return appHelper()->isClientOrStaff();
    }
}

if (!function_exists('get_batch_pdf'))
{
    function get_batch_pdf($batchId)
    {
        return appHelper()->getBatchPdf($batchId);
    }
}

if (!function_exists('get_current_notifications'))
{
    function get_current_notifications($notifications)
    {
        return appHelper()->getCurrentNotifications($notifications);
    }
}

if (!function_exists('patient_global_custom_id_generator'))
{
    function patient_global_custom_id_generator($id)
    {
        return appHelper()->patientGlobalCustomIdGenerator($id);
    }
}

// *********************************************************
// Legacy API helpers
// *********************************************************
if (!function_exists('legacy_jsonify'))
{
    function legacyJsonify($data = [])
    {
        return appHelper()->legacyJsonify($data);
    }
}

if (!function_exists('legacy_errorify'))
{
    function legacy_errorify($message, $extra = [])
    {
        return appHelper()->legacyErrorify($message, $extra);
    }
}

if (!function_exists('legacy_successful'))
{
    function legacy_successful($extra = [])
    {
        return appHelper()->legacySuccessful($extra);
    }
}

// *********************************************************
// END of LEGACY HElpers API
// *********************************************************
