<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Document extends Model
{
    protected $fillable =['sujet','contenu','fichier','categorie_id','organisme_id'];
}
