<?php

if (!function_exists('isJson')) {
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if (!function_exists('log_activity')) {
    function log_activity($activity, $info = null)
    {
        $user = auth()->user();
        \App\Models\ActivityLog::create([
            'user_id'   => $user?->id,
            'activity'  => $activity,
            'ip_address'=> request()->ip(),
            'info'      => is_array($info) ? json_encode($info) : $info,
        ]);
    }
}
