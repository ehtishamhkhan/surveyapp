<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = [
        'id', 'respondent_id', 'form_id','response_csv'
    ];
}
