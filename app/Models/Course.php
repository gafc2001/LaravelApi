<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "url_image",
        "description",
    ];
    public function getUrlImage(){
        return url("/")."/storage/courses/".$this->url_image;
    }
}
