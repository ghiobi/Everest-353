<?php

if (! function_exists('canEdit')){
    function canEdit($idOwner){
        if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin') || Auth::user()->id == $idOwner){
            return true;
        }
        return false;
    }
}
