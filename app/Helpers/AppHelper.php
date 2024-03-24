<?php

function is_superadmin()
{
    if (auth()->user()->getRoleNames()->first() === 'superadmin') {
        return true;
    } else {
        return false;
    }
}


function is_pengadministrasiumum()
{
    if (auth()->user()->getRoleNames()->first() === 'Pengadministrasi Umum') {
        return true;
    } else {
        return false;
    }
}

function is_wakildirekturii()
{
    if (auth()->user()->getRoleNames()->first() === 'Wakil Direktur II') {
        return true;
    } else {
        return false;
    }
}

function is_pejabatpembuatkomitmen()
{
    if (auth()->user()->getRoleNames()->first() === 'Pejabat Pembuat Komitmen') {
        return true;
    } else {
        return false;
    }
}


function is_bendaharakeuangan()
{
    if (auth()->user()->getRoleNames()->first() === 'Bendahara Keuangan') {
        return true;
    } else {
        return false;
    }
}
